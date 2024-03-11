@extends('layouts.app')
@section('content')
    <!--header-->
    <div class="container-fluid main-container">
    @if ($user)
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title text-indigo">
                        Editar Usuario:  "{{ $user->name }}"
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <form action="{{ route('users.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                </svg>
                                Volver a la lista de usuarios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('users.update', $user) }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="name" class="my-2">Nombre del Usuario </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="email" class="my-2">Correo del Usuario </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="package" class="my-2">Nombre del Paquete </label>
                    <input type="text" class="form-control @error('package') is-invalid @enderror" id="package" name="package" value="{{ old('package', $user->package) }}">
                    @error('package')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="password" class="my-2">Contraseña </label>
                    <div class="input-group input-group-flat">
                        <input id="password" name="password" type="password" class="form-control" autocomplete="off" value="{{ old('password') }}">
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
                <div class="form-group my-2">
                    <label for="role" class="my-2">Rol del Usuario </label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                        <option value="CLIENT" {{ old('role', $user->role) === 'CLIENT' ? 'selected' : '' }}>Cliente</option>
                    </select>
                    @error('role')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="billing_cycle" class="my-2">Ciclo de Facturación </label>
                    <select class="form-select @error('billing_cycle') is-invalid @enderror" id="billing_cycle" name="billing_cycle">
                        <option value="MONTHLY" {{ old('billing_cycle', $user->billing_cycle) === 'MONTHLY' ? 'selected' : '' }}>Mensual</option>
                        <option value="YEARLY" {{ old('billing_cycle', $user->billing_cycle) === 'YEARLY' ? 'selected' : '' }}>Anual</option>
                        <option value="ONE_TIME" {{ old('billing_cycle', $user->billing_cycle) === 'ONE_TIME' ? 'selected' : '' }}>Unica vez</option>
                    </select>
                    @error('billing_cycle')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row my-2">
                    <div class="col">
                        <label for="billing_day" class="my-2">Dia de Facturación </label>
                        <input type="number" class="form-control @error('billing_day') is-invalid @enderror" id="billing_day" name="billing_day" value="{{ old('billing_day', $user->billing_day) }}">
                        @error('billing_day')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="billing_month" class="my-2">Mes de Facturación </label>
                        <input type="number" class="form-control @error('billing_month') is-invalid @enderror" id="billing_month" name="billing_month" value="{{ old('billing_month', $user->billing_month) }}">
                        @error('billing_month')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="gross_amount" class="my-2">Monto Bruto </label>
                    <input type="number" class="form-control @error('gross_amount') is-invalid @enderror" id="gross_amount" name="gross_amount" value="{{ old('gross_amount', $user->gross_amount) }}">
                    @error('gross_amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="unique_payment" class="my-2">Pago Unico </label>
                    <input type="number" class="form-control @error('unique_payment') is-invalid @enderror" id="unique_payment" name="unique_payment" value="{{ old('unique_payment', $user->unique_payment) }}">
                    @error('unique_payment')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <div class="d-flex flex-column col-12 ">
                        <label for="logo" class="my-2">Imagen del Logo</label>
                        <span>*Solo se permite archivos de tipo: jpeg, png, svg, webp. Tamaño máximo: 2MB. </span>
                    </div>
                    @if($user->logo) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $user->logo }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="Profile Image">
                        </div>
                    @else
                        <div>
                            <label for="logo" class="my-2">No hay imagen de logo previamente cargada</label>
                        </div>
                    @endif
                    <div class="input-group">
                        <input type="file" class="btn  @error('logo') is-invalid @enderror" id="logo" name="logo">
                    </div>
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="website" class="my-2">Sitio Web </label>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $user->website) }}">
                    @error('website')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-start my-4">
                    <button type="submit" class="btn btn-indigo w-auto">Actualizar Usuario</button>
                </div>
            </div> 
        </form>
    @else
        <div class="row mt-3">
            <div class="row-5">
                <div class="alert alert-danger" role="alert">
                    "Hubo un error al intentar traer la información usuario"
                </div>
                <a href={{ route('users.index') }} class="btn btn-primary">Voler a la lista de Usuarios</a>
            </div>
        </div>
        @endif
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
    </script>
@endsection