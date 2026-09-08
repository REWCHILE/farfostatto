<!DOCTYPE html>
<html lang="es" class="h-full antialiased dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Admin Panel — FARFO'S TATTOO")</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex bg-background text-foreground font-sans selection:bg-accent selection:text-accent-foreground">

    <div x-data="{ sidebarOpen: true }" class="min-h-screen w-full flex">
        {{-- Sidebar --}}
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'" 
            class="bg-surface border-r border-border transition-all duration-300 flex flex-col shrink-0"
        >
            <div class="p-6 h-20 flex items-center justify-between border-b border-border">
                <span x-show="sidebarOpen" class="font-serif font-black uppercase text-accent tracking-tighter text-xl">
                    FARFO'S
                </span>
                <button @click="sidebarOpen = !sidebarOpen" class="text-muted hover:text-foreground transition-colors p-1" aria-label="Toggle Sidebar">
                    <i :data-lucide="sidebarOpen ? 'x' : 'menu'" class="w-5 h-5"></i>
                </button>
            </div>

            <nav class="flex-grow py-8 px-4 space-y-2">
                @php
                    $links = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'bar-chart-3'],
                        ['route' => 'admin.agenda', 'label' => 'Agenda', 'icon' => 'calendar'],
                        ['route' => 'admin.requests', 'label' => 'Solicitudes', 'icon' => 'message-square'],
                        ['route' => 'admin.clients', 'label' => 'Clientes', 'icon' => 'users'],
                        ['route' => 'admin.portfolio', 'label' => 'Portfolio', 'icon' => 'image'],
                        ['route' => 'admin.settings', 'label' => 'Ajustes', 'icon' => 'settings'],
                    ];
                @endphp

                @foreach($links as $link)
                    @php $isActive = request()->routeIs($link['route'].'*'); @endphp
                    <a 
                        href="{{ route($link['route']) }}" 
                        class="flex items-center gap-4 p-3 font-bold uppercase tracking-widest text-[10px] transition-all group rounded-sm {{ $isActive ? 'bg-accent text-accent-foreground shadow-md' : 'text-muted hover:text-foreground hover:bg-white/5' }}"
                    >
                        <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4 shrink-0 {{ $isActive ? 'text-accent-foreground' : 'text-accent group-hover:scale-110 transition-transform' }}"></i>
                        <span x-show="sidebarOpen" class="truncate">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-border">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 p-3 font-bold uppercase tracking-widest text-[10px] text-red-400 hover:bg-red-500/10 transition-all rounded-sm">
                        <i data-lucide="log-out" class="w-4 h-4 shrink-0"></i>
                        <span x-show="sidebarOpen">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Area --}}
        <div class="flex-grow flex flex-col overflow-hidden min-w-0">
            {{-- Topbar --}}
            <header class="h-20 border-b border-border bg-surface flex items-center justify-between px-8 shrink-0">
                <div class="relative w-96 max-w-full">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted w-4 h-4"></i>
                    <input 
                        type="text" 
                        placeholder="Buscar cliente, cita..." 
                        class="w-full bg-background border border-border pl-10 pr-4 py-2 text-[10px] uppercase font-bold outline-none focus:border-accent transition-colors"
                    >
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" target="_blank" class="text-xs uppercase tracking-widest text-muted hover:text-accent font-bold hidden sm:flex items-center gap-1.5 transition-colors">
                        <span>Ver Sitio</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>

                    <button class="relative text-muted hover:text-foreground transition-colors p-1" aria-label="Notificaciones">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-accent rounded-full border border-surface"></span>
                    </button>

                    <div class="w-[1px] h-8 bg-border"></div>

                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-black uppercase tracking-widest">{{ Auth::guard('admin')->user()->name ?? "Admin FARFO'S" }}</p>
                            <p class="text-[8px] text-muted uppercase tracking-tighter">Dueño / Artista</p>
                        </div>
                        <div class="w-10 h-10 bg-accent text-accent-foreground flex items-center justify-center font-black rounded-sm shadow-md">
                            F
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mx-8 mt-6 p-4 bg-accent/10 border border-accent/30 text-accent text-xs uppercase tracking-wider font-bold flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-accent hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-8 mt-6 p-4 bg-red-500/10 border border-red-500/30 text-red-400 text-xs uppercase tracking-wider font-bold flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-red-400 hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            @if(session('info'))
                <div class="mx-8 mt-6 p-4 bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs uppercase tracking-wider font-bold flex items-center justify-between">
                    <span>{{ session('info') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-blue-400 hover:text-foreground"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            {{-- View Content --}}
            <main class="flex-grow overflow-y-auto p-8 md:p-12 bg-background/50">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
