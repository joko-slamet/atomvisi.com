@props(['value', 'suffix' => '', 'label'])

<div
    x-data="{ display: 0 }"
    x-init="
        ScrollTrigger.create({
            trigger: $el,
            start: 'top 85%',
            once: true,
            onEnter: () => gsap.to($data, {
                display: {{ (int) $value }},
                duration: 1.8,
                ease: 'power2.out',
                onUpdate: () => display = Math.round(display),
            }),
        })
    "
    class="flex flex-col items-center text-center"
>
    <span class="font-serif text-4xl font-semibold text-gold-400 sm:text-5xl">
        <span x-text="display">0</span>{{ $suffix }}
    </span>
    <span class="mt-2 text-sm font-medium uppercase tracking-wide text-forest-100/70">{{ $label }}</span>
</div>
