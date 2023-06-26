@section('title', 'Mis Diagramas')
<x-app-layout>
    <div class="page bg-black">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title ">
                                Diagramas en los que participas
                            </h2>

                        </div>
                        <!-- Page title actions -->
                        <div class="col-12 col-md-auto ms-auto d-print-none">
                           
                            <a href="#" class="btn btn-white d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Agregar Diagrama
                            </a>
                        </div>

                    </div>
                </div>

                <div class="page-body ">
                    <div class="container-xl ">
                        @if (is_countable($diagramas) && count($diagramas) > 0)
                            <div class="row row-cards ">
                                @foreach ($diagramas as $diagrama)
                                    <div class="col-lg-12 mt-1 mb-1" >
                                        <div class="card ">
                                            <div class="card-body ">
                                                <div class="row align-items-center ">
                                                    <div class="col-2">
                                                        <img src="{{ asset('assets/img/uml-w.png') }}"
                                                            alt="Food Deliver UI dashboards" class="rounded">
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="card-title mb-1 ">
                                                            <a href="#"
                                                                class="text-reset " style="font-size: 30px"> {{ $diagrama->nombre }}</a>
                                                        </h3>
                                                            @if ($diagrama->user_id == Auth::user()->id)
                                                            <span class="text-success">Dueño</span>
                                                            @else
                                                            <span class="text-info">participando</span>
                                                            @endif
                                                        </p>
                                                        <div class="text-muted" style="font-size: 20px">
                                                            {{ $diagrama->descripcion }}
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="datagrid-title" style="font-size: 20px">Lista de Usuarios</div>
                                                        <div class="datagrid-content">
                                                            @if (count($diagrama->usuarios) > 1)
                                                                <div class="avatar-list avatar-list-stacked">
                                                                    @foreach ($diagrama->usuarios as $usuario)
                                                                        @if ($usuario->id != $diagrama->user_id)
                                                                            @if ($usuario->url)
                                                                                <span
                                                                                    class="avatar avatar-xs avatar-rounded cursor-help"
                                                                                    style="background-image: url({{ asset('storage/' . $usuario->url) }})"
                                                                                    data-bs-toggle="popover"
                                                                                    data-bs-placement="top"
                                                                                    data-bs-html="true"
                                                                                    data-bs-content="<p class='mb-0'>{{ $usuario->name }} - Participante</p><p class='mb-0'><a href='#'>{{ $usuario->email }}</a></p>">
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="avatar avatar-xs avatar-rounded cursor-help"
                                                                                    data-bs-toggle="popover"
                                                                                    data-bs-placement="top"
                                                                                    data-bs-html="true"
                                                                                    data-bs-content="<p class='mb-0'>{{ $usuario->name }} - Participante</p>
                                                                                <p class='mb-0'><a href='#'>{{ $usuario->email }}</a></p>
                                                                                ">{{ Str::substr($usuario->name, 0, 2) }}</span>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="h6">Sin usuarios</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown ">
                                                            <a href="#" class="btn-action"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                    width="48" height="48" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <circle cx="12" cy="12"
                                                                        r="1" />
                                                                    <circle cx="12" cy="19"
                                                                        r="1" />
                                                                    <circle cx="12" cy="5"
                                                                        r="1" />
                                                                </svg>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="{{ route('diagramas.diagramar', $diagrama->id) }}"
                                                                    class="dropdown-item">Editar Diagrama</a>
                                                                {{-- @endcan --}}
                                                                @if ($diagrama->user_id == Auth::user()->id)
                                                                    <a href="{{ route('diagramas.edit', $diagrama->id) }}"
                                                                    class="dropdown-item">Editar Información</a>
                                                                    <a href="{{ route('diagramas.usuarios', $diagrama->id) }}"
                                                                        class="dropdown-item">Administrar</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @if ($diagrama->user_id == Auth::user()->id)
                                                    <div class="col-auto">
                                                        <form method="POST" action="{{ route('diagramas.delete',$diagrama->id) }}" ">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="switch-icon switch-icon-fade"><i class="fa-solid fa-trash" style="color:white"></i></button>
                                                          </form>
                                                    </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card mt-1">
                                <div class="card-body pb-0">
                                    <div class="pagination">
                                        {{ $diagramas->links() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row row-cards">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="empty">
                                            <div class="empty-img"><img
                                                    src="{{ asset('/back/static/illustrations/undraw_quitting_time_dm8t.svg') }}"
                                                    height="128" alt="">
                                            </div>
                                            <p class="empty-title">Sin diagramas</p>
                                            
                                            <div class="empty-action">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modal-report">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <line x1="12" y1="5" x2="12"
                                                            y2="19" />
                                                        <line x1="5" y1="12" x2="19"
                                                            y2="12" />
                                                    </svg>
                                                    Crear Diagrama
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Diagrama</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('diagramas.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input name="nombre" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cargar diagrama</label>
                                            <select class="form-select" name="diagrama_id">
                                                <option value="nuevo" selected>Nuevo</option>
                                                @foreach (Auth::user()->misDiagramas as $diagrama)
                                                    <option value="{{$diagrama->id}}">{{$diagrama->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>

                        <div class="modal-body">

                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">Descripcion</label>
                                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary bg-danger text-white"
                                data-bs-dismiss="modal">
                                Cancelar
                            </a>
                            <button class="btn btn-primary ms-auto" type="submit" data-bs-dismiss="modal">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Crear Diagrama
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            
        </script>
    @endpush
</x-app-layout>
