<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(): View
    {
        return view('formAdmin', [
            'tags' => Tag::query()->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $selectedTags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $project = Project::create($validated);
        $project->tags()->sync($selectedTags);

        return redirect()->route('projects.create');
    }

    public function index(): View
    {
        $projects = Project::with('tags')->latest()->get();

        return view('projects', compact('projects'));
    }
}
