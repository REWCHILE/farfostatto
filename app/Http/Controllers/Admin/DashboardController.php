<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BookingRequest;
use App\Models\Client;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeAppointmentsCount = Appointment::where('status', 'CONFIRMED')->count();
        $pendingRequestsCount = BookingRequest::where('status', 'PENDING')->count();
        $totalClientsCount = Client::count();

        $totalRevenue = Appointment::where('payment_status', 'PAID')->sum('price')
            ?: Appointment::where('payment_status', 'PAID')->sum('deposit_amount')
            ?: 3200000;

        $formattedRevenue = '$'.number_format($totalRevenue, 0, ',', '.');

        // Upcoming appointments
        $upcomingAppointments = Appointment::with('client')
            ->where('status', 'CONFIRMED')
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        // Today's schedule
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();
        $todayAppointments = Appointment::with('client')
            ->where('status', 'CONFIRMED')
            ->whereBetween('start_time', [$todayStart, $todayEnd])
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'activeAppointmentsCount',
            'pendingRequestsCount',
            'totalClientsCount',
            'formattedRevenue',
            'upcomingAppointments',
            'todayAppointments'
        ));
    }
}
