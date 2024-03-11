@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-indigo">
                    Crear Experiencia
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('experiences.index') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-experiences-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            Volver a la lista de Experiencias
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('experiences.store') }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-12 col-md-6">
            <div class="form-group my-2 ">
                <label for="is_active">El especialista esta activo?</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Si</label>
                </div>
                @error('is_active')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="job_es" class="my-2">Puesto de trabajo en Español</label>
                <input type="text" class="form-control @error('job_es') is-invalid @enderror" id="job_es" name="job_es" value="{{ old('job_es') }}">
                @error('job_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="job_en" class="my-2">Puesto de trabajo en Inglés</label>
                <input type="text" class="form-control @error('job_en') is-invalid @enderror" id="job_en" name="job_en" value="{{ old('job_en') }}">
                @error('job_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="job_it" class="my-2">Puesto de trabajo en Italiano</label>
                <input type="text" class="form-control @error('job_it') is-invalid @enderror" id="job_it" name="job_it" value="{{ old('job_it') }}">
                @error('job_it')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="company" class="my-2">Empresa</label>
                <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company') }}">
                @error('company')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="startDate" class="my-2">Fecha de Inicio</label>
                <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate" value="{{ old('startDate') }}">
                @error('startDate')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="endDate" class="my-2">Fecha de Fin</label>
                <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate" value="{{ old('endDate') }}">
                @error('endDate')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="details_es" class="my-2">Detalles en Español</label>
                <p class="text-muted">*Agregue detalles de la experiencia en español</p>
                <textarea class="form-control" id="details_es_span" name="details_es_span" rows="3"></textarea>
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-detail-es">Agregar Detalle</button>
                    <button type="button" class="btn btn-danger" id="remove-detail-es" disabled>Remover Detalle</button>
                </div>
                @error('details_es')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="details-es-container" class="my-2">
                <!-- JavaScript will populate this section -->
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="details_en" class="my-2">Detalles en Inglés</label>
                <p class="text-muted">*Agregue detalles de la experiencia en inglés</p>
                <textarea class="form-control" id="details_en_span" name="details_en_span" rows="3">{{ old('details_en') }}</textarea>
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-detail-en">Agregar Detalle</button>
                    <button type="button" class="btn btn-danger" id="remove-detail-en" disabled>Remover Detalle</button>
                </div>
                @error('details_en')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="details-en-container" class="my-2">
                <!-- JavaScript will populate this section -->
            </div>
            <div class="form-group my-2">
                <label for="details_it" class="my-2">Detalles en Italiano</label>
                <p class="text-muted">*Agregue detalles de la experiencia en italiano</p>
                <textarea class="form-control" id="details_it_span" name="details_it_span" rows="3">{{ old('details_it') }}</textarea>
                <div class="flex flex-row my-2">
                    <button type="button" class="btn btn-indigo" id="add-detail-it">Agregar Detalle</button>
                    <button type="button" class="btn btn-danger" id="remove-detail-it" disabled>Remover Detalle</button>
                </div>
                @error('details_it')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div id="details-it-container" class="my-2">
                <!-- JavaScript will populate this section -->
            </div>
            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="image1" class="my-2">Imagen de Experiencia 1</label>
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
                    <label for="image2" class="my-2">Imagen de Experiencia 2</label>
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
                    <label for="image3" class="my-2">Imagen de Experiencia 3</label>
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
                    <label for="image4" class="my-2">Imagen de Experiencia 4</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('image4') is-invalid @enderror" id="image4" name="image4">
                </div>
                @error('image4')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-start my-4">
                <button type="submit" class="btn btn-indigo w-auto">Crear Experiencia</button>
            </div>  
        </div>
    </form>
    </div>
    @include('config.diegopenavicente.details')
@endsection