@extends('layouts.app')

@section('title', "Sobre Mí — Sebastián, El Farfo")

@section('content')
<main class="pt-32 pb-24 bg-background">
    <div class="container mx-auto px-6">
        {{-- Hero Header --}}
        <div class="max-w-4xl mb-24">
            <h1 class="text-5xl md:text-7xl font-serif font-black uppercase tracking-tighter mb-8 italic">
                Sebastián, <span class="text-accent">El Farfo</span>
            </h1>
            <p class="text-lg md:text-xl text-muted font-medium leading-relaxed uppercase tracking-widest">
                De Profesor de Artes a Tatuador Profesional: Una evolución natural impulsada por la pasión y la técnica.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">
            {{-- Left Column: Story & Philosophy --}}
            <div class="space-y-12">
                <div class="space-y-6">
                    <h2 class="text-3xl font-serif font-bold uppercase italic tracking-tight text-white">
                        Mi Trayectoria Profesional
                    </h2>
                    <p class="text-muted leading-relaxed text-sm">
                        Comencé mi camino en el arte como <strong class="text-foreground">Profesor de Artes Visuales (UMCE)</strong>, profundizando luego en la pintura con un diplomado en la <strong class="text-foreground">Pontificia Universidad Católica</strong> y culminando con un <strong class="text-foreground">Magíster en Estudios de la Imagen en la Universidad Alberto Hurtado</strong>.
                    </p>
                    <p class="text-muted leading-relaxed text-sm">
                        Toda esta formación académica ha nutrido profundamente mi visión estética y conceptual del tatuaje. Hoy, canalizo ese conocimiento en cada diseño, buscando dar sentido a las imágenes que acompañarán a cada persona de por vida.
                    </p>
                </div>

                <div class="space-y-6">
                    <h3 class="text-2xl font-serif font-bold uppercase italic tracking-tight text-white">
                        Arte y Pasión
                    </h3>
                    <p class="text-muted leading-relaxed text-sm">
                        Trabajo profesionalmente como tatuador en Santiago de Chile, ofreciendo diseños personalizados que nacen del diálogo con cada cliente. Creo que un tatuaje no solo debe embellecer, sino también integrarse al cuerpo, fluir con su anatomía y cargarse de intención.
                    </p>
                    <p class="text-muted leading-relaxed text-sm">
                        Busco reconectar con el <strong class="text-foreground">carácter ritual del tatuaje</strong>, entendiendo la piel como un soporte significativo, donde cada imagen cuenta una historia única.
                    </p>
                </div>

                {{-- Counters --}}
                <div class="grid grid-cols-2 gap-8 pt-6 border-t border-border">
                    <div>
                        <p class="text-4xl font-serif font-black text-accent mb-2">150+</p>
                        <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-muted">Clientes Satisfechos</p>
                    </div>
                    <div>
                        <p class="text-4xl font-serif font-black text-accent mb-2">600+</p>
                        <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-muted">Arte Único</p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Why choose Sebastian card --}}
            <div class="space-y-8 bg-surface p-10 md:p-12 border border-border sticky top-32 shadow-2xl">
                <h3 class="text-xl font-serif font-bold uppercase tracking-widest mb-6">
                    ¿Por qué tatuarte conmigo?
                </h3>
                
                <div class="space-y-8">
                    <div class="flex gap-6">
                        <div class="w-12 h-12 shrink-0 border border-accent/30 flex items-center justify-center text-accent bg-background">
                            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold uppercase text-xs tracking-widest mb-1 font-serif italic text-accent">
                                Formación Académica
                            </h4>
                            <p class="text-xs text-muted leading-relaxed">
                                Visión estética respaldada por años de estudio formal en artes visuales e imagen.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-12 h-12 shrink-0 border border-accent/30 flex items-center justify-center text-accent bg-background">
                            <i data-lucide="palette" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold uppercase text-xs tracking-widest mb-1 font-serif italic text-accent">
                                Diseño Autoral
                            </h4>
                            <p class="text-xs text-muted leading-relaxed">
                                Cada pieza es única, diseñada específicamente para tu anatomía y mensaje.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-12 h-12 shrink-0 border border-accent/30 flex items-center justify-center text-accent bg-background">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold uppercase text-xs tracking-widest mb-1 font-serif italic text-accent">
                                Compromiso Ético
                            </h4>
                            <p class="text-xs text-muted leading-relaxed">
                                Máximos estándares de higiene, bioseguridad y atención personalizada.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <a 
                        href="{{ route('booking') }}" 
                        class="block w-full text-center bg-accent text-accent-foreground py-5 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-accent/90 transition-all shadow-xl"
                    >
                        Reserva tu Sesión Ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
