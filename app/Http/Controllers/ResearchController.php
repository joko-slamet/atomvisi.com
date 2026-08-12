<?php

namespace App\Http\Controllers;

use App\Models\ResearchProject;

class ResearchController extends Controller
{
    public function index()
    {
        $featured = ResearchProject::query()
            ->published()
            ->where('is_featured', true)
            ->orderBy('order')
            ->get();

        $projects = ResearchProject::query()
            ->published()
            ->orderByDesc('year')
            ->orderBy('order')
            ->paginate(9);

        return view('pages.research.index', compact('featured', 'projects'));
    }

    public function show(string $locale, ResearchProject $researchProject)
    {
        abort_unless($researchProject->status === 'published', 404);

        return view('pages.research.show', ['project' => $researchProject]);
    }
}
