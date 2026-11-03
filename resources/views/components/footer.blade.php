<footer class="container-fluid px-3 py-4 bg-s border-top">
    <nav aria-label="Navigazione footer">
        <ul class="nav justify-content-center gap-3">
            <li class="nav-item">
                <a class="nav-link color-p" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-p" href="{{ route('projects.index') }}">Progetti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-p" href="{{ route('projects.create') }}">FormProgetti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-p" href="https://github.com/damianori18-dot?tab=repositories"
                    target="_blank" rel="noopener noreferrer">GitHub</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-p" href="https://www.linkedin.com/in/damiano-ricci-junior-web-developer/"
                    target="_blank" rel="noopener noreferrer">LinkedIn</a>
            </li>
        </ul>
    </nav>
    <p class="color-p small text-center mt-3 mb-0">
        &copy; {{ now()->year }} Damiano Ricci. Tutti i diritti riservati.
    </p>
</footer>