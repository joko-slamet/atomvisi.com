<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PageStat;
use App\Models\Service;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::query()->active()->ordered()->get();
        $stats = PageStat::query()->active()->ordered()->get();
        $testimonials = Testimonial::query()->active()->ordered()->get();
        $latestArticles = Article::query()
            ->published()
            ->type('article')
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.home', compact('services', 'stats', 'testimonials', 'latestArticles'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function coreValues()
    {
        return view('pages.core-values');
    }

    public function vision()
    {
        return view('pages.vision');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
