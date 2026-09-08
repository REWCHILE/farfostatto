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
                { id: 'proceso', label: 'Proceso de Tatuaje', num: '03' },
                { id: 'contacto-cta', label: 'Contacto & Cita', num: '04' }
            ],
            scrollToSection(id) {
                if (window.scrollToFarfoSection) {
                    window.scrollToFarfoSection(id);
                } else {
                    const el = document.getElementById(id);
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
            init() {
                const obs = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeSection = entry.target.id;
                        }
                    });
                }, { threshold: 0.25 });

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
            <h1 id="hero-title" class="text-6xl sm:text-7xl md:text-8xl lg:text-[9.5rem] font-serif font-black tracking-tighter leading-[0.9] mb-8 select-none">
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
            @click.prevent="document.getElementById('ritual')?.scrollIntoView({ behavior: 'smooth', block: 'center' })"
            class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-1.5 group text-muted hover:text-accent transition-colors focus:outline-none cursor-pointer"
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
            isMuted: true,
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
            selectReel(index) {
                this.activeReel = index;
                this.videoPlaying = true;
                this.$nextTick(() => {
                    if (this.$refs.ritualVideo) {
                        this.$refs.ritualVideo.load();
                        this.$refs.ritualVideo.muted = this.isMuted;
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
            toggleRitualMute() {
                if (!this.$refs.ritualVideo) return;
                this.isMuted = !this.isMuted;
                this.$refs.ritualVideo.muted = this.isMuted;
                this.$nextTick(() => {
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            },
            init() {
                this.$nextTick(() => {
                    if (this.$refs.ritualVideo) {
                        this.$refs.ritualVideo.muted = this.isMuted;
                        this.$refs.ritualVideo.play().catch(() => {});
                    }
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
            }
        }"
        class="py-24 sm:py-28 lg:py-36 min-h-screen flex items-center bg-surface relative overflow-hidden border-t border-border/40"
    >
        {{-- Radial Background Ambience --}}
        <div 
            class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] pointer-events-none opacity-[0.05]"
            style="background: radial-gradient(circle at center, var(--accent) 0%, transparent 50%); filter: blur(140px);"
        ></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="section-content-grid max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                
                {{-- Left Column (5 cols on desktop): Story, Philosophy & Actions --}}
                <div class="lg:col-span-5 space-y-6">
                    
                    {{-- Section Badge --}}
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-accent/25 bg-accent/10">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-accent"></i>
                        <span class="text-accent uppercase tracking-[0.3em] text-[10px] font-black">Filosofía & Trayectoria</span>
                    </div>

                    {{-- Section Title (Enlarged & Majestic) --}}
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.25rem] font-serif font-black uppercase tracking-tight leading-[1.06] text-foreground">
                        El Ritual de las <span class="text-accent italic">Imágenes</span>, <br class="hidden sm:inline" />
                        Historias en tu <span class="text-accent italic">Piel</span>.
                    </h2>

                    {{-- Description (Farfo's Tattoo copy) --}}
                    <p class="text-muted leading-relaxed uppercase tracking-[0.12em] text-xs sm:text-sm font-medium max-w-lg">
                        Farfo's Tattoo combina su formación académica con la maestría del tatuaje moderno. Diálogo consciente transformando memorias y pasiones en obras imperecederas.
                    </p>

                    {{-- Action Buttons: Ver Portafolio & Sobre Mí (Directly below Farfo's Tattoo copy) --}}
                    <div class="flex flex-wrap sm:flex-nowrap gap-3 pt-2 max-w-lg">
                        <a 
                            href="{{ route('portfolio') }}" 
                            class="group relative flex-1 py-3.5 px-6 bg-accent text-accent-foreground text-xs uppercase font-black tracking-[0.18em] overflow-hidden transition-all hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] text-center rounded flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Ver Portafolio 
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <div class="absolute inset-0 bg-white/15 -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                        </a>
                        <a 
                            href="{{ route('about') }}" 
                            class="group flex-1 py-3.5 px-6 border border-border/80 bg-card/80 text-foreground text-xs uppercase font-black tracking-[0.18em] hover:border-accent hover:text-accent transition-all duration-300 text-center rounded flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span class="flex items-center justify-center gap-2">
                                Sobre Mí 
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Right Column (7 cols on desktop): Wider Video Showcase shifted right and lowered 5px --}}
                <div class="lg:col-span-7 flex justify-center lg:justify-end lg:pr-2 translate-y-[5px]">
                    <div class="w-full max-w-[460px] sm:max-w-[490px] md:max-w-[510px] lg:max-w-[520px] relative">
                        
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
                                        <span class="text-[10.5px] uppercase tracking-[0.2em] font-black text-accent truncate" x-text="reels[activeReel].tag"></span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono tracking-widest text-muted">
                                            <span class="text-accent font-bold" x-text="'0' + (activeReel + 1)"></span>/0<span x-text="reels.length"></span>
                                        </span>
                                        <a 
                                            :href="reels[activeReel].instagram"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-muted hover:text-accent p-1 transition-colors cursor-pointer"
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
                                        :muted="isMuted"
                                        loop
                                        playsinline
                                        class="w-full h-full object-cover group-hover/video:scale-105 transition-transform duration-700"
                                    ></video>

                                    {{-- Vignette Overlay for Crisp Readability --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/30 pointer-events-none"></div>

                                    {{-- Slider Navigation Arrows --}}
                                    <button
                                        @click="prevReel()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none cursor-pointer"
                                        title="Video Anterior"
                                    >
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                    </button>

                                    <button
                                        @click="nextReel()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none cursor-pointer"
                                        title="Siguiente Video"
                                    >
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </button>

                                    {{-- Floating Audio Mute / Unmute Toggle Button --}}
                                    <button
                                        @click="toggleRitualMute()"
                                        class="absolute bottom-14 right-3 z-20 w-9 h-9 rounded-full bg-black/80 border border-accent/50 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none cursor-pointer"
                                        :title="isMuted ? 'Activar Sonido' : 'Silenciar'"
                                    >
                                        <i :data-lucide="isMuted ? 'volume-x' : 'volume-2'" class="w-3.5 h-3.5"></i>
                                    </button>

                                    {{-- Play / Pause Floating Toggle --}}
                                    <button
                                        @click="toggleRitualVideo()"
                                        class="absolute bottom-3 right-3 z-20 w-9 h-9 rounded-full bg-black/80 border border-accent/50 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none cursor-pointer"
                                        :title="videoPlaying ? 'Pausar Video' : 'Reproducir Video'"
                                    >
                                        <i :data-lucide="videoPlaying ? 'pause' : 'play'" class="w-3.5 h-3.5"></i>
                                    </button>

                                    {{-- Artwork Title & Subtitle Badge --}}
                                    <div class="absolute bottom-3 left-3 z-20 max-w-[70%]">
                                        <p class="text-xs sm:text-[13px] font-bold text-white tracking-wide truncate drop-shadow" x-text="reels[activeReel].title"></p>
                                        <p class="text-[9.5px] text-accent tracking-wider uppercase font-semibold truncate" x-text="reels[activeReel].desc"></p>
                                    </div>
                                </div>

                                {{-- Capsule Integrated Footer: 4-Reel Switcher Tabs --}}
                                <div class="p-2 sm:p-2.5 bg-black/95 border-t border-white/10 z-20">
                                    {{-- 4 Reels Tabs (Antes & Después, Sesión en Vivo, Cover Up Épico, Primer Lugar Fest) --}}
                                    <div class="grid grid-cols-4 gap-1 sm:gap-1.5">
                                        <template x-for="(reel, rIndex) in reels" :key="rIndex">
                                            <button
                                                @click="selectReel(rIndex)"
                                                :class="activeReel === rIndex 
                                                    ? 'bg-accent/20 border-accent text-accent font-bold shadow-[0_0_10px_rgba(212,175,55,0.25)]' 
                                                    : 'bg-card/70 border-border/70 text-muted hover:border-accent/40 hover:text-foreground'"
                                                class="py-2 sm:py-2.5 px-1 border text-center text-[9px] uppercase tracking-wider transition-all rounded flex flex-col items-center justify-center gap-0.5 focus:outline-none cursor-pointer hover:scale-105 active:scale-95 select-none"
                                            >
                                                <span class="truncate w-full font-bold" x-text="'0' + (rIndex + 1)"></span>
                                                <span class="truncate w-full text-[8px] opacity-80" x-text="reel.tag"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mi Proceso de Tatuaje Section (Alternating: Video Left, Text Right) --}}
    <section 
        id="proceso"
        x-data="{
            activeStep: 0,
            isPlaying: true,
            hasReached: false,
            isMuted: true,
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
                    description: 'Con máquina rotativa calibrada, se trazan las líneas fundamentales de la obra. Líneas firmes, uniformes y limpias que aseguran la máxima definición a través de los años.',
                    specs: [
                        { label: 'Máquinas', val: 'Rotativas de precisión milimétrica' },
                        { label: 'Trazo', val: 'Línea sólida, continua y nítida' },
                        { label: 'Profundidad', val: 'Penetración dérmica exacta sin sobretrauma' }
                    ],
                    quote: 'La línea es el cimiento de la obra: si la estructura es impecable, el tatuaje lucirá imponente por décadas.'
                },
                {
                    num: '02',
                    badge: 'PREPARACIÓN & ANATOMÍA',
                    title: 'Calco y Adaptación Anatómica',
                    short: '02. Calco en Piel',
                    tag: 'Transfer Stencil',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-1-calco.mp4') }}',
                    image: '{{ asset('images/proceso/paso-1-calco.jpg') }}',
                    description: 'Posicionamiento milimétrico de la plantilla sobre el cuerpo. Cada curvatura es respetada para que el diseño fluya de manera orgánica con los tendones y la musculatura viva en movimiento.',
                    specs: [
                        { label: 'Técnica', val: 'Estudio Anatómico & Transfer Stencil' },
                        { label: 'Zona', val: 'Brazo y Antebrazo Completo' },
                        { label: 'Propósito', val: 'Dinamismo visual y escala armónica' }
                    ],
                    quote: 'Un tatuaje de alto impacto dialoga directamente con la silueta viva de tu cuerpo.'
                },
                {
                    num: '03',
                    badge: 'BIOSEGURIDAD & PIGMENTOS',
                    title: 'Asepsia Clínica y Pigmentos Sellados',
                    short: '03. Asepsia & Tintas',
                    tag: 'Grado Médico',
                    featured: false,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-2-tintas.mp4') }}',
                    image: '{{ asset('images/proceso/paso-2-tintas.jpg') }}',
                    description: 'Apertura de insumos 100% esterilizados en presencia directa del cliente. Pigmentos premium certificados (Electric Ink) desprecintados de fábrica garantizan pureza y bioseguridad absoluta.',
                    specs: [
                        { label: 'Tintas', val: 'Electric Ink Selladas de Fábrica' },
                        { label: 'Bioseguridad', val: 'Campos y barreras estériles descartables' },
                        { label: 'Normativa', val: 'Cumplimiento riguroso de asepsia clínica' }
                    ],
                    quote: 'La seguridad no es negociable: cada aguja, tetina y pigmento se desprecinta frente a tus ojos.'
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
                    description: 'Construcción de volumen mediante degradados progresivos de escala de grises. Este paso define las escamas, la textura de los cuernos y la ferocidad en la mirada de la pieza.',
                    specs: [
                        { label: 'Gradación', val: 'Escala tonal de negros puros y grises' },
                        { label: 'Efecto', val: 'Sensación de volumen y relieve tridimensional' },
                        { label: 'Detalle', val: 'Texturizado escama por escama' }
                    ],
                    quote: 'El contraste le da alma a la pieza: separa las capas y le otorga esa presencia que parece emerger de la piel.'
                },
                {
                    num: '05',
                    badge: 'SATURACIÓN VIVA',
                    title: 'Saturación de Color: El Dragón Sagrado',
                    short: '05. Color Shenlong ★',
                    tag: 'Full Color',
                    featured: true,
                    mediaType: 'video',
                    video: '{{ asset('images/proceso/paso-5-color.mp4') }}',
                    image: '{{ asset('images/proceso/paso-5-color.jpg') }}',
                    description: 'El punto culminante: saturación densa de verdes esmeralda, destellos llameantes y el fulgor dorado de las esferas. Técnica de empaque de color sólido de máxima fijación.',
                    specs: [
                        { label: 'Paleta', val: 'Verde esmeralda, oro, carmín y blanco óptico' },
                        { label: 'Técnica', val: 'Empaque de pigmento denso de alta fijación' },
                        { label: 'Resultado', val: 'Intensidad cromática y brillo duradero' }
                    ],
                    quote: '⚡️ ¿Qué pedirías si tuvieras las 7 esferas? Un diseño con significado plasmado con máxima fidelidad.'
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
                    description: 'La pieza culminada en su máximo esplendor. Desinfección suave, aplicación de apósito dérmico hipoalergénico (segunda piel) e indicaciones para una cicatrización brillante.',
                    specs: [
                        { label: 'Cuidado', val: 'Película dérmica protectora de última generación' },
                        { label: 'Estilo', val: 'Anime Ink & Geek Culture Premium' },
                        { label: 'Artista', val: 'Sebastián El Farfo' }
                    ],
                    quote: 'Me encanta cuando los tatuajes se transforman en portadores de recuerdos personales, guardianes de historias únicas.'
                }
            ],
            selectStep(index) {
                this.activeStep = index;
                this.photoAngle = 1;
                this.videoProgress = 0;
                this.$nextTick(() => {
                    if (this.$refs.stepVideo) {
                        this.$refs.stepVideo.load();
                        this.$refs.stepVideo.muted = this.isMuted;
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
            toggleProcesoMute() {
                if (!this.$refs.stepVideo) return;
                this.isMuted = !this.isMuted;
                this.$refs.stepVideo.muted = this.isMuted;
                this.$nextTick(() => {
                    if (window.lucide) {
                        window.lucide.createIcons({ icons: window.lucide.icons });
                    }
                });
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
                                this.$refs.stepVideo.muted = this.isMuted;
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
        class="py-24 sm:py-28 lg:py-36 min-h-screen flex items-center bg-background relative overflow-hidden border-t border-border/40"
    >
        {{-- Background Ambience --}}
        <div 
            class="absolute -top-1/2 -right-1/2 w-[200%] h-[200%] pointer-events-none opacity-[0.05]"
            style="background: radial-gradient(circle at center, var(--accent) 0%, transparent 50%); filter: blur(140px);"
        ></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="section-content-grid max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                
                {{-- Column 1: Video / Media Showcase on LEFT (7 cols on desktop, +40px wider, lowered 5px) --}}
                <div class="lg:col-span-7 flex justify-center lg:justify-start lg:pl-2 order-1 lg:order-1 translate-y-[5px]">
                    <div class="w-full max-w-[460px] sm:max-w-[490px] md:max-w-[510px] lg:max-w-[520px] relative">
                        
                        {{-- Ambient Brand Golden Wave Breathing in Background --}}
                        <div class="absolute -inset-3 bg-gradient-to-tr from-accent/25 via-accent/40 to-accent/15 rounded-[36px] blur-2xl opacity-60 animate-gold-wave pointer-events-none"></div>

                        {{-- Encapsulated Luxury Frame with Animated Golden Border Wave --}}
                        <div class="relative p-[2.5px] rounded-[32px] overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.95)] border border-accent/40">
                            
                            {{-- Rotating Golden Conic Wave --}}
                            <div class="absolute -inset-[150%] bg-[conic-gradient(from_0deg_at_50%_50%,transparent_0deg,transparent_75deg,rgba(212,175,55,0.1)_105deg,rgba(212,175,55,0.95)_135deg,rgba(255,245,190,1)_150deg,rgba(212,175,55,0.95)_165deg,rgba(212,175,55,0.1)_195deg,transparent_225deg)] animate-spin-slow pointer-events-none"></div>

                            {{-- Inner Studio Chassis --}}
                            <div class="relative bg-black rounded-[30px] overflow-hidden flex flex-col border border-white/5">
                                
                                {{-- Studio Capsule Header Bar --}}
                                <div class="px-4 py-2.5 bg-black/90 backdrop-blur-md border-b border-white/10 flex items-center justify-between z-20">
                                    <div class="flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                                        </span>
                                        <span class="text-[10.5px] uppercase tracking-[0.2em] font-black text-accent truncate" x-text="steps[activeStep].tag"></span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-mono tracking-widest text-muted">
                                            <span class="text-accent font-bold" x-text="'0' + (activeStep + 1)"></span>/0<span x-text="steps.length"></span>
                                        </span>
                                        <a 
                                            href="https://www.instagram.com/farfos_tattoo/"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-muted hover:text-accent p-1 transition-colors cursor-pointer"
                                            title="Ver perfil oficial en Instagram"
                                        >
                                            <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                </div>

                                {{-- Segmented Step Bars --}}
                                <div class="px-3 pt-2 pb-1 bg-black/80 flex gap-1 z-20">
                                    <template x-for="(st, sIndex) in steps" :key="sIndex">
                                        <button
                                            @click="selectStep(sIndex)"
                                            class="flex-1 h-1.5 rounded-full overflow-hidden transition-all duration-300 relative focus:outline-none cursor-pointer"
                                            :class="sIndex < activeStep ? 'bg-accent shadow-[0_0_6px_rgba(212,175,55,0.6)]' : (sIndex === activeStep ? 'bg-white/30' : 'bg-white/15')"
                                            :title="`Paso 0${sIndex + 1}: ${st.short}`"
                                        >
                                            <template x-if="sIndex === activeStep">
                                                <div 
                                                    class="h-full bg-accent shadow-[0_0_10px_rgba(212,175,55,1)] transition-[width] duration-150"
                                                    :style="`width: ${videoProgress}%`"
                                                ></div>
                                            </template>
                                        </button>
                                    </template>
                                </div>

                                {{-- Media Viewport --}}
                                <div class="relative aspect-[4/5] sm:aspect-[3/4] md:aspect-[4/5] max-h-[500px] bg-card overflow-hidden group/video flex items-center justify-center">
                                    
                                    {{-- Video Mode --}}
                                    <template x-if="steps[activeStep].mediaType === 'video'">
                                        <div class="relative w-full h-full cursor-pointer" @click="toggleVideo()">
                                            <video
                                                x-ref="stepVideo"
                                                :src="steps[activeStep].video"
                                                :poster="steps[activeStep].image"
                                                autoplay
                                                :muted="isMuted"
                                                loop
                                                playsinline
                                                @timeupdate="updateVideoProgress()"
                                                @loadedmetadata="updateVideoProgress()"
                                                class="w-full h-full object-cover group-hover/video:scale-105 transition-transform duration-700"
                                            ></video>

                                            {{-- Center Play Icon when paused --}}
                                            <div 
                                                x-show="!isPlaying" 
                                                x-transition.opacity
                                                class="absolute inset-0 z-10 flex items-center justify-center bg-black/40 pointer-events-none"
                                            >
                                                <div class="w-14 h-14 rounded-full bg-accent/90 text-black flex items-center justify-center shadow-[0_0_25px_rgba(212,175,55,0.7)] backdrop-blur-sm">
                                                    <svg class="w-6 h-6 fill-current ml-0.5" viewBox="0 0 24 24">
                                                        <polygon points="5 3 19 12 5 21 5 3"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Image Mode (Paso 06) --}}
                                    <template x-if="steps[activeStep].mediaType === 'image'">
                                        <div class="relative w-full h-full">
                                            <img
                                                :src="photoAngle === 1 ? steps[activeStep].image : steps[activeStep].image2"
                                                alt="Resultado final del tatuaje"
                                                class="w-full h-full object-cover"
                                            />
                                            <div class="absolute bottom-14 left-3 right-3 z-20 flex items-center justify-between">
                                                <div class="bg-black/85 backdrop-blur-md border border-accent/40 p-0.5 flex gap-1 rounded">
                                                    <button
                                                        @click="photoAngle = 1"
                                                        :class="photoAngle === 1 ? 'bg-accent text-accent-foreground font-black' : 'text-foreground/70 hover:text-foreground'"
                                                        class="px-2.5 py-1 text-[9px] uppercase tracking-widest transition-all rounded-sm cursor-pointer"
                                                    >
                                                        Frontal
                                                    </button>
                                                    <button
                                                        @click="photoAngle = 2"
                                                        :class="photoAngle === 2 ? 'bg-accent text-accent-foreground font-black' : 'text-foreground/70 hover:text-foreground'"
                                                        class="px-2.5 py-1 text-[9px] uppercase tracking-widest transition-all rounded-sm cursor-pointer"
                                                    >
                                                        Detalle
                                                    </button>
                                                </div>
                                                <span class="bg-black/70 backdrop-blur-sm border border-white/10 px-2 py-0.5 text-[8.5px] uppercase tracking-widest text-accent font-bold rounded">
                                                    HD View
                                                </span>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Vignette Overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/30 pointer-events-none"></div>

                                    {{-- Slider Navigation Arrows --}}
                                    <button
                                        @click="prevStep()"
                                        class="absolute left-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none cursor-pointer"
                                        title="Paso Anterior"
                                    >
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                    </button>

                                    <button
                                        @click="nextStep()"
                                        class="absolute right-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-black/75 border border-white/20 text-white hover:border-accent hover:text-accent hover:scale-110 flex items-center justify-center backdrop-blur-md transition-all shadow-lg focus:outline-none cursor-pointer"
                                        title="Siguiente Paso"
                                    >
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </button>

                                    {{-- Floating Audio Mute / Unmute Toggle Button above Scrubber in Proceso --}}
                                    <template x-if="steps[activeStep].mediaType === 'video'">
                                        <button
                                            @click.stop="toggleProcesoMute()"
                                            class="absolute bottom-16 right-3 z-20 w-8 h-8 rounded-full bg-black/85 border border-accent/60 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none cursor-pointer"
                                            :title="isMuted ? 'Activar Sonido' : 'Silenciar'"
                                        >
                                            <i :data-lucide="isMuted ? 'volume-x' : 'volume-2'" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </template>

                                    {{-- Bottom Firmly Anchored Scrubber & Controls Bar --}}
                                    <template x-if="steps[activeStep].mediaType === 'video'">
                                        <div 
                                            @click.stop
                                            class="absolute bottom-0 left-0 right-0 z-20 p-3 bg-gradient-to-t from-black/95 via-black/85 to-transparent flex flex-col gap-1.5"
                                        >
                                            {{-- Interactive Clickable Progress Bar / Scrubber --}}
                                            <div 
                                                @click="seekVideo($event)"
                                                class="w-full py-1 cursor-pointer group/bar relative select-none"
                                                title="Línea de tiempo del video (clic o arrastra)"
                                            >
                                                <div class="w-full h-1.5 bg-white/20 rounded-full overflow-hidden relative shadow-inner border border-white/10">
                                                    <div 
                                                        class="h-full bg-gradient-to-r from-accent via-accent to-[#FFF5BE] shadow-[0_0_8px_rgba(212,175,55,1)] transition-[width] duration-100"
                                                        :style="`width: ${videoProgress}%`"
                                                    ></div>
                                                </div>
                                                <div 
                                                    class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-3.5 h-3.5 rounded-full bg-accent border-2 border-white shadow-[0_0_8px_rgba(212,175,55,1)] pointer-events-none transition-[left] duration-100"
                                                    :style="`left: ${videoProgress}%`"
                                                ></div>
                                            </div>

                                            {{-- Controls Row: Play + Mute + Timestamp + Short Tag --}}
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    {{-- Play / Pause Toggle --}}
                                                    <button 
                                                        @click="toggleVideo()"
                                                        class="w-7 h-7 rounded-full bg-accent text-black flex items-center justify-center hover:scale-110 active:scale-95 transition-transform shadow focus:outline-none cursor-pointer"
                                                        :title="isPlaying ? 'Pausar' : 'Reproducir'"
                                                    >
                                                        <i :data-lucide="isPlaying ? 'pause' : 'play'" class="w-3.5 h-3.5"></i>
                                                    </button>

                                                    {{-- Audio Mute / Unmute Toggle Button --}}
                                                    <button 
                                                        @click="toggleProcesoMute()"
                                                        class="w-7 h-7 rounded-full bg-black/80 border border-accent/50 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-black transition-all shadow focus:outline-none cursor-pointer"
                                                        :title="isMuted ? 'Activar Sonido' : 'Silenciar'"
                                                    >
                                                        <i :data-lucide="isMuted ? 'volume-x' : 'volume-2'" class="w-3.5 h-3.5"></i>
                                                    </button>

                                                    <span class="font-mono text-[9.5px] text-white/95 font-bold tracking-wider" x-text="currentTimeFormatted + ' / ' + durationFormatted"></span>
                                                </div>
                                                <span class="text-[9px] uppercase tracking-wider font-bold text-accent bg-black/60 border border-accent/30 px-2 py-0.5 rounded truncate max-w-[50%]" x-text="steps[activeStep].short"></span>
                                            </div>
                                        </div>
                                    </template>

                                </div>

                                {{-- Capsule Integrated Footer: 6-Step Switcher Tabs + Action Button --}}
                                <div class="p-2 sm:p-2.5 bg-black/95 border-t border-white/10 z-20 space-y-2">
                                    {{-- 6-Step Switcher Tabs --}}
                                    <div class="grid grid-cols-6 gap-1.5">
                                        <template x-for="(step, sIdx) in steps" :key="sIdx">
                                            <button
                                                @click="selectStep(sIdx)"
                                                :class="activeStep === sIdx 
                                                    ? 'bg-accent/20 border-accent text-accent font-bold shadow-[0_0_8px_rgba(212,175,55,0.25)] scale-105' 
                                                    : 'bg-card/70 border-border/70 text-muted hover:border-accent/40 hover:text-foreground'"
                                                class="py-2 px-0.5 border text-center text-[9px] uppercase font-mono font-bold tracking-wider transition-all rounded flex flex-col items-center justify-center gap-0.5 focus:outline-none cursor-pointer hover:border-accent hover:text-accent hover:scale-105 active:scale-95 select-none"
                                                :title="step.title"
                                            >
                                                <span class="font-bold" x-text="'0' + (sIdx + 1)"></span>
                                            </button>
                                        </template>
                                    </div>

                                    {{-- Action Button: Agendar Cita (Under the 6 buttons of the video card) --}}
                                    <div class="pt-0.5">
                                        <a 
                                            href="{{ route('booking') }}" 
                                            class="group relative w-full py-2.5 px-4 bg-accent text-accent-foreground text-[10.5px] sm:text-xs uppercase font-black tracking-[0.18em] overflow-hidden transition-all hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] text-center rounded flex items-center justify-center gap-2 cursor-pointer"
                                        >
                                            <span class="relative z-10 flex items-center justify-center gap-2">
                                                Agendar Cita 
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform"></i>
                                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                                            </span>
                                            <div class="absolute inset-0 bg-white/15 -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Story, Description & Console on RIGHT (5 cols on desktop) --}}
                <div class="lg:col-span-5 space-y-6 order-2 lg:order-2">
                    
                    {{-- Section Badge --}}
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-accent/25 bg-accent/10">
                        <i data-lucide="layers" class="w-3.5 h-3.5 text-accent"></i>
                        <span class="text-accent uppercase tracking-[0.3em] text-[10px] font-black">Metodología & Flujo Real</span>
                    </div>

                    {{-- Section Title (Enlarged & Majestic) --}}
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.25rem] font-serif font-black uppercase tracking-tight leading-[1.06] text-foreground">
                        El Proceso de <span class="text-accent italic">Tatuaje</span>, <br class="hidden sm:inline" />
                        De la Idea a la <span class="text-accent italic">Piel</span>.
                    </h2>

                    {{-- Description (Enlarged & Crisp) --}}
                    <p class="text-muted leading-relaxed uppercase tracking-[0.12em] text-xs sm:text-sm font-medium max-w-lg">
                        Desde el trazado estructural y el calco anatómico hasta la saturación viva y la segunda piel. Acompaña cada etapa real del ritual con Sebastián Farfo.
                    </p>

                    {{-- Compact Encapsulated Step Console --}}
                    <div class="bg-card/90 border border-border/80 rounded-xl p-4 sm:p-5 backdrop-blur-xl relative overflow-hidden shadow-xl space-y-3.5">
                        
                        {{-- Top Capsule Bar --}}
                        <div class="flex items-center justify-between border-b border-border/50 pb-2.5">
                            <div class="flex items-center gap-1.5 text-accent font-black text-[10px] sm:text-[10.5px] uppercase tracking-[0.2em]">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                <span x-text="steps[activeStep].badge"></span>
                            </div>
                            <span class="text-[9.5px] font-mono uppercase tracking-widest text-muted">
                                Etapa 0<span x-text="activeStep + 1"></span> / 0<span x-text="steps.length"></span>
                            </span>
                        </div>

                        {{-- Active Step Content Box --}}
                        <div class="bg-surface/70 rounded-lg p-3.5 sm:p-4 border border-border/50 transition-all duration-300 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-accent text-[9px] uppercase tracking-[0.25em] font-black" x-text="steps[activeStep].tag"></span>
                                <div class="flex items-center gap-1">
                                    <template x-for="(s, i) in steps" :key="i">
                                        <button 
                                            @click="selectStep(i)" 
                                            :class="i === activeStep ? 'w-4 bg-accent' : 'w-1 bg-border hover:bg-muted'"
                                            class="h-1 rounded-full transition-all duration-300 focus:outline-none cursor-pointer"
                                        ></button>
                                    </template>
                                </div>
                            </div>

                            <h4 x-text="steps[activeStep].title" class="font-serif font-black text-base sm:text-lg uppercase tracking-tight text-foreground"></h4>
                            <p x-text="steps[activeStep].description" class="text-[11px] sm:text-xs text-muted uppercase tracking-[0.08em] leading-relaxed font-semibold"></p>

                            {{-- Technical Specs List --}}
                            <div class="pt-2 border-t border-border/50 space-y-1.5">
                                <template x-for="(spec, i) in steps[activeStep].specs" :key="i">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="text-muted uppercase tracking-wider font-bold" x-text="spec.label"></span>
                                        <span class="text-foreground font-semibold text-right" x-text="spec.val"></span>
                                    </div>
                                </template>
                            </div>

                            {{-- Quote Pill --}}
                            <div class="pt-2 border-t border-border/40 flex items-start gap-1.5 text-accent text-[9.5px] italic">
                                <i data-lucide="quote" class="w-3 h-3 shrink-0 mt-0.5"></i>
                                <span x-text="steps[activeStep].quote"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Pre-Footer CTA Section with Live Studio Reel --}}
    <section 
        id="contacto-cta"
        x-data="{
            ctaPlaying: true,
            activeIndex: 1,
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
            toggleCtaVideo() {
                if (!this.$refs.ctaVideo) return;
                if (this.$refs.ctaVideo.paused) {
                    this.$refs.ctaVideo.play();
                    this.ctaPlaying = true;
                } else {
                    this.$refs.ctaVideo.pause();
                    this.ctaPlaying = false;
                }
            },
            init() {
                setInterval(() => {
                    this.activeIndex = (this.activeIndex + 1) % this.specs.length;
                    this.$nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); });
                }, 5000);

                const obs = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            if (this.$refs.ctaVideo && this.ctaPlaying) {
                                this.$refs.ctaVideo.play().catch(() => {});
                            }
                        } else {
                            if (this.$refs.ctaVideo) {
                                this.$refs.ctaVideo.pause();
                            }
                        }
                    });
                }, { threshold: 0.25 });
                obs.observe(this.$el);
            }
        }"
        class="py-24 sm:py-28 lg:py-36 bg-surface relative overflow-hidden border-t border-border/50"
    >
        {{-- Background Ambience Glow --}}
        <div class="absolute -top-1/2 right-0 w-[500px] h-[500px] rounded-full bg-accent/5 blur-[140px] pointer-events-none"></div>
        <div class="absolute -bottom-1/2 left-0 w-[500px] h-[500px] rounded-full bg-accent/5 blur-[140px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="section-content-grid max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                {{-- Left Column (7 cols on lg): Texts, WhatsApp Direct CTA, Online Booking & Socials --}}
                <div class="lg:col-span-7 space-y-6">
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-accent/25 bg-accent/10">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5 text-accent animate-pulse"></i>
                        <span class="text-accent uppercase tracking-[0.3em] text-[9.5px] font-black">Atención Directa & Reserva</span>
                    </div>

                    {{-- Title (Enlarged & Majestic) --}}
                    <h2 class="text-3xl sm:text-5xl lg:text-6xl xl:text-[4rem] font-serif font-black uppercase tracking-tight leading-[1.02] text-foreground">
                        ¿Tienes una idea en mente? <br />
                        <span class="text-accent italic">Hagámosla Realidad</span>
                    </h2>

                    {{-- Description --}}
                    <p class="text-muted text-xs sm:text-sm uppercase tracking-[0.14em] font-medium leading-relaxed max-w-xl">
                        Cada tatuaje es una pieza de autor diseñada a tu medida. Conversemos directamente por WhatsApp para evaluar tu proyecto, resolver dudas sobre el diseño y agendar tu próxima sesión.
                    </p>

                    {{-- Enhanced Encapsulated Technical Excellence Console (Moved to Last CTA) --}}
                    <div class="bg-card/90 border border-border/80 rounded-xl p-4 sm:p-5 backdrop-blur-xl relative overflow-hidden shadow-xl space-y-3.5 max-w-xl">
                        
                        {{-- Top Header / Capsule Bar --}}
                        <div class="flex items-center justify-between border-b border-border/50 pb-2.5">
                            <div class="flex items-center gap-2 text-accent font-black text-[10px] sm:text-[10.5px] uppercase tracking-[0.2em]">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                <span>Pilares de Excelencia Técnica</span>
                            </div>
                            <span class="text-[9.5px] font-mono uppercase tracking-widest text-muted">
                                Pilar 0<span x-text="activeIndex + 1"></span> / 04
                            </span>
                        </div>

                        {{-- 4-Pill Segmented Selector Tabs --}}
                        <div class="grid grid-cols-2 gap-2.5">
                            <template x-for="(spec, i) in specs" :key="i">
                                <button
                                    @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })"
                                    :class="activeIndex === i 
                                        ? 'bg-accent text-accent-foreground border-accent font-black shadow-[0_0_12px_rgba(212,175,55,0.25)]' 
                                        : 'bg-surface/80 text-foreground/75 border-border/70 hover:border-accent/50 hover:text-foreground'"
                                    class="py-3 px-3 rounded-md border text-left flex items-center gap-2 text-[10.5px] sm:text-[11.5px] uppercase tracking-wider transition-all duration-200 focus:outline-none cursor-pointer select-none hover:scale-[1.02]"
                                >
                                    <i :data-lucide="spec.icon" class="w-3.5 h-3.5 shrink-0"></i>
                                    <span class="truncate font-black" x-text="spec.title"></span>
                                </button>
                            </template>
                        </div>

                        {{-- Active Pillar Content Box --}}
                        <div class="bg-surface/70 rounded-lg p-3.5 sm:p-4 border border-border/50 transition-all duration-300 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-accent text-[9.5px] uppercase tracking-[0.25em] font-black" x-text="specs[activeIndex].category"></span>
                                <div class="flex items-center gap-1.5">
                                    <template x-for="(s, i) in specs" :key="i">
                                        <button 
                                            @click="activeIndex = i; $nextTick(() => { window.lucide?.createIcons({ icons: window.lucide?.icons }); })" 
                                            :class="i === activeIndex ? 'w-5 bg-accent' : 'w-1.5 bg-border hover:bg-muted'"
                                            class="h-1 rounded-full transition-all duration-300 focus:outline-none cursor-pointer"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                            <h4 x-text="specs[activeIndex].title" class="font-serif font-black text-base sm:text-lg uppercase tracking-tight text-foreground"></h4>
                            <p x-text="specs[activeIndex].description" class="text-xs sm:text-[13px] text-muted uppercase tracking-[0.08em] leading-relaxed font-semibold"></p>
                        </div>
                    </div>

                    {{-- CTA Buttons: WhatsApp Direct (Priority) + Online Booking --}}
                    <div class="flex flex-col sm:flex-row gap-3.5 pt-2">
                        {{-- WhatsApp Direct Button --}}
                        <a 
                            href="https://wa.me/56934424269?text=Hola%20Sebasti%C3%A1n%2C%20quiero%20cotizar%20un%20tatuaje%20contigo." 
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group px-7 py-4 bg-[#25D366] text-black font-black uppercase tracking-[0.2em] text-xs transition-all hover:shadow-[0_0_25px_rgba(37,211,102,0.4)] hover:scale-[1.02] flex items-center justify-center gap-3 rounded-sm"
                        >
                            <i data-lucide="message-circle" class="w-4 h-4 fill-current"></i>
                            <span>+56 9 3442 4269 · Escríbeme al WhatsApp</span>
                        </a>

                        {{-- Online Booking Button --}}
                        <a 
                            href="{{ route('booking') }}" 
                            class="px-6 py-4 bg-accent text-accent-foreground font-black uppercase tracking-[0.2em] text-xs transition-all hover:bg-accent/90 hover:shadow-[0_0_20px_rgba(212,175,55,0.3)] flex items-center justify-center gap-2 rounded-sm"
                        >
                            <span>Reservar Cita</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    {{-- Social Channels & Direct Contact Pill Box --}}
                    <div class="pt-4 border-t border-border/60">
                        <div class="text-[10px] uppercase tracking-[0.25em] text-muted font-bold mb-3">
                            Canales Oficiales & Ubicación
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            {{-- Instagram --}}
                            <a 
                                href="https://www.instagram.com/farfos_tattoo/" 
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full border border-border/80 bg-card/80 hover:border-accent hover:text-accent transition-all text-xs font-mono"
                            >
                                <i data-lucide="instagram" class="w-3.5 h-3.5 text-accent"></i>
                                <span>@farfos_tattoo</span>
                            </a>

                            {{-- Location --}}
                            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full border border-border/80 bg-card/80 text-muted text-xs font-mono">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                                <span>Santiago, Chile · Barrio Bellavista / Providencia</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Column (5 cols on lg): Live Studio Video Capsule --}}
                <div class="lg:col-span-5 flex justify-center lg:justify-end">
                    <div class="w-full max-w-[340px] sm:max-w-[360px] relative">
                        
                        {{-- Golden Glow Wave in Background --}}
                        <div class="absolute -inset-3 bg-gradient-to-tr from-accent/25 via-accent/40 to-accent/15 rounded-[36px] blur-2xl opacity-60 animate-gold-wave pointer-events-none"></div>

                        {{-- Frame --}}
                        <div class="relative p-[2.5px] rounded-[32px] overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.95)] border border-accent/40">
                            
                            {{-- Rotating Golden Conic Wave --}}
                            <div class="absolute -inset-[150%] bg-[conic-gradient(from_0deg_at_50%_50%,transparent_0deg,transparent_75deg,rgba(212,175,55,0.1)_105deg,rgba(212,175,55,0.95)_135deg,rgba(255,245,190,1)_150deg,rgba(212,175,55,0.95)_165deg,rgba(212,175,55,0.1)_195deg,transparent_225deg)] animate-spin-slow pointer-events-none"></div>

                            {{-- Inner Capsule --}}
                            <div class="relative bg-black rounded-[30px] overflow-hidden flex flex-col border border-white/5">
                                
                                {{-- Top Bar --}}
                                <div class="px-4 py-2.5 bg-black/90 backdrop-blur-md border-b border-white/10 flex items-center justify-between z-20">
                                    <div class="flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                                        </span>
                                        <span class="text-[9.5px] uppercase tracking-[0.2em] font-black text-accent">Sesión en Vivo</span>
                                    </div>
                                    <a 
                                        href="https://www.instagram.com/farfos_tattoo/" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="text-[9.5px] font-mono tracking-wider text-muted hover:text-accent flex items-center gap-1 transition-colors"
                                    >
                                        <i data-lucide="instagram" class="w-3 h-3"></i>
                                        <span>@farfos_tattoo</span>
                                    </a>
                                </div>

                                {{-- Video Viewport --}}
                                <div class="relative aspect-[9/16] bg-card overflow-hidden group/cta flex items-center justify-center">
                                    <video
                                        x-ref="ctaVideo"
                                        src="{{ asset('videos/cta_short.mp4') }}"
                                        poster="{{ asset('videos/cta_banner.jpg') }}"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                        class="w-full h-full object-cover group-hover/cta:scale-105 transition-transform duration-700"
                                    ></video>

                                    {{-- Vignette Overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/30 pointer-events-none"></div>

                                    {{-- Play / Pause Floating Toggle --}}
                                    <button
                                        @click="toggleCtaVideo()"
                                        class="absolute bottom-3 right-3 z-20 w-9 h-9 rounded-full bg-black/80 border border-accent/50 text-accent flex items-center justify-center hover:scale-110 hover:bg-accent hover:text-accent-foreground transition-all backdrop-blur-md shadow-lg focus:outline-none cursor-pointer"
                                        :title="ctaPlaying ? 'Pausar Video' : 'Reproducir Video'"
                                    >
                                        <i :data-lucide="ctaPlaying ? 'pause' : 'play'" class="w-3.5 h-3.5"></i>
                                    </button>

                                    {{-- Bottom Badge --}}
                                    <div class="absolute bottom-3 left-3 z-20 max-w-[75%]">
                                        <p class="text-xs font-bold text-white tracking-wide truncate drop-shadow">Sebastián, El Farfo</p>
                                        <p class="text-[9px] text-accent tracking-wider uppercase font-semibold truncate">En plena creación</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    // Global Helper: Smoothly scroll to the exact vertical center of a section's content
    window.scrollToFarfoSection = function(id) {
        if (id === 'hero-section') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        const section = document.getElementById(id);
        if (!section) return;

        // Find the inner content grid or container inside the section
        const content = section.querySelector('.section-content-grid') || section.querySelector('.grid') || section.querySelector('.container') || section;
        const rect = content.getBoundingClientRect();
        const currentScrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;
        
        // Exactly center the content in the viewport:
        const targetY = currentScrollY + rect.top + (rect.height / 2) - (window.innerHeight / 2);

        window.scrollTo({
            top: Math.max(0, Math.round(targetY)),
            behavior: 'smooth'
        });
    };

    // Smooth scroll for internal anchor links (like #ritual or #proceso)
    document.addEventListener('click', function(e) {
        const anchor = e.target.closest('a[href^="#"], a[href*="#ritual"], a[href*="#proceso"], a[href*="#contacto-cta"]');
        if (anchor) {
            const href = anchor.getAttribute('href');
            const hashIdx = href.indexOf('#');
            if (hashIdx !== -1) {
                const id = href.substring(hashIdx + 1);
                if (id && document.getElementById(id)) {
                    e.preventDefault();
                    window.scrollToFarfoSection(id);
                    history.pushState(null, null, '#' + id);
                }
            }
        }
    });

    // On initial page load if hash exists, center that section
    if (window.location.hash) {
        const hashId = window.location.hash.substring(1);
        setTimeout(() => {
            if (document.getElementById(hashId)) {
                window.scrollToFarfoSection(hashId);
            }
        }, 250);
    }

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
