@extends('layouts.app')

@section('content')
    <h1>SECCION HABILIDADES</h1>
    <h2>Crea un nueva Habilidad:</h2>
    <form method="POST" action="{{ route('skills.storeSkill') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Nombre de la skill</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
            @error('title')
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
            <label for="keywords"> Palabras clave (separados por comas)</label>
            <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords" name="keywords">
            @error('keywords')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Logo de la empresa</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" >
            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Crear</button>
        </div>
    </form>
    <h2>Habilidades:</h2>
    @foreach ($skills as $skill)
    <h3>Habilidad : {{ $skill->id }}</h3>

    <form method="POST" action="{{ route('skills.updateSkill', $skill->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Nombre de la skill</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('skill', $skill->title) }}">
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_es">Detalles en Español</label>
            <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es" name="description_es">{{ old('description_es', $skill->description_es) }}</textarea>
            @error('description_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Detalles en Ingles</label>
            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en">{{ old('description_en', $skill->description_en) }}</textarea>
            @error('description_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description_en">Detalles en Italiano</label>
            <textarea class="form-control @error('description_it') is-invalid @enderror" id="description_it" name="description_it">{{ old('description_it', $skill->description_it) }}</textarea>
            @error('description_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="keywords">Palabras clave (separados por comas)</label>
            <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords" name="keywords"
            value="{{ old('keywords', implode(',', json_decode($skill->keywords))) }}">
            @error('keywords')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Imagen de la habilidad</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" >
            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
        </div>
    </form>
    <form action="{{ route('skills.deleteSkill', $skill->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-danger w-auto">Borrar</button>
        </div>
    </form>
    @endforeach
@endsection
