<div class="page">
  <div class="navbar navbar-vertical navbar-expand border border-start-1 border-indigo bg-white" style="width:260px">
      <div class="container-fluid">
          <button class="navbar-toggler" type="button">
              <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark">
              @if (Auth::user())
                <a href="{{ Auth::user()->website }}" target="_blank">
                    <img src="{{env('BACKEND_URL_IMAGE') . Auth::user()->logo }}" style="width: 50px; height: 50px;" alt="Tabler" class="navbar-brand-image">
                </a>
              @endif
          </h1>
          <div class="collapse navbar-collapse" id="sidebar-menu">
              <ul class="navbar-nav pt-lg-3">
                  <li class="nav-item button-sidebar">
                      <a class="nav-link" href={{ route('home.index') }}>
                        <span class="nav-link-title">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                             <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                             <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                             <path d="M10 12h4v4h-4z"></path>
                          </svg>
                          Inicio
                        </span>
                      </a>
                  </li>
                  @if (Auth::user() && Auth::user()->role == 'ADMIN')
                  <li class="nav-item button-sidebar {{ request()->routeIs('users.*') ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="nav-link-title">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                         <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                         <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                         <path d="M15 19l2 2l4 -4"></path>
                      </svg>
                      Clientes
                    </span>
                      </a>
                  </li>
                  @endif

                  @if(Auth::user() && Auth::user()->ExistControllerPackage())
                    @foreach(Auth::user()->getControllerClassesInPackageFolder() as $controller)
                        <li class="nav-item button-sidebar {{ request()->routeIs($controller['routeName'].'.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route($controller['routeName'].'.index') }}">
                                <span class="nav-link-title">
                                    {!! $controller['icon'] !!}
                                    {{ $controller['label'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                  @endif

                  @if (Auth::user() && (Auth::user()->role == 'CLIENT'))
                    <li class="nav-item button-sidebar">
                      <a class="nav-link " href="{{ route('user-profile.show', Auth::user()) }}">
                      <span class="nav-link-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                           <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                           <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                           <path d="M15 19l2 2l4 -4"></path>
                        </svg>
                        Mi perfil 
                      </span>
                        </a>
                    </li>
                  @endif
                  @if (Auth::user())
                  <li class="nav-item mt-auto">
                      <a class="nav-link mt-auto text-indigo" href="{{ route('home.index') }}">
                          <img src="{{env('BACKEND_URL_IMAGE') . Auth::user()->logo }}" alt="" width="32" height="32" class="me-2">
                          <strong>{{ Auth::user()->name }}</strong>
                      </a>
                  </li>
                  @endif

                  <li class="w-full mb-2 items-center">
                      <a class="btn btn-indigo w-full" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                        <span class="nav-link-title">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                             <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                             <path d="M9 12h12l-3 -3"></path>
                             <path d="M18 15l3 -3"></path>
                          </svg>
                          Salir
                        </span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
              </ul>
          </div>
      </div>
  </div>
</div>