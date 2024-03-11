@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-indigo">
                    Crear Skill
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('skills.index') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-skills-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            Volver a la lista de Skills
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('skills.store') }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="title" class="my-2">Titulo del la Skill </label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="description_es" class="my-2">Descripcion en Español </label>
                <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es" rows="3">{{ old('description_es') }}</textarea>
                @error('description_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="description_en" class="my-2">Descripcion en Ingles </label>
                <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en') }}</textarea>
                @error('description_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="description_it" class="my-2">Descripcion en Italiano </label>
                <textarea class="form-control @error('description_it') is-invalid @enderror" id="description_it" name="description_it" rows="3">{{ old('description_it') }}</textarea>
                @error('description_it')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="keywords" class="my-2">Keywords</label>
                <p class="text-muted">*Agregue las keywords que desee</p>
                <input class="form-control" id="keywords_span" name="keywords_span" value="">
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-keyword">Agregar Keyword</button>
                    <button type="button" class="btn btn-danger" id="remove-keyword" disabled>Remover Keyword</button>
                </div>
                @error('keywords')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="keywords-container" class="my-2 d-flex flex-row flex-wrap">
                <!-- JavaScript will populate this section -->
            </div>

            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image" class="my-2">Imagen de Skill</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image') is-invalid @enderror" id="image" name="image">
                </div>
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-start my-4">
                <button type="submit" class="btn btn-indigo w-auto">Crear Skill</button>
            </div>  
        </div>
    </form>
    </div>
    @include('config.diegopenavicente.skills')
@endsection