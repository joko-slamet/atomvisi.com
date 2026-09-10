<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->active()
            ->topLevel()
            ->ordered()
            ->with(['activeChildren' => fn ($query) => $query->ordered()])
            ->get();

        return view('pages.services.index', compact('services'));
    }

    public function show(string $locale, Service $service)
    {
        abort_unless($service->is_active, 404);

        $service->load(['activeChildren' => fn ($query) => $query->ordered(), 'parent']);

        $otherServices = Service::query()
            ->active()
            ->topLevel()
            ->ordered()
            ->where('id', '!=', $service->parent_id ?? $service->id)
            ->limit(3)
            ->get();

        return view('pages.services.show', compact('service', 'otherServices'));
    }
}
