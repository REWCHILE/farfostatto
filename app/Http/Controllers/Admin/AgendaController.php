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

        // Build sorted agenda items for mobile list view and chronological overview
        $agendaItems = collect();

        foreach ($appointments as $app) {
            $startDt = Carbon::parse($app->start_time);
            $endDt = Carbon::parse($app->end_time);

            $agendaItems->push([
                'id' => $app->id,
                'type' => 'APPOINTMENT',
                'title' => $app->title,
                'client_name' => $app->client->name ?? 'Cliente',
                'client_email' => $app->client->email ?? '',
                'client_phone' => $app->client->phone ?? '',
                'start_time_raw' => $app->start_time,
                'start_time' => $startDt->format('H:i'),
                'end_time' => $endDt->format('H:i'),
                'date_key' => $startDt->format('Y-m-d'),
                'date_label' => $startDt->isoFormat('dddd D [de] MMMM'),
                'date_day_num' => $startDt->format('d'),
                'date_month_short' => $startDt->isoFormat('MMM'),
                'is_today' => $startDt->isToday(),
                'is_current_month' => $startDt->month === $month,
                'payment_status' => $app->payment_status,
                'deposit_amount' => number_format($app->deposit_amount, 0, ',', '.'),
                'price' => number_format($app->price ?? 150000, 0, ',', '.'),
                'description' => $app->description,
                'location' => $app->location ?? 'INKNEFABLE',
            ]);
        }

        foreach ($blocks as $blk) {
            $startDt = Carbon::parse($blk->start_time);
            $endDt = Carbon::parse($blk->end_time);

            $agendaItems->push([
                'id' => $blk->id,
                'type' => 'BLOCK',
                'title' => 'Bloqueo: '.$blk->type,
                'client_name' => 'Estudio FARFO\'S',
                'client_email' => '',
                'client_phone' => '',
                'start_time_raw' => $blk->start_time,
                'start_time' => $startDt->format('H:i'),
                'end_time' => $endDt->format('H:i'),
                'date_key' => $startDt->format('Y-m-d'),
                'date_label' => $startDt->isoFormat('dddd D [de] MMMM'),
                'date_day_num' => $startDt->format('d'),
                'date_month_short' => $startDt->isoFormat('MMM'),
                'is_today' => $startDt->isToday(),
                'is_current_month' => $startDt->month === $month,
                'payment_status' => null,
                'deposit_amount' => null,
                'price' => null,
                'description' => $blk->description ?? 'Horario reservado para descanso o mantención.',
                'location' => 'INKNEFABLE',
            ]);
        }

        $agendaItems = $agendaItems->sortBy('start_time_raw')->values();

        return view('admin.agenda', compact('currentDate', 'calendarDays', 'year', 'month', 'agendaItems'));
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
