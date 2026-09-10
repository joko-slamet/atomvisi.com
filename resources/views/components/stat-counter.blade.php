@props(['value', 'suffix' => '', 'label', 'icon' => null])

@php
    $radius = 52;
    $circumference = 2 * M_PI * $radius;
@endphp

<div
    x-data="{ display: 0 }"
    x-init="
        ScrollTrigger.create({
            trigger: $el,
            start: 'top 85%',
            once: true,
            onEnter: () => {
                gsap.to($data, {
                    display: {{ (int) $value }},
                    duration: 1.8,
                    ease: 'power2.out',
                    onUpdate: () => display = Math.round(display),
                });
                gsap.fromTo($refs.ring, {
                    strokeDashoffset: {{ $circumference }},
                }, {
                    strokeDashoffset: {{ $circumference * 0.12 }},
                    duration: 1.8,
                    ease: 'power2.out',
                });
            },
        })
    "
    class="group relative flex flex-col items-center rounded-2xl border border-cream/10 bg-cream/[0.03] px-6 py-8 text-center backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-gold-400/30 hover:bg-cream/[0.06]"
>
    <div class="relative flex h-28 w-28 items-center justify-center">
        <svg class="absolute inset-0 -rotate-90" viewBox="0 0 120 120" fill="none" aria-hidden="true">
            <circle cx="60" cy="60" r="{{ $radius }}" stroke="currentColor" stroke-width="3" class="text-cream/10" />
            <circle x-ref="ring" cx="60" cy="60" r="{{ $radius }}" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                    stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $circumference }}"
                    class="text-gold-400" />
        </svg>

        @if ($icon)
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-gold-500/10 text-gold-400 transition-colors duration-300 group-hover:bg-gold-500/20">
                <x-icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif
    </div>

    <span class="mt-5 font-sans text-4xl font-semibold text-cream sm:text-5xl">
        <span x-text="display">0</span>{{ $suffix }}
    </span>
    <span class="mt-2 text-sm font-medium uppercase tracking-wide text-forest-100/70">{{ $label }}</span>
</div>
