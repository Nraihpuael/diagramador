@section('title', 'Usuarios de Diagrama')
<x-app-layout>
    <div class="page bg-black">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                Administrar Usuarios
                            </h2>
                            <p style="font-size: 20px">Diagrama: {{ $diagrama->nombre }}</p>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-12 col-md-auto ms-auto">
                            <a href="{{ route('diagramas.misDiagramas') }}" class="btn btn-secondary">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-body">
                <div class="container-xl">
                    <ul class="nav nav-bordered mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Administrar</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('eventos.favoritos') }}">Favoritos</a>
                        </li> --}}
                    </ul>
                    <div class="col-12 row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Usuarios</h3>
                                </div>
                                @if (count($diagrama->usuarios) > 0)
                                    @foreach ($diagrama->usuarios as $usuario)
                                        <div class="list-group list-group-flush list-group-hoverable">
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="#">
                                                            @if ($usuario->url)
                                                                <span class="avatar avatar-sm"
                                                                    style="background-image: url({{ asset('storage/' . $usuario->url) }})"></span>
                                                            @else
                                                                <span
                                                                    class="avatar avatar-sm">{{ Str::substr($usuario->name, 0, 2) }}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <a href="#"
                                                            class="text-reset d-block">{{ $usuario->name }}</a>
                                                        <div class="d-block text-muted text-truncate mt-n1">
                                                            {{ $usuario->email }}
                                                        </div>
                                                    </div>

                                                    @if ($usuario->id != $diagrama->user_id)
                                                        <div class="col-auto">
                                                            <div class="btn-action">
                                                                <button class="switch-icon switch-icon-fade"
                                                                    data-bs-toggle="switch-icon"
                                                                    title="Cambiar favorito"
                                                                    onclick="editor({{ $usuario->id }}, {{ $diagrama->id }})">
                                                                    @if ($diagrama->permiso($usuario->id) == 1)
                                                                        <span class="switch-icon-a text-success mt-1">
                                                                            <i class="fa-solid fa-pen"></i>
                                                                        </span>
                                                                        <span class="switch-icon-b text-red mt-1">
                                                                            <i class="fa-solid fa-eye"></i>
                                                                        </span>
                                                                    @else
                                                                        <span class="switch-icon-a text-red mt-1">
                                                                            <i class="fa-solid fa-eye"></i>
                                                                        </span>
                                                                        <span class="switch-icon-b text-success mt-1">
                                                                            <i class="fa-solid fa-pen"></i>
                                                                        </span>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="row">
                                                                <form
                                                                    action="{{ route('diagramas.banear', $diagrama->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div class="col-auto">
                                                                        <input type="text" hidden name="user_id"
                                                                            value="{{ $usuario->id }}">
                                                                    </div>

                                                                    <div class="col-auto px-1">
                                                                        <button class="btn btn-danger" type="submit">
                                                                            Banear
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Agregar Usuario</h3>
                                </div>
                                <div class="card-body">
                                    <div class="g-3">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Seleccionar el usuario</label>
                                               
                                                @foreach ($all as $todos)
                                                    <div class="list-group list-group-flush list-group-hoverable">
                                                        <div class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <a href="#">
                                                                        @if ($todos->url)
                                                                            <span class="avatar avatar-sm"
                                                                                style="background-image: url({{ asset('storage/' . $todos->url) }})"></span>
                                                                        @else
                                                                            <span
                                                                                class="avatar avatar-sm">{{ Str::substr($todos->name, 0, 2) }}</span>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="col text-truncate">
                                                                    <a href="#"
                                                                        class="text-reset d-block">{{ $todos->name }}</a>
                                                                    <div
                                                                        class="d-block text-muted text-truncate mt-n1">
                                                                        {{ $todos->email }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    @if (count(
                                                                        $todos->user_diagramas()->where('diagrama_id', $diagrama->id)->get()) > 0)
                                                                        @if ($todos->id == $diagrama->user_id)
                                                                            <div class="row">
                                                                                <div class="col-auto px-1">
                                                                                    <a href="#"
                                                                                        class="btn btn-orange disabled">
                                                                                        Dueño
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <a href="#"
                                                                                class="btn btn-info disabled">
                                                                                Participando
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <form
                                                                            action="{{ route('notificaciones.store') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="integer" hidden
                                                                                value="{{ $diagrama->id }}"
                                                                                name="diagrama_id">
                                                                            <input type="integer" hidden
                                                                                value="{{ $todos->id }}"
                                                                                name="user_id">

                                                                            <button class="btn btn-success"
                                                                                type="submit">
                                                                                Invitar
                                                                            </button>
                                                                        </form>
                                                                        {{-- @endif --}}
                                                                    @endif


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="card mt-1">
                                                    <div class="card-body pb-0">
                                                        <div class="pagination">
                                                            {{ $all->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            function editor(user_id, diagrama_id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('diagramas/editor') }}",
                    data: {
                        id: user_id,
                        diagrama: diagrama_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function() {
                    
                    },
                });
            };
        </script>
    @endpush

</x-app-layout>
