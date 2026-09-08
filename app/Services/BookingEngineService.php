<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AvailabilityRule;
use App\Models\TimeBlock;
use Carbon\Carbon;

class BookingEngineService
{
    /**
     * Get available time slots for a given date.
     */
    public function getAvailableSlots(Carbon $date, int $appointmentDurationMinutes = 180, int $bufferMinutes = 30): array
    {
        $dayOfWeek = $date->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
        $dayStart = $date->copy()->startOfDay();
        $dayEnd = $date->copy()->endOfDay();

        // 1. Fetch Availability Rules for this day of week
        $rules = AvailabilityRule::where('day_of_week', $dayOfWeek)->get();

        if ($rules->isEmpty()) {
            return [];
        }

        // 2. Fetch Busy Blocks (Appointments and TimeBlocks)
        $appointments = Appointment::where('status', '!=', 'CANCELLED')
            ->where(function ($query) use ($dayStart, $dayEnd) {
                $query->whereBetween('start_time', [$dayStart, $dayEnd])
                    ->orWhereBetween('end_time', [$dayStart, $dayEnd])
                    ->orWhere(function ($q) use ($dayStart, $dayEnd) {
                        $q->where('start_time', '<=', $dayStart)
                            ->where('end_time', '>=', $dayEnd);
                    });
            })
            ->get();

        $blocks = TimeBlock::where(function ($query) use ($dayStart, $dayEnd) {
            $query->whereBetween('start_time', [$dayStart, $dayEnd])
                ->orWhereBetween('end_time', [$dayStart, $dayEnd])
                ->orWhere(function ($q) use ($dayStart, $dayEnd) {
                    $q->where('start_time', '<=', $dayStart)
                        ->where('end_time', '>=', $dayEnd);
                });
        })->get();

        $busySlots = [];

        foreach ($appointments as $app) {
            $busySlots[] = [
                'start' => Carbon::parse($app->start_time),
                'end' => Carbon::parse($app->end_time),
            ];
        }

        foreach ($blocks as $block) {
            $busySlots[] = [
                'start' => Carbon::parse($block->start_time),
                'end' => Carbon::parse($block->end_time),
            ];
        }

        // 3. Generate potential slots considering the rules
        $availableSlots = [];

        foreach ($rules as $rule) {
            [$startH, $startM] = explode(':', $rule->start_time);
            [$endH, $endM] = explode(':', $rule->end_time);

            $ruleStart = $date->copy()->setHour((int) $startH)->setMinute((int) $startM)->setSecond(0);
            $ruleEnd = $date->copy()->setHour((int) $endH)->setMinute((int) $endM)->setSecond(0);

            $currentPointer = $ruleStart->copy();

            while ($currentPointer->copy()->addMinutes($appointmentDurationMinutes)->lte($ruleEnd)) {
                $slotEnd = $currentPointer->copy()->addMinutes($appointmentDurationMinutes);

                // Check overlap
                $isOverlapping = false;
                foreach ($busySlots as $busy) {
                    // slotStart < busyEnd && slotEnd > busyStart
                    if ($currentPointer->lt($busy['end']) && $slotEnd->gt($busy['start'])) {
                        $isOverlapping = true;
                        break;
                    }
                }

                if (! $isOverlapping) {
                    $availableSlots[] = [
                        'start' => $currentPointer->toIso8601String(),
                        'end' => $slotEnd->toIso8601String(),
                        'time_label' => $currentPointer->format('H:i').' - '.$slotEnd->format('H:i'),
                        'is_available' => true,
                    ];
                }

                $currentPointer->addMinutes(30);
            }
        }

        return $availableSlots;
    }

    /**
     * Check if a specific time range is available.
     */
    public function isTimeRangeAvailable(Carbon $start, Carbon $end, ?int $excludeAppointmentId = null): bool
    {
        $appQuery = Appointment::where('status', '!=', 'CANCELLED')
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            });

        if ($excludeAppointmentId) {
            $appQuery->where('id', '!=', $excludeAppointmentId);
        }

        $overlappingAppointments = $appQuery->count();

        $overlappingBlocks = TimeBlock::where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->count();

        return $overlappingAppointments === 0 && $overlappingBlocks === 0;
    }

    /**
     * Get dates with active appointments or blocks in a given month.
     */
    public function getReservedDays(int $month, int $year): array
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $appointments = Appointment::where('status', '!=', 'CANCELLED')
            ->whereBetween('start_time', [$startDate, $endDate])
            ->pluck('start_time');

        $blocks = TimeBlock::whereBetween('start_time', [$startDate, $endDate])
            ->pluck('start_time');

        $reservedDates = [];

        foreach ($appointments as $time) {
            $reservedDates[] = Carbon::parse($time)->format('Y-m-d');
        }

        foreach ($blocks as $time) {
            $reservedDates[] = Carbon::parse($time)->format('Y-m-d');
        }

        return array_values(array_unique($reservedDates));
    }
}
