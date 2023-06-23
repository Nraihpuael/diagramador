<x-guest-layout>
    @section('title', isset($title) ? $title : 'Login')
 
    <div class="page page-center bg-black">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{asset('assets/img/uml.png')}}"
                        height="50" alt=""></a>
            </div>
            <form method="POST" action="{{ route('login') }}" class="" autocomplete="off">
                @csrf
                <div class="">
                    <h2 class="card-title text-center mb-4">Iniciar sesion con tu Cuenta</h2>
                    <div class="mb-3">
                        {{-- Email --}}
                        <label class="form-label">Dirección Email</label>
                        <input id="email" name="email" type="email" class="form-control"
                            placeholder="Ingresa tu Email" autocomplete="off" :value="old('email')">
                    </div>
                    <div class="mb-2">
                        {{-- Password --}}
                        <label class="form-label">
                            Contraseña
                        </label>

                        <div class="input-group input-group-flat">
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Contraseña" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input id="remember_me" name="remember" type="checkbox" class="form-check-input" />
                            <span class="form-check-label">Recuerdame en este dispositivo</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-white w-100">Ingresar</button>
                    </div>
                </div>
               
            </form>
            <div class="text-center text-muted mt-3">
                Aun no tienes una cuenta? <a href="{{ route('register') }}" style="color:aqua" tabindex="-1" >Sign up</a>
                @if (Route::has('password.request'))
                    <br><br>
                    <a href="{{ route('password.request') }}" style="color:aqua">Olvidaste tu contraseña?</a>
                @endif
            </div>
        </div>
    </div>

</x-guest-layout>
