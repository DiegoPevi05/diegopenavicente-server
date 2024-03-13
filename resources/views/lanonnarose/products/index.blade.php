@extends('layouts.app')
@section('content')
    <div class="container-fluid main-container">
    @extends('config.log')
    <!--header-->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle text-indigo">
                    Panel de Contenido Web
                </div>
                <h2 class="page-title text-indigo">
                    Contenido Web
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <form action="{{ route('lanonnarose.products.create') }}" method="POST">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-indigo d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Crear nuevo Contenido Web
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form class="d-flex flex-row form-inline py-2 col-5 gap-2 mb-4" action="{{ route('lanonnarose.products.index') }}" method="GET">
        <input class="form-control mr-sm-2" type="search" name="name" placeholder="Buscar por nombre" aria-label="Search">
        <button class="btn btn-indigo my-2 my-sm-0 col-3" type="submit">Buscar</button>
    </form>
    <!--table uers-->
    <div class="table-responsive">
        <table class="table table-vcenter">
            <thead>
            <tr>
                <th class="no-sort">#</th>
                <th>Nombre</th>
                <th>Titulo ES </th>
                <th>Section Es </th>
                <th>Pequeña Descripción ES</th>
                <th>Descripción ES</th>
                <th>Imagen</th>
                <th>Es importante? </th>
                <th class="no-sort">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    @if($product->title_es)
                        @if(strlen($product->title_es) > 10)
                            <td>{{ substr($product->title_es, 0, 10) }}...</td>
                        @else
                            <td>{{ $product->title_es }}</td>
                        @endif
                    @else
                        <td></td>
                    @endif
                    @if($product->section_es)
                        @if(strlen($product->section_es) > 10)
                            <td>{{ substr($product->section_es, 0, 10) }}...</td>
                        @else
                            <td>{{ $product->section_es }}</td>
                        @endif
                    @else
                        <td></td>
                    @endif
                    @if($product->shortDescription_es)
                        @if(strlen($product->shortDescription_es) > 10)
                            <td>{{ substr($product->shortDescription_es, 0, 10) }}...</td>
                        @else
                            <td>{{ $product->shortDescription_es }}</td>
                        @endif
                    @else
                        <td></td>
                    @endif
                    @if($product->description_es)
                        @if(strlen($product->description_es) > 10)
                            <td>{{ substr($product->description_es, 0, 10) }}...</td>
                        @else
                            <td>{{ $product->description_es }}</td>
                        @endif
                    @else
                        <td></td>
                    @endif
                    <td>
                        @if($product->imageUrl)
                            <a href="{{env('BACKEND_URL_IMAGE')}}{{ $product->imageUrl }}" target="_blank" class="btn btn-indigo btn-md btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
                            </a>
                        @else
                            <span class="badge bg-red">No Imagen</span>
                        @endif
                    </td>
                    <td>
                        @if($product->isImportant)
                            <span class="badge bg-indigo">Si</span>
                        @else
                            <span class="badge bg-red">No</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm gap-2" role="group">
                            <form action="{{ route('lanonnarose.products.edit', $product) }}" method="POST">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-indigo btn-md btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                       <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                       <path d="M16 5l3 3"></path>
                                    </svg>
                                </button>
                            </form>
                            <form action="#" method="POST">
                                <a href="#" data-delete-product="{{ route('lanonnarose.products.destroy', $product) }}" data-bs-toggle="modal" data-bs-target="#modal-delete-product" class="btn btn-red btn-md btn-icon h-6 w-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7l16 0"></path>
                                        <path d="M10 11l0 6"></path>
                                        <path d="M14 11l0 6"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination gap-2">
                <li class="btn btn-indigo btn-sm rounded"><a class="text-white no-underline px-2" href="{{ route('lanonnarose.products.index', ['page' => ($products->currentPage()-1)]) }}">Anterior</a></li>
                @for ($i = 1; $i <= $products->lastPage(); $i++)
                    <li class="btn btn-indigo btn-sm bg-indigo {{ ($i == $products->currentPage()) ? ' active' : '' }}"><a class="page-link bg-indigo" href="{{ route('lanonnarose.products.index', ['page' => $i]) }}">{{ $i }}</a></li>
                @endfor
                <li class="btn btn-indigo btn-sm rounded"><a class="text-white no-underline px-2" href="{{ route('lanonnarose.products.index', ['page' => ($products->currentPage()+1)]) }}">Siguiente</a></li>
            </ul>
        </nav>
    </div>
    <div class="modal modal-blur fade" id="modal-delete-product" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <!-- Download SVG icon from https://tabler-icons.io/i/alert-triangle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg>
            <h3>Estas Seguro de Eliminar el Producto?</h3>
            <div class="text-muted">Estas seguro de eliminar el Producto toda su informacion sera removida</div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col">
                  <a href="#" class="btn btn-white w-100" data-bs-dismiss="modal">
                    Cancelar
                  </a>
                </div>
                <div class="col">
                  <form method="POST" id="form-delete-product">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                      Borrar Producto
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>

    <script>
    $('a[data-delete-product]').on('click', function () {
        $("#form-delete-product").attr('action', $(this).data('delete-product'));
    })
  </script>

@endsection