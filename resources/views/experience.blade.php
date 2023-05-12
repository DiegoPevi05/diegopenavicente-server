@extends('layouts.app')

@section('content')
    <h1>SECCION EXPERIENCIA</h1>
    <h2>Crea un nueva experiencia:</h2>
    <form method="POST" action="{{ route('experiences.storeExperience') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="job_es">Trabajo en español</label>
            <input type="text" class="form-control @error('job_es') is-invalid @enderror" id="job_es" name="job_es">
            @error('job_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="job_en">Trabajo en Ingles</label>
            <input type="text" class="form-control @error('job_en') is-invalid @enderror" id="job_en" name="job_en">
            @error('job_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="job_it">Trabajo en Italiano</label>
            <input type="text" class="form-control @error('job_it') is-invalid @enderror" id="job_it" name="job_it">
            @error('job_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="company">Compañia</label>
            <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company">
            @error('company')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_es">Detalles en Español</label>
            <textarea class="form-control @error('details_es') is-invalid @enderror" id="details_es" name="details_es"></textarea>
            @error('details_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_en">Detalles en Ingles</label>
            <textarea class="form-control @error('details_en') is-invalid @enderror" id="details_en" name="details_en"></textarea>
            @error('details_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_en">Detalles en Italiano</label>
            <textarea class="form-control @error('details_it') is-invalid @enderror" id="details_it" name="details_it"></textarea>
            @error('details_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="startDate">Fecha de Comienzo</label>
            <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate">
            @error('startDate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="endDate">Fecha de Fin</label>
            <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate">
            @error('endDate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image1">Imagen de la experiencia Numero 1</label>
            <input type="file" class="form-control @error('image1') is-invalid @enderror" id="image1" name="image1" >
            @error('image1')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image2">Imagen de la experiencia Numero 2</label>
            <input type="file" class="form-control @error('image2') is-invalid @enderror" id="image2" name="image2" >
            @error('image2')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image3">Imagen de la experiencia Numero 3</label>
            <input type="file" class="form-control @error('image3') is-invalid @enderror" id="image3" name="image3" >
            @error('image3')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image4">Imagen de la experiencia Numero 4</label>
            <input type="file" class="form-control @error('image4') is-invalid @enderror" id="image4" name="image4" >
            @error('image4')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Crear</button>
        </div>
    </form>
    <h2>Experiencias:</h2>
    @foreach ($experiences as $experience)
    <h3>Experiencia : {{ $experience->id }}</h3>

    <form method="POST" action="{{ route('experiences.updateExperience', $experience->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="job_es">Trabajo en español</label>
            <input type="text" class="form-control @error('job_es') is-invalid @enderror" id="job_es" name="job_es" value="{{ old('job_es', $experience->job_es) }}">
            @error('job_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="job_en">Trabajo en Ingles</label>
            <input type="text" class="form-control @error('job_en') is-invalid @enderror" id="job_en" name="job_en" value="{{ old('job_en', $experience->job_en) }}">
            @error('job_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="job_it">Trabajo en Italiano</label>
            <input type="text" class="form-control @error('job_it') is-invalid @enderror" id="job_it" name="job_it" value="{{ old('job_it', $experience->job_it) }}">
            @error('job_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="company">Compañia</label>
            <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company', $experience->company) }}">
            @error('company')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_es">Detalles en Español</label>
            <textarea class="form-control @error('details_es') is-invalid @enderror" id="details_es" name="details_es">{{ old('details_es', implode(',', json_decode($experience->details_es))) }}</textarea>
            @error('details_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_en">Detalles en Ingles</label>
            <textarea class="form-control @error('details_en') is-invalid @enderror" id="details_en" name="details_en">{{ old('details_en', implode(',', json_decode($experience->details_en))) }}</textarea>
            @error('details_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_en">Detalles en Italiano</label>
            <textarea class="form-control @error('details_it') is-invalid @enderror" id="details_it" name="details_it">{{ old('details_it', implode(',', json_decode($experience->details_it))) }}</textarea>
            @error('details_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="startDate">Fecha de Comienzo</label>
            <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate">
            @error('startDate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="endDate">Fecha de Fin</label>
            <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate">
            @error('endDate')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image1">Imagen de la experiencia Numero 1</label>
            <input type="file" class="form-control @error('image1') is-invalid @enderror" id="image1" name="image1" >
            @error('image1')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image2">Imagen de la experiencia Numero 2</label>
            <input type="file" class="form-control @error('image2') is-invalid @enderror" id="image2" name="image2" >
            @error('image2')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image3">Imagen de la experiencia Numero 3</label>
            <input type="file" class="form-control @error('image3') is-invalid @enderror" id="image3" name="image3" >
            @error('image3')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image4">Imagen de la experiencia Numero 4</label>
            <input type="file" class="form-control @error('image4') is-invalid @enderror" id="image4" name="image4" >
            @error('image4')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
        </div>
    </form>
    <form action="{{ route('experiences.deleteExperience', $experience->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-danger w-auto">Borrar</button>
        </div>
    </form>
    @endforeach
@endsection
