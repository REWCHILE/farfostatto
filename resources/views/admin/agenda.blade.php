@extends('layouts.admin')

@section('title', "Agenda Global — FARFO'S TATTOO")

@section('content')
<div class="space-y-8 h-full flex flex-col" x-data="{ 
    selectedItem: null, 
    showBlockModal: false,
    viewMode: 'month'
}">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-serif font-bold mb-2">Agenda Global</h1>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold">Control total de citas y disponibilidad</p>
        </div>

        <div class="flex items-center gap-4 bg-surface border border-border p-1 rounded-sm">
            <button 
                @click="viewMode = 'month'"
                :class="viewMode === 'month' ? 'bg-accent text-accent-foreground' : 'text-muted hover:text-foreground'"
                class="px-4 py-2 text-[10px] uppercase tracking-widest font-black transition-all"
            >
                Mes
            </button>
            <button 
                @click="viewMode = 'week'"
                :class="viewMode === 'week' ? 'bg-accent text-accent-foreground' : 'text-muted hover:text-foreground'"
                class="px-4 py-2 text-[10px] uppercase tracking-widest font-black transition-all"
            >
                Semana
            </button>
            <button 
                @click="viewMode = 'day'"
                :class="viewMode === 'day' ? 'bg-accent text-accent-foreground' : 'text-muted hover:text-foreground'"
                class="px-4 py-2 text-[10px] uppercase tracking-widest font-black transition-all"
            >
                Día
            </button>
        </div>

        <div class="flex items-center gap-4">
            <button 
                @click="showBlockModal = true" 
                class="flex items-center gap-2 bg-accent text-accent-foreground px-6 py-3 text-[10px] uppercase tracking-[0.2em] font-black group transition-all shadow-[0_0_15px_rgba(212,175,55,0.2)]"
            >
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Nuevo Bloqueo / Cita</span>
            </button>
        </div>
    </div>

    {{-- Month Navigation Bar --}}
    <div class="flex justify-between items-center bg-surface border border-border px-6 py-4">
        <div class="flex items-center gap-6">
            <h2 class="text-xl font-serif font-bold min-w-[200px] capitalize text-white">
                {{ $currentDate->isoFormat('MMMM YYYY') }}
            </h2>
            <div class="flex items-center gap-2">
                @php
                    $prevMonth = $currentDate->copy()->subMonth();
                    $nextMonth = $currentDate->copy()->addMonth();
                @endphp
                <a href="{{ route('admin.agenda', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" class="p-2 border border-border hover:border-accent transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('admin.agenda', ['year' => now()->year, 'month' => now()->month]) }}" class="px-4 py-2 text-[10px] uppercase tracking-widest font-bold border border-border hover:bg-white/5">
                    Hoy
                </a>
                <a href="{{ route('admin.agenda', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" class="p-2 border border-border hover:border-accent transition-colors">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-[10px] uppercase tracking-widest text-muted font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-accent"></span> Abono Pagado
            </span>
            <span class="text-[10px] uppercase tracking-widest text-muted font-bold flex items-center gap-1.5 ml-3">
                <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Pendiente Abono
            </span>
            <span class="text-[10px] uppercase tracking-widest text-muted font-bold flex items-center gap-1.5 ml-3">
                <span class="w-2 h-2 rounded-full bg-red-500"></span> Bloqueo
            </span>
        </div>
    </div>

    {{-- Monthly Calendar Grid --}}
    <div class="flex-grow bg-surface border border-border overflow-hidden relative shadow-2xl">
        {{-- Days of week header --}}
        <div class="grid grid-cols-7 border-b border-border bg-background/50">
            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dayName)
                <div class="py-4 text-center text-[10px] uppercase tracking-[0.3em] font-black text-muted">
                    {{ $dayName }}
                </div>
            @endforeach
        </div>

        {{-- Cells --}}
        <div class="grid grid-cols-7">
            @foreach($calendarDays as $cell)
                <div 
                    class="min-h-[135px] border-r border-b border-border p-3 transition-colors hover:bg-white/5 relative {{ !$cell['is_current_month'] ? 'bg-background/40 opacity-30' : '' }} {{ $cell['is_today'] ? 'bg-accent/5 ring-1 ring-inset ring-accent/30' : '' }}"
                >
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full {{ $cell['is_today'] ? 'bg-accent text-accent-foreground' : 'text-muted' }}">
                            {{ $cell['day_num'] }}
                        </span>
                    </div>

                    {{-- Day Items Preview --}}
                    <div class="space-y-1.5 overflow-hidden">
                        {{-- Appointments --}}
                        @foreach($cell['appointments'] as $app)
                            @php
                                $isPaid = $app->payment_status === 'PAID';
                                $itemJson = json_encode([
                                    'id' => $app->id,
                                    'title' => $app->title,
                                    'client_name' => $app->client->name ?? 'Cliente',
                                    'client_email' => $app->client->email ?? '',
                                    'client_phone' => $app->client->phone ?? '',
                                    'start_time' => \Carbon\Carbon::parse($app->start_time)->format('H:i'),
                                    'end_time' => \Carbon\Carbon::parse($app->end_time)->format('H:i'),
                                    'date_label' => \Carbon\Carbon::parse($app->start_time)->isoFormat('D [de] MMMM YYYY'),
                                    'type' => 'APPOINTMENT',
                                    'payment_status' => $app->payment_status,
                                    'deposit_amount' => number_format($app->deposit_amount, 0, ',', '.'),
                                    'price' => number_format($app->price ?? 150000, 0, ',', '.'),
                                    'description' => $app->description,
                                    'location' => $app->location ?? 'INKNEFABLE',
                                ]);
                            @endphp
                            <button 
                                type="button"
                                @click="selectedItem = {{ $itemJson }}"
                                class="w-full text-[9px] p-2 truncate border font-bold uppercase tracking-wider text-left transition-all hover:scale-[1.02] flex items-center justify-between {{ $isPaid ? 'bg-accent/10 border-accent/30 text-accent' : 'bg-yellow-500/10 border-yellow-500/30 text-yellow-500' }}"
                            >
                                <span class="truncate">
                                    {{ \Carbon\Carbon::parse($app->start_time)->format('H:i') }} • {{ $app->title }}
                                </span>
                                <i data-lucide="{{ $isPaid ? 'badge-check' : 'shield-alert' }}" class="w-3 h-3 shrink-0 ml-1"></i>
                            </button>
                        @endforeach

                        {{-- TimeBlocks --}}
                        @foreach($cell['blocks'] as $blk)
                            @php
                                $blkJson = json_encode([
                                    'id' => $blk->id,
                                    'title' => 'Bloqueo: ' . $blk->type,
                                    'client_name' => 'Estudio FARFO\'S',
                                    'start_time' => \Carbon\Carbon::parse($blk->start_time)->format('H:i'),
                                    'end_time' => \Carbon\Carbon::parse($blk->end_time)->format('H:i'),
                                    'date_label' => \Carbon\Carbon::parse($blk->start_time)->isoFormat('D [de] MMMM YYYY'),
                                    'type' => 'BLOCK',
                                    'description' => $blk->description ?? 'Horario reservado para descanso o mantención.',
                                ]);
                            @endphp
                            <button 
                                type="button"
                                @click="selectedItem = {{ $blkJson }}"
                                class="w-full text-[9px] p-2 truncate border font-bold uppercase tracking-wider text-left transition-all hover:scale-[1.02] bg-red-500/10 border-red-500/30 text-red-400 flex items-center justify-between"
                            >
                                <span class="truncate">
                                    {{ \Carbon\Carbon::parse($blk->start_time)->format('H:i') }} • {{ $blk->type }}
                                </span>
                                <i data-lucide="lock" class="w-3 h-3 shrink-0 ml-1"></i>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Detail Slide-Over Drawer --}}
        <div 
            x-show="selectedItem" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 w-84 md:w-96 h-full bg-surface border-l border-border shadow-2xl p-8 z-30 overflow-y-auto"
            style="display: none;"
        >
            <div class="flex justify-between items-start mb-8">
                <h3 class="text-xl font-serif font-black uppercase italic text-accent">Detalle de Cita</h3>
                <button @click="selectedItem = null" class="text-muted hover:text-foreground">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <template x-if="selectedItem">
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-muted mb-1">Título / Cliente</p>
                        <p class="font-bold text-base text-foreground" x-text="selectedItem.title"></p>
                        <p class="text-xs text-muted mt-0.5" x-text="selectedItem.client_name"></p>
                        <p class="text-xs text-accent mt-0.5" x-text="selectedItem.client_phone"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-y border-border py-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-muted mb-1">Inicio</p>
                            <p class="text-base font-mono font-bold text-foreground" x-text="selectedItem.start_time"></p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-muted mb-1">Fin</p>
                            <p class="text-base font-mono font-bold text-foreground" x-text="selectedItem.end_time"></p>
                        </div>
                    </div>

                    {{-- Appointment Details --}}
                    <template x-if="selectedItem.type === 'APPOINTMENT'">
                        <div class="space-y-6">
                            <div 
                                :class="selectedItem.payment_status === 'PAID' ? 'bg-accent/10 border-accent/30 text-accent' : 'bg-yellow-500/10 border-yellow-500/30 text-yellow-500'"
                                class="p-4 border font-black text-center text-xs uppercase tracking-widest"
                            >
                                <span x-text="selectedItem.payment_status === 'PAID' ? 'Abono Recibido: PAGADA' : 'Abono: PENDIENTE'"></span>
                                <p class="text-[10px] mt-1 opacity-80" x-text="'$ ' + selectedItem.deposit_amount + ' CLP'"></p>
                            </div>

                            {{-- Actions if unpaid --}}
                            <template x-if="selectedItem.payment_status === 'UNPAID'">
                                <div class="pt-2 space-y-3">
                                    <form :action="'{{ url('admin/agenda/confirm-deposit') }}/' + selectedItem.id" method="POST" onsubmit="return confirm('¿Confirmar recepción del abono de $30.000?');">
                                        @csrf
                                        <button type="submit" class="w-full bg-accent text-accent-foreground py-3 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-accent/90 shadow-md">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                            <span>Confirmar Pago $30.000</span>
                                        </button>
                                    </form>

                                    <form :action="'{{ url('admin/agenda/release') }}/' + selectedItem.id" method="POST" onsubmit="return confirm('¿Seguro que deseas liberar esta hora? La cita se eliminará.');">
                                        @csrf
                                        <button type="submit" class="w-full border border-red-500/30 text-red-400 py-3 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-red-500/10 transition-all">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                            <span>Liberar Hora</span>
                                        </button>
                                    </form>
                                </div>
                            </template>

                            <template x-if="selectedItem.description">
                                <div class="pt-2">
                                    <p class="text-[10px] uppercase tracking-widest text-muted mb-2">Descripción del Tatuaje</p>
                                    <p class="text-xs text-muted leading-relaxed italic border-l-2 border-accent/30 pl-3 py-1" x-text="'&ldquo;' + selectedItem.description + '&rdquo;'"></p>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- Create TimeBlock Modal --}}
    <div 
        x-show="showBlockModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 bg-background/90 backdrop-blur-sm z-[100] flex items-center justify-center p-6"
        style="display: none;"
    >
        <div class="bg-surface border border-border p-8 md:p-10 max-w-md w-full shadow-2xl relative">
            <h3 class="text-2xl font-serif font-black uppercase italic mb-2">Crear Bloqueo de Horario</h3>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold mb-6">Bloquear franja horaria en la agenda</p>

            <form action="{{ route('admin.agenda.create-block') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Fecha</label>
                    <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Hora Inicio</label>
                        <input type="time" name="start_time" value="14:00" required class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Hora Fin</label>
                        <input type="time" name="end_time" value="15:00" required class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Motivo</label>
                    <select name="type" required class="w-full bg-background border border-border p-3 text-xs uppercase font-bold focus:border-accent outline-none">
                        <option value="LUNCH">Almuerzo / Colación</option>
                        <option value="VACATION">Vacaciones / Feriado</option>
                        <option value="PERSONAL">Asunto Personal</option>
                        <option value="CLOSED">Estudio Cerrado</option>
                        <option value="OTHER">Otro</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-accent">Nota (Opcional)</label>
                    <input type="text" name="description" placeholder="Ej: Esterilización de instrumental" class="w-full bg-background border border-border p-3 text-sm focus:border-accent outline-none">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-accent text-accent-foreground py-3 text-[10px] uppercase font-black tracking-widest hover:bg-accent/90 shadow-md">
                        Guardar Bloqueo
                    </button>
                    <button type="button" @click="showBlockModal = false" class="px-6 border border-border text-muted py-3 text-[10px] uppercase font-black hover:text-foreground">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
