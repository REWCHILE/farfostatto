<!DOCTYPE html>
<html lang="es" class="h-full antialiased dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin — FARFO'S TATTOO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex items-center justify-center p-6 bg-[url('https://images.unsplash.com/photo-1590201774843-021110a2663c?q=80&w=2000')] bg-cover bg-center font-sans text-foreground">
    {{-- Dark Backdrop overlay --}}
    <div class="absolute inset-0 bg-black/85 backdrop-blur-md"></div>
    
    <div class="max-w-md w-full bg-surface border border-border p-10 md:p-12 relative z-10 shadow-[0_0_60px_rgba(0,0,0,0.8)]">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="font-serif font-black uppercase text-accent tracking-tighter text-4xl mb-2 italic">Admin</h1>
            <p class="text-[10px] uppercase tracking-[0.3em] font-black text-muted">Centro de Comando FARFO'S</p>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-400 text-xs uppercase tracking-wider font-bold">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-3">
                <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    Usuario / Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email', 'admin@farfos.com') }}"
                    required
                    class="w-full bg-background border border-border p-4 text-sm outline-none focus:border-accent transition-colors"
                    placeholder="admin@farfos.com"
                >
            </div>

            <div class="space-y-3">
                <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-black text-accent">
                    <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    value="admin_password_123"
                    required
                    class="w-full bg-background border border-border p-4 text-sm outline-none focus:border-accent transition-colors"
                >
            </div>

            <div class="bg-accent/5 border border-accent/20 p-3 text-[10px] text-muted uppercase tracking-wider font-medium">
                <p>Credenciales por defecto:</p>
                <p class="text-accent font-bold mt-0.5">admin@farfos.com / admin_password_123</p>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-3 bg-accent text-accent-foreground py-4 text-[10px] uppercase font-black tracking-[0.2em] hover:bg-accent/90 transition-all shadow-[0_0_20px_rgba(212,175,55,0.2)]">
                <span>Ingresar al Sistema</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>

        <div class="mt-10 text-center">
            <a href="{{ route('home') }}" class="text-[10px] uppercase tracking-widest text-muted hover:text-accent transition-colors">
                ← Volver al Sitio Público
            </a>
        </div>
    </div>
</body>
</html>
