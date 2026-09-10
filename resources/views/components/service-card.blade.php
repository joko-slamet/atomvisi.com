@props(['service'])

<a href="{{ route('services.show', $service) }}"
   data-aos="fade-up"
   class="group relative flex flex-col overflow-hidden rounded-2xl border border-forest-100 bg-white p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10"
>
    <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gold-500 transition-transform duration-300 group-hover:scale-x-100"></span>

    <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-forest-50 text-forest-700 transition-colors duration-300 group-hover:bg-forest-700 group-hover:text-gold-400">
        <x-icon :name="$service->icon ?? 'heroicon-o-briefcase'" class="h-7 w-7" />
    </span>

    <h3 class="mt-6 font-sans text-xl font-semibold text-forest-800">{{ $service->name }}</h3>
    <p class="mt-3 text-sm leading-relaxed text-charcoal/70">{{ $service->short_description }}</p>

    <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-forest-700 transition-colors group-hover:text-gold-600">
        {{ __('Pelajari Lebih Lanjut') }}
        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
    </span>
</a>
