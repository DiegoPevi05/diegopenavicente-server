@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-indigo">
                    Crear Proyecto
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('diegopenavicente.projects.index') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-projects-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            Volver a la lista de proyectos
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('diegopenavicente.projects.store') }}" class="row flex-column flex-md-row" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-12 col-md-6">
            <div class="form-group my-2">
                <label for="project" class="my-2">Titulo del Proyecto </label>
                <input type="text" class="form-control @error('project') is-invalid @enderror" id="project" name="project" value="{{ old('project') }}">
                @error('project')
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
                <label for="link" class="my-2">Link del Proyecto </label>
                <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}">
                @error('link')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="github" class="my-2">Link del Repositorio en Github </label>
                <input type="text" class="form-control @error('github') is-invalid @enderror" id="github" name="github" value="{{ old('github') }}">
                @error('github')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <label for="skills_ids" class="my-2">Skills
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-code" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 8l-4 4l4 4" /><path d="M17 8l4 4l-4 4" /><path d="M14 4l-4 16" /></svg>
                </label>
                <div class="row g-2">
                    <div class="col">
                        <input type="text" class="form-control" id="skill-input-title" name="skill-input-title" value="{{ old('skill-input-title') }}">
                    </div>
                    <div class="col-auto">
                      <button onclick="fetchSkills(event)" class="btn btn-icon" aria-label="Button">

                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <circle cx="10" cy="10" r="7" />
                          <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>
                      </button>
                    </div>
                </div>
                <ul id="skills-list-options" class="list-group mt-2"></ul>
                <div id="skills-container" class="my-2">
                <!-- JavaScript will populate this section -->
                </div>
                @error('skills')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group my-2">
                <div class="d-flex flex-column col-12 ">
                    <label for="logo" class="my-2">Imagen del Proyecto</label>
                    <span>*Solo se permite archivos de tipo: jpeg, png, webp. Tamaño máximo: 2MB. </span>
                </div>
                <div class="input-group">
                    <input type="file" class="btn  @error('logo') is-invalid @enderror" id="logo" name="logo">
                </div>
                @error('logo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-start my-4">
                <button type="submit" class="btn btn-indigo w-auto">Crear Proyecto</button>
            </div>  
        </div>
    </form>
    </div>
    @include('config.diegopenavicente.projects')
@endsection