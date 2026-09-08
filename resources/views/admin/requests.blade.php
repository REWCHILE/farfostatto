@extends('layouts.admin')

@section('title', "Solicitudes — FARFO'S TATTOO")

@section('content')
<div class="space-y-8" x-data="{ approvingReq: null }">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-serif font-bold mb-2">Solicitudes Recientes</h1>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold">Gestión de nuevas propuestas y conversiones a cita</p>
        </div>
        <a href="{{ route('admin.requests', ['status' => $status]) }}" class="text-[10px] uppercase tracking-widest font-bold text-muted hover:text-accent flex items-center gap-2">
            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Sincronizar
        </a>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-4 border-b border-border">
        <a 
            href="{{ route('admin.requests', ['status' => 'PENDING']) }}"
            class="px-6 py-4 text-[10px] uppercase tracking-widest font-black transition-all relative {{ $status === 'PENDING' ? 'text-accent' : 'text-muted hover:text-foreground' }}"
        >
            Pendientes
            @if($status === 'PENDING')
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-accent"></div>
            @endif
        </a>
        <a 
            href="{{ route('admin.requests', ['status' => 'APPROVED']) }}"
            class="px-6 py-4 text-[10px] uppercase tracking-widest font-black transition-all relative {{ $status === 'APPROVED' ? 'text-accent' : 'text-muted hover:text-foreground' }}"
        >
            Aprobadas
            @if($status === 'APPROVED')
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-accent"></div>
            @endif
        </a>
        <a 
            href="{{ route('admin.requests', ['status' => 'REJECTED']) }}"
            class="px-6 py-4 text-[10px] uppercase tracking-widest font-black transition-all relative {{ $status === 'REJECTED' ? 'text-accent' : 'text-muted hover:text-foreground' }}"
        >
            Rechazadas
            @if($status === 'REJECTED')
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-accent"></div>
            @endif
        </a>
    </div>

    {{-- Request Cards List --}}
    <div class="grid grid-cols-1 gap-6">
        @forelse($requests as $req)
            <div class="bg-surface border border-border overflow-hidden hover:border-accent/40 transition-colors group">
                <div class="p-8 flex flex-col lg:flex-row gap-8 items-start">
                    {{-- Client Info --}}
                    <div class="w-full lg:w-1/4">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-background border border-border flex items-center justify-center font-bold text-accent uppercase rounded-sm">
                                {{ strtoupper(substr($req->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-serif font-bold text-base">{{ $req->client->name }}</h4>
                                <p class="text-[10px] text-muted uppercase tracking-widest">{{ $req->client->email }}</p>
                                <p class="text-[10px] text-accent uppercase tracking-widest mt-0.5">{{ $req->client->phone }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2 text-muted">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-accent"></i>
                                <span class="uppercase tracking-wider font-bold">
                                    {{ \Carbon\Carbon::parse($req->preferred_date)->isoFormat('D MMM YYYY') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-muted">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-accent"></i>
                                <span class="uppercase tracking-wider font-bold">
                                    {{ $req->preferred_time_slot === 'Morning' ? 'Mañana (10:00 - 14:00)' : 'Tarde (15:00 - 19:00)' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-muted">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                                <span class="uppercase tracking-wider font-bold">
                                    {{ $req->location ?? 'INKNEFABLE' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Description & Details --}}
                    <div class="w-full lg:w-2/4">
                        <div class="flex items-center gap-2 mb-3 text-accent">
                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                            <span class="text-[10px] uppercase tracking-widest font-black">Propuesta</span>
                        </div>
                        <p class="text-sm text-foreground/90 leading-relaxed italic border-l-2 border-accent/30 pl-4 py-1">
                            "{{ $req->description }}"
                        </p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="bg-background border border-border px-3 py-1 text-[9px] uppercase tracking-widest font-black text-muted">
                                Zona: {{ $req->body_zone }}
                            </span>
                            <span class="bg-background border border-border px-3 py-1 text-[9px] uppercase tracking-widest font-black text-muted">
                                Tamaño: {{ $req->size }}
                            </span>
                            <span class="bg-background border border-border px-3 py-1 text-[9px] uppercase tracking-widest font-black text-muted">
                                Recibida: {{ \Carbon\Carbon::parse($req->created_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="w-full lg:w-1/4 flex flex-col gap-3 justify-center items-end self-stretch">
                        @if($req->status === 'PENDING')
                            <button 
                                @click="approvingReq = { 
                                    id: '{{ $req->id }}', 
                                    name: '{{ addslashes($req->client->name) }}',
                                    date: '{{ \Carbon\Carbon::parse($req->preferred_date)->format('Y-m-d') }}',
                                    time: '{{ $req->preferred_time_slot === 'Morning' ? '10:00' : '15:00' }}'
                                }"
                                class="w-full bg-accent text-accent-foreground py-3 text-[10px] uppercase tracking-widest font-black flex items-center justify-center gap-2 hover:bg-accent/90 transition-all shadow-[0_0_15px_rgba(212,175,55,0.2)]"
                            >
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>Aprobar y Agendar</span>
                            </button>

                            <form action="{{ route('admin.requests.reject', $req->id) }}" method="POST" class="w-full" onsubmit="return confirm('¿Seguro que deseas rechazar esta solicitud?');">
                                @csrf
                                <button type="submit" class="w-full border border-border py-3 text-[10px] uppercase tracking-widest font-black flex items-center justify-center gap-2 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/20 transition-all text-muted">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                    <span>Rechazar</span>
                                </button>
                            </form>
                        @elseif($req->status === 'APPROVED')
                            <span class="w-full py-3 bg-accent/10 border border-accent/30 text-accent text-center text-[10px] uppercase tracking-widest font-black">
                                Aprobada y Agendada
                            </span>
                        @else
                            <span class="w-full py-3 bg-red-500/10 border border-red-500/20 text-red-400 text-center text-[10px] uppercase tracking-widest font-black">
                                Solicitud Rechazada
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center border-2 border-dashed border-border group hover:border-accent/40 transition-colors">
                <p class="text-muted uppercase tracking-widest text-[10px] font-black group-hover:text-accent transition-colors">
                    No hay solicitudes en esta categoría
                </p>
            </div>
        @endforelse
    </div>

    {{-- Approval Modal --}}
    <div 
        x-show="approvingReq" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 bg-background/90 backdrop-blur-sm z-[100] flex items-center justify-center p-6"
        style="display: none;"
    >
        <div class="bg-surface border border-border p-8 md:p-10 max-w-lg w-full shadow-2xl relative">
            <h3 class="text-2xl font-serif font-black uppercase italic mb-2">Agendar Cita</h3>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold mb-6">
                Confirmar fecha, hora y precio para <span class="text-accent" x-text="approvingReq ? approvingReq.name : ''"></span>
            </p>

            <form 
                :action="'{{ url('admin/requests') }}/' + (approvingReq ? approvingReq.id : '') + '/approve'" 
                method="POST" 
                class="space-y-6"
            >
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Fecha</label>
                        <input 
                            type="date" 
                            name="date" 
                            :value="approvingReq ? approvingReq.date : ''"
                            required 
                            class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none"
                        >
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Hora</label>
                        <input 
                            type="time" 
                            name="time" 
                            :value="approvingReq ? approvingReq.time : '10:00'"
                            required 
                            class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none"
                        >
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Precio Estimado (CLP)</label>
                    <input 
                        type="number" 
                        name="price" 
                        placeholder="Ej: 150000" 
                        value="150000"
                        class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none"
                    >
                </div>

                <div class="bg-accent/5 border border-accent/20 p-4">
                    <p class="text-[9px] uppercase tracking-widest font-black text-accent mb-1">Nota del Agendamiento</p>
                    <p class="text-[10px] text-muted italic">Se creará una cita en estado CONFIRMADA con abono de $30.000 pendiente por confirmar.</p>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-accent text-accent-foreground py-4 text-[10px] uppercase font-black tracking-widest hover:bg-accent/90 shadow-md">
                        Confirmar Agenda
                    </button>
                    <button type="button" @click="approvingReq = null" class="px-8 border border-border text-muted py-4 text-[10px] uppercase font-black hover:text-foreground">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
