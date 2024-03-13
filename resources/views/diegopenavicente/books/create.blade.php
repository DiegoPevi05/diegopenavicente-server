@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-indigo">
                    Crear Libro
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('diegopenavicente.books.index') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-books-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            Volver a la lista de libros
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('diegopenavicente.books.store') }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="title" class="my-2">Titulo del libro </label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="author" class="my-2">Autor del Libro </label>
                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author') }}">
                @error('author')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="content_es" class="my-2">Contenido en Español </label>
                <textarea class="form-control @error('content_es') is-invalid @enderror" id="content_es" name="content_es" rows="3">{{ old('content_es') }}</textarea>
                @error('content_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="content_en" class="my-2">Contenido en Ingles </label>
                <textarea class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en" rows="3">{{ old('content_en') }}</textarea>
                @error('content_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="content_it" class="my-2">Contenido en Italiano </label>
                <textarea class="form-control @error('content_it') is-invalid @enderror" id="content_it" name="content_it" rows="3">{{ old('content_it') }}</textarea>
                @error('content_it')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="href" class="my-2">Enlace </label>
                <input type="text" class="form-control @error('href') is-invalid @enderror" id="href" name="href" value="{{ old('href') }}">
                @error('href')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="img" class="my-2">Imagen de Perfil</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('img') is-invalid @enderror" id="img" name="img">
                </div>
                @error('img')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="type">Tipo</label>
                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                    <option value="Cultural" selected>Cultural</option>
                    <option value="CODE" selected>Codigo</option>
                </select>
                @error('type')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-start my-4">
                <button type="submit" class="btn btn-indigo w-auto">Crear Libro</button>
            </div>  
        </div>
    </form>
    </div>
@endsection