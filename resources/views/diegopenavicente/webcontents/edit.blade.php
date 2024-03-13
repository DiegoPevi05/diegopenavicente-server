@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    @if ($webcontent)
        @extends('config.log')
        <!--header-->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title text-indigo">
                        Editar Libro
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <form action="{{ route('diegopenavicente.webcontents.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-indigo d-none d-sm-inline-block " data-bs-toggle="modal" data-bs-target="#modal-report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-webcontents-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                </svg>
                                Volver a la lista de Libros 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('diegopenavicente.webcontents.update', ['webcontentsdp' => $webcontent->id]) }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="name" class="my-2">Titulo del la Skill </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $webcontent->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="content_es" class="my-2">Descripcion en Español </label>
                    <textarea class="form-control @error('content_es') is-invalid @enderror" id="content_es" name="content_es" rows="3">{{ old('content_es',$webcontent->content_es) }}</textarea>
                    @error('content_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="content_en" class="my-2">Descripcion en Ingles </label>
                    <textarea class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en" rows="3">{{ old('content_en',$webcontent->content_en) }}</textarea>
                    @error('content_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="content_it" class="my-2">Descripcion en Italiano </label>
                    <textarea class="form-control @error('content_it') is-invalid @enderror" id="content_it" name="content_it" rows="3">{{ old('content_it',$webcontent->content_it) }}</textarea>
                    @error('content_it')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-start my-4">
                    <button type="submit" class="btn btn-indigo w-auto">Editar Contenido Web</button>
                </div>
            </div>
        </form>
        </div>
    @else
        <div class="row mt-3">
            <div class="row-5">
                <div class="alert alert-danger" role="alert">
                    "Hubo un error al intentar traer la información del contenido web, por favor intente de nuevo."
                </div>
                <a href={{ route('diegopenavicente.webcontents.index') }} class="btn btn-primary">Voler a la lista de Contenido Web</a>
            </div>
        </div>
    @endif
@endsection