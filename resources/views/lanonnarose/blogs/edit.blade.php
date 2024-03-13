@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    @if ($blog)
        @extends('config.log')
        <!--header-->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title text-indigo">
                        Editar Blog
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <form action="{{ route('lanonnarose.blogs.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-indigo d-none d-sm-inline-block " data-bs-toggle="modal" data-bs-target="#modal-report">
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
        <form method="POST" action="{{ route('lanonnarose.blogs.update',$blog) }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-12 col-md-6">
                <div class="form-group my-2">
                    <label for="title_es" class="my-2">Título en Español</label>
                    <input type="text" class="form-control @error('title_es') is-invalid @enderror" id="title_es" name="title_es" value="{{ old('title_es',$blog->title_es) }}">
                    @error('title_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="title_en" class="my-2">Título en Inglés</label>
                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" id="title_en" name="title_en" value="{{ old('title_en',$blog->title_en) }}">
                    @error('title_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="subTitle_es" class="my-2">Subtítulo en Español</label>
                    <input type="text" class="form-control @error('subTitle_es') is-invalid @enderror" id="subTitle_es" name="subTitle_es" value="{{ old('subTitle_es',$blog->subTitle_es) }}">
                    @error('subTitle_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="subTitle_en" class="my-2">Subtítulo en Inglés</label>
                    <input type="text" class="form-control @error('subTitle_en') is-invalid @enderror" id="subTitle_en" name="subTitle_en" value="{{ old('subTitle_en',$blog->subTitle_en) }}">
                    @error('subTitle_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="description_es" class="my-2">Descripción en Español</label>
                    <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es" rows="3">{{ old('description_es',$blog->description_es) }}</textarea>
                    @error('description_es')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2">
                    <label for="description_en" class="my-2">Descripción en Inglés</label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="3">{{ old('description_en',$blog->description_en) }}</textarea>
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
                    @if($blog->image1) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $blog->image1 }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="image1">
                        </div>
                    @else
                        <div>
                            <label for="img" class="my-2">No hay imagen de experiencia previamente cargada</label>
                        </div>
                    @endif
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
                    @if($blog->image2) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $blog->image2 }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="image2">
                        </div>
                    @else
                        <div>
                            <label for="img" class="my-2">No hay imagen de experiencia previamente cargada</label>
                        </div>
                    @endif
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
                    @if($blog->image3) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $blog->image3 }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="image3">
                        </div>
                    @else
                        <div>
                            <label for="img" class="my-2">No hay imagen de experiencia previamente cargada</label>
                        </div>
                    @endif
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
                    @if($blog->image4) 
                        <div class="m-2">
                            <img src="{{env('BACKEND_URL_IMAGE')}}{{ $blog->image4 }}" class="rounded flex-start border border-5 border-indigo" style="height: 200px;" alt="image4">
                        </div>
                    @else
                        <div>
                            <label for="img" class="my-2">No hay imagen de experiencia previamente cargada</label>
                        </div>
                    @endif
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
                    <button type="submit" class="btn btn-indigo w-auto">Actualizar Blog</button>
                </div>  
            </div>
        </form>
        </div>
    @else
        <div class="row mt-3">
            <div class="row-5">
                <div class="alert alert-danger" role="alert">
                    "Hubo un error al intentar traer la información del blog"
                </div>
                <a href={{ route('lanonnarose.blogs.index') }} class="btn btn-primary">Voler a la lista de Blogs</a>
            </div>
        </div>
    @endif
    @include('config.lanonnarose.blogs')
@endsection