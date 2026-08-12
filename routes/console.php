<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Checks every minute whether the current time matches one of the run times
// configured in the "Pengaturan AI Artikel" admin page; only actually
// generates an article when a scheduled slot is due.
Schedule::command('articles:generate-ai')
    ->everyMinute()
    ->withoutOverlapping();
