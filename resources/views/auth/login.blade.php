<x-layout>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-custom">
                    <h1 class="h2 color-a google-sans-code fw-bold mb-4">Accedi</h1>

                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label color-p">Email</label>
                            <input type="email"
                                class="form-control bg-s color-p border-secondary @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label color-p">Password</label>
                            <input type="password"
                                class="form-control bg-s color-p border-secondary @error('password') is-invalid @enderror"
                                id="password" name="password" autocomplete="current-password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-light">Accedi</button>
                    </form>

                    <p class="color-p mt-4">
                        Non hai un account?
                        <a class="color-a" href="{{ route('register') }}">Registrati</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</x-layout>