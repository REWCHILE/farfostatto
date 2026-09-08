@extends('layouts.app')

@section('title', "Solicitud Enviada — FARFO'S TATTOO")

@section('content')
<div class="min-h-screen flex items-center justify-center bg-background py-28 px-6">
    <div class="max-w-xl w-full bg-surface border border-border p-8 md:p-12 text-center relative overflow-hidden shadow-2xl">
        {{-- Golden Top Accent Line --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-accent"></div>
        
        {{-- Icon --}}
        <div class="w-20 h-20 bg-accent/20 rounded-full flex items-center justify-center mx-auto mb-8 text-accent shadow-[0_0_30px_rgba(212,175,55,0.2)]">
            <i data-lucide="check-circle-2" class="w-10 h-10"></i>
        </div>
        
        <h2 class="text-3xl md:text-4xl font-serif font-black uppercase mb-4 italic text-foreground">
            ¡Solicitud Enviada!
        </h2>
        
        <p class="text-muted text-xs uppercase tracking-widest leading-relaxed mb-10">
            Gracias por confiar en FARFO'S TATTOO. Tu propuesta está siendo revisada personalmente por Sebastián.
        </p>

        {{-- Deposit Instructions Card --}}
        <div class="bg-background border border-accent/30 p-8 mb-10 text-left space-y-5 shadow-lg">
            <div class="flex items-center gap-3 border-b border-border pb-4">
                <i data-lucide="shield-check" class="text-accent w-5 h-5 shrink-0"></i>
                <h3 class="text-xs uppercase font-black tracking-[0.2em] text-accent">Reserva de Agenda</h3>
            </div>
            
            <p class="text-xs leading-relaxed uppercase tracking-wider text-foreground/90">
                Para garantizar tu espacio exclusivo en la agenda, solicitamos una seña de <strong class="text-accent font-black text-sm">$30.000 CLP</strong>.
            </p>

            <div class="space-y-2 text-[10px] uppercase tracking-widest font-bold text-muted">
                <p>• La hora quedará confirmada una vez registrado el comprobante.</p>
                <p>• Este monto se descuenta íntegramente del total del tatuaje.</p>
                <p>• Envía tu comprobante vía WhatsApp para agilizar la confirmación.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a 
                href="https://wa.me/56934424269?text=Hola%20Sebastián,%20acabo%20de%20enviar%20mi%20solicitud%20de%20tatuaje%20desde%20la%20web." 
                target="_blank" 
                class="bg-accent text-accent-foreground px-8 py-4 text-[10px] uppercase font-black tracking-widest hover:bg-accent/90 transition-all shadow-[0_0_20px_rgba(212,175,55,0.25)] flex items-center justify-center gap-2"
            >
                <i data-lucide="phone" class="w-4 h-4"></i>
                <span>Enviar Comprobante WhatsApp</span>
            </a>
            <a 
                href="{{ route('home') }}" 
                class="border border-border text-muted px-8 py-4 text-[10px] uppercase font-black tracking-widest hover:text-foreground hover:border-accent transition-all flex items-center justify-center"
            >
                Volver al Inicio
            </a>
        </div>
    </div>
</div>
@endsection
