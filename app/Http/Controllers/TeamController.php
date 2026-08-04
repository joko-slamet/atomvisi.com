<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::query()->active()->ordered()->get();

        return view('pages.team', compact('members'));
    }
}
