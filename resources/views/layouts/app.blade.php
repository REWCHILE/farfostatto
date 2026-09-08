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

    {{-- Luxury Footer with Ambient Video Background & Official Channels --}}
    <footer id="footer" class="snap-section scroll-mt-20 relative overflow-hidden bg-black border-t border-border/70 pt-20 pb-12 mt-auto">
        
        {{-- Ambient Video Loop in Background --}}
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-20">
            <video 
                autoplay 
                muted 
                loop 
                playsinline 
                class="w-full h-full object-cover filter blur-[2px] scale-105"
            >
                <source src="{{ asset('videos/hero_bg.mp4') }}" type="video/mp4">
            </video>
            {{-- Vignette and Ambient Golden Glows --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/85 to-[#050505]/95"></div>
            <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-accent/10 blur-[120px] pointer-events-none animate-pulse"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full bg-accent/10 blur-[120px] pointer-events-none animate-pulse"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
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
                            <div class="w-6 h-6 rounded-full bg-[#25D366]/20 border border-[#25D366]/40 flex items-center justify-center text-[#25D366] shrink-0">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382C17.18 14.237 15.742 13.529 15.474 13.432C15.207 13.335 15.012 13.286 14.818 13.578C14.623 13.869 14.064 14.525 13.894 14.719C13.724 14.914 13.553 14.938 13.262 14.792C12.97 14.646 12.031 14.338 10.916 13.344C10.048 12.57 9.462 11.616 9.292 11.324C9.121 11.033 9.274 10.875 9.42 10.73C9.552 10.599 9.713 10.388 9.859 10.218C10.005 10.048 10.054 9.926 10.151 9.732C10.248 9.537 10.2 9.367 10.127 9.221C10.054 9.076 9.47 7.641 9.227 7.058C8.99 6.49 8.749 6.568 8.567 6.559C8.397 6.55 8.202 6.55 8.007 6.55C7.813 6.55 7.496 6.623 7.229 6.915C6.961 7.206 6.207 7.912 6.207 9.346C6.207 10.78 7.253 12.165 7.399 12.36C7.545 12.554 9.444 15.485 12.35 16.741C13.041 17.039 13.58 17.217 13.998 17.35C14.693 17.571 15.326 17.539 15.827 17.464C16.386 17.381 17.548 16.761 17.791 16.08C18.034 15.399 18.034 14.816 17.961 14.694C17.888 14.573 17.694 14.5 17.402 14.354L17.472 14.382ZM12.042 21.75H12.037C10.317 21.75 8.631 21.288 7.151 20.41L6.797 20.2L3 21.196L4.018 17.493L3.788 17.127C2.824 15.592 2.316 13.821 2.317 12.003C2.32 6.654 6.685 2.3 12.044 2.3C14.636 2.301 17.076 3.312 18.907 5.148C20.738 6.984 21.745 9.428 21.743 12.022C21.74 17.371 17.398 21.75 12.042 21.75Z"/>
                                </svg>
                            </div>
                            <a href="https://wa.me/56958747816" target="_blank" rel="noopener" class="hover:text-accent transition-colors">+56 9 5874 7816</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="text-accent w-5 h-5 shrink-0"></i>
                            <span>hola@farfos.cl</span>
                        </li>
                    </ul>
                </div>

                {{-- Social & Hours with Official Logotypes --}}
                <div>
                    <h4 class="text-accent uppercase tracking-widest text-xs font-bold mb-6">Síguenos & Chat</h4>
                    <div class="flex flex-col gap-3 mb-6">
                        {{-- Instagram Official Badge --}}
                        <a 
                            href="https://www.instagram.com/farfos_tattoo/" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-border/80 bg-surface/80 text-foreground/90 hover:border-accent hover:text-accent hover:shadow-[0_0_20px_rgba(212,175,55,0.25)] hover:scale-[1.02] transition-all duration-300 backdrop-blur-md"
                            title="Instagram Oficial @farfos_tattoo"
                        >
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-[#f09433] via-[#e6683c] to-[#bc1888] flex items-center justify-center text-white shrink-0 shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] uppercase tracking-widest text-muted font-bold">Instagram Oficial</span>
                                <span class="font-mono text-xs font-bold text-foreground group-hover:text-accent transition-colors">@farfos_tattoo</span>
                            </div>
                        </a>

                        {{-- WhatsApp Official Badge --}}
                        <a 
                            href="https://wa.me/56958747816" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-border/80 bg-surface/80 text-foreground/90 hover:border-[#25D366] hover:text-[#25D366] hover:shadow-[0_0_20px_rgba(37,211,102,0.3)] hover:scale-[1.02] transition-all duration-300 backdrop-blur-md"
                            title="WhatsApp Oficial Directo"
                        >
                            <div class="w-8 h-8 rounded-lg bg-[#25D366] flex items-center justify-center text-black shrink-0 shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382C17.18 14.237 15.742 13.529 15.474 13.432C15.207 13.335 15.012 13.286 14.818 13.578C14.623 13.869 14.064 14.525 13.894 14.719C13.724 14.914 13.553 14.938 13.262 14.792C12.97 14.646 12.031 14.338 10.916 13.344C10.048 12.57 9.462 11.616 9.292 11.324C9.121 11.033 9.274 10.875 9.42 10.73C9.552 10.599 9.713 10.388 9.859 10.218C10.005 10.048 10.054 9.926 10.151 9.732C10.248 9.537 10.2 9.367 10.127 9.221C10.054 9.076 9.47 7.641 9.227 7.058C8.99 6.49 8.749 6.568 8.567 6.559C8.397 6.55 8.202 6.55 8.007 6.55C7.813 6.55 7.496 6.623 7.229 6.915C6.961 7.206 6.207 7.912 6.207 9.346C6.207 10.78 7.253 12.165 7.399 12.36C7.545 12.554 9.444 15.485 12.35 16.741C13.041 17.039 13.58 17.217 13.998 17.35C14.693 17.571 15.326 17.539 15.827 17.464C16.386 17.381 17.548 16.761 17.791 16.08C18.034 15.399 18.034 14.816 17.961 14.694C17.888 14.573 17.694 14.5 17.402 14.354L17.472 14.382ZM12.042 21.75H12.037C10.317 21.75 8.631 21.288 7.151 20.41L6.797 20.2L3 21.196L4.018 17.493L3.788 17.127C2.824 15.592 2.316 13.821 2.317 12.003C2.32 6.654 6.685 2.3 12.044 2.3C14.636 2.301 17.076 3.312 18.907 5.148C20.738 6.984 21.745 9.428 21.743 12.022C21.74 17.371 17.398 21.75 12.042 21.75Z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] uppercase tracking-widest text-muted font-bold">WhatsApp Directo</span>
                                <span class="font-mono text-xs font-bold text-foreground group-hover:text-[#25D366] transition-colors">+56 9 5874 7816</span>
                            </div>
                        </a>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent/10 border border-accent/20 text-[9.5px] uppercase tracking-widest text-accent font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent animate-ping"></span>
                        <span>Atención con cita previa</span>
                    </div>
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
