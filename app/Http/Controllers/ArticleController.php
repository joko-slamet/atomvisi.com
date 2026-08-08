<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function opEd()
    {
        $articles = Article::query()
            ->published()
            ->type('op-ed')
            ->latest('published_at')
            ->paginate(9);

        return view('pages.articles.index', [
            'articles' => $articles,
            'type' => 'op-ed',
            'title' => __('OP-EDS'),
            'subtitle' => __('Opini dan analisis dari para peneliti kami tentang isu-isu strategis terkini.'),
        ]);
    }

    public function newsletter(Request $request)
    {
        $categories = Category::query()->where('type', 'article')->get();

        $articles = Article::query()
            ->published()
            ->type('newsletter')
            ->when(
                $request->filled('category'),
                fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $request->query('category')))
            )
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.articles.newsletter', [
            'articles' => $articles,
            'categories' => $categories,
            'title' => __('Newsletters'),
            'subtitle' => __('Arsip newsletter dan kajian berkala Atom Visi Indonesia.'),
        ]);
    }

    public function blog()
    {
        $articles = Article::query()
            ->published()
            ->type('article')
            ->latest('published_at')
            ->paginate(9);

        return view('pages.articles.index', [
            'articles' => $articles,
            'type' => 'article',
            'title' => __('Insight & Artikel'),
            'subtitle' => __('Wawasan terbaru seputar riset kebijakan, politik, dan strategi.'),
        ]);
    }

    public function show(Article $article)
    {
        abort_unless($article->status === 'published', 404);

        $article->increment('views');

        $related = Article::query()
            ->published()
            ->type($article->type)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.articles.show', compact('article', 'related'));
    }
}
