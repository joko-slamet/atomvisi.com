<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->active()->ordered()->get();

        return view('pages.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        $otherServices = Service::query()
            ->active()
            ->ordered()
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        return view('pages.services.show', compact('service', 'otherServices'));
    }
}
