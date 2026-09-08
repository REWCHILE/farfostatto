<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\Client;
use App\Services\BookingEngineService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('pages.booking');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|min:10',
            'size' => 'required|string',
            'body_zone' => 'required|string',
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone' => 'required|string|min:8',
            'preferred_date' => 'required|date',
            'preferred_time_slot' => 'required|in:Morning,Afternoon',
            'location' => 'required|string',
        ], [
            'description.min' => 'Por favor, describe tu idea con más detalle (mínimo 10 caracteres).',
            'size.required' => 'Elige un tamaño aproximado.',
            'body_zone.required' => 'Dinos dónde quieres el tatuaje.',
            'name.required' => 'Tu nombre es necesario.',
            'email.email' => 'Ingresa un email válido.',
            'phone.required' => 'Ingresa tu teléfono o WhatsApp.',
            'preferred_date.required' => 'Selecciona una fecha en el calendario.',
            'location.required' => 'Por favor, elige un estudio.',
        ]);

        // 1. Find or create client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]
        );

        // Update phone or name if changed
        $client->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        // 2. Create Booking Request
        $bookingRequest = BookingRequest::create([
            'client_id' => $client->id,
            'description' => $validated['description'],
            'size' => $validated['size'],
            'body_zone' => $validated['body_zone'],
            'preferred_date' => Carbon::parse($validated['preferred_date']),
            'preferred_time_slot' => $validated['preferred_time_slot'],
            'location' => $validated['location'],
            'status' => 'PENDING',
        ]);

        return redirect()->route('booking.success')->with('booking_id', $bookingRequest->id);
    }

    public function success()
    {
        return view('pages.booking-success');
    }

    public function apiReservedDays(Request $request, BookingEngineService $service)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        $days = $service->getReservedDays($month, $year);

        return response()->json($days);
    }
}
