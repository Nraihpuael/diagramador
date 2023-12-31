@section('title', 'Perfil')
<x-app-layout>
    <div class="page">
        <div class="page-wrapper bg-black">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                Configuraciones
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body bg-white">
                <div class="container-xl">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-3 d-none d-md-block border-end  bg-black">

                                <div class="card-body">
                                    <h4 class="subheader">Configuraciones de Cuenta</h4>
                                    <div class="list-group list-group-transparent">
                                        <a href="{{ route('profile.index') }}"
                                            class="list-group-item list-group-item-action d-flex align-items-center">Mi
                                            Cuenta</a>
                                        <a href="#"
                                            class="list-group-item list-group-item-action d-flex align-items-center active">Mis
                                            Notificaciones</a>
                                    </div>
                                    
                                </div>

                            </div>

                            <div class="col d-flex flex-column">

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Notificaciones</h3>
                                        </div>
                                        <div class="card-body">
                                            @if (count($notificaciones) > 0)
                                                @foreach ($notificaciones as $notificacion)
                                                    <div class="row g-3">
                                                        <div class="col-8">
                                                            <div class="row g-3 align-items-center">
                                                                <a href="#" class="col-auto">
                                                                    <span class="avatar"
                                                                        style="background-image: url(./static/avatars/000m.jpg)">
                                                                        <span class="badge bg-red"></span></span>
                                                                </a>
                                                                <div class="col">
                                                                    <a href="#"
                                                                        class="text-reset d-block text-truncate">Diagramas:
                                                                        {{ $notificacion->diagrama->nombre }}</a>
                                                                    <div class="text-muted mt-n1">
                                                                        {{ $notificacion->contenido }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="row">
                                                                <div class="col-auto">

                                                                    <form
                                                                        action="{{ route('notificaciones.leer', $notificacion->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('put')
                                                                        <button type="submit"
                                                                            class="btn btn-info border-0"
                                                                            title="Marcar visto">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="icon icon-tabler icon-tabler-eye m-0"
                                                                                width="44" height="44"
                                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                                stroke="#ffffff" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                                <circle cx="12" cy="12"
                                                                                    r="2" />
                                                                                <path
                                                                                    d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                                            </svg>
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                No tienes notificaciones sin leer
                                            @endif
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
</x-app-layout>
