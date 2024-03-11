@extends('layouts.app')
@section('content')
<div class="container container-tight py-4">
    @extends('config.log')
    <div class="text-center mb-4">
        <a href="{{env('FRONTEND_URL')}}" class="navbar-brand navbar-brand-autodark">
            <img src="{{env('BACKEND_URL_IMAGE')}}/logos/dp.svg" style="width: 100px; height: 100px;" alt="Tabler" class="navbar-brand-image">
        </a>
    </div>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4 text-indigo">Iniciar Sesión</h2>
            <form action="{{ route('login') }}" method="post" autocomplete="off" novalidate="">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label class="form-label">Correo Electronico</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="tu@email.com" autocomplete="off" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Contraseña
                        <span class="form-label-description">
                    <a href="{{"recover-password"}}" >Me olvide mi contraseña</a>
                  </span>
                    </label>
                    <div class="input-group input-group-flat">
                        <input id="password" name="password" type="password" class="form-control" placeholder="Tu Contraseña" autocomplete="off" value="{{ old('password') }}">
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Toggle password visibility" data-bs-original-title="Toggle password visibility" id="password-toggle">
                                <!-- Updated SVG icon to toggle password visibility -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                </svg>
                            </a>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-indigo w-100">Iniciar Sesión</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-secondary mt-3">
          Ver  <a href="{{"terms-of-service"}}" tabindex="-1">Terminos y condiciones</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');

        passwordToggle.addEventListener('click', function (event) {
            event.preventDefault();
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    });

    function storeValueInLocalStorage(key, value) {
        localStorage.setItem(key, value);
    }
</script>
@endsection