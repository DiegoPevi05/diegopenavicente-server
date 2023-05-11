@extends('layouts.app')

@section('content')
    <h1>SECCION PROYECTOS</h1>
    <h2>Crea un nueva Proyecto:</h2>
    <form method="POST" action="{{ route('projects.storeProject') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="project">Nombre del Proyecto</label>
            <input type="text" class="form-control @error('project') is-invalid @enderror" id="project" name="project">
            @error('project')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_es">Descripcion en Español</label>
            <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es"></textarea>
            @error('description_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Descripcion en Ingles</label>
            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en"></textarea>
            @error('description_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Descripcion en Italiano</label>
            <textarea class="form-control @error('description_it') is-invalid @enderror" id="description_it" name="description_it"></textarea>
            @error('description_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="link">Enlace del Proyecto</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link">
            @error('link')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="languages">lenguajes (separados por comas)</label>
            <input type="text" class="form-control @error('languages') is-invalid @enderror" id="languages" name="languages">
            @error('languages')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="logo">Logo de la empresa</label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" >
            @error('logo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Crear</button>
        </div>
    </form>
    <h2>Proyectos:</h2>
    @foreach ($projects as $project)
    <h3>Proyecto : {{ $project->id }}</h3>

    <form method="POST" action="{{ route('projects.updateProject', $project->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="project">Nombre del Proyecto</label>
            <input type="text" class="form-control @error('project') is-invalid @enderror" id="project" name="project" value="{{ old('project', $project->project) }}">
            @error('project')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_es">Detalles en Español</label>
            <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es">{{ old('description_es', $project->description_es) }}</textarea>
            @error('description_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Detalles en Ingles</label>
            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en">{{ old('description_en', $project->description_en) }}</textarea>
            @error('description_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Detalles en Italiano</label>
            <textarea class="form-control @error('description_it') is-invalid @enderror" id="description_it" name="description_it">{{ old('description_it', $project->description_it) }}</textarea>
            @error('description_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="link">Enlace del Proyecto</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $project->link) }}">
            @error('link')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="languages">lenguajes (separados por comas)</label>
            <input type="text" class="form-control @error('languages') is-invalid @enderror" id="languages" name="languages"
            value="{{ old('languages', implode(',', json_decode($project->languages))) }}">
            @error('languages')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="logo">Logo de la empresa</label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" >
            @error('logo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
        </div>
    </form>
    <form action="{{ route('projects.deleteProject', $project->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-danger w-auto">Borrar</button>
        </div>
    </form>
    @endforeach
@endsection
