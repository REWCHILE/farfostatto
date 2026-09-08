@extends('layouts.app')

@section('title', "FARFO'S TATTOO — Arte en tu Piel")

@section('content')
<div class="bg-background text-foreground">

    {{-- Floating Section Indicator & Quick Snap Navigator (Desktop & Tablet) --}}
    <nav 
        x-data="{
            activeSection: 'hero-section',
            sections: [
                { id: 'hero-section', label: 'Inicio', num: '01' },
                { id: 'ritual', label: 'El Ritual', num: '02' },
                { id: 'proceso', label: 'Proceso Shenlong', num: '03' },
                { id: 'footer', label: 'Contacto & Info', num: '04' }
            ],
            scrollToSection(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
            },
            init() {
                const obs = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeSection = entry.target.id;
                        }
                    });
                }, { threshold: 0.3 });

                this.sections.forEach(s => {
                    const el = document.getElementById(s.id);
                    if (el) obs.observe(el);
                });
            }
        }"
        class="fixed right-5 top-1/2 -translate-y-1/2 z-40 hidden xl:flex flex-col gap-5 items-center p-2.5 rounded-full bg-black/75 backdrop-blur-md border border-accent/25 shadow-[0_0_30px_rgba(0,0,0,0.9)]"
        aria-label="Navegación por secciones"
    >
        <template x-for="sec in sections" :key="sec.id">
            <button
                @click="scrollToSection(sec.id)"
                class="group relative flex items-center justify-center p-1 focus:outline-none cursor-pointer"
                :aria-label="'Ir a ' + sec.label"
            >
                {{-- Tooltip floating to the left --}}
                <div 
                    class="absolute right-full mr-3 px-3 py-1 bg-black/95 border border-accent/40 text-accent text-[10px] uppercase tracking-widest font-black whitespace-nowrap rounded pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-200 -translate-x-1 group-hover:translate-x-0 shadow-2xl backdrop-blur-md"
                >
                    <span class="text-white/60 font-mono mr-1" x-text="sec.num + ' ·'"></span>
                    <span x-text="sec.label"></span>
                </div>

                {{-- Dot / Pill Indicator --}}
                <div 
                    class="transition-all duration-300 rounded-full"
                    :class="activeSection === sec.id 
                        ? 'w-2.5 h-7 bg-accent shadow-[0_0_15px_rgba(212,175,55,1)]' 
                        : 'w-2.5 h-2.5 bg-white/30 group-hover:bg-accent/70'"
                ></div>
            </button>
        </template>
    </nav>

    {{-- Hero Section --}}
    <section 
        id="hero-section"
        class="snap-section scroll-mt-20 relative min-h-screen flex items-center justify-center overflow-hidden bg-background"
    >
        {{-- Background Video Optimized for Horizontal/Responsive Displays --}}
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <video
                autoplay
                muted
                loop
                playsinline
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 min-w-full min-h-full w-auto h-auto object-cover opacity-25 select-none"
                poster="{{ asset('videos/hero_bg.jpg') }}"
            >
                <source src="{{ asset('videos/hero_bg.mp4') }}" type="video/mp4">
            </video>

            {{-- Multi-layered Dark Vignette & Gradient Overlays so video never breaks horizontally --}}
            <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-background/80"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,var(--background)_80%)] opacity-95"></div>
        </div>

        {{-- Background Cinematic Particles Canvas --}}
        <canvas 
            id="hero-particles" 
            class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-40 z-[1]"
            style="filter: blur(1.5px);"
        ></canvas>

        {{-- Background Radial Gold Glow --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[140%] pointer-events-none opacity-20 z-[1]">
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
            <div id="hero-cta" class="flex flex-col sm:flex-row items-center justify-center gap-5 mt-12 opacity-0">
                <a
                    href="{{ route('booking') }}"
                    class="group relative px-9 py-4 bg-accent text-accent-foreground font-black uppercase tracking-[0.22em] text-xs overflow-hidden shadow-[0_0_30px_rgba(212,175,55,0.3)] transition-all duration-300 rounded-sm hover:scale-[1.02]"
                >
                    <span class="relative z-10 flex items-center gap-3">
                        Reserva tu sesión 
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute top-0 left-0 w-full h-full bg-white/20 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                </a>

                <a
                    href="{{ route('portfolio') }}"
                    class="group relative px-9 py-4 bg-white hover:bg-neutral-100 text-neutral-950 font-black uppercase tracking-[0.22em] text-xs border-2 border-accent shadow-[0_0_25px_rgba(212,175,55,0.25)] transition-all duration-300 rounded-sm hover:scale-[1.02] overflow-hidden"
                >
                    <span class="relative z-10 flex items-center gap-2.5">
                        <span>Ver Portafolio</span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-accent stroke-[2.5] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute inset-0 bg-accent/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </a>
            </div>
        </div>

        {{-- Scroll Cue Indicator --}}
        <a 
            href="#ritual" 
            class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-1.5 group text-muted hover:text-accent transition-colors focus:outline-none"
            title="Deslizar a El Ritual"
        >
            <span class="text-[9px] uppercase tracking-[0.35em] text-accent font-bold group-hover:tracking-[0.45em] transition-all">Desliza</span>
            <div class="w-5 h-8 rounded-full border border-accent/50 group-hover:border-accent flex items-start justify-center p-1 backdrop-blur-sm transition-colors shadow-[0_0_10px_rgba(212,175,55,0.2)]">
                <div class="w-1.5 h-2 bg-accent rounded-full animate-bounce"></div>
            </div>
        </a>

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
                },
                {
                    title: 'Cover Up Magistral · Mewtwo',
                    category: 'Cover Up & Color',
                    tag: 'Cover Up Épico',
                    desc: 'Transformación de tatuaje antiguo en Mewtwo full color.',
                    video: '{{ asset('videos/ritual_slider_3.mp4') }}',
                    poster: '{{ asset('videos/ritual_slider_3_final.jpg') }}',
                    instagram: 'https://www.instagram.com/p/DYXQlSeRfJy/',
                    label: '03. Cover Up Mewtwo'
                },
                {
                    title: '1° Lugar Tattoo Masters Fest 2025',
                    category: 'Premios & Convención',
                    tag: '🏆 1° Lugar Fest',
                    desc: 'Máscara La Tirana a color en pecho y Angelita Aries Black & Grey.',
                    video: '{{ asset('videos/ritual_slider_4.mp4') }}',
                    poster: '{{ asset('videos/ritual_slider_4.jpg') }}',
                    instagram: 'https://www.instagram.com/reel/DHUhHOlOcbO/',
                    label: '04. Masters Fest'
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
        class="snap-section scroll-mt-20 py-32 bg-surface relative overflow-hidden border-t border-border/40"
    >
        {{-- Radial Background Ambience --}}
        <div 
            class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] pointer-events-none opacity-[0.05]"
            style="background: radial-gradient(circle at center, var(--accent) 0%, transparent 50%); filter: blur(140px);"
        ></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                
                {{-- Left Column (5 cols on desktop): Compact Story, Philosophy & Technical Console --}}
                <div class="lg:col-span-5 space-y-5">
                    
                    {{-- Section Badge --}}
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-accent/25 bg-accent/10">
                        <i data-lucide="sparkles" class="w-3 h-3 text-accent"></i>
                        <span class="text-accent uppercase tracking-[0.3em] text-[9px] font-black">Filosofía & Trayectoria</span>
                    </div>

                    {{-- Section Title --}}
                    <h2 class="text-2xl sm:text-3xl lg:text-[2.25rem] font-serif font-black uppercase tracking-tight leading-[1.1]">
                        El Ritual de las <span class="text-accent italic">Imágenes</span>, <br class="hidden sm:inline" />
                        Historias en tu <span class="text-accent italic">Piel</span>.
                    </h2>

                    {{-- Description --}}
                    <p class="text-muted leading-relaxed uppercase tracking-[0.13em] text-[11px] font-semibold max-w-sm">
                        Sebastián, El Farfo, combina su formación académica con la maestría del tatuaje moderno. Diálogo consciente transformando memorias y pasiones en obras imperecederas.
                    </p>

                    {{-- Compact Encapsulated Technical Excellence Console --}}
                    <div class="bg-card/85 border border-border/80 rounded-xl p-4 backdrop-blur-xl relative overflow-hidden shadow-lg space-y-3">
                        
                        {{-- Top Header / Capsule Bar --}}
                        <div class="flex items-center justify-between border-b border-border/50 pb-2.5">
                            <div class="flex items-center gap-1.5 text-accent font-black text-[9px] uppercase tracking-[0.2em]">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                <span>Pilares de Excelencia Técnica</span>
                            </div>
                            <span class="text-[9px] font-mono uppercase tracking-widest text-muted">
                                Pilar 0<span x-text="activeIndex + 1"></span> / 04
                            </span>
                        </div>

                        {{-- 4-Pill Segmented Selector Tabs --}}
                        <div class="grid grid-cols-2 gap-1.5">
                            <template x-for="(spec, i) in specs" :key="i">
                                <button
                                    @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })"
                                    :class="activeIndex === i 
                                        ? 'bg-accent text-accent-foreground border-accent font-black shadow-[0_0_12px_rgba(212,175,55,0.25)]' 
                                        : 'bg-surface/80 text-foreground/70 border-border/70 hover:border-accent/40 hover:text-foreground'"
                                    class="p-2 rounded-md border text-left flex items-center gap-2 text-[9px] uppercase tracking-wider transition-all duration-300 focus:outline-none"
                                >
                                    <i :data-lucide="spec.icon" class="w-3 h-3 shrink-0"></i>
                                    <span class="truncate font-bold" x-text="spec.title"></span>
                                </button>
                            </template>
                        </div>

                        {{-- Active Pillar Content Box --}}
                        <div class="bg-surface/60 rounded-lg p-3 border border-border/40 transition-all duration-300">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-accent text-[8px] uppercase tracking-[0.25em] font-black" x-text="specs[activeIndex].category"></span>
                                <div class="flex items-center gap-1">
                                    <template x-for="(s, i) in specs" :key="i">
                                        <button 
                                            @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })" 
                                            :class="i === activeIndex ? 'w-5 bg-accent' : 'w-1.5 bg-border hover:bg-muted'"
                                            class="h-1 rounded-full transition-all duration-300 focus:outline-none"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                            <h4 x-text="specs[activeIndex].title" class="font-serif font-black text-base uppercase tracking-tight text-foreground mb-0.5"></h4>
                            <p x-text="specs[activeIndex].description" class="text-[10px] text-muted uppercase tracking-[0.1em] leading-relaxed font-semibold"></p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-0.5">
                        <a 
                            href="{{ route('portfolio') }}" 
                            class="group relative px-6 py-3 bg-accent text-accent-foreground text-[11px] uppercase font-black tracking-[0.2em] overflow-hidden transition-all hover:shadow-[0_0_20px_rgba(212,175,55,0.3)] text-center rounded-sm"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Ver Portafolio 
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform duration-500"></i>
                            </span>
                            <div class="absolute inset-0 bg-white/10 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                        </a>
                        <a 
                            href="{{ route('about') }}" 
                            class="group px-6 py-3 border border-border text-foreground text-[11px] uppercase font-black tracking-[0.2em] hover:border-accent hover:text-accent transition-all duration-500 text-center rounded-sm"
                        >
                            <span class="flex items-center justify-center gap-2">
                                Sobre Mí 
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform duration-500"></i>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Right Column (7 cols on desktop): Wider & Centered Studio Reel Showcase with Brand Wave Border --}}
                <div class="lg:col-span-7 flex justify-center lg:justify-start lg:pl-6">
                    <div class="w-full max-w-[420px] sm:max-w-[440px] md:max-w-[460px] relative">
                        
                        {{-- Ambient Brand Golden Wave Breathing in Background --}}
                        <div class="absolute -inset-3 bg-gradient-to-tr from-accent/25 via-accent/40 to-accent/15 rounded-[36px] blur-2xl opacity-60 animate-gold-wave pointer-events-none"></div>

                        {{-- Encapsulated Luxury Frame with Animated Golden Border Wave --}}
                        <div class="relative p-[2.5px] rounded-[32px] overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.95)] border border-accent/40">
                            
                            {{-- Rotating Golden Conic Wave (Subtle Moving Wave in Farfo Brand Color) --}}
                            <div class="absolute -inset-[150%] bg-[conic-gradient(from_0deg_at_50%_50%,transparent_0deg,transparent_75deg,rgba(212,175,55,0.1)_105deg,rgba(212,175,55,0.95)_135deg,rgba(255,245,190,1)_150deg,rgba(212,175,55,0.95)_165deg,rgba(212,175,55,0.1)_195deg,transparent_225deg)] animate-spin-slow pointer-events-none"></div>

                            {{-- Inner Studio Chassis --}}
                            <div class="relative bg-black rounded-[30px] overflow-hidden flex flex-col border border-white/5">
                                
                                {{-- Studio Capsule Header Bar --}}
                                <div class="px-4 py-3 bg-black/90 backdrop-blur-md border-b border-white/10 flex items-center justify-between z-20">
                                    <div class="flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                                        </span>
                                        <span class="text-[10px] uppercase tracking-[0.2em] font-black text-accent truncate" x-text="reels[activeReel].tag"></span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono tracking-widest text-muted">
                                            <span class="text-accent font-bold" x-text="'0' + (activeReel + 1)"></span>/0<span x-text="reels.length"></span>
                                        </span>
                                        <a 
                                            :href="reels[activeReel].instagram"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-muted hover:text-accent p-1 transition-colors"
                                            title="Ver reel original en Instagram"
                                        >
                                            <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                </div>

                                {{-- Video Viewport (Generous Width & Proportional Height) --}}
                                <div class="relative aspect-[4/5] sm:aspect-[3/4] md:aspect-[4/5] max-h-[500px] bg-card overflow-hidden group/video flex items-center justify-center">
                                    
                                    <video
                                        x-ref="ritualVideo"
                                        :src="reels[activeReel].video"
                                        :poster="reels[activeReel].poster"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                        class="w-full h-full object-cover group-hover/video:scale-105 transition-transform duration-700"
                                    ></video>

                                    {{-- Vignette Overlay for Crisp Readability --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/30 pointer-events-none"></div>

                                    {{-- Slider Navigation Arrows --}}
                                    <button
                                        @click="prevReel()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none"
                                        title="Video Anterior"
                                    >
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                    </button>

                                    <button
                                        @click="nextReel()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none"
                                        title="Siguiente Video"
                                    >
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </button>

                                    {{-- Play / Pause Floating Toggle --}}
                                    <button
                                        @click="toggleRitualVideo()"
                                        class="absolute bottom-3 right-3 z-20 w-9 h-9 rounded-full bg-black/80 border border-accent/50 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none"
                                        :title="videoPlaying ? 'Pausar Video' : 'Reproducir Video'"
                                    >
                                        <i :data-lucide="videoPlaying ? 'pause' : 'play'" class="w-3.5 h-3.5"></i>
                                    </button>

                                    {{-- Artwork Title & Subtitle Badge --}}
                                    <div class="absolute bottom-3 left-3 z-20 max-w-[75%]">
                                        <p class="text-xs font-bold text-white tracking-wide truncate drop-shadow" x-text="reels[activeReel].title"></p>
                                        <p class="text-[9px] text-accent/90 tracking-wider uppercase font-semibold truncate" x-text="reels[activeReel].desc"></p>
                                    </div>
                                </div>

                                {{-- Capsule Integrated Footer: 4-Reel Switcher Tabs --}}
                                <div class="p-2 sm:p-2.5 bg-black/95 border-t border-white/10 z-20">
                                    <div class="grid grid-cols-4 gap-1 sm:gap-1.5">
                                        <template x-for="(reel, rIndex) in reels" :key="rIndex">
                                            <button
                                                @click="selectReel(rIndex)"
                                                :class="activeReel === rIndex 
                                                    ? 'bg-accent/20 border-accent text-accent font-bold shadow-[0_0_10px_rgba(212,175,55,0.25)]' 
                                                    : 'bg-card/70 border-border/70 text-muted hover:border-accent/40 hover:text-foreground'"
                                                class="py-1.5 sm:py-2 px-1 border text-center text-[8.5px] sm:text-[9px] uppercase tracking-wider transition-all rounded flex flex-col items-center justify-center gap-0.5 focus:outline-none"
                                            >
                                                <span class="truncate w-full font-bold" x-text="'0' + (rIndex + 1)"></span>
                                                <span class="truncate w-full text-[7.5px] sm:text-[8px] opacity-80" x-text="reel.tag"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Mi Proceso de Tatuaje Section --}}
    <section 
        id="proceso"
        x-data="{
            activeStep: 0, // Starts on Step 01 (Shenlong lines / structure)
            isPlaying: true,
            hasReached: false,
            videoProgress: 0,
            currentTimeFormatted: '0:00',
            durationFormatted: '0:00',
            photoAngle: 1,
            steps: [
                {
                    num: '01',
                    badge: 'TRAZO & ESTRUCTURA',
                    title: 'Trazado Estructural de Líneas Sólidas',
                    short: '01. Líneas Guía',
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
                    badge: 'PREPARACIÓN & ANATOMÍA',
                    title: 'Calco y Adaptación Anatómica',
                    short: '03. Calco Anatómico',
                    tag: 'Diseño en Piel',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-1-calco.mp4') }}',
                    image: '{{ asset('images/proceso/paso-1-calco.jpg') }}',
                    description: 'El proceso de preparación inicia con el posicionamiento milimétrico de la plantilla sobre el brazo del cliente. Cada curvatura corporal es respetada minuciosamente para que el dragón fluya de manera orgánica con los tendones y la musculatura en movimiento.',
                    specs: [
                        { label: 'Técnica', val: 'Estudio Anatómico & Transfer Stencil' },
                        { label: 'Zona', val: 'Brazo y Antebrazo Completo' },
                        { label: 'Propósito', val: 'Dinamismo visual y escala armónica' }
                    ],
                    quote: 'Un tatuaje de alto impacto no es una imagen plana: es un diálogo directo con la silueta viva de tu cuerpo.'
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
                this.videoProgress = 0;
                this.$nextTick(() => {
                    if (this.$refs.stepVideo) {
                        this.$refs.stepVideo.load();
                        if (this.hasReached && this.isPlaying) {
                            this.$refs.stepVideo.play().catch(() => {});
                        }
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            },
            updateVideoProgress() {
                if (!this.$refs.stepVideo || !this.$refs.stepVideo.duration) return;
                const cur = this.$refs.stepVideo.currentTime;
                const dur = this.$refs.stepVideo.duration;
                this.videoProgress = (cur / dur) * 100;
                const curM = Math.floor(cur / 60);
                const curS = Math.floor(cur % 60).toString().padStart(2, '0');
                const durM = Math.floor(dur / 60);
                const durS = Math.floor(dur % 60).toString().padStart(2, '0');
                this.currentTimeFormatted = `${curM}:${curS}`;
                this.durationFormatted = `${durM}:${durS}`;
            },
            seekVideo(event) {
                if (!this.$refs.stepVideo || !this.$refs.stepVideo.duration) return;
                const rect = event.currentTarget.getBoundingClientRect();
                const pos = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
                this.$refs.stepVideo.currentTime = pos * this.$refs.stepVideo.duration;
                this.updateVideoProgress();
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
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.hasReached = true;
                            if (this.$refs.stepVideo && this.isPlaying) {
                                this.$refs.stepVideo.play().catch(() => {});
                            }
                        } else {
                            if (this.$refs.stepVideo) {
                                this.$refs.stepVideo.pause();
                            }
                        }
                    });
                }, { threshold: 0.25 });
                observer.observe(this.$el);

                this.$nextTick(() => {
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            }
        }"
        class="snap-section scroll-mt-20 py-32 bg-background relative overflow-hidden border-t border-border/50"
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
                        
                        {{-- Top Story-Style Segmented Step Progress Bar --}}
                        <div class="absolute top-0 left-0 right-0 z-30 p-3 bg-gradient-to-b from-black/90 via-black/50 to-transparent flex flex-col gap-2">
                            <div class="grid grid-cols-6 gap-1.5 sm:gap-2">
                                <template x-for="(st, sIndex) in steps" :key="sIndex">
                                    <button
                                        @click="selectStep(sIndex)"
                                        class="h-1.5 sm:h-2 rounded-full overflow-hidden transition-all duration-300 relative focus:outline-none cursor-pointer"
                                        :class="sIndex < activeStep ? 'bg-accent shadow-[0_0_8px_rgba(212,175,55,0.5)]' : (sIndex === activeStep ? 'bg-white/30' : 'bg-white/15')"
                                        :title="`Paso 0${sIndex + 1}: ${st.short}`"
                                    >
                                        <template x-if="sIndex === activeStep">
                                            <div 
                                                class="h-full bg-accent shadow-[0_0_12px_rgba(212,175,55,1)] transition-[width] duration-150"
                                                :style="`width: ${videoProgress}%`"
                                            ></div>
                                        </template>
                                    </button>
                                </template>
                            </div>

                            {{-- Step Counter & Tag Header --}}
                            <div class="flex items-center justify-between text-[10px] uppercase font-mono tracking-widest text-muted px-0.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
                                    <span class="text-accent font-black">Paso 0<span x-text="activeStep + 1"></span> / 06</span>
                                </div>
                                <span class="text-white/90 font-bold truncate max-w-[65%]" x-text="steps[activeStep].title"></span>
                            </div>
                        </div>

                        {{-- Floating Navigation Arrows (Mobile & Desktop) --}}
                        <button
                            @click="prevStep()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-black/85 hover:bg-accent border border-accent/40 hover:border-accent text-white hover:text-black flex items-center justify-center backdrop-blur-md shadow-[0_4px_20px_rgba(0,0,0,0.8)] transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none"
                            title="Paso Anterior"
                            aria-label="Paso Anterior"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>

                        <button
                            @click="nextStep()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-black/85 hover:bg-accent border border-accent/40 hover:border-accent text-white hover:text-black flex items-center justify-center backdrop-blur-md shadow-[0_4px_20px_rgba(0,0,0,0.8)] transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none"
                            title="Siguiente Paso"
                            aria-label="Siguiente Paso"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>

                        {{-- Video Display (Steps 1 to 5, plays when in view) --}}
                        <template x-if="steps[activeStep].mediaType === 'video'">
                            <div class="relative w-full h-full cursor-pointer" @click="toggleVideo()">
                                <video
                                    x-ref="stepVideo"
                                    :src="steps[activeStep].video"
                                    :poster="steps[activeStep].image"
                                    muted
                                    loop
                                    playsinline
                                    @timeupdate="updateVideoProgress()"
                                    @loadedmetadata="updateVideoProgress()"
                                    class="w-full h-full object-cover"
                                ></video>

                                {{-- Central Play Overlay Indicator when paused --}}
                                <div 
                                    x-show="!isPlaying" 
                                    x-transition.opacity
                                    class="absolute inset-0 z-10 flex items-center justify-center bg-black/40 pointer-events-none"
                                >
                                    <div class="w-16 h-16 rounded-full bg-accent/90 text-black flex items-center justify-center shadow-[0_0_30px_rgba(212,175,55,0.7)] backdrop-blur-sm">
                                        <svg class="w-7 h-7 fill-current ml-1" viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"/>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Bottom Video Scrubber Timeline & Playback Info Bar --}}
                                <div 
                                    @click.stop
                                    class="absolute bottom-0 left-0 right-0 z-20 p-3.5 bg-gradient-to-t from-black/95 via-black/75 to-transparent flex flex-col gap-2.5"
                                >
                                    {{-- Interactive Clickable Progress Bar / Scrubber with Visible Thumb --}}
                                    <div 
                                        @click="seekVideo($event)"
                                        class="w-full py-1.5 cursor-pointer group/bar relative select-none"
                                        title="Línea de tiempo del video (toca o haz clic para moverte)"
                                    >
                                        <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden relative shadow-inner border border-white/10">
                                            <div 
                                                class="h-full bg-gradient-to-r from-accent via-accent to-[#FFF5BE] shadow-[0_0_12px_rgba(212,175,55,1)] transition-[width] duration-100"
                                                :style="`width: ${videoProgress}%`"
                                            ></div>
                                        </div>
                                        {{-- Scrubber Thumb Head --}}
                                        <div 
                                            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-accent border-2 border-white shadow-[0_0_10px_rgba(212,175,55,1)] pointer-events-none transition-[left] duration-100"
                                            :style="`left: ${videoProgress}%`"
                                        ></div>
                                    </div>

                                    {{-- Playback Controls & Timestamp Row --}}
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <button 
                                                @click="toggleVideo()"
                                                class="w-8 h-8 rounded-full bg-accent text-black flex items-center justify-center hover:scale-110 active:scale-95 transition-transform shadow-[0_0_15px_rgba(212,175,55,0.6)] focus:outline-none"
                                                :title="isPlaying ? 'Pausar Video' : 'Reproducir Video'"
                                            >
                                                <template x-if="isPlaying">
                                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                        <rect x="6" y="4" width="4" height="16" rx="1"/>
                                                        <rect x="14" y="4" width="4" height="16" rx="1"/>
                                                    </svg>
                                                </template>
                                                <template x-if="!isPlaying">
                                                    <svg class="w-3.5 h-3.5 fill-current ml-0.5" viewBox="0 0 24 24">
                                                        <polygon points="5 3 19 12 5 21 5 3"/>
                                                    </svg>
                                                </template>
                                            </button>
                                            
                                            <span class="font-mono text-[11px] text-white/95 font-bold tracking-wider" x-text="currentTimeFormatted + ' / ' + durationFormatted"></span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-[9px] uppercase tracking-wider font-bold text-accent bg-black/80 border border-accent/40 px-2.5 py-1 rounded backdrop-blur-sm shadow" x-text="steps[activeStep].tag"></span>
                                        </div>
                                    </div>
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
