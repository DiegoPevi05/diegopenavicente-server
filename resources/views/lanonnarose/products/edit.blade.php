@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    @if ($product)
        @extends('config.log')
        <!--header-->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title text-indigo">
                        Editar Producto
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <form action="{{ route('lanonnarose.products.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-indigo d-none d-sm-inline-block " data-bs-toggle="modal" data-bs-target="#modal-report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-products-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                </svg>
                                Volver a la lista de Productos
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('lanonnarose.products.update',$product) }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="name" class="my-2">Nombre del Producto</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$product->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="title_es" class="my-2">Título en Español</label>
                    <input type="text" class="form-control @error('title_es') is-invalid @enderror" id="title_es" name="title_es" value="{{ old('title_es',$product->title_es) }}">
                    @error('title_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="title_en" class="my-2">Título en Inglés</label>
                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" id="title_en" name="title_en" value="{{ old('title_en',$product->title_en) }}">
                    @error('title_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="section_es" class="my-2">Sección en Español</label>
                    <input type="text" class="form-control @error('section_es') is-invalid @enderror" id="section_es" name="section_es" value="{{ old('section_es',$product->section_es) }}">
                    @error('section_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="section_en" class="my-2">Sección en Inglés</label>
                    <input type="text" class="form-control @error('section_en') is-invalid @enderror" id="section_en" name="section_en" value="{{ old('section_en',$product->section_en) }}">
                    @error('section_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="shortDescription_es" class="my-2">Descripción Corta en Español</label>
                    <input type="text" class="form-control @error('shortDescription_es') is-invalid @enderror" id="shortDescription_es" name="shortDescription_es" value="{{ old('shortDescription_es',$product->shortDescription_es) }}">
                    @error('shortDescription_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="shortDescription_en" class="my-2">Descripción Corta en Inglés</label>
                    <input type="text" class="form-control @error('shortDescription_en') is-invalid @enderror" id="shortDescription_en" name="shortDescription_en" value="{{ old('shortDescription_en',$product->shortDescription_en) }}">
                    @error('shortDescription_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="description_es" class="my-2">Descripción en Español</label>
                    <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es" rows="3">{{ old('description_es',$product->description_es) }}</textarea>
                    @error('description_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="description_en" class="my-2">Descripción en Inglés</label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en',$product->description_en) }}</textarea>
                    @error('description_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <div class="d-flex flex-column col-12 ">
                        <label for="imageUrl" class="my-2">Imagen del product 1</label>
                        <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                    </div>
                    @if($product->imageUrl) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $product->imageUrl }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="imageUrl">
                        </div>
                    @else
                        <div>
                            <label for="img" class="my-2">No hay imagen de experiencia previamente cargada</label>
                        </div>
                    @endif
                    <div class="input-group">
                        <input type="file" class="btn  @error('imageUrl') is-invalid @enderror" id="imageUrl" name="imageUrl">
                    </div>
                    @error('imageUrl')
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
                    <button type="submit" class="btn btn-indigo w-auto">Actualizar Producto</button>
                </div>  
            </div>
        </form>
        </div>
    @else
        <div class="row mt-3">
            <div class="row-5">
                <div class="alert alert-danger" role="alert">
                    "Hubo un error al intentar traer la información del Producto"
                </div>
                <a href={{ route('lanonnarose.products.index') }} class="btn btn-primary">Voler a la lista de productos</a>
            </div>
        </div>
    @endif
@endsection