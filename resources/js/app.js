import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AOS from 'aos';
import 'aos/dist/aos.css';

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 60,
    disable: prefersReducedMotion,
});

document.addEventListener('livewire:navigated', () => AOS.refresh());
