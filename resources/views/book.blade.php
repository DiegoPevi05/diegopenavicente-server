@extends('layouts.app')

@section('content')
    <h1>SECCION LIBROS</h1>
    <h2>Crea un nuevo libro:</h2>
    <form method="POST" action="{{ route('books.storeBook') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Nombre del libro</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="type">Tipo de libro</label>
            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                <option value="code">Code</option>
                <option value="cultural">Cultural</option>
            </select>
            @error('type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="author">Autor del libro</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author">
            @error('author')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_es">Descripcion en Español</label>
            <textarea class="form-control @error('content_es') is-invalid @enderror" id="content_es" name="content_es"></textarea>
            @error('content_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_en">Descripcion en Ingles</label>
            <textarea class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en"></textarea>
            @error('content_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_en">Descripcion en Italiano</label>
            <textarea class="form-control @error('content_it') is-invalid @enderror" id="content_it" name="content_it"></textarea>
            @error('content_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="href">Enlace del libro</label>
            <input type="text" class="form-control @error('href') is-invalid @enderror" id="href" name="href">
            @error('href')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="img">Imagen del libro</label>
            <input type="file" class="form-control @error('img') is-invalid @enderror" id="img" name="img" >
            @error('img')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Crear</button>
        </div>
    </form>
    <h2>Habilidades:</h2>
    @foreach ($books as $book)
    <h3>Habilidad : {{ $book->id }}</h3>

    <form method="POST" action="{{ route('books.updateBook', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Nombre de la book</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('book', $book->title) }}">
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="type">Secciòn de Producto</label>
            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                <option value="code" {{$book->type == "code" ? 'selected' : ''}}>Code</option>
                <option value="cultural" {{$book->type == "cultural" ? 'selected' : ''}}>Cultural</option>
            </select>
            @error('type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="author">Nombre de la book</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('book', $book->author) }}">
            @error('author')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_es">Detalles en Español</label>
            <textarea class="form-control @error('content_es') is-invalid @enderror" id="content_es" name="content_es">{{ old('content_es', $book->content_es) }}</textarea>
            @error('content_es')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_en">Detalles en Ingles</label>
            <textarea class="form-control @error('content_en') is-invalid @enderror" id="content_en" name="content_en">{{ old('content_en', $book->content_en) }}</textarea>
            @error('content_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="content_en">Detalles en Italiano</label>
            <textarea class="form-control @error('content_it') is-invalid @enderror" id="content_it" name="content_it">{{ old('content_it', $book->content_it) }}</textarea>
            @error('content_it')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="href">Enlace del libro</label>
            <input type="text" class="form-control @error('href') is-invalid @enderror" id="href" name="href" value="{{ old('href', $book->href) }}">
            @error('href')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="img">Imagen del libro</label>
            <input type="file" class="form-control @error('img') is-invalid @enderror" id="img" name="img" >
            @error('img')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-primary w-auto">Actualizar</button>
        </div>
    </form>
    <form action="{{ route('books.deleteBook', $book->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-center my-4">
          <button type="submit" class="btn btn-danger w-auto">Borrar</button>
        </div>
    </form>
    @endforeach
@endsection
