@extends('layouts.app')

@section('content')
    <h1>Contenido de la pagina</h1>
    @foreach ($webContent as $item)
    <h3>Contenido Numero: {{ $item->id }}</h3>
    <form method="POST" action="{{ route('contentweb.updatecontent', $item->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="writeword">Nombre del Contenido</label>
            <input type="text" class="form-control @error('writeword') is-invalid @enderror" id="writeword" name="writeword" value="{{ $item->name }}">
            @error('writeword')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_es">Contenido en español</label>
            <textarea type="text" class="form-control @error('content_es') is-invalid @enderror" id="content_es" name="content_es">{{  $item->content_es }}</textarea>
            @error('content_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_en">Contenido en ingles</label>
            <textarea type="text" class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en">{{  $item->content_en }}</textarea>
            @error('content_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_it">Contenido en italiano</label>
            <textarea type="text" class="form-control @error('content_it') is-invalid @enderror" id="content_it" name="content_it">{{  $item->content_it }}</textarea>
            @error('content_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
        </div>
    </form>
    @endforeach
@endsection
