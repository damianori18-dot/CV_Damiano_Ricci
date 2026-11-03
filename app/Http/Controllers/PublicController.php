<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $projects = Project::query()
            ->with('tags')
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('projects'));
    }
}
