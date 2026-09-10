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

// Livewire component updates (e.g. the political calculator or contact form
// swapping in their result view) patch the DOM without a page navigation, so
// AOS never sees newly-inserted [data-aos] elements unless told to rescan.
document.addEventListener('livewire:init', () => {
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => AOS.refresh());
    });
});

// Alpine ships bundled with Livewire, so custom components are registered
// via the alpine:init hook rather than importing/starting Alpine ourselves.
document.addEventListener('alpine:init', () => {
    Alpine.data('heroSection', (words = [
        'Riset Kebijakan Publik',
        'Analisis Politik & Geopolitik',
        'Survey & Kajian Sosial',
        'Strategi & Konsultasi',
    ]) => ({
        words,
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
        fitFrame: null,

        init() {
            this.$watch('active', () => {
                this.progress = 0;
                this.fitOrbit();
                // Re-measure once the active card finishes its scale transition.
                setTimeout(() => this.fitOrbit(), 350);
            });

            if (!prefersReducedMotion) {
                this.startAutoplay();
            }

            // Reserve just enough space around the orbit so no floating card is clipped.
            this.fitFrame = this.$el.querySelector('[data-orbit-frame]');
            this.fitOrbit();
            requestAnimationFrame(() => {
                this.fitOrbit();
                requestAnimationFrame(() => this.fitOrbit());
            });

            let raf = null;
            this.onResize = () => {
                if (raf) {
                    return;
                }
                raf = requestAnimationFrame(() => {
                    raf = null;
                    this.fitOrbit();
                });
            };
            window.addEventListener('resize', this.onResize, { passive: true });

            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(() => this.fitOrbit());
            }
            window.addEventListener('load', this.onResize, { passive: true, once: true });
        },

        destroy() {
            if (this.onResize) {
                window.removeEventListener('resize', this.onResize);
            }
        },

        fitOrbit() {
            const frame = this.fitFrame;
            const box = frame && frame.querySelector('[data-orbit-box]');

            if (!frame || !box || !frame.offsetParent) {
                return;
            }

            frame.style.padding = '0px';

            const cards = box.querySelectorAll('[data-orbit-card]');
            const bounds = box.getBoundingClientRect();
            let top = 0;
            let right = 0;
            let bottom = 0;
            let left = 0;

            cards.forEach((card) => {
                const rect = card.getBoundingClientRect();
                top = Math.max(top, bounds.top - rect.top);
                right = Math.max(right, rect.right - bounds.right);
                bottom = Math.max(bottom, rect.bottom - bounds.bottom);
                left = Math.max(left, bounds.left - rect.left);
            });

            const buffer = 32;
            const px = (value) => Math.ceil(Math.max(0, value) + buffer);

            // Vertical padding is free (it never shrinks a width-driven square).
            frame.style.paddingTop = `${px(top)}px`;
            frame.style.paddingBottom = `${px(bottom)}px`;

            // Horizontal padding competes with the orbit width, so keep the square
            // at a sensible minimum before letting the section absorb the rest.
            const minBox = Math.min(512, frame.clientWidth);
            const roomEachSide = Math.max(0, (frame.clientWidth - minBox) / 2);
            const cap = Math.max(24, Math.round(roomEachSide));

            frame.style.paddingLeft = `${Math.min(cap, px(left))}px`;
            frame.style.paddingRight = `${Math.min(cap, px(right))}px`;
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

    Alpine.data('whyReasons', () => ({
        active: 0,

        init() {
            const items = this.$refs.items.querySelectorAll('[data-reason]');

            items.forEach((el, index) => {
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 55%',
                    end: 'bottom 45%',
                    onEnter: () => (this.active = index),
                    onEnterBack: () => (this.active = index),
                });
            });
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

    // Kalkulator politik: hasil dikirim dari Livewire lewat event "calculator-result-ready",
    // lalu disimpan di localStorage sebagai riwayat sisi klien. "Hapus Riwayat" hanya
    // menghapus data localStorage ini, record di database (untuk admin) tidak tersentuh.
    Alpine.data('politicalCalculatorResult', () => ({
        result: null,
        openMonth: 1,
        storageKey: 'atomvisi-political-calculator-result',

        init() {
            const saved = localStorage.getItem(this.storageKey);

            if (saved) {
                try {
                    this.result = JSON.parse(saved);
                } catch (e) {
                    localStorage.removeItem(this.storageKey);
                }
            }

            this.$wire.on('calculator-result-ready', (event) => {
                this.result = event.payload;
                this.openMonth = 1;
                localStorage.setItem(this.storageKey, JSON.stringify(this.result));
            });
        },

        clearResult() {
            localStorage.removeItem(this.storageKey);
            this.result = null;
            this.$wire.resetForm();
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value ?? 0);
        },
    }));
});
