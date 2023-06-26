<x-guest-layout>
    @section('title', isset($title) ? $title : 'Login')
    <div class="page page-center bg-black">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('assets/img/uml.png') }}"
                        height="50" alt=""></a>
            </div>
            <form class="card card-md bg-black" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Crear nueva cuenta</h2>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                            :value="old('name')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" id="email" type="email" class="form-control" placeholder="Enter email"
                            :value="old('email')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group input-group-flat">
                            <input id="password" name="password" required type="password" class="form-control"
                                placeholder="Password" autocomplete="new-password">
                        </div>
                    </div>
                    {{-- <input type="number" name="plane_id" value="{{ $plane_id }}" hidden> --}}

                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <div class="input-group input-group-flat">
                            <input id="password_confirmation" name="password_confirmation" required type="password"
                                class="form-control" placeholder="Confirm Password" autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" />
                            <span class="form-check-label">Agree the <a href="#" tabindex="-1" style="color:aqua">terms
                                    and policy</a>.</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-black w-100"  >
                            Registrar
                        </button>
                        <div class="text-center text-muted mt-3 ">
                            Ya tienes una cuenta? <a href="{{ route('login') }}" tabindex="-1" style="color:aqua">Sign in</a>
                        </div>
                    </div>
                   
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>