@extends('layouts.app')

@section('title', "Reservar Cita — FARFO'S TATTOO")

@section('content')
<div class="bg-background pt-24 pb-20" x-data="bookingWizard()">
    <section class="py-12">
        <div class="container mx-auto px-6 max-w-3xl">
            {{-- Header --}}
            <div class="mb-12 text-center">
                <h1 class="text-5xl md:text-7xl font-serif font-black mb-4 tracking-tighter uppercase">
                    Reservar <span class="text-accent italic">Cita</span>
                </h1>
                <p class="text-muted uppercase tracking-[0.2em] text-[10px] font-bold font-mono">
                    Paso <span x-text="step"></span> de 3 — 
                    <span x-show="step === 1">Tu Idea</span>
                    <span x-show="step === 2">Información</span>
                    <span x-show="step === 3">Agenda</span>
                </p>
            </div>

            {{-- Form Container --}}
            <div class="bg-surface border border-border p-8 md:p-14 shadow-2xl relative">
                {{-- Dynamic Progress Bar --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-background">
                    <div 
                        class="h-full bg-accent transition-all duration-500 ease-out"
                        :style="'width: ' + ((step / 3) * 100) + '%'"
                    ></div>
                </div>

                @if(isset($errors) && $errors->any())
                    <div class="mb-8 p-4 bg-red-500/10 border border-red-500/30 text-red-400 text-xs uppercase tracking-wider font-bold">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="booking-form" action="{{ route('booking.store') }}" method="POST" @submit="handleSubmit">
                    @csrf

                    {{-- Step 1: Tattoo Details --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" class="space-y-8">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                                <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                Cuéntanos tu idea
                            </label>
                            <textarea 
                                name="description"
                                x-model="formData.description"
                                placeholder="Ej: Serpiente en blackwork para el antebrazo..."
                                class="w-full bg-background border border-border p-5 text-sm focus:border-accent outline-none min-h-[140px] transition-colors"
                                required
                            >{{ old('description') }}</textarea>
                            <p x-show="step1Error" class="text-red-500 text-[10px] uppercase font-bold" x-text="step1Error"></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] uppercase tracking-widest font-black text-accent">Tamaño (cm)</label>
                                <select 
                                    name="size" 
                                    x-model="formData.size"
                                    class="w-full bg-background border border-border p-4 text-xs uppercase font-bold outline-none focus:border-accent"
                                    required
                                >
                                    <option value="">Seleccionar...</option>
                                    <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>Pequeño (2-5cm)</option>
                                    <option value="M" {{ old('size', 'M') == 'M' ? 'selected' : '' }}>Mediano (5-15cm)</option>
                                    <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>Grande (15-30cm)</option>
                                    <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>Pieza Completa</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] uppercase tracking-widest font-black text-accent">Zona del Cuerpo</label>
                                <input 
                                    type="text" 
                                    name="body_zone" 
                                    x-model="formData.body_zone"
                                    placeholder="Ej: Antebrazo" 
                                    value="{{ old('body_zone') }}"
                                    class="w-full bg-background border border-border p-4 text-xs uppercase font-bold outline-none focus:border-accent" 
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Contact Information --}}
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" style="display: none;" class="space-y-8">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                Nombre Completo
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                x-model="formData.name"
                                value="{{ old('name') }}"
                                placeholder="Tu nombre" 
                                class="w-full bg-background border border-border p-4 text-sm outline-none focus:border-accent"
                                required
                            >
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] uppercase tracking-widest font-black text-accent">Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    x-model="formData.email"
                                    value="{{ old('email') }}"
                                    placeholder="correo@ejemplo.com" 
                                    class="w-full bg-background border border-border p-4 text-sm outline-none focus:border-accent"
                                    required
                                >
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] uppercase tracking-widest font-black text-accent">WhatsApp / Teléfono</label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    x-model="formData.phone"
                                    value="{{ old('phone') }}"
                                    placeholder="+56 9 ..." 
                                    class="w-full bg-background border border-border p-4 text-sm outline-none focus:border-accent"
                                    required
                                >
                            </div>
                        </div>
                        <p x-show="step2Error" class="text-red-500 text-[10px] uppercase font-bold" x-text="step2Error"></p>
                    </div>

                    {{-- Step 3: Studio & Calendar Booking --}}
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" style="display: none;" class="space-y-12">
                        {{-- Studio Selector --}}
                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                Seleccionar Estudio
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="location" value="INKNEFABLE" x-model="formData.location" class="hidden peer">
                                    <div class="p-6 border border-border bg-background peer-checked:bg-accent peer-checked:text-accent-foreground peer-checked:border-accent transition-all group-hover:border-accent/40">
                                        <p class="text-xs uppercase font-black tracking-widest">INKNEFABLE</p>
                                        <p class="text-[9px] opacity-75 uppercase mt-1">Agustinas 814, Stgo. Centro</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="location" value="IL CAPO STUDIO" x-model="formData.location" class="hidden peer">
                                    <div class="p-6 border border-border bg-background peer-checked:bg-accent peer-checked:text-accent-foreground peer-checked:border-accent transition-all group-hover:border-accent/40">
                                        <p class="text-xs uppercase font-black tracking-widest">IL CAPO STUDIO</p>
                                        <p class="text-[9px] opacity-75 uppercase mt-1">Av. La Montaña 2850, Valle Grande</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Interactive Custom Calendar --}}
                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                Fecha Preferida
                            </label>

                            <input type="hidden" name="preferred_date" x-model="formData.preferred_date" required>

                            <div class="relative p-6 md:p-8 overflow-hidden rounded-sm border border-border shadow-2xl bg-[#0a0a0a]">
                                {{-- Month Header --}}
                                <div class="flex items-center justify-between mb-8">
                                    <h2 class="text-3xl md:text-4xl font-serif font-black uppercase italic text-accent tracking-tighter" x-text="currentMonthName"></h2>
                                    <div class="flex gap-3">
                                        <button type="button" @click="prevMonth" class="w-9 h-9 rounded-full border border-border flex items-center justify-center hover:bg-accent hover:text-accent-foreground transition-all">
                                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                        </button>
                                        <button type="button" @click="nextMonth" class="w-9 h-9 rounded-full border border-border flex items-center justify-center hover:bg-accent hover:text-accent-foreground transition-all">
                                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Calendar Legend --}}
                                <div class="flex items-center gap-3 mb-6 border-b border-border/40 pb-4 text-[9px] uppercase font-black tracking-widest">
                                    <div class="w-2 h-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.6)]"></div>
                                    <span class="text-muted">Días ocupados</span>
                                    <div class="ml-auto flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-accent"></div>
                                        <span class="text-accent">Seleccionado</span>
                                    </div>
                                </div>

                                {{-- Days Header --}}
                                <div class="grid grid-cols-7 mb-2 text-center text-[10px] font-black text-muted uppercase tracking-widest">
                                    <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
                                </div>

                                {{-- Calendar Days Grid --}}
                                <div class="grid grid-cols-7 gap-px bg-border/20 border border-border/20">
                                    <template x-for="day in calendarDays" :key="day.dateStr">
                                        <div 
                                            @click="!day.isPast && selectDate(day.dateStr)"
                                            :class="{
                                                'bg-surface/40 hover:bg-surface/70 cursor-pointer': !day.isPast,
                                                'cursor-not-allowed opacity-25 grayscale': day.isPast,
                                                'opacity-30': !day.isCurrentMonth,
                                                'bg-accent/15 border border-accent/60': formData.preferred_date === day.dateStr
                                            }"
                                            class="relative h-16 sm:h-20 flex flex-col items-center justify-center transition-all group"
                                        >
                                            <span 
                                                x-text="day.dayNum"
                                                :class="formData.preferred_date === day.dateStr ? 'text-accent font-black scale-110' : 'text-foreground/80'"
                                                class="text-sm font-bold transition-all"
                                            ></span>

                                            {{-- Red dot if reserved --}}
                                            <div 
                                                x-show="reservedDays.includes(day.dateStr)" 
                                                class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.6)]"
                                            ></div>

                                            {{-- Accent dot if selected --}}
                                            <div 
                                                x-show="formData.preferred_date === day.dateStr" 
                                                class="absolute bottom-1.5 w-1.5 h-1.5 rounded-full bg-accent"
                                            ></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <p x-show="step3Error" class="text-red-500 text-[10px] uppercase font-bold" x-text="step3Error"></p>
                        </div>

                        {{-- Time Slot Selector --}}
                        <div class="space-y-4">
                            <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                Jornada de Preferencia
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="preferred_time_slot" value="Morning" x-model="formData.preferred_time_slot" class="hidden peer">
                                    <div class="p-5 border border-border bg-background peer-checked:bg-accent peer-checked:text-accent-foreground peer-checked:border-accent transition-all group-hover:border-accent/40 text-center">
                                        <p class="text-xs uppercase font-black tracking-widest">Mañana</p>
                                        <p class="text-[9px] opacity-75 uppercase mt-1">10:00 - 14:00</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="preferred_time_slot" value="Afternoon" x-model="formData.preferred_time_slot" class="hidden peer">
                                    <div class="p-5 border border-border bg-background peer-checked:bg-accent peer-checked:text-accent-foreground peer-checked:border-accent transition-all group-hover:border-accent/40 text-center">
                                        <p class="text-xs uppercase font-black tracking-widest">Tarde</p>
                                        <p class="text-[9px] opacity-75 uppercase mt-1">15:00 - 19:00</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Wizard Action Controls --}}
                    <div class="flex justify-between items-center mt-12 pt-8 border-t border-border/40">
                        <button 
                            type="button" 
                            x-show="step > 1" 
                            @click="step--" 
                            class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-muted hover:text-foreground transition-all"
                        >
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver
                        </button>

                        <button 
                            type="button" 
                            x-show="step < 3" 
                            @click="nextStep" 
                            class="ml-auto flex items-center gap-2 bg-accent text-accent-foreground px-10 py-4 text-[10px] uppercase font-black tracking-widest hover:bg-accent/90 transition-all shadow-[0_0_20px_rgba(212,175,55,0.2)]"
                        >
                            Continuar <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>

                        <button 
                            type="submit" 
                            x-show="step === 3" 
                            class="ml-auto flex items-center gap-2 bg-accent text-accent-foreground px-10 py-4 text-[10px] uppercase font-black tracking-widest hover:bg-accent/90 transition-all shadow-[0_0_20px_rgba(212,175,55,0.2)]"
                        >
                            Enviar Propuesta <i data-lucide="check" class="w-4 h-4"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function bookingWizard() {
        return {
            step: 1,
            step1Error: '',
            step2Error: '',
            step3Error: '',
            formData: {
                description: '{{ old('description', '') }}',
                size: '{{ old('size', 'M') }}',
                body_zone: '{{ old('body_zone', '') }}',
                name: '{{ old('name', '') }}',
                email: '{{ old('email', '') }}',
                phone: '{{ old('phone', '') }}',
                location: '{{ old('location', 'INKNEFABLE') }}',
                preferred_date: '{{ old('preferred_date', '') }}',
                preferred_time_slot: '{{ old('preferred_time_slot', 'Morning') }}'
            },
            currentMonthDate: new Date(),
            reservedDays: [],
            calendarDays: [],

            init() {
                this.updateCalendar();
                this.fetchReservedDays();
            },

            nextStep() {
                if (this.step === 1) {
                    if (!this.formData.description || this.formData.description.length < 10) {
                        this.step1Error = 'Por favor, describe tu idea con más detalle (mínimo 10 caracteres).';
                        return;
                    }
                    if (!this.formData.size) {
                        this.step1Error = 'Elige un tamaño.';
                        return;
                    }
                    if (!this.formData.body_zone) {
                        this.step1Error = 'Dinos en qué zona del cuerpo deseas el tatuaje.';
                        return;
                    }
                    this.step1Error = '';
                    this.step = 2;
                } else if (this.step === 2) {
                    if (!this.formData.name || this.formData.name.length < 2) {
                        this.step2Error = 'Ingresa tu nombre completo.';
                        return;
                    }
                    if (!this.formData.email || !this.formData.email.includes('@')) {
                        this.step2Error = 'Ingresa un email válido.';
                        return;
                    }
                    if (!this.formData.phone || this.formData.phone.length < 8) {
                        this.step2Error = 'Ingresa un número telefónico o WhatsApp de contacto.';
                        return;
                    }
                    this.step2Error = '';
                    this.step = 3;
                }
                this.$nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); });
            },

            handleSubmit(e) {
                if (!this.formData.preferred_date) {
                    e.preventDefault();
                    this.step3Error = 'Por favor selecciona una fecha en el calendario.';
                    return;
                }
                this.step3Error = '';
            },

            get currentMonthName() {
                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                return months[this.currentMonthDate.getMonth()] + ' ' + this.currentMonthDate.getFullYear();
            },

            prevMonth() {
                this.currentMonthDate = new Date(this.currentMonthDate.getFullYear(), this.currentMonthDate.getMonth() - 1, 1);
                this.updateCalendar();
                this.fetchReservedDays();
            },

            nextMonth() {
                this.currentMonthDate = new Date(this.currentMonthDate.getFullYear(), this.currentMonthDate.getMonth() + 1, 1);
                this.updateCalendar();
                this.fetchReservedDays();
            },

            selectDate(dateStr) {
                this.formData.preferred_date = dateStr;
                this.step3Error = '';
            },

            async fetchReservedDays() {
                try {
                    const m = this.currentMonthDate.getMonth() + 1;
                    const y = this.currentMonthDate.getFullYear();
                    const res = await fetch(`{{ route('api.reserved-days') }}?month=${m}&year=${y}`);
                    if (res.ok) {
                        this.reservedDays = await res.json();
                    }
                } catch (e) {
                    console.error('Error fetching reserved days:', e);
                }
            },

            updateCalendar() {
                const year = this.currentMonthDate.getFullYear();
                const month = this.currentMonthDate.getMonth();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);

                // Monday is first day of week (index 0)
                let startOffset = firstDay.getDay() - 1;
                if (startOffset < 0) startOffset = 6;

                const days = [];
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                // Preceding days
                for (let i = startOffset; i > 0; i--) {
                    const d = new Date(year, month, 1 - i);
                    days.push({
                        dayNum: d.getDate(),
                        dateStr: this.formatDate(d),
                        isCurrentMonth: false,
                        isPast: d < today
                    });
                }

                // Month days
                for (let d = 1; d <= lastDay.getDate(); d++) {
                    const dateObj = new Date(year, month, d);
                    days.push({
                        dayNum: d,
                        dateStr: this.formatDate(dateObj),
                        isCurrentMonth: true,
                        isPast: dateObj < today
                    });
                }

                // Trailing days to fill 35 or 42 cells
                const totalCells = days.length <= 35 ? 35 : 42;
                const remaining = totalCells - days.length;
                for (let d = 1; d <= remaining; d++) {
                    const dateObj = new Date(year, month + 1, d);
                    days.push({
                        dayNum: d,
                        dateStr: this.formatDate(dateObj),
                        isCurrentMonth: false,
                        isPast: dateObj < today
                    });
                }

                this.calendarDays = days;
            },

            formatDate(date) {
                const y = date.getFullYear();
                const m = String(date.getMonth() + 1).padStart(2, '0');
                const d = String(date.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            }
        };
    }
</script>
@endpush
