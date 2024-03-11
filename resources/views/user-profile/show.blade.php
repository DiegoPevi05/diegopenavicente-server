@extends('layouts.app')
@section('content')
    <!--header-->
    <div class="container-fluid main-container">
    @if ($user_profile)
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title text-indigo">
                        Editar Usuario:  "{{ $user_profile->name }}"
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <form action="{{ route('user-profile.edit', $user_profile ) }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                       <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                       <path d="M16 5l3 3"></path>
                                    </svg>
                                Actualizar Informacion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group my-2">
                <label for="name" class="my-2">Nombre del Usuario </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user_profile->name) }}" readonly>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="email" class="my-2">Correo del Usuario </label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user_profile->email) }}" readonly>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="password" class="my-2">Contraseña </label>
                <span>* Si deseas actualizar tu contraseña necesitas dirigete a la seccion de actualizar informacion.</span>
            </div>
        </div>
    @else
        <div class="row mt-3">
            <div class="row-5">
                <div class="alert alert-danger" role="alert">
                    "Hubo un error al intentar traer la información usuario"
                </div>
                <a href={{ route('home.index') }} class="btn btn-primary">Voler al inicio</a>
            </div>
        </div>
    @endif
    </div>
@endsection