<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BookingRequest;
use App\Services\BookingEngineService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'PENDING');

        $requests = BookingRequest::with('client')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.requests', compact('requests', 'status'));
    }

    public function approve(Request $request, $id, BookingEngineService $bookingEngine)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'nullable|numeric',
        ]);

        $bookingReq = BookingRequest::with('client')->findOrFail($id);

        $startTime = Carbon::parse($validated['date'].' '.$validated['time']);
        $endTime = $startTime->copy()->addHours(3); // Default 3 hour session

        // Validate availability
        if (! $bookingEngine->isTimeRangeAvailable($startTime, $endTime)) {
            return back()->with('error', 'El horario seleccionado ya no se encuentra disponible.');
        }

        DB::transaction(function () use ($bookingReq, $startTime, $endTime, $validated) {
            Appointment::create([
                'client_id' => $bookingReq->client_id,
                'booking_request_id' => $bookingReq->id,
                'title' => 'Tatuaje: '.$bookingReq->client->name,
                'description' => $bookingReq->description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'price' => $validated['price'] ?? 150000,
                'deposit_amount' => 30000,
                'payment_status' => 'UNPAID',
                'status' => 'CONFIRMED',
                'location' => $bookingReq->location ?? 'INKNEFABLE',
            ]);

            $bookingReq->update(['status' => 'APPROVED']);
        });

        return redirect()->route('admin.requests')->with('success', 'Solicitud aprobada y cita agendada exitosamente.');
    }

    public function reject($id)
    {
        $bookingReq = BookingRequest::findOrFail($id);
        $bookingReq->update(['status' => 'REJECTED']);

        return redirect()->route('admin.requests')->with('success', 'Solicitud rechazada.');
    }
}
