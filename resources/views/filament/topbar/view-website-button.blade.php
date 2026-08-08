<x-filament::button
    tag="a"
    href="{{ route('home', ['locale' => app()->getLocale()]) }}"
    target="_blank"
    color="gray"
    icon="heroicon-o-globe-alt"
    class="mr-2"
>
    {{ __('Lihat Website') }}
</x-filament::button>
