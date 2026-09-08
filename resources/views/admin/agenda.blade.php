@extends('layouts.admin')

@section('title', "Agenda Global — FARFO'S TATTOO")

@section('content')
<div class="space-y-8 h-full flex flex-col" x-data="{ 
    selectedItem: null, 
    showBlockModal: false,
    viewMode: window.innerWidth < 1024 ? 'list' : 'month',
    listFilter: 'all'
}">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold mb-1 sm:mb-2">Agenda Global</h1>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold">Control total de citas y disponibilidad</p>
        </div>

        {{-- Mode Switcher (List vs Grid) --}}
        <div class="flex items-center gap-2 bg-surface border border-border p-1 rounded-sm w-full sm:w-auto justify-center sm:justify-start">
            <button 
                @click="viewMode = 'list'"
                :class="viewMode === 'list' ? 'bg-accent text-accent-foreground shadow-sm font-black' : 'text-muted hover:text-foreground font-bold'"
                class="flex-1 sm:flex-initial px-4 py-2 text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-1.5 focus:outline-none"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
                    <circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
                    <circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
                </svg>
                <span>Lista</span>
            </button>
            <button 
                @click="viewMode = 'month'"
                :class="viewMode === 'month' ? 'bg-accent text-accent-foreground shadow-sm font-black' : 'text-muted hover:text-foreground font-bold'"
                class="flex-1 sm:flex-initial px-4 py-2 text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-1.5 focus:outline-none"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>Grilla / Mes</span>
            </button>
        </div>

        <div class="flex items-center gap-4 w-full sm:w-auto">
            <button 
                @click="showBlockModal = true" 
                class="w-full sm:w-auto flex items-center justify-center gap-2 bg-accent text-accent-foreground px-6 py-3 text-[10px] uppercase tracking-[0.2em] font-black group transition-all shadow-[0_0_15px_rgba(212,175,55,0.2)]"
            >
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Nuevo Bloqueo / Cita</span>
            </button>
        </div>
    </div>

    {{-- Month Navigation Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface border border-border px-4 sm:px-6 py-4">
        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
            <h2 class="text-lg sm:text-xl font-serif font-bold min-w-max capitalize text-white">
                {{ $currentDate->isoFormat('MMMM YYYY') }}
            </h2>
            <div class="flex items-center gap-2">
                @php
                    $prevMonth = $currentDate->copy()->subMonth();
                    $nextMonth = $currentDate->copy()->addMonth();
                @endphp
                <a href="{{ route('admin.agenda', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" class="p-2 border border-border hover:border-accent text-foreground transition-colors" title="Mes Anterior">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('admin.agenda', ['year' => now()->year, 'month' => now()->month]) }}" class="px-3.5 py-1.5 text-[10px] uppercase tracking-widest font-bold border border-border hover:bg-white/5">
                    Hoy
                </a>
                <a href="{{ route('admin.agenda', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" class="p-2 border border-border hover:border-accent text-foreground transition-colors" title="Siguiente Mes">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-[10px] uppercase tracking-widest text-muted font-bold">
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-accent"></span> Abono Pagado
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Pendiente Abono
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Bloqueo
            </span>
        </div>
    </div>

    {{-- LIST VIEW (Default on Mobile) --}}
    <div x-show="viewMode === 'list'" class="space-y-6">
        {{-- List Filters --}}
        <div class="flex flex-wrap items-center gap-2 pb-1">
            <button 
                @click="listFilter = 'all'"
                :class="listFilter === 'all' ? 'bg-accent text-accent-foreground font-black shadow-sm' : 'bg-surface text-muted hover:text-foreground border border-border'"
                class="px-3.5 py-1.5 text-[10px] uppercase tracking-wider transition-all"
            >
                Todos ({{ $agendaItems->count() }})
            </button>
            <button 
                @click="listFilter = 'paid'"
                :class="listFilter === 'paid' ? 'bg-accent text-accent-foreground font-black shadow-sm' : 'bg-surface text-muted hover:text-foreground border border-border'"
                class="px-3.5 py-1.5 text-[10px] uppercase tracking-wider transition-all flex items-center gap-1.5"
            >
                <span class="w-2 h-2 rounded-full bg-accent"></span>
                <span>Abonados ({{ $agendaItems->where('payment_status', 'PAID')->count() }})</span>
            </button>
            <button 
                @click="listFilter = 'unpaid'"
                :class="listFilter === 'unpaid' ? 'bg-yellow-500 text-black font-black shadow-sm' : 'bg-surface text-muted hover:text-foreground border border-border'"
                class="px-3.5 py-1.5 text-[10px] uppercase tracking-wider transition-all flex items-center gap-1.5"
            >
                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                <span>Pendientes ({{ $agendaItems->where('payment_status', 'UNPAID')->count() }})</span>
            </button>
            <button 
                @click="listFilter = 'block'"
                :class="listFilter === 'block' ? 'bg-red-500 text-white font-black shadow-sm' : 'bg-surface text-muted hover:text-foreground border border-border'"
                class="px-3.5 py-1.5 text-[10px] uppercase tracking-wider transition-all flex items-center gap-1.5"
            >
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span>Bloqueos ({{ $agendaItems->where('type', 'BLOCK')->count() }})</span>
            </button>
        </div>

        @if($agendaItems->isEmpty())
            <div class="bg-surface border border-border p-10 sm:p-14 text-center space-y-4">
                <div class="w-14 h-14 rounded-full bg-accent/10 border border-accent/30 text-accent flex items-center justify-center mx-auto shadow-lg">
                    <i data-lucide="calendar-x" class="w-7 h-7"></i>
                </div>
                <h3 class="font-serif font-bold text-lg text-white">No hay citas ni bloqueos programados</h3>
                <p class="text-muted text-xs uppercase tracking-wider max-w-sm mx-auto leading-relaxed">
                    No se encontraron registros activos en la agenda para {{ $currentDate->isoFormat('MMMM YYYY') }}.
                </p>
                <button 
                    @click="showBlockModal = true" 
                    class="inline-flex items-center gap-2 bg-accent text-accent-foreground px-6 py-3 text-[10px] uppercase tracking-widest font-black shadow-md hover:bg-accent/90 transition-all"
                >
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Crear Nuevo Bloqueo o Cita</span>
                </button>
            </div>
        @else
            @php
                $groupedAgenda = $agendaItems->groupBy('date_key');
            @endphp

            <div class="space-y-6">
                @foreach($groupedAgenda as $dateKey => $items)
                    @php
                        $firstItem = $items->first();
                        $isToday = $firstItem['is_today'];
                    @endphp
                    <div class="space-y-3">
                        {{-- Date Group Header --}}
                        <div class="flex items-center justify-between border-b border-border/80 pb-2 px-1">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-serif font-bold text-sm sm:text-base capitalize text-white">
                                    {{ $firstItem['date_label'] }}
                                </h3>
                                @if($isToday)
                                    <span class="px-2 py-0.5 rounded-full bg-accent text-accent-foreground text-[9px] font-black uppercase tracking-widest">
                                        Hoy
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] font-mono uppercase tracking-widest text-muted font-bold">
                                {{ $items->count() }} {{ $items->count() === 1 ? 'evento' : 'eventos' }}
                            </span>
                        </div>

                        {{-- Items Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($items as $item)
                                @php
                                    $itemJson = json_encode($item);
                                    $isApp = $item['type'] === 'APPOINTMENT';
                                    $isPaid = $item['payment_status'] === 'PAID';
                                    $filterCategory = $isApp ? ($isPaid ? 'paid' : 'unpaid') : 'block';
                                @endphp
                                <div 
                                    x-show="listFilter === 'all' || listFilter === '{{ $filterCategory }}'"
                                    class="bg-surface border border-border p-4 sm:p-5 flex flex-col justify-between gap-4 transition-all hover:border-accent/50 group relative overflow-hidden shadow-sm"
                                >
                                    {{-- Accent indicator strip on left --}}
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $isApp ? ($isPaid ? 'bg-accent' : 'bg-yellow-500') : 'bg-red-500' }}"></div>

                                    <div class="space-y-2.5 pl-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-xs font-black tracking-wider text-foreground">
                                                    {{ $item['start_time'] }} - {{ $item['end_time'] }}
                                                </span>
                                            </div>

                                            @if($isApp)
                                                @if($isPaid)
                                                    <span class="inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-accent/15 border border-accent/40 text-accent">
                                                        <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                                                        <span>Abono Pagado</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-yellow-500/15 border border-yellow-500/40 text-yellow-500">
                                                        <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                                        <span>Pendiente Abono</span>
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-red-500/15 border border-red-500/40 text-red-400">
                                                    <i data-lucide="lock" class="w-3 h-3"></i>
                                                    <span>Bloqueo</span>
                                                </span>
                                            @endif
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-sm sm:text-base text-foreground tracking-tight group-hover:text-accent transition-colors">
                                                {{ $item['title'] }}
                                            </h4>
                                            <p class="text-xs text-muted font-medium mt-0.5">
                                                {{ $item['client_name'] }}
                                                @if(!empty($item['client_phone']))
                                                    • <span class="text-accent/90">{{ $item['client_phone'] }}</span>
                                                @endif
                                            </p>
                                        </div>

                                        @if(!empty($item['description']))
                                            <p class="text-[11px] text-muted/80 line-clamp-2 italic border-l border-border/80 pl-2">
                                                &ldquo;{{ $item['description'] }}&rdquo;
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center justify-between border-t border-border/50 pt-3 pl-2 gap-2">
                                        <button 
                                            type="button"
                                            @click="selectedItem = {{ $itemJson }}"
                                            class="text-[10px] uppercase tracking-widest font-black text-accent hover:text-white flex items-center gap-1 transition-colors"
                                        >
                                            <span>Ver Ficha / Opciones</span>
                                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                        </button>

                                        @if($isApp && !$isPaid)
                                            <form action="{{ url('admin/agenda/confirm-deposit') }}/{{ $item['id'] }}" method="POST" onsubmit="return confirm('¿Confirmar recepción del abono de $30.000?');">
                                                @csrf
                                                <button type="submit" class="bg-accent/20 hover:bg-accent text-accent hover:text-black border border-accent/40 text-[9px] font-black uppercase tracking-widest px-2.5 py-1.5 transition-all shadow-sm">
                                                    Confirmar $30.000
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- MONTHLY CALENDAR GRID (Desktop or manual toggle) --}}
    <div x-show="viewMode === 'month'" class="flex-grow bg-surface border border-border overflow-x-auto relative shadow-2xl">
        <div class="min-w-[720px] lg:min-w-0">
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
        </div>
    </div>

    {{-- Detail Slide-Over Drawer Backdrop --}}
    <div 
        x-show="selectedItem" 
        @click="selectedItem = null"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50"
        style="display: none;"
    ></div>

    {{-- Detail Slide-Over Drawer --}}
    <div 
        x-show="selectedItem" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-full sm:w-[420px] h-full bg-surface border-l border-border shadow-2xl p-6 sm:p-8 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex justify-between items-start mb-8 border-b border-border pb-4">
            <div>
                <h3 class="text-xl font-serif font-black uppercase italic text-accent">Detalle de Agenda</h3>
                <p class="text-[10px] text-muted uppercase tracking-widest mt-0.5" x-text="selectedItem ? selectedItem.date_label : ''"></p>
            </div>
            <button @click="selectedItem = null" class="text-muted hover:text-foreground p-1 rounded hover:bg-white/5" aria-label="Cerrar">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <template x-if="selectedItem">
            <div class="space-y-6">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-muted mb-1">Título / Registro</p>
                    <p class="font-bold text-lg text-foreground" x-text="selectedItem.title"></p>
                    <p class="text-xs text-muted mt-0.5" x-text="selectedItem.client_name"></p>
                    <template x-if="selectedItem.client_phone">
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-xs text-accent font-bold" x-text="selectedItem.client_phone"></span>
                            <a 
                                :href="'https://wa.me/' + selectedItem.client_phone.replace(/[^0-9]/g, '')"
                                target="_blank"
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[10px] uppercase tracking-wider font-bold hover:bg-emerald-500/30"
                            >
                                WhatsApp
                            </a>
                        </div>
                    </template>
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

                {{-- Appointment Specific Details --}}
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

                {{-- TimeBlock Specific Details --}}
                <template x-if="selectedItem.type === 'BLOCK'">
                    <div class="space-y-4">
                        <div class="p-4 border border-red-500/30 bg-red-500/10 text-red-400 font-bold text-xs uppercase tracking-widest text-center">
                            Franja de Horario Bloqueada
                        </div>
                        <template x-if="selectedItem.description">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-muted mb-1">Motivo / Detalle</p>
                                <p class="text-xs text-muted italic" x-text="selectedItem.description"></p>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>
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
        class="fixed inset-0 bg-background/90 backdrop-blur-sm z-[100] flex items-center justify-center p-4 sm:p-6"
        style="display: none;"
    >
        <div class="bg-surface border border-border p-6 sm:p-10 max-w-md w-full shadow-2xl relative">
            <h3 class="text-xl sm:text-2xl font-serif font-black uppercase italic mb-2">Crear Bloqueo de Horario</h3>
            <p class="text-muted text-[10px] uppercase tracking-widest font-bold mb-6">Bloquear franja horaria en la agenda</p>

            <form action="{{ route('admin.agenda.create-block') }}" method="POST" class="space-y-5">
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
                    <button type="button" @click="showBlockModal = false" class="px-5 border border-border text-muted py-3 text-[10px] uppercase font-black hover:text-foreground">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
