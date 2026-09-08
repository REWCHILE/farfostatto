@extends('layouts.admin')

@section('title', "Dashboard — FARFO'S TATTOO")

@section('content')
<div class="space-y-12">
    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-serif font-bold mb-2">Panel de Control</h1>
        <p class="text-muted text-[10px] uppercase tracking-widest font-bold">Estado actual de FARFO'S TATTOO STUDIO</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1 --}}
        <div class="bg-surface border border-border p-8 hover:border-accent/40 transition-colors group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-background border border-border group-hover:bg-accent group-hover:border-accent transition-all duration-500 text-accent">
                    <i data-lucide="calendar" class="w-5 h-5 group-hover:text-accent-foreground transition-colors duration-500"></i>
                </div>
                <span class="text-[10px] font-black font-mono text-accent">+4</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-muted mb-1">Citas Activas</p>
                <h3 class="text-3xl font-serif font-black tracking-tighter">{{ $activeAppointmentsCount }}</h3>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-surface border border-border p-8 hover:border-accent/40 transition-colors group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-background border border-border group-hover:bg-blue-500 group-hover:border-blue-500 transition-all duration-500 text-blue-400">
                    <i data-lucide="clock" class="w-5 h-5 group-hover:text-white transition-colors duration-500"></i>
                </div>
                <span class="text-[10px] font-black font-mono text-blue-400">+2</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-muted mb-1">Nuevas Solicitudes</p>
                <h3 class="text-3xl font-serif font-black tracking-tighter">{{ $pendingRequestsCount }}</h3>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-surface border border-border p-8 hover:border-accent/40 transition-colors group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-background border border-border group-hover:bg-purple-500 group-hover:border-purple-500 transition-all duration-500 text-purple-400">
                    <i data-lucide="users" class="w-5 h-5 group-hover:text-white transition-colors duration-500"></i>
                </div>
                <span class="text-[10px] font-black font-mono text-purple-400">+12</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-muted mb-1">Clientes Totales</p>
                <h3 class="text-3xl font-serif font-black tracking-tighter">{{ $totalClientsCount }}</h3>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-surface border border-border p-8 hover:border-accent/40 transition-colors group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-background border border-border group-hover:bg-green-500 group-hover:border-green-500 transition-all duration-500 text-green-400">
                    <i data-lucide="trending-up" class="w-5 h-5 group-hover:text-white transition-colors duration-500"></i>
                </div>
                <span class="text-[10px] font-black font-mono text-green-400">+15%</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-muted mb-1">Ingresos Estimados</p>
                <h3 class="text-3xl font-serif font-black tracking-tighter">{{ $formattedRevenue }}</h3>
            </div>
        </div>
    </div>

    {{-- Tables & Schedules --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- Recent Upcoming Appointments --}}
        <div class="xl:col-span-2 bg-surface border border-border overflow-hidden">
            <div class="p-6 border-b border-border flex justify-between items-center">
                <h4 class="text-[10px] uppercase tracking-[0.3em] font-black">Próximas Citas</h4>
                <a href="{{ route('admin.agenda') }}" class="text-[10px] uppercase font-black text-accent hover:underline transition-all">Ver Todo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-border bg-background/50">
                            <th class="px-6 py-4 text-[9px] uppercase tracking-widest font-black text-muted">Cliente</th>
                            <th class="px-6 py-4 text-[9px] uppercase tracking-widest font-black text-muted">Estado Abono</th>
                            <th class="px-6 py-4 text-[9px] uppercase tracking-widest font-black text-muted">Fecha</th>
                            <th class="px-6 py-4 text-[9px] uppercase tracking-widest font-black text-muted text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/40">
                        @forelse($upcomingAppointments as $app)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-sm bg-accent text-accent-foreground flex items-center justify-center font-black text-[10px]">
                                            {{ strtoupper(substr($app->client->name ?? 'C', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-tight">{{ $app->client->name ?? 'Cliente' }}</p>
                                            <p class="text-[9px] text-muted uppercase">{{ $app->title }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($app->payment_status === 'PAID')
                                        <span class="bg-accent/10 border border-accent/30 text-accent px-2 py-1 text-[8px] uppercase tracking-widest font-black">
                                            Abono Pagado
                                        </span>
                                    @else
                                        <span class="bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 px-2 py-1 text-[8px] uppercase tracking-widest font-black">
                                            Pendiente $30.000
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold">{{ \Carbon\Carbon::parse($app->start_time)->isoFormat('D MMM') }}</p>
                                    <p class="text-[9px] text-muted uppercase tracking-tighter">{{ \Carbon\Carbon::parse($app->start_time)->format('H:i') }} hrs</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.agenda') }}" class="text-muted hover:text-accent transition-colors">
                                        <i data-lucide="more-vertical" class="w-4 h-4 inline"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-xs text-muted uppercase tracking-widest">
                                    No hay citas próximas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Schedule Preview --}}
        <div class="bg-surface border border-border flex flex-col">
            <div class="p-6 border-b border-border flex justify-between items-center">
                <h4 class="text-[10px] uppercase tracking-[0.3em] font-black">Agenda Hoy</h4>
                <a href="{{ route('admin.agenda') }}"><i data-lucide="arrow-up-right" class="w-4 h-4 text-accent"></i></a>
            </div>
            <div class="p-8 flex-grow space-y-6">
                @forelse($todayAppointments as $app)
                    <div class="relative pl-6 border-l-2 border-accent/30">
                        <div class="absolute top-0 left-[-2px] w-[2px] h-4 bg-accent"></div>
                        <p class="text-[9px] uppercase tracking-widest font-black text-accent mb-1">
                            {{ \Carbon\Carbon::parse($app->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($app->end_time)->format('H:i') }}
                        </p>
                        <h5 class="font-serif font-bold text-sm">{{ $app->title }}</h5>
                        <p class="text-[9px] text-muted uppercase mt-1">{{ $app->description ?? 'Sesión de tatuaje' }}</p>
                    </div>
                @empty
                    <div class="relative pl-6 border-l-2 border-border">
                        <p class="text-[9px] uppercase tracking-widest font-black text-muted mb-1">Hoy</p>
                        <h5 class="font-serif font-bold text-sm text-muted">Sin citas programadas para hoy</h5>
                    </div>
                @endforelse
            </div>
            <a href="{{ route('admin.agenda') }}" class="p-4 bg-background border-t border-border text-[10px] uppercase font-black hover:text-accent transition-colors text-center">
                Administrar Agenda Completa
            </a>
        </div>
    </div>
</div>
@endsection
