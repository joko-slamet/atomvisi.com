<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $preferred = request()->getPreferredLanguage(SetLocale::SUPPORTED_LOCALES);

    return redirect('/'.($preferred ?? 'id'));
});

Route::prefix('{locale}')
    ->where(['locale' => implode('|', SetLocale::SUPPORTED_LOCALES)])
    ->middleware('setlocale')
    ->group(function () {
        Route::get('/', [PageController::class, 'home'])->name('home');

        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/core-values', [PageController::class, 'coreValues'])->name('core-values');
        Route::get('/vision-mission', [PageController::class, 'vision'])->name('vision');
        Route::get('/team', [TeamController::class, 'index'])->name('team');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');

        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

        Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
        Route::get('/research/{researchProject}', [ResearchController::class, 'show'])->name('research.show');

        Route::get('/op-ed', [ArticleController::class, 'opEd'])->name('op-ed.index');
        Route::get('/newsletter', [ArticleController::class, 'newsletter'])->name('newsletter.index');
        Route::get('/insight', [ArticleController::class, 'blog'])->name('articles.index');
        Route::get('/insight/{article}', [ArticleController::class, 'show'])->name('articles.show');
    });
