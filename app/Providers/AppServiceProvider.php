<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konten translatable (artikel, layanan, riset, dll) selalu lengkap dalam
        // Bahasa Indonesia, bukan Inggris — beda dengan APP_FALLBACK_LOCALE (=en)
        // yang dipakai untuk file bahasa UI. Tanpa ini, konten yang belum punya
        // terjemahan Inggris (mis. artikel hasil AI generator) tampil kosong sama
        // sekali saat diakses lewat locale "en", bukan jatuh ke versi Indonesia.
        Translatable::fallback(fallbackLocale: 'id', fallbackAny: true);

        View::composer([
            'components.layouts.footer',
            'components.whatsapp-float',
            'pages.contact',
        ], function ($view) {
            $view->with('settings', Setting::current());
        });
    }
}
