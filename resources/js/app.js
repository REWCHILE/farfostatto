import Alpine from 'alpinejs';
import gsap from 'gsap';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.gsap = gsap;
window.lucide = { createIcons, icons };

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Re-run icons when Alpine mutates or renders
document.addEventListener('alpine:initialized', () => {
    createIcons({ icons });
});

Alpine.start();
