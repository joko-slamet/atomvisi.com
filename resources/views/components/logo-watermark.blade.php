@props(['class' => ''])

{{--
    Decorative background silhouette of the brand mark's "atom" glyph only
    (the circular badge behind it is cropped out), tinted via the parent's
    text color (currentColor). Source: public/images/logo-icon-atom.png.
--}}
<span
    aria-hidden="true"
    class="block bg-current {{ $class }}"
    style="
        -webkit-mask-image: url('{{ asset('images/logo-icon-atom.png') }}');
        -webkit-mask-repeat: no-repeat;
        -webkit-mask-position: center;
        -webkit-mask-size: contain;
        mask-image: url('{{ asset('images/logo-icon-atom.png') }}');
        mask-repeat: no-repeat;
        mask-position: center;
        mask-size: contain;
    "
></span>
