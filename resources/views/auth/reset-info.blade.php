@section('title', 'Perfil')
<x-app-layout>
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
                                        class="list-group-item list-group-item-action d-flex align-items-center active">Mi
                                        Cuenta</a>
                                    <a href="{{ route('notificaciones.index') }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center">Mis
                                        Notificaciones</a>
                                </div>
                                
                            </div>

                        </div>

                        <div class="col d-flex flex-column">
                            <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <h2 class="mb-3">Mi Cuenta</h2>
                                    <h3 class="card-title">Detalles de Perfil</h3>
                                    <div class="row align-items-center">
                                        
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-label text-primary">Cambiar Nombre</div>
                                            <input name="name" type="text"
                                                class="form-control @error('name')is-invalid @enderror"
                                                value="{{ $user->name }}">
                                            @error('name')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-label text-primary">Cambiar Email</div>
                                                <input name="email" type="text"
                                                    class="form-control @error('email')is-invalid @enderror"
                                                    value="{{ $user->email }}">
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-label text-primary">Cambiar contraseña</div>
                                                <div class="form-floating mb-1">
                                                    <input name="password_actual" type="password"
                                                        class="form-control" id="floating-password-0"
                                                        autocomplete="off">
                                                    <label for="floating-password">Contraseña actual</label>
                                                </div>
                                                @error('passwordActual')
                                                    <small class="text-danger mb-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-1">
                                                    <input name="password_new" type="password"
                                                        class="form-control @error('password_new')is-invalid @enderror"
                                                        id="floating-password-1" autocomplete="off">
                                                    <label for="floating-password">Nueva Contraseña</label>
                                                </div>
                                                @error('passwordMenor')
                                                    <small class="text-danger mb-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-1">
                                                    <input name="password_confirm" type="password"
                                                        class="form-control @error('password_confirm')is-invalid @enderror"
                                                        id="floating-password-2" autocomplete="off">
                                                    <label for="floating-password">Confirmar Nueva Contraseña</label>
                                                </div>
                                                @error('passwordConfirm')
                                                    <small class="text-danger mb-2">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-start">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            let verImagen = (event) => {
                let leer_img = new FileReader();
                let id_img = document.getElementById('perfil');

                leer_img.onload = () => {
                    if (leer_img.readyState == 2) {
                        id_img.src = leer_img.result;
                    }
                }
                leer_img.readAsDataURL(event.target.files[0])
            }
        </script>
    @endpush
</x-app-layout>
