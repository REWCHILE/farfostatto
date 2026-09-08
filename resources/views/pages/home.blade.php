@extends('layouts.app')

@section('title', "FARFO'S TATTOO — Arte en tu Piel")

@section('content')
<div class="bg-background text-foreground">

    {{-- Hero Section --}}
    <section 
        id="hero-section"
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-background"
    >
        {{-- Background Cinematic Particles Canvas --}}
        <canvas 
            id="hero-particles" 
            class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-40 z-0"
            style="filter: blur(1.5px);"
        ></canvas>

        {{-- Background Radial Gold Glow --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[140%] pointer-events-none opacity-20">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(circle_at_center,var(--accent)_0%,transparent_70%)] blur-[120px]"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center pt-24 pb-16">
            {{-- Subtitle Badge --}}
            <div id="hero-badge" class="mb-6 opacity-0">
                <span class="text-accent uppercase tracking-[0.6em] text-xs font-bold bg-accent/10 px-5 py-2.5 rounded-full border border-accent/20">
                    Premium Tattoo Studio
                </span>
            </div>

            {{-- Main Title with Split Text Animation --}}
            <h1 id="hero-title" class="text-6xl md:text-8xl lg:text-[9.5rem] font-serif font-black tracking-tighter leading-[0.9] mb-8 select-none">
                <div class="overflow-hidden">
                    <span class="hero-line block">ARTE EN</span>
                </div>
                <div class="overflow-hidden text-accent italic">
                    <span class="hero-line block">TU PIEL</span>
                </div>
            </h1>

            {{-- Call To Action Buttons --}}
            <div id="hero-cta" class="flex flex-col sm:flex-row items-center justify-center gap-6 mt-12 opacity-0">
                <a
                    href="{{ route('booking') }}"
                    class="group relative px-10 py-5 bg-accent text-accent-foreground font-bold uppercase tracking-widest text-xs overflow-hidden shadow-[0_0_30px_rgba(212,175,55,0.25)]"
                >
                    <span class="relative z-10 flex items-center gap-3">
                        Reserva tu sesión 
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute top-0 left-0 w-full h-full bg-white/20 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                </a>

                <a
                    href="{{ route('portfolio') }}"
                    class="px-10 py-5 border border-border hover:border-accent hover:text-accent transition-all font-bold uppercase tracking-widest text-xs"
                >
                    Ver Portafolio
                </a>
            </div>
        </div>

        {{-- Decorative Watermark Text --}}
        <div class="absolute bottom-10 left-10 hidden lg:block overflow-hidden pointer-events-none">
            <span class="text-[10vw] font-serif font-black text-white/[0.02] leading-none select-none uppercase">
                FARFO'S TATTOO
            </span>
        </div>
    </section>

    {{-- Presentation Section: El Ritual de las Imágenes con Video Slider --}}
    <section 
        id="ritual"
        x-data="{
            activeIndex: 0,
            activeReel: 0,
            videoPlaying: true,
            reels: [
                {
                    title: 'Retrato Realista & Bull Terrier',
                    category: 'Antes & Después',
                    tag: 'Antes & Después',
                    desc: 'Transformación y homenaje canino sobre el hombro.',
                    video: '{{ asset('videos/ritual_antes_despues.mp4') }}',
                    poster: '{{ asset('videos/ritual_antes_despues_after.jpg') }}',
                    instagram: 'https://www.instagram.com/p/Db-y_0Jx6l5/',
                    label: '01. Retrato Bull Terrier'
                },
                {
                    title: 'Línea & Proceso Pokémon',
                    category: 'Sesión en Vivo',
                    tag: 'Sesión en Vivo',
                    desc: 'Evolución de Gengar y Haunter en pierna completa.',
                    video: '{{ asset('videos/ritual_slider_2.mp4') }}',
                    poster: '{{ asset('videos/ritual_slider_2_reveal.jpg') }}',
                    instagram: 'https://www.instagram.com/p/DZsFjYCvcig/',
                    label: '02. Pierna Pokémon'
                }
            ],
            specs: [
                {
                    icon: 'shield-check',
                    title: 'Asepsia Clínica',
                    category: 'Bioseguridad',
                    description: 'Protocolos quirúrgicos rigurosos, campo estéril y desprecintado de insumos de grado médico frente al cliente.'
                },
                {
                    icon: 'zap',
                    title: 'Tecnología Rotativa',
                    category: 'Precisión',
                    description: 'Uso de máquinas rotativas de última generación para líneas microscópicas, trazo limpio y menor trauma en la piel.'
                },
                {
                    icon: 'star',
                    title: 'Insumos Premium',
                    category: 'Pigmentos',
                    description: 'Pigmentos veganos de alta fijación (Electric Ink) y cartuchos certificados internacionalmente para saturación duradera.'
                },
                {
                    icon: 'palette',
                    title: 'Diseño Anatómico',
                    category: 'Composición',
                    description: 'Cada obra es concebida y adaptada para fluir en armonía orgánica con la musculatura y contorno del cuerpo.'
                }
            ],
            selectReel(index) {
                this.activeReel = index;
                this.videoPlaying = true;
                this.$nextTick(() => {
                    if (this.$refs.ritualVideo) {
                        this.$refs.ritualVideo.load();
                        this.$refs.ritualVideo.play().catch(() => {});
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            },
            nextReel() {
                this.selectReel((this.activeReel + 1) % this.reels.length);
            },
            prevReel() {
                this.selectReel((this.activeReel - 1 + this.reels.length) % this.reels.length);
            },
            toggleRitualVideo() {
                if (!this.$refs.ritualVideo) return;
                if (this.$refs.ritualVideo.paused) {
                    this.$refs.ritualVideo.play();
                    this.videoPlaying = true;
                } else {
                    this.$refs.ritualVideo.pause();
                    this.videoPlaying = false;
                }
            },
            init() {
                setInterval(() => {
                    this.activeIndex = (this.activeIndex + 1) % this.specs.length;
                    this.$nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); });
                }, 5000);

                this.$nextTick(() => {
                    if (this.$refs.ritualVideo) {
                        this.$refs.ritualVideo.play().catch(() => {});
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            }
        }"
        class="py-32 bg-surface relative overflow-hidden border-t border-border/40"
    >
        {{-- Radial Background Ambience --}}
        <div 
            class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] pointer-events-none opacity-[0.05]"
            style="background: radial-gradient(circle at center, var(--accent) 0%, transparent 50%); filter: blur(140px);"
        ></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                {{-- Left Column: Story, Philosophy & Controls (5 cols) --}}
                <div class="lg:col-span-5 space-y-8">
                    {{-- Section Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-accent/20 bg-accent/10">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent"></i>
                        <span class="text-accent uppercase tracking-[0.35em] text-[10px] font-black">Filosofía & Trayectoria</span>
                    </div>

                    {{-- Section Title --}}
                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif font-black uppercase tracking-tighter leading-[0.95]">
                        El Ritual de las <span class="text-accent italic">Imágenes</span>, <br />
                        Historias en tu <span class="text-accent italic">Piel</span>.
                    </h2>

                    {{-- Description --}}
                    <p class="text-muted leading-relaxed uppercase tracking-[0.16em] text-xs font-semibold max-w-xl">
                        Sebastián, El Farfo, combina su formación académica con la maestría del tatuaje moderno. Cada diseño es un diálogo consciente sobre un soporte vivo, transformando memorias, tributos y pasiones en obras imperecederas.
                    </p>

                    {{-- Interactive Spec Switcher Pills --}}
                    <div class="pt-2 space-y-3">
                        <div class="text-[10px] uppercase tracking-[0.25em] text-accent font-black flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            Pilares de Excelencia Técnica
                        </div>
                        <div class="grid grid-cols-2 gap-2.5">
                            <template x-for="(spec, i) in specs" :key="i">
                                <button
                                    @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })"
                                    :class="activeIndex === i 
                                        ? 'bg-accent text-accent-foreground border-accent font-black shadow-[0_0_15px_rgba(212,175,55,0.25)]' 
                                        : 'bg-card/70 text-foreground/70 border-border hover:border-accent/40 hover:text-foreground'"
                                    class="p-3 border text-left flex items-center gap-2.5 text-xs uppercase tracking-wider transition-all duration-300 focus:outline-none"
                                >
                                    <i :data-lucide="spec.icon" class="w-4 h-4 shrink-0"></i>
                                    <span class="truncate text-[11px] font-bold" x-text="spec.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a 
                            href="{{ route('portfolio') }}" 
                            class="group relative px-8 py-4 bg-accent text-accent-foreground text-xs uppercase font-black tracking-[0.25em] overflow-hidden transition-all hover:shadow-[0_0_25px_rgba(212,175,55,0.3)] text-center"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Ver Portafolio 
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-500"></i>
                            </span>
                            <div class="absolute inset-0 bg-white/10 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                        </a>
                        <a 
                            href="{{ route('about') }}" 
                            class="group px-8 py-4 border border-border text-foreground text-xs uppercase font-black tracking-[0.25em] hover:border-accent transition-all duration-500 text-center"
                        >
                            <span class="flex items-center justify-center gap-2">
                                Sobre Mí 
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-500"></i>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Right Column (7 cols): Interactive Video Reel Slider + Rotating Pillar Card --}}
                <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                    
                    {{-- 1. Video Reels Slider Card (7 cols of 12) --}}
                    <div class="md:col-span-7 flex flex-col space-y-3">
                        <div class="relative aspect-[9/16] bg-card border border-border/80 overflow-hidden shadow-2xl group flex items-center justify-center">
                            
                            {{-- Top Live Badge --}}
                            <div class="absolute top-4 left-4 z-20 flex items-center gap-2">
                                <span class="bg-black/85 backdrop-blur-md border border-accent/40 text-accent px-3 py-1.5 text-[10px] uppercase tracking-[0.2em] font-black flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                                    <span x-text="reels[activeReel].tag"></span>
                                </span>
                            </div>

                            {{-- Top Right Instagram Handle & Slide Counter --}}
                            <a 
                                :href="reels[activeReel].instagram"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="absolute top-4 right-4 z-20 bg-black/85 backdrop-blur-md border border-white/10 text-muted hover:text-accent px-2.5 py-1 text-[10px] font-mono tracking-wider transition-colors flex items-center gap-1"
                                title="Ver en Instagram"
                            >
                                <span class="text-accent font-bold" x-text="'0' + (activeReel + 1) + '/02'"></span>
                                <i data-lucide="instagram" class="w-3 h-3 ml-1"></i>
                            </a>

                            {{-- Active Video Reel --}}
                            <video
                                x-ref="ritualVideo"
                                :src="reels[activeReel].video"
                                :poster="reels[activeReel].poster"
                                autoplay
                                muted
                                loop
                                playsinline
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            ></video>

                            {{-- Slider Navigation Arrows Overlay --}}
                            <button
                                @click="prevReel()"
                                class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/80 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md shadow-lg transition-all focus:outline-none"
                                title="Video Anterior"
                            >
                                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                            </button>

                            <button
                                @click="nextReel()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/80 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md shadow-lg transition-all focus:outline-none"
                                title="Siguiente Video"
                            >
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </button>

                            {{-- Play/Pause Overlay Button --}}
                            <button
                                @click="toggleRitualVideo()"
                                class="absolute bottom-4 right-4 z-20 w-10 h-10 rounded-full bg-black/85 border border-accent/40 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none"
                                :title="videoPlaying ? 'Pausar Video' : 'Reproducir Video'"
                            >
                                <i :data-lucide="videoPlaying ? 'pause' : 'play'" class="w-4 h-4"></i>
                            </button>

                            {{-- Bottom Left Video Title Tag --}}
                            <div class="absolute bottom-4 left-4 z-20 max-w-[70%] bg-black/85 backdrop-blur-sm border border-white/10 px-3 py-1.5 text-[10px] uppercase tracking-wider text-foreground/90 font-bold flex items-center gap-1.5">
                                <i data-lucide="video" class="w-3 h-3 text-accent shrink-0"></i>
                                <span class="truncate" x-text="reels[activeReel].title"></span>
                            </div>

                            {{-- Corner Gold Accents --}}
                            <div class="absolute -top-1 -left-1 w-5 h-5 border-t-2 border-l-2 border-accent pointer-events-none z-30"></div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 border-b-2 border-r-2 border-accent pointer-events-none z-30"></div>
                        </div>

                        {{-- Reel Switcher Tabs Below Video Player --}}
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="(reel, rIndex) in reels" :key="rIndex">
                                <button
                                    @click="selectReel(rIndex)"
                                    :class="activeReel === rIndex 
                                        ? 'bg-accent/20 border-accent text-accent font-bold' 
                                        : 'bg-card/60 border-border/70 text-muted hover:border-accent/40 hover:text-foreground'"
                                    class="py-2 px-3 border text-left text-[10px] uppercase tracking-wider transition-all flex items-center justify-between"
                                >
                                    <span class="truncate" x-text="reel.label"></span>
                                    <span :class="activeReel === rIndex ? 'w-2 h-2 rounded-full bg-accent' : 'w-1.5 h-1.5 rounded-full bg-border'"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- 2. Rotating Spec Details Card (5 cols of 12) --}}
                    <div class="md:col-span-5 flex flex-col justify-between bg-card/90 border border-border/80 p-6 sm:p-8 backdrop-blur-xl relative overflow-hidden shadow-2xl">
                        {{-- Background Watermark Icon --}}
                        <div class="absolute -right-6 -bottom-6 opacity-5 pointer-events-none text-accent">
                            <i data-lucide="award" class="w-36 h-36"></i>
                        </div>

                        <div class="space-y-6 relative z-10">
                            {{-- Top Category & Indicator --}}
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 border border-accent/30 flex items-center justify-center text-accent bg-accent/10">
                                    <i :data-lucide="specs[activeIndex].icon" class="w-6 h-6"></i>
                                </div>
                                <span class="text-[10px] uppercase tracking-widest font-mono text-muted">
                                    Pilar 0<span x-text="activeIndex + 1"></span> / 04
                                </span>
                            </div>

                            {{-- Active Pillar Content --}}
                            <div class="space-y-3">
                                <span class="text-accent text-[10px] uppercase tracking-[0.3em] font-black" x-text="specs[activeIndex].category"></span>
                                <h4 x-text="specs[activeIndex].title" class="font-serif font-black text-2xl sm:text-3xl uppercase tracking-tight text-foreground leading-tight"></h4>
                                <p x-text="specs[activeIndex].description" class="text-xs text-muted uppercase tracking-[0.14em] leading-relaxed font-bold"></p>
                            </div>
                        </div>

                        {{-- Progress Dots & Direct Reel Link --}}
                        <div class="pt-6 relative z-10 space-y-4">
                            <div class="flex gap-2">
                                <template x-for="(s, i) in specs" :key="i">
                                    <button 
                                        @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })" 
                                        :class="i === activeIndex ? 'w-8 bg-accent' : 'w-2 bg-border hover:bg-muted'"
                                        class="h-1 transition-all duration-300 focus:outline-none"
                                    ></button>
                                </template>
                            </div>

                            <a 
                                :href="reels[activeReel].instagram" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-accent/80 hover:text-accent font-bold pt-2 transition-colors group"
                            >
                                <i data-lucide="instagram" class="w-3.5 h-3.5 text-accent"></i>
                                <span>Ver reel activo en Instagram</span>
                                <i data-lucide="arrow-up-right" class="w-3 h-3 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                            </a>
                        </div>

                        {{-- Corner Line --}}
                        <div class="absolute -bottom-3 -right-3 w-16 h-16 border-r-2 border-b-2 border-accent/20 pointer-events-none"></div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- Mi Proceso de Tatuaje Section --}}
    <section 
        id="proceso"
        x-data="{
            activeStep: 4, // Default to Step 5 (index 4: Color Shenlong - slide 7) as highlighted
            isPlaying: true,
            photoAngle: 1,
            steps: [
                {
                    num: '01',
                    badge: 'PREPARACIÓN & ANATOMÍA',
                    title: 'Calco y Adaptación Anatómica',
                    short: '01. Calco Anatómico',
                    tag: 'Diseño en Piel',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-1-calco.mp4') }}',
                    image: '{{ asset('images/proceso/paso-1-calco.jpg') }}',
                    description: 'El proceso inicia con el posicionamiento milimétrico de la plantilla sobre el brazo del cliente. Cada curvatura corporal es respetada minuciosamente para que el dragón fluya de manera orgánica con los tendones y la musculatura en movimiento.',
                    specs: [
                        { label: 'Técnica', val: 'Estudio Anatómico & Transfer Stencil' },
                        { label: 'Zona', val: 'Brazo y Antebrazo Completo' },
                        { label: 'Propósito', val: 'Dinamismo visual y escala armónica' }
                    ],
                    quote: 'Un tatuaje de alto impacto no es una imagen plana: es un diálogo directo con la silueta viva de tu cuerpo.'
                },
                {
                    num: '02',
                    badge: 'BIOSEGURIDAD & PIGMENTOS',
                    title: 'Asepsia Clínica y Pigmentos Sellados',
                    short: '02. Asepsia & Tintas',
                    tag: 'Grado Médico',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-2-tintas.mp4') }}',
                    image: '{{ asset('images/proceso/paso-2-tintas.jpg') }}',
                    description: 'Apertura de insumos 100% esterilizados en presencia directa del cliente. Se utilizan pigmentos premium certificados internacionalmente (Electric Ink) desprecintados de fábrica, garantizando pureza total, fijación duradera y bioseguridad absoluta.',
                    specs: [
                        { label: 'Tintas', val: 'Electric Ink Selladas de Fábrica' },
                        { label: 'Bioseguridad', val: 'Campos y barreras estériles descartables' },
                        { label: 'Normativa', val: 'Cumplimiento riguroso de asepsia clínica' }
                    ],
                    quote: 'La seguridad no es negociable: cada aguja, tetina y pigmento se desprecinta frente a tus ojos antes de empezar.'
                },
                {
                    num: '03',
                    badge: 'TRAZO & ESTRUCTURA',
                    title: 'Trazado Estructural de Líneas Sólidas',
                    short: '03. Líneas Guía',
                    tag: 'Precisión Rotativa',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-3-lineas.mp4') }}',
                    image: '{{ asset('images/proceso/paso-3-lineas.jpg') }}',
                    description: 'Con máquina rotativa de alta gama y cartuchos calibrados, se trazan las líneas fundamentales de Shenlong. Líneas firmes, uniformes y limpias que aseguran la máxima definición y legibilidad del tatuaje a través de los años.',
                    specs: [
                        { label: 'Máquinas', val: 'Rotativas de precisión milimétrica' },
                        { label: 'Trazo', val: 'Línea sólida, continua y nítida' },
                        { label: 'Profundidad', val: 'Penetración dérmica exacta sin sobretrauma' }
                    ],
                    quote: 'La línea es el cimiento de la obra: si la estructura es impecable, el tatuaje lucirá imponente por décadas.'
                },
                {
                    num: '04',
                    badge: 'VOLUMEN & PROFUNDIDAD',
                    title: 'Sombreado y Textura Tridimensional',
                    short: '04. Sombras & Relieve',
                    tag: 'Black & Grey Base',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-4-sombras.mp4') }}',
                    image: '{{ asset('images/proceso/paso-4-sombras.jpg') }}',
                    description: 'Construcción de volumen y atmósfera mediante degradados progresivos de negro y escala de grises. Este paso define las escamas, la textura de los cuernos y la ferocidad en la mirada del mítico dragón.',
                    specs: [
                        { label: 'Gradación', val: 'Escala tonal de negros puros y grises' },
                        { label: 'Efecto', val: 'Sensación de volumen y relieve tridimensional' },
                        { label: 'Detalle', val: 'Texturizado escama por escama' }
                    ],
                    quote: 'El contraste le da alma al dragón: separa las capas y le otorga esa presencia viva que parece emerger de la piel.'
                },
                {
                    num: '05',
                    badge: 'SATURACIÓN VIVA (DESTACADO)',
                    title: 'Saturación de Color: El Dragón Sagrado',
                    short: '05. Color Shenlong ★',
                    tag: 'Full Color Saturation',
                    featured: true,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-5-color.mp4') }}',
                    image: '{{ asset('images/proceso/paso-5-color.jpg') }}',
                    description: 'El punto culminante de la sesión: saturación densa de verdes esmeralda, destellos llameantes y el fulgor dorado de las esferas del dragón. Técnica de empaque de color sólido que asegura tonos vívidos y resistentes al paso del tiempo.',
                    specs: [
                        { label: 'Paleta', val: 'Verde esmeralda, oro, carmín y blanco óptico' },
                        { label: 'Técnica', val: 'Empaque de pigmento denso de alta fijación' },
                        { label: 'Resultado', val: 'Intensidad cromática y brillo duradero' }
                    ],
                    quote: '⚡️ ¿Qué pedirías si tuvieras las 7 esferas? Un diseño con significado, magia y fuerza interior plasmado con máxima fidelidad.'
                },
                {
                    num: '06',
                    badge: 'OBRA CULMINADA',
                    title: 'Resultado Final y Protocolo Post-Cuidado',
                    short: '06. Pieza Final',
                    tag: 'Masterpiece',
                    featured: false,
                    mediaType: 'image',
                    image: '{{ asset('images/proceso/paso-6-resultado.jpg') }}',
                    image2: '{{ asset('images/proceso/paso-6-resultado-2.jpg') }}',
                    description: 'La pieza culminada en su máximo esplendor sobre el brazo. Se realiza desinfección suave, aplicación de apósito dérmico hipoalergénico (segunda piel) e instrucciones exhaustivas de cuidado para una cicatrización brillante.',
                    specs: [
                        { label: 'Cuidado', val: 'Película dérmica protectora de última generación' },
                        { label: 'Estilo', val: 'Anime Ink & Geek Culture Premium' },
                        { label: 'Artista', val: 'Sebastián El Farfo' }
                    ],
                    quote: 'Me encanta cuando los tatuajes se transforman en portadores de recuerdos personales, convirtiéndose en guardianes de historias únicas.'
                }
            ],
            selectStep(index) {
                this.activeStep = index;
                this.photoAngle = 1;
                this.$nextTick(() => {
                    if (this.$refs.stepVideo) {
                        this.$refs.stepVideo.load();
                        this.$refs.stepVideo.play().catch(() => {});
                        this.isPlaying = true;
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            },
            toggleVideo() {
                if (!this.$refs.stepVideo) return;
                if (this.$refs.stepVideo.paused) {
                    this.$refs.stepVideo.play();
                    this.isPlaying = true;
                } else {
                    this.$refs.stepVideo.pause();
                    this.isPlaying = false;
                }
            },
            nextStep() {
                this.selectStep((this.activeStep + 1) % this.steps.length);
            },
            prevStep() {
                this.selectStep((this.activeStep - 1 + this.steps.length) % this.steps.length);
            },
            init() {
                this.$nextTick(() => {
                    if (this.$refs.stepVideo) {
                        this.$refs.stepVideo.play().catch(() => {});
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            }
        }"
        class="scroll-mt-24 py-32 bg-background relative overflow-hidden border-t border-border/50"
    >
        {{-- Atmospheric Background Glows --}}
        <div class="absolute top-1/3 -right-60 w-[500px] h-[500px] rounded-full bg-accent/5 blur-[140px] pointer-events-none"></div>
        <div class="absolute bottom-10 -left-60 w-[500px] h-[500px] rounded-full bg-accent/5 blur-[140px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Header Title & Subtitle --}}
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full border border-accent/30 bg-accent/10 backdrop-blur-md shadow-[0_0_20px_rgba(212,175,55,0.15)]">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent animate-pulse"></i>
                    <span class="text-accent uppercase tracking-[0.35em] text-[11px] font-black">Registro en Estudio · Caso Shenlong</span>
                </div>

                <h2 class="text-4xl sm:text-6xl md:text-7xl font-serif font-black uppercase tracking-tighter leading-[0.95] text-foreground">
                    Mi Proceso de <span class="text-accent italic">Tatuaje</span>
                </h2>

                <p class="text-muted text-xs sm:text-sm uppercase tracking-[0.18em] font-semibold leading-relaxed pt-2">
                    Desde el estudio anatómico del calco hasta la saturación viva del color y la cicatrización. Acompaña cada etapa real del ritual en la piel.
                </p>
            </div>

            {{-- Step Tabs Navigation --}}
            <div class="mb-12 overflow-x-auto pb-4 scrollbar-none">
                <div class="flex items-center justify-start lg:justify-center gap-2 sm:gap-3 min-w-max mx-auto px-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <button
                            @click="selectStep(index)"
                            :class="activeStep === index 
                                ? 'bg-accent text-accent-foreground border-accent shadow-[0_0_25px_rgba(212,175,55,0.35)] scale-105' 
                                : 'bg-surface/80 text-foreground/70 border-border hover:border-accent/50 hover:text-foreground'"
                            class="group relative px-4 sm:px-6 py-3.5 border rounded-none transition-all duration-300 font-sans flex items-center gap-2.5 text-left focus:outline-none"
                        >
                            <span 
                                :class="activeStep === index ? 'text-accent-foreground/90 font-black' : 'text-accent font-bold'"
                                class="text-xs font-mono"
                                x-text="step.num"
                            ></span>
                            <span class="text-xs uppercase tracking-wider font-bold" x-text="step.short"></span>
                            
                            <template x-if="step.featured">
                                <span 
                                    :class="activeStep === index ? 'bg-black text-accent' : 'bg-accent/20 text-accent'"
                                    class="text-[9px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded ml-1"
                                >
                                    Slide 7
                                </span>
                            </template>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Main Interactive Display: Split Screen (Media Left, Content Right) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-stretch max-w-7xl mx-auto">
                
                {{-- Media Player Column (7 cols on lg) --}}
                <div class="lg:col-span-7 flex flex-col">
                    <div class="relative w-full aspect-[4/5] sm:aspect-[4/4] lg:aspect-[4/5] bg-card border border-border/80 overflow-hidden shadow-2xl flex items-center justify-center group">
                        
                        {{-- Top Badge: Live Footage --}}
                        <div class="absolute top-4 left-4 z-20 flex items-center gap-2">
                            <span class="bg-black/80 backdrop-blur-md border border-accent/40 text-accent px-3 py-1.5 text-[10px] uppercase tracking-[0.25em] font-black flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                                <span x-text="steps[activeStep].tag"></span>
                            </span>
                        </div>

                        {{-- Step Counter Watermark --}}
                        <div class="absolute top-4 right-4 z-20 bg-black/80 backdrop-blur-md border border-white/10 text-muted px-3 py-1.5 text-[10px] font-mono tracking-widest uppercase">
                            Paso <span class="text-accent font-bold" x-text="steps[activeStep].num"></span> / 06
                        </div>

                        {{-- Video Display (Steps 1 to 5) --}}
                        <template x-if="steps[activeStep].mediaType === 'video'">
                            <div class="relative w-full h-full">
                                <video
                                    x-ref="stepVideo"
                                    :src="steps[activeStep].video"
                                    :poster="steps[activeStep].image"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    class="w-full h-full object-cover"
                                ></video>

                                {{-- Video Play/Pause Overlay Button --}}
                                <button 
                                    @click="toggleVideo()"
                                    class="absolute bottom-4 right-4 z-20 w-11 h-11 rounded-full bg-black/80 border border-accent/40 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all duration-300 backdrop-blur-md shadow-lg focus:outline-none"
                                    :title="isPlaying ? 'Pausar Video' : 'Reproducir Video'"
                                >
                                    <i :data-lucide="isPlaying ? 'pause' : 'play'" class="w-5 h-5"></i>
                                </button>

                                {{-- Video Indicator --}}
                                <div class="absolute bottom-4 left-4 z-20 bg-black/70 backdrop-blur-sm border border-white/10 px-3 py-1 text-[10px] uppercase tracking-widest text-foreground/80 flex items-center gap-2">
                                    <i data-lucide="video" class="w-3.5 h-3.5 text-accent"></i>
                                    Video en Bucle
                                </div>
                            </div>
                        </template>

                        {{-- Final Photo Display (Step 6) --}}
                        <template x-if="steps[activeStep].mediaType === 'image'">
                            <div class="relative w-full h-full">
                                <img
                                    :src="photoAngle === 1 ? steps[activeStep].image : steps[activeStep].image2"
                                    alt="Resultado final del tatuaje Shenlong"
                                    class="w-full h-full object-cover transition-opacity duration-500"
                                />

                                {{-- Photo Angle Switcher --}}
                                <div class="absolute bottom-4 left-4 right-4 z-20 flex items-center justify-between">
                                    <div class="bg-black/80 backdrop-blur-md border border-accent/40 p-1 flex gap-1">
                                        <button
                                            @click="photoAngle = 1"
                                            :class="photoAngle === 1 ? 'bg-accent text-accent-foreground font-black' : 'text-foreground/70 hover:text-foreground'"
                                            class="px-3 py-1 text-[10px] uppercase tracking-widest transition-all"
                                        >
                                            Vista Frontal
                                        </button>
                                        <button
                                            @click="photoAngle = 2"
                                            :class="photoAngle === 2 ? 'bg-accent text-accent-foreground font-black' : 'text-foreground/70 hover:text-foreground'"
                                            class="px-3 py-1 text-[10px] uppercase tracking-widest transition-all"
                                        >
                                            Detalle Esferas
                                        </button>
                                    </div>

                                    <div class="bg-black/70 backdrop-blur-sm border border-white/10 px-3 py-1 text-[10px] uppercase tracking-widest text-accent font-bold">
                                        Fotografía HD
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Corner Gold Accents --}}
                        <div class="absolute -top-1 -left-1 w-6 h-6 border-t-2 border-l-2 border-accent pointer-events-none z-30"></div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-2 border-r-2 border-accent pointer-events-none z-30"></div>
                    </div>

                    {{-- Step Navigation Arrows Under Media --}}
                    <div class="flex items-center justify-between mt-4 px-1">
                        <button
                            @click="prevStep()"
                            class="flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-muted hover:text-accent transition-colors py-2 group"
                        >
                            <i data-lucide="chevron-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                            Paso Anterior
                        </button>

                        <div class="flex gap-1.5">
                            <template x-for="(s, i) in steps" :key="i">
                                <button
                                    @click="selectStep(i)"
                                    :class="i === activeStep ? 'w-6 bg-accent' : 'w-2 bg-border hover:bg-muted'"
                                    class="h-1 transition-all duration-300 focus:outline-none"
                                ></button>
                            </template>
                        </div>

                        <button
                            @click="nextStep()"
                            class="flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-muted hover:text-accent transition-colors py-2 group"
                        >
                            Siguiente Paso
                            <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                {{-- Content & Details Column (5 cols on lg) --}}
                <div class="lg:col-span-5 flex flex-col justify-between space-y-8 bg-surface/70 border border-border/70 p-8 sm:p-10 relative overflow-hidden backdrop-blur-xl">
                    {{-- Giant Watermark Number in Card Background --}}
                    <div 
                        class="absolute -right-4 -bottom-8 font-serif font-black text-[140px] leading-none text-white/[0.03] select-none pointer-events-none"
                        x-text="steps[activeStep].num"
                    ></div>

                    <div class="space-y-6 relative z-10">
                        {{-- Stage Badge --}}
                        <div class="flex items-center justify-between">
                            <span 
                                class="text-accent text-[11px] font-black uppercase tracking-[0.3em] bg-accent/10 border border-accent/20 px-3.5 py-1.5"
                                x-text="steps[activeStep].badge"
                            ></span>

                            <a
                                href="https://www.instagram.com/p/DOKNBZgkiJO/?img_index=7"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 text-[11px] uppercase tracking-widest font-bold text-muted hover:text-accent transition-colors"
                            >
                                <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                                <span>Ver Post</span>
                                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                            </a>
                        </div>

                        {{-- Title --}}
                        <h3 
                            class="text-2xl sm:text-3xl lg:text-4xl font-serif font-black uppercase tracking-tight text-foreground leading-tight"
                            x-text="steps[activeStep].title"
                        ></h3>

                        {{-- Narrative Description --}}
                        <p 
                            class="text-sm text-foreground/80 leading-relaxed font-sans"
                            x-text="steps[activeStep].description"
                        ></p>

                        {{-- Technical Specifications Grid --}}
                        <div class="pt-4 border-t border-border/60 space-y-3">
                            <div class="text-[10px] uppercase tracking-[0.25em] text-accent font-black">
                                Parámetros Técnicos
                            </div>
                            <div class="grid grid-cols-1 gap-2.5">
                                <template x-for="(spec, i) in steps[activeStep].specs" :key="i">
                                    <div class="flex items-start justify-between gap-4 py-2 border-b border-border/40 text-xs">
                                        <span class="text-muted uppercase tracking-wider font-bold text-[11px]" x-text="spec.label"></span>
                                        <span class="text-foreground font-semibold text-right" x-text="spec.val"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Post Quote Box --}}
                        <div class="p-4 bg-background/60 border-l-2 border-accent/70 space-y-2">
                            <div class="flex items-center gap-1.5 text-accent text-[10px] uppercase tracking-widest font-black">
                                <i data-lucide="quote" class="w-3 h-3"></i>
                                Sebastián · El Farfo
                            </div>
                            <p 
                                class="text-xs italic text-foreground/90 leading-relaxed"
                                x-text="steps[activeStep].quote"
                            ></p>
                        </div>
                    </div>

                    {{-- Call to Action Buttons --}}
                    <div class="pt-6 relative z-10 flex flex-col sm:flex-row gap-4">
                        <a
                            href="{{ route('booking') }}"
                            class="group relative flex-1 px-6 py-4 bg-accent text-accent-foreground font-bold uppercase tracking-widest text-xs overflow-hidden text-center shadow-[0_0_20px_rgba(212,175,55,0.2)]"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Quiero mi Proyecto
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <div class="absolute top-0 left-0 w-full h-full bg-white/20 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                        </a>

                        <a
                            href="https://www.instagram.com/p/DOKNBZgkiJO/?img_index=7"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="px-6 py-4 border border-border hover:border-accent hover:text-accent transition-all font-bold uppercase tracking-widest text-xs flex items-center justify-center gap-2 text-foreground/80 text-center"
                        >
                            <i data-lucide="instagram" class="w-4 h-4 text-accent"></i>
                            Post Original
                        </a>
                    </div>
                </div>

            </div>

            {{-- Bottom Banner Summary --}}
            <div class="mt-20 border border-border/80 bg-gradient-to-r from-card via-surface to-card p-8 sm:p-12 text-center relative overflow-hidden">
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-accent/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                    <span class="text-accent uppercase tracking-[0.4em] text-[11px] font-black">
                        Arte de Autor a tu Medida
                    </span>
                    <h4 class="text-2xl sm:text-4xl font-serif font-black uppercase tracking-tight text-foreground">
                        ¿Tienes una idea para tu próxima pieza?
                    </h4>
                    <p class="text-muted text-xs sm:text-sm uppercase tracking-[0.15em] leading-relaxed">
                        Cada diseño se trabaja desde cero, adaptando anime, realismo, mitología y blackwork al contorno exacto de tu cuerpo.
                    </p>
                    <div class="pt-4 flex flex-wrap justify-center gap-4">
                        <a 
                            href="{{ route('booking') }}"
                            class="px-8 py-3.5 bg-accent text-accent-foreground font-bold uppercase tracking-widest text-xs hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all"
                        >
                            Cotizar Ahora
                        </a>
                        <a 
                            href="{{ route('portfolio') }}"
                            class="px-8 py-3.5 border border-border hover:border-accent hover:text-accent transition-all font-bold uppercase tracking-widest text-xs"
                        >
                            Explorar Trabajos
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. GSAP Entrance Animations
        if (window.gsap) {
            const tl = gsap.timeline({ defaults: { ease: "power4.out" } });
            
            tl.fromTo(".hero-line", 
                { y: 120, opacity: 0 }, 
                { y: 0, opacity: 1, duration: 1.4, stagger: 0.15, delay: 0.3 }
            )
            .fromTo("#hero-badge", 
                { y: 20, opacity: 0 }, 
                { y: 0, opacity: 1, duration: 0.8 }, 
                "-=0.8"
            )
            .fromTo("#hero-cta", 
                { y: 20, opacity: 0 }, 
                { y: 0, opacity: 1, duration: 0.8 }, 
                "-=0.6"
            );
        }

        // 2. Interactive Gold Canvas Particles
        const canvas = document.getElementById('hero-particles');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let particles = [];
            let mouse = { x: 0, y: 0 };
            let animId;

            const resize = () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            };
            window.addEventListener('resize', resize);
            resize();

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2.5 + 1;
                    this.speedX = (Math.random() - 0.5) * 0.4;
                    this.speedY = (Math.random() - 0.5) * 0.4;
                    this.opacity = Math.random() * 0.5 + 0.1;
                }

                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    const dx = mouse.x - this.x;
                    const dy = mouse.y - this.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 140) {
                        this.x -= dx * 0.015;
                        this.y -= dy * 0.015;
                    }

                    if (this.x > canvas.width) this.x = 0;
                    else if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    else if (this.y < 0) this.y = canvas.height;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity})`;
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = "rgba(212, 175, 55, 0.4)";
                    ctx.fill();
                }
            }

            const count = Math.min(Math.floor((canvas.width * canvas.height) / 12000), 100);
            for (let i = 0; i < count; i++) {
                particles.push(new Particle());
            }

            const animate = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                animId = requestAnimationFrame(animate);
            };
            animate();

            window.addEventListener('mousemove', (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });
        }
    });
</script>
@endpush
