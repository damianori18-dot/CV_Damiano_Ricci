<x-layout>
    <main class="container-fluid">
        <div class="row vh-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-6">
                <h1 class="display-1 color-a fw-bold">WEB DEVELOPER</h1>
                <h2 class="color-p google-sans-code">Full Stack</h2>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="photo-wrapper">
                    <div class="photo-container">
                        <img src="{{ asset('media/foto-cv.jpg') }}" alt="foto profilo">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section class="skills-strip" id="skills" aria-label="Tecnologie">
        <div class="skills-track">
            <span>HTML5 <i>✳</i></span><span>CSS3 <i>✳</i></span><span>JAVASCRIPT <i>✳</i></span><span>RESPONSIVE DESIGN
                <i>✳</i></span><span>BOOTSTRAP <i>✳</i></span><span>GIT / GITHUB <i>✳</i></span><span>PHP
                <i>✳</i></span><span>LARAVEL <i>✳</i></span><span>MYSQL <i>✳</i></span>
            <span aria-hidden="true">HTML5 <i>✳</i></span><span aria-hidden="true">CSS3 <i>✳</i></span><span
                aria-hidden="true">JAVASCRIPT <i>✳</i></span><span aria-hidden="true">RESPONSIVE DESIGN
                <i>✳</i></span><span aria-hidden="true">BOOTSTRAP <i>✳</i></span><span aria-hidden="true">GIT / GITHUB
                <i>✳</i></span><span aria-hidden="true">PHP <i>✳</i></span><span aria-hidden="true">LARAVEL
                <i>✳</i></span><span aria-hidden="true">MYSQL <i>✳</i></span>
        </div>
    </section>
    <section class="container-fluid p-5 bg-s">
        <h2 class="color-p google-sans-code fw-semi-bold">FORMAZIONE</h2>
        <div class="py-3">
            <div class="row g-1 align-items-center">
                <div class="col-md-5">
                    <div class="card-body">
                        <h5 class="card-title color-a google-sans-code fw-bold">Master Full Stack Web Developer</h5>
                        <p class="card-text color-p">Corso intensivo di 400 ore focalizzato sullo sviluppo web Full
                            Stack e
                            sulle metodologie di lavoro utilizzate nelle tech company.</p> <br>

                        <p class="card-text color-a google-sans-code fw-bold">Principali tecnologie e competenze
                            acquisite:</p>
                        <ul class="color-p">
                            <li>
                                <p class="card-text color-a">Frontend:</p> HTML, CSS, JavaScript.
                            </li>
                            <li>
                                <p class="card-text color-a">Backend & Database:</p> PHP, Architettura MVC, MySQL.
                            </li>
                            <li>
                                <p class="card-text color-a">Framework:</p> Laravel (Routing, Migrations, Eloquent ORM,
                                Blade).
                            </li>
                            <li>
                                <p class="card-text color-a">Metodologie di lavoro:</p> Metodologie Agili (Scrum),
                                programmazione in team e versionamento
                                del codice con Git/GitHub.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <img src="{{ asset('media/attestato.png') }}" class="img-fluid rounded" alt="...">
                </div>
            </div>
        </div>
    </section>
    <section class="container py-5" id="projects">
        <h2 class="h2 color-a google-sans-code fw-bold mb-4">Ultimi progetti</h2>

        <div class="row">
            @forelse ($projects as $project)
                <div class="col-12 col-lg-4 mb-4">
                    <article class="card-custom project-card p-4 h-100">
                        <h3 class="h3 color-a google-sans-code fw-bold project-card-title">{{ $project->title }}</h3>
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                        class="img-fluid rounded mb-3">
                        @if ($project->tags->isNotEmpty())
                            <ul class="project-tags list-unstyled d-flex flex-wrap gap-2 mb-3">
                                @foreach ($project->tags as $tag)
                                    <li><span class="badge">{{ $tag->name }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="color-p mt-3 project-card-description">{{ $project->description }}</p>
                        <div class="project-card-actions">
                            <button type="button"
                                class="btn project-card-action-link project-description-trigger d-none"
                                data-bs-toggle="modal" data-bs-target="#projectDescriptionModal"
                                data-project-title="{{ $project->title }}"
                                data-project-description="{{ $project->description }}">
                                Leggi tutta la descrizione
                            </button>
                            <a href="{{ $project->github_url }}" class="project-card-action-link" target="_blank"
                                rel="noopener noreferrer">GitHub</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="color-p">Nessun progetto caricato.</p>
                </div>
            @endforelse
        </div>

    </section>
    <div class="modal fade" id="projectDescriptionModal" tabindex="-1"
        aria-labelledby="projectDescriptionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title h5 color-a google-sans-code fw-bold" id="projectDescriptionModalTitle">
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <p class="color-p mb-0" id="projectDescriptionModalText"></p>
                </div>
            </div>
        </div>
    </div>
    <section>

    </section>
</x-layout>
