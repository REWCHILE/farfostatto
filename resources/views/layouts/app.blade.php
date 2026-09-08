<!DOCTYPE html>
<html lang="es" class="h-full antialiased dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "FARFO'S TATTOO — Estudio de Tatuajes de Alta Gama")</title>
    <meta name="description" content="Estudio de tatuajes de alta gama en Santiago, Chile. Diseños de autor, realismo, anime, blackwork y cover up por Sebastián El Farfo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-background text-foreground selection:bg-accent selection:text-accent-foreground">

    {{-- Sticky Luxury Navbar --}}
    <header 
        x-data="{ scrolled: false, mobileOpen: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
        :class="scrolled ? 'bg-background/85 backdrop-blur-md border-b border-border py-4 shadow-xl' : 'bg-transparent py-6'"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-500"
    >
        <nav class="container mx-auto px-6 flex justify-between items-center">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="group">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-serif font-black tracking-tighter text-accent group-hover:text-foreground transition-colors duration-300">
                        FARFO'S
                    </span>
                    <span class="text-xs uppercase tracking-[0.3em] font-sans font-bold pt-1 text-foreground/80">
                        Tattoo
                    </span>
                </div>
            </a>

            {{-- Desktop Links --}}
            <ul class="hidden md:flex items-center gap-10">
                <li>
                    <a href="{{ route('home') }}" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group {{ request()->routeIs('home') ? 'text-accent' : 'text-foreground/90' }}">
                        Inicio
                        <span class="absolute -bottom-1 left-0 {{ request()->routeIs('home') ? 'w-full' : 'w-0' }} h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('portfolio') }}" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group {{ request()->routeIs('portfolio') ? 'text-accent' : 'text-foreground/90' }}">
                        Portafolio
                        <span class="absolute -bottom-1 left-0 {{ request()->routeIs('portfolio') ? 'w-full' : 'w-0' }} h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#proceso" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group text-foreground/90">
                        Proceso
                        <span class="absolute -bottom-1 left-0 w-0 h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group {{ request()->routeIs('about') ? 'text-accent' : 'text-foreground/90' }}">
                        Sobre Mí
                        <span class="absolute -bottom-1 left-0 {{ request()->routeIs('about') ? 'w-full' : 'w-0' }} h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('booking') }}" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group {{ request()->routeIs('booking*') ? 'text-accent' : 'text-foreground/90' }}">
                        Reserva
                        <span class="absolute -bottom-1 left-0 {{ request()->routeIs('booking*') ? 'w-full' : 'w-0' }} h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="text-xs uppercase tracking-widest font-bold hover:text-accent transition-colors duration-300 relative group {{ request()->routeIs('contact') ? 'text-accent' : 'text-foreground/90' }}">
                        Contacto
                        <span class="absolute -bottom-1 left-0 {{ request()->routeIs('contact') ? 'w-full' : 'w-0' }} h-[1px] bg-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
            </ul>

            {{-- Desktop CTA --}}
            <div class="hidden md:flex items-center gap-6">
                <a 
                    href="{{ route('booking') }}" 
                    class="px-6 py-2.5 border border-accent text-accent text-xs uppercase tracking-widest font-bold hover:bg-accent hover:text-accent-foreground transition-all duration-500"
                >
                    Reserva Ahora
                </a>
            </div>

            {{-- Mobile Toggle Button --}}
            <button 
                @click="mobileOpen = !mobileOpen" 
                class="md:hidden text-foreground p-2 focus:outline-none"
                aria-label="Abrir Menú"
            >
                <i :data-lucide="mobileOpen ? 'x' : 'menu'" class="w-6 h-6"></i>
            </button>
        </nav>

        {{-- Mobile Drawer Menu --}}
        <div 
            x-show="mobileOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="absolute top-full left-0 w-full bg-surface border-b border-border md:hidden shadow-2xl"
            style="display: none;"
        >
            <ul class="flex flex-col p-8 gap-6 text-center">
                <li>
                    <a href="{{ route('home') }}" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Inicio</a>
                </li>
                <li>
                    <a href="{{ route('portfolio') }}" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Portafolio</a>
                </li>
                <li>
                    <a href="{{ route('home') }}#proceso" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Proceso</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Sobre Mí</a>
                </li>
                <li>
                    <a href="{{ route('booking') }}" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Reserva</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" @click="mobileOpen = false" class="text-base uppercase tracking-widest font-serif hover:text-accent transition-all">Contacto</a>
                </li>
                <li class="pt-4">
                    <a href="{{ route('booking') }}" @click="mobileOpen = false" class="inline-block w-full px-6 py-4 bg-accent text-accent-foreground text-xs uppercase tracking-widest font-black">
                        Reserva Ahora
                    </a>
                </li>
            </ul>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Luxury Footer --}}
    <footer id="footer" class="snap-section scroll-mt-20 bg-surface border-t border-border pt-20 pb-10 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                {{-- Brand Section --}}
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="inline-block mb-6">
                        <span class="text-3xl font-serif font-black tracking-tighter text-accent">
                            FARFO'S
                        </span>
                        <span class="block text-xs uppercase tracking-[0.5em] font-sans font-bold text-foreground">
                            Tattoo
                        </span>
                    </a>
                    <p class="text-muted text-xs leading-relaxed max-w-xs uppercase tracking-wider font-medium">
                        Estudio de tatuajes de alta gama enfocado en el arte, la elegancia y la personalización.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-accent uppercase tracking-widest text-xs font-bold mb-8">Navegación</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-sm text-foreground/80 hover:text-accent transition-colors">Inicio</a></li>
                        <li><a href="{{ route('portfolio') }}" class="text-sm text-foreground/80 hover:text-accent transition-colors">Portafolio</a></li>
                        <li><a href="{{ route('booking') }}" class="text-sm text-foreground/80 hover:text-accent transition-colors">Reserva</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm text-foreground/80 hover:text-accent transition-colors">Sobre Mí</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-foreground/80 hover:text-accent transition-colors">Contacto</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h4 class="text-accent uppercase tracking-widest text-xs font-bold mb-8">Contacto</h4>
                    <ul class="space-y-4 text-sm text-foreground/80">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="text-accent w-5 h-5 shrink-0 mt-0.5"></i>
                            <span>Calle Galería de Arte 123, <br> Santiago, Chile</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="phone" class="text-accent w-5 h-5 shrink-0"></i>
                            <span>+56 9 5874 7816</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="text-accent w-5 h-5 shrink-0"></i>
                            <span>hola@farfos.cl</span>
                        </li>
                    </ul>
                </div>

                {{-- Social & Hours --}}
                <div>
                    <h4 class="text-accent uppercase tracking-widest text-xs font-bold mb-8">Síguenos</h4>
                    <div class="flex gap-4 mb-6">
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-border flex items-center justify-center text-foreground/80 hover:border-accent hover:text-accent transition-all duration-300">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="https://wa.me/56958747816" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-border flex items-center justify-center text-foreground/80 hover:border-accent hover:text-accent transition-all duration-300">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </a>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold">Atención con cita previa</p>
                </div>
            </div>

            <div class="border-t border-border/50 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-muted text-[10px] uppercase tracking-widest">
                    © {{ date('Y') }} FARFO'S TATTOO. Todos los derechos reservados.
                </p>
                <div class="text-muted text-[10px] uppercase tracking-widest flex gap-6">
                    <a href="{{ route('admin.login') }}" class="hover:text-accent transition-colors">Panel Admin</a>
                    <a href="#" class="hover:text-foreground">Privacidad</a>
                    <a href="#" class="hover:text-foreground">Términos</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
