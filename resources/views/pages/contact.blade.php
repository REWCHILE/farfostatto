@extends('layouts.app')

@section('title', "Contacto — FARFO'S TATTOO")

@section('content')
<div class="bg-background pt-24">
    <section class="py-20">
        <div class="container mx-auto px-6">
            {{-- Header --}}
            <div class="text-center mb-20">
                <h1 class="text-5xl md:text-7xl font-serif font-black mb-6 tracking-tighter uppercase">
                    Estamos en <span class="text-accent italic">Contacto</span>
                </h1>
                <p class="text-muted max-w-2xl mx-auto uppercase tracking-widest text-xs font-bold leading-relaxed">
                    ¿Tienes dudas? Escríbenos o visítanos en uno de nuestros estudios de FARFO'S TATTOO.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                {{-- Left: Contact Channels, Studios & Hours --}}
                <div class="lg:col-span-1 space-y-12">
                    {{-- Direct Channels --}}
                    <div>
                        <h3 class="text-accent uppercase tracking-widest text-xs font-bold mb-6">Canales Directos</h3>
                        <ul class="space-y-6">
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-surface border border-border flex items-center justify-center text-accent shrink-0">
                                    <i data-lucide="phone" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold mb-1">WhatsApp</p>
                                    <a href="https://wa.me/56958747816" target="_blank" class="text-lg font-medium hover:text-accent transition-colors">+56 9 5874 7816</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-surface border border-border flex items-center justify-center text-accent shrink-0">
                                    <i data-lucide="instagram" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold mb-1">Instagram</p>
                                    <a href="https://instagram.com" target="_blank" class="text-lg font-medium hover:text-accent transition-colors">@farfos_tattoo</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-surface border border-border flex items-center justify-center text-accent shrink-0">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold mb-1">Email</p>
                                    <a href="mailto:hola@farfos.cl" class="text-lg font-medium hover:text-accent transition-colors">hola@farfos.cl</a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- Studio Locations --}}
                    <div>
                        <h3 class="text-accent uppercase tracking-widest text-xs font-bold mb-6">Nuestros Estudios</h3>
                        <ul class="space-y-8">
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-surface border border-border flex items-center justify-center text-accent shrink-0">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold mb-1">INKNEFABLE</p>
                                    <p class="text-lg font-medium text-foreground">Agustinas 814, <br>Santiago Centro.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-surface border border-border flex items-center justify-center text-accent shrink-0">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-muted font-bold mb-1">IL CAPO STUDIO</p>
                                    <p class="text-lg font-medium text-foreground">Av. La Montaña 2850, <br>Valle Grande.</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- Schedule --}}
                    <div>
                        <h3 class="text-accent uppercase tracking-widest text-xs font-bold mb-6">Horarios de Atención</h3>
                        <div class="space-y-4">
                            <div class="flex items-baseline gap-4">
                                <p class="text-[10px] uppercase tracking-widest text-muted font-bold w-16">LUN-VIE</p>
                                <p class="text-lg font-medium">11:00 — 20:00 HRS</p>
                            </div>
                            <div class="flex items-baseline gap-4">
                                <p class="text-[10px] uppercase tracking-widest text-muted font-bold w-16">SÁB</p>
                                <p class="text-lg font-medium">12:00 — 19:00 HRS</p>
                            </div>
                            <p class="text-muted text-[10px] mt-4 uppercase tracking-[0.2em] font-medium italic">
                                * Atención sólo con cita previa confirmada
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Right: Embedded Google Maps --}}
                <div class="lg:col-span-2 h-[550px] lg:h-[650px] bg-surface border border-border relative overflow-hidden group shadow-2xl">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.1760447069!2d-70.65074392434316!3d-33.440610996452296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5a07204f1a1%3A0xe54d2e07198a2872!2sAgustinas%20814%2C%208320223%20Santiago%2C%20Regi%C3%B3n%20Metropolitana!5e0!3m2!1ses!2scl!4v1711900000000!5m2!1ses!2scl" 
                        class="absolute inset-0 w-full h-full grayscale opacity-60 contrast-125 group-hover:opacity-100 transition-opacity duration-700"
                        style="border: 0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                    <div class="absolute inset-0 pointer-events-none border border-accent/20"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
