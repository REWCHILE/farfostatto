<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BookingRequest;
use App\Models\TimeBlock;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        $currentDate = Carbon::create($year, $month, 1);

        $start = $currentDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $end = $currentDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $appointments = Appointment::with('client')
            ->where('status', '!=', 'CANCELLED')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end]);
            })
            ->get();

        $blocks = TimeBlock::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_time', [$start, $end])
                ->orWhereBetween('end_time', [$start, $end]);
        })->get();

        $calendarPeriod = CarbonPeriod::create($start, $end);
        $calendarDays = [];

        foreach ($calendarPeriod as $date) {
            $dateStr = $date->format('Y-m-d');
            $dayApps = $appointments->filter(function ($app) use ($dateStr) {
                return Carbon::parse($app->start_time)->format('Y-m-d') === $dateStr;
            });
            $dayBlocks = $blocks->filter(function ($blk) use ($dateStr) {
                return Carbon::parse($blk->start_time)->format('Y-m-d') === $dateStr;
            });

            $calendarDays[] = [
                'date' => $date->copy(),
                'date_str' => $dateStr,
                'day_num' => $date->format('j'),
                'is_current_month' => $date->month === $month,
                'is_today' => $date->isToday(),
                'appointments' => $dayApps,
                'blocks' => $dayBlocks,
            ];
        }

        return view('admin.agenda', compact('currentDate', 'calendarDays', 'year', 'month'));
    }

    public function confirmDeposit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'payment_status' => 'PAID',
            'paid_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Abono de $30.000 confirmado exitosamente.');
    }

    public function releaseSlot($id)
    {
        $appointment = Appointment::findOrFail($id);

        DB::transaction(function () use ($appointment) {
            if ($appointment->booking_request_id) {
                BookingRequest::where('id', $appointment->booking_request_id)->update(['status' => 'REJECTED']);
            }
            $appointment->delete();
        });

        return redirect()->back()->with('success', 'La hora ha sido liberada y la cita cancelada.');
    }

    public function createBlock(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $start = Carbon::parse($validated['start_date'].' '.$validated['start_time']);
        $end = Carbon::parse($validated['start_date'].' '.$validated['end_time']);

        TimeBlock::create([
            'start_time' => $start,
            'end_time' => $end,
            'type' => $validated['type'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Bloqueo de horario creado correctamente.');
    }
}
