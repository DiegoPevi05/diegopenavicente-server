@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-name text-indigo">
                    Crear Blog
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('lanonnarose.blogs.index') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-blogs-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            Volver a la lista de Blogs
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('lanonnarose.blogs.store') }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="title_es" class="my-2">Título en Español</label>
                <input type="text" class="form-control @error('title_es') is-invalid @enderror" id="title_es" name="title_es" value="{{ old('title_es') }}">
                @error('title_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="title_en" class="my-2">Título en Inglés</label>
                <input type="text" class="form-control @error('title_en') is-invalid @enderror" id="title_en" name="title_en" value="{{ old('title_en') }}">
                @error('title_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="subTitle_es" class="my-2">Subtítulo en Español</label>
                <input type="text" class="form-control @error('subTitle_es') is-invalid @enderror" id="subTitle_es" name="subTitle_es" value="{{ old('subTitle_es') }}">
                @error('subTitle_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="subTitle_en" class="my-2">Subtítulo en Inglés</label>
                <input type="text" class="form-control @error('subTitle_en') is-invalid @enderror" id="subTitle_en" name="subTitle_en" value="{{ old('subTitle_en') }}">
                @error('subTitle_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="description_es" class="my-2">Descripción en Español</label>
                <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es" rows="3">{{ old('description_es') }}</textarea>
                @error('description_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="description_en" class="my-2">Descripción en Inglés</label>
                <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en') }}</textarea>
                @error('description_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="bulletpoints_es" class="my-2">bulletpoints_es</label>
                <p class="text-muted">*Agregue las bulletpoints_es que desee</p>
                <input class="form-control" id="bulletpoints_es_span" name="bulletpoints_es_span" value="">
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-bulletpoint_es">Agregar bulletpoint_es</button>
                    <button type="button" class="btn btn-danger" id="remove-bulletpoint_es" disabled>Remover Bullet Point en Español</button>
                </div>
                @error('bulletpoints_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="bulletpoints_es-container" class="my-2 d-flex flex-row flex-wrap">
                <!-- JavaScript will populate this section -->
            </div>
            <div class="form-group my-2">
                <label for="bulletpoints_en" class="my-2">bulletpoints_en</label>
                <p class="text-muted">*Agregue las bulletpoints_en que desee</p>
                <input class="form-control" id="bulletpoints_en_span" name="bulletpoints_en_span" value="">
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-bulletpoint_en">Agregar bulletpoint_en</button>
                    <button type="button" class="btn btn-danger" id="remove-bulletpoint_en" disabled>Remover Bullet Point en Inglés</button>
                </div>
                @error('bulletpoints_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="bulletpoints_en-container" class="my-2 d-flex flex-row flex-wrap">
                <!-- JavaScript will populate this section -->
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image1" class="my-2">Imagen del Blog 1</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image1') is-invalid @enderror" id="image1" name="image1">
                </div>
                @error('image1')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image2" class="my-2">Imagen del Blog 2</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image2') is-invalid @enderror" id="image2" name="image2">
                </div>
                @error('image2')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image3" class="my-2">Imagen del Blog 3</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image3') is-invalid @enderror" id="image3" name="image3">
                </div>
                @error('image3')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image4" class="my-2">Imagen del Blog 4</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image4') is-invalid @enderror" id="image4" name="image4">
                </div>
                @error('image4')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2 ">
                <label for="isImportant">Es importante?</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input @error('isImportant') is-invalid @enderror" id="isImportant" name="isImportant" {{ old('isImportant') ? 'checked' : '' }}>
                    <label class="form-check-label" for="isImportant">Si</label>
                </div>
                @error('isImportant')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-start my-4">
                <button type="submit" class="btn btn-indigo w-auto">Crear Blog</button>
            </div>  
        </div>
    </form>
    </div>
    @include('config.lanonnarose.blogs')
@endsection