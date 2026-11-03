<x-layout>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-custom">
                    <h1 class="h2 color-a google-sans-code fw-bold mb-4">Crea un account</h1>

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label color-p">Nome</label>
                            <input type="text"
                                class="form-control bg-s color-p border-secondary @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" autocomplete="name" required
                                autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label color-p">Email</label>
                            <input type="email"
                                class="form-control bg-s color-p border-secondary @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label color-p">Password</label>
                            <input type="password"
                                class="form-control bg-s color-p border-secondary @error('password') is-invalid @enderror"
                                id="password" name="password" autocomplete="new-password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label color-p">Conferma password</label>
                            <input type="password"
                                class="form-control bg-s color-p border-secondary @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                autocomplete="new-password" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-light">Registrati</button>
                    </form>

                    <p class="color-p mt-4">
                        Hai già un account?
                        <a class="color-a" href="{{ route('login') }}">Accedi</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</x-layout>