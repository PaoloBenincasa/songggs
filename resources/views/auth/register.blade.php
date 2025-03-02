<x-layout>
        <div class="container childHeight">
            <div class="row justify-content-center pt-5">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Registrati') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Nome utente -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Nome') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Conferma Password -->
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">{{ __('Conferma Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>

                                <!-- Nome d'arte -->
                                <div class="mb-3">
                                    <label for="stage_name" class="form-label">{{ __('Nome d\'arte') }}</label>
                                    <input id="stage_name" type="text"
                                        class="form-control @error('stage_name') is-invalid @enderror" name="stage_name"
                                        value="{{ old('stage_name') }}" required>
                                    @error('stage_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Pulsante di registrazione -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
</x-layout>
