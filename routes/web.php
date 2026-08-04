<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/nilai-nilai', [PageController::class, 'coreValues'])->name('core-values');
Route::get('/visi-misi', [PageController::class, 'vision'])->name('vision');
Route::get('/tim-kami', [TeamController::class, 'index'])->name('team');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/riset', [ResearchController::class, 'index'])->name('research.index');
Route::get('/riset/{researchProject}', [ResearchController::class, 'show'])->name('research.show');

Route::get('/op-ed', [ArticleController::class, 'opEd'])->name('op-ed.index');
Route::get('/newsletter', [ArticleController::class, 'newsletter'])->name('newsletter.index');
Route::get('/insight', [ArticleController::class, 'blog'])->name('articles.index');
Route::get('/insight/{article}', [ArticleController::class, 'show'])->name('articles.show');
