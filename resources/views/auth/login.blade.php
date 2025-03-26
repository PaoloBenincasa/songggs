<x-layout>
    <div class="container childHeight">
        <div class="row justify-content-center pt-5">
            <div class="col-md-8 ">
                <div class="card account-body">
                    <div class="card-header">{{ __('login') }}</div>

                    <div class="card-body">
                        <form  method="POST" action="{{ route('login') }}">
                            @csrf

                           
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('email') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                          
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                       
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">{{ __('remember me') }}</label>
                            </div>

                          
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('log in') }}
                                </button>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layout>
