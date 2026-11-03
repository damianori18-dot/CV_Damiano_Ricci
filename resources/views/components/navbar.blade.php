<nav class="navbar navbar-expand-lg px-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <h4 class="google-sans-code mb-0">Damiano<span class="color-a"> Ricci</span></h4>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
             <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('projects.index') }}">Progetti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('projects.create') }}">FormProgetti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page"
                        href="https://github.com/damianori18-dot?tab=repositories" target="_blank">GitHub</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page"
                        href="https://www.linkedin.com/in/damiano-ricci-junior-web-developer/" target="_blank">LinkedIn</a>
                </li>
            </ul> 

        </div>
    </div>
</nav>
