<x-layout>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-custom">
                    <h1 class="h2 color-a google-sans-code fw-bold mb-4">
                        {{ $project ? 'Modifica progetto' : 'Aggiungi progetto' }}
                    </h1>

                    <form action="{{ $project ? route('projects.update', $project) : route('projects.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($project)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label color-p">Titolo</label>
                            <input type="text" class="form-control bg-s color-p border-secondary @error('title') is-invalid @enderror"
                                id="title" name="title" value="{{ old('title', $project?->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label color-p">Descrizione</label>
                            <textarea class="form-control bg-s color-p border-secondary @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4">{{ old('description', $project?->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <fieldset class="mb-3">
                            <legend class="form-label color-p">Tecnologie</legend>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($tags as $tag)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                            id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                                            @checked(in_array($tag->id, (array) old('tags', $project?->tags->modelKeys() ?? [])))>
                                        <label class="form-check-label color-p" for="tag-{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @if ($errors->has('tags') || $errors->has('tags.*'))
                                <div class="text-danger small mt-1">
                                    {{ $errors->first('tags') ?: $errors->first('tags.*') }}
                                </div>
                            @endif
                        </fieldset>

                        <div class="mb-3">
                            <label for="image" class="form-label color-p">Immagine</label>
                            <input type="file" class="form-control bg-s color-p border-secondary @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            @if ($project?->imageUrl())
                                <img src="{{ $project->imageUrl() }}" alt="{{ $project->title }}"
                                    class="img-fluid rounded mt-2">
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="github_url" class="form-label color-p">URL GitHub</label>
                            <input type="url" class="form-control bg-s color-p border-secondary @error('github_url') is-invalid @enderror"
                                id="github_url" name="github_url" value="{{ old('github_url', $project?->github_url) }}"
                                placeholder="https://github.com/utente/repo">
                            @error('github_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-light">Salva progetto</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-layout>
