import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AOS from 'aos';
import 'aos/dist/aos.css';

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 60,
    disable: prefersReducedMotion,
});

document.addEventListener('livewire:navigated', () => AOS.refresh());

// Alpine ships bundled with Livewire, so custom components are registered
// via the alpine:init hook rather than importing/starting Alpine ourselves.
document.addEventListener('alpine:init', () => {
    Alpine.data('heroSection', () => ({
        words: [
            'Riset Kebijakan Publik',
            'Analisis Politik & Geopolitik',
            'Survey & Kajian Sosial',
            'Strategi & Konsultasi',
        ],
        wordIndex: 0,

        init() {
            this.revealHeadline();

            if (!prefersReducedMotion) {
                this.cycleWords();
            }

            if (!prefersReducedMotion && canHover) {
                this.initParallax();
            }
        },

        revealHeadline() {
            const lines = this.$refs.headline.querySelectorAll('[data-line]');
            const rest = this.$el.querySelectorAll('[data-reveal]');

            gsap.set(lines, { yPercent: 110, opacity: 0 });
            gsap.set(rest, { y: 24, opacity: 0 });

            const tl = gsap.timeline({ delay: 0.15 });
            tl.to(lines, {
                yPercent: 0,
                opacity: 1,
                duration: 1,
                ease: 'power3.out',
                stagger: 0.12,
            }).to(rest, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out',
                stagger: 0.1,
            }, '-=0.5');

            if (this.$refs.underline) {
                const length = this.$refs.underline.getTotalLength();
                gsap.set(this.$refs.underline, { strokeDasharray: length, strokeDashoffset: length });
                tl.to(this.$refs.underline, {
                    strokeDashoffset: 0,
                    duration: 0.9,
                    ease: 'power2.inOut',
                }, '-=0.4');
            }
        },

        cycleWords() {
            const el = this.$refs.rotatingWord;

            setInterval(() => {
                gsap.to(el, {
                    yPercent: -100,
                    opacity: 0,
                    duration: 0.4,
                    ease: 'power2.in',
                    onComplete: () => {
                        this.wordIndex = (this.wordIndex + 1) % this.words.length;
                        gsap.set(el, { yPercent: 100 });
                        gsap.to(el, { yPercent: 0, opacity: 1, duration: 0.5, ease: 'power2.out' });
                    },
                });
            }, 2800);
        },

        initParallax() {
            const layers = this.$el.querySelectorAll('[data-parallax]');

            const movers = Array.from(layers).map((layer) => ({
                layer,
                depth: parseFloat(layer.dataset.parallax) || 20,
                moveX: gsap.quickTo(layer, 'x', { duration: 0.9, ease: 'power3.out' }),
                moveY: gsap.quickTo(layer, 'y', { duration: 0.9, ease: 'power3.out' }),
            }));

            this.$el.addEventListener('mousemove', (event) => {
                const rect = this.$el.getBoundingClientRect();
                const relX = (event.clientX - rect.left) / rect.width - 0.5;
                const relY = (event.clientY - rect.top) / rect.height - 0.5;

                movers.forEach(({ depth, moveX, moveY }) => {
                    moveX(relX * depth);
                    moveY(relY * depth);
                });
            });
        },
    }));

    Alpine.data('serviceShowcase', (count) => ({
        active: 0,
        count,
        paused: false,
        progress: 0,
        timer: null,

        init() {
            this.$watch('active', () => {
                this.progress = 0;
            });

            if (!prefersReducedMotion) {
                this.startAutoplay();
            }
        },

        select(index) {
            this.active = index;
            this.progress = 0;
        },

        startAutoplay() {
            const durationMs = 5000;
            const stepMs = 50;

            this.timer = setInterval(() => {
                if (this.paused) {
                    return;
                }

                this.progress += (stepMs / durationMs) * 100;

                if (this.progress >= 100) {
                    this.active = (this.active + 1) % this.count;
                    this.progress = 0;
                }
            }, stepMs);
        },
    }));

    Alpine.data('tiltCard', () => ({
        init() {
            if (!canHover || prefersReducedMotion) {
                return;
            }

            const el = this.$el;
            gsap.set(el, { transformPerspective: 800, transformStyle: 'preserve-3d' });

            const rotateX = gsap.quickTo(el, 'rotationX', { duration: 0.6, ease: 'power3.out' });
            const rotateY = gsap.quickTo(el, 'rotationY', { duration: 0.6, ease: 'power3.out' });

            el.addEventListener('mousemove', (event) => {
                const rect = el.getBoundingClientRect();
                const relX = (event.clientX - rect.left) / rect.width - 0.5;
                const relY = (event.clientY - rect.top) / rect.height - 0.5;
                rotateY(relX * 8);
                rotateX(relY * -8);
            });

            el.addEventListener('mouseleave', () => {
                rotateX(0);
                rotateY(0);
            });
        },
    }));
});
