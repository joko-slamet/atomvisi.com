{{-- Text color is inherited from the wrapping element; wrap <x-logo /> in a container with the desired text-* class. --}}
<a href="{{ route('home') }}" class="group inline-flex items-center gap-3 text-inherit" aria-label="Atom Visi Indonesia — Beranda">
    <svg viewBox="0 0 48 48" class="h-10 w-10 shrink-0" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M24 2C24 2 6 20.5 6 30.5C6 40.6 14.06 46 24 46C33.94 46 42 40.6 42 30.5C42 20.5 24 2 24 2Z"
              fill="url(#logo-gradient)" />
        <circle cx="24" cy="27" r="7.5" fill="none" stroke="#D4A53D" stroke-width="1.4" opacity="0.9" />
        <path d="M20 30C20.8 27.2 22.2 25.8 24 25.8C25.8 25.8 27.2 27.2 28 30" stroke="#D4A53D" stroke-width="1.4" stroke-linecap="round" opacity="0.9" />
        <defs>
            <linearGradient id="logo-gradient" x1="6" y1="2" x2="42" y2="46" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#1B4332" />
                <stop offset="1" stop-color="#5C8F6C" />
            </linearGradient>
        </defs>
    </svg>
    <span class="flex flex-col leading-none text-inherit">
        <span class="font-serif text-lg font-semibold tracking-tight text-inherit">Atom Visi</span>
        <span class="text-[0.65rem] font-medium uppercase tracking-[0.2em] text-inherit opacity-70">Indonesia</span>
    </span>
</a>
