<x-layout>
    <section class="container py-5">
        <h1 class="h2 color-a google-sans-code fw-bold mb-4">Progetti</h1>

        @forelse ($projects as $project)
            <article class="card-custom mb-4 p-4">
                <h2 class="h3 color-a google-sans-code fw-bold">{{ $project->title }}</h2>
                @if ($project->tags->isNotEmpty())
                    <ul class="project-tags list-unstyled d-flex flex-wrap gap-2 mb-3">
                        @foreach ($project->tags as $tag)
                            <li><span class="badge">{{ $tag->name }}</span></li>
                        @endforeach
                    </ul>
                @endif
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                    class="img-fluid rounded mb-3">
                <p class="color-p mt-3">{{ $project->description }}</p>
                <a href="{{ $project->github_url }}" class="color-a" target="_blank" rel="noopener noreferrer">GitHub</a>
            </article>
        @empty
            <p class="color-p">Nessun progetto caricato.</p>
        @endforelse
    </section>
</x-layout>
