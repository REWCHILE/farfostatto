@extends('layouts.app')

@section('title', "Portafolio — FARFO'S TATTOO")

@section('content')
<div class="bg-background pt-24" x-data="{ currentFilter: 'Todos' }">
    <section class="py-20">
        <div class="container mx-auto px-6 text-center mb-16">
            <h1 class="text-5xl md:text-7xl font-serif font-black mb-6 tracking-tighter uppercase italic">
                Muestra de <span class="text-accent not-italic">Portafolio</span>
            </h1>
            <p class="text-muted max-w-2xl mx-auto uppercase tracking-widest text-[10px] font-bold">
                Una selección de trabajos hechos con precisión y dedicación. Cada pieza es única y diseñada exclusivamente para el cliente.
            </p>
        </div>

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16 px-6">
            @foreach($categories as $cat)
                <button
                    @click="currentFilter = '{{ $cat }}'"
                    :class="currentFilter === '{{ $cat }}' 
                        ? 'bg-accent border-accent text-accent-foreground shadow-[0_0_15px_rgba(212,175,55,0.3)]' 
                        : 'border-border text-muted hover:text-foreground hover:border-accent'"
                    class="px-8 py-3 text-[10px] uppercase tracking-widest font-black border transition-all duration-300 rounded-sm"
                >
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        {{-- Portfolio Gallery Grid --}}
        <div class="container mx-auto px-6 mb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolioItems as $item)
                    @php $categoryName = $item->style->name ?? 'Realismo'; @endphp
                    <div
                        x-show="currentFilter === 'Todos' || currentFilter === '{{ $categoryName }}'"
                        x-transition:enter="transition ease-out duration-400"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="aspect-[4/5] bg-surface relative overflow-hidden group cursor-pointer border border-border rounded-sm shadow-xl"
                    >
                        <img 
                            src="{{ $item->image_url }}" 
                            alt="{{ $item->title }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0"
                        >
                        {{-- Hover Dark Overlay with details --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-8">
                            <p class="text-[10px] uppercase tracking-widest text-accent font-bold mb-2">
                                {{ $categoryName }}
                            </p>
                            <h3 class="text-2xl font-serif font-bold italic mb-2 text-white">
                                {{ $item->title }}
                            </h3>
                            <p class="text-[11px] text-muted uppercase tracking-wider leading-relaxed line-clamp-3">
                                {{ $item->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom CTA --}}
        <div class="text-center pb-12">
            <p class="text-xs uppercase tracking-widest text-muted font-bold mb-6">¿Tienes una idea en mente para tu próximo tatuaje?</p>
            <a href="{{ route('booking') }}" class="inline-block px-10 py-5 bg-accent text-accent-foreground text-xs uppercase font-black tracking-widest hover:bg-accent/90 transition-all shadow-xl">
                Agenda tu Consulta
            </a>
        </div>
    </section>
</div>
@endsection
