@extends('auth.contenido')

@section('content')
<div class="contenido-login">
    
    <div class="row justify-content-center">
        <div class="col-md-4 text-center logo-login-notischool">
            <img class="rounded-circle" src="{{ url('storage/img/logo/logo-Notischool-login.jpg') }}">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card-group mb-0">
                <div class="card p-4">

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="card-body">
                        {{-- card-body --}}

                            <div class="titulo-login">Iniciar sesión en el panel</div>
                            <hr style="border: 1px solid #ccc;">

                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                <input id="email" type="text" class="form-control @error('usuario') is-invalid @enderror" name="usuario" value="{{ old('usuario') }}" required autocomplete="usuario" placeholder="Usuario" autofocus>
                            </div>
                            {!!$errors->first('usuario','<div class="row">
                                                            <div class="col text-center">
                                                                <p class="mensaje-error-login">
                                                                    :message
                                                                </p>
                                                            </div>
                                                        </div>')!!}

                            
                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            </div>
                            {!!$errors->first('password','<div class="row">
                                                                <div class="col text-center">
                                                                    <p class="mensaje-error-login">
                                                                        :message
                                                                    </p>
                                                                </div>
                                                            </div>')!!}


                            <div class="row mb-3">
                                <div class="col-md text-center">
                                    <div class="form-check my-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label pl-0" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md text-center">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Acceder') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md text-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('¿Olvidaste tu contraseña?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        {{-- card-body --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <span style="font-size: 25px; text-align: center; display: block; color: #E6E6E6;">
            Panel de acceso a la administración de avisos escolares
            </span>
        </div>
        </div>
        <div class="row justify-content-center">
        <div class="col-md-8">
            <span style="font-size: 18px; text-align: center; display: block; color: #fff;">
            www.notischool.com
            </span>
        </div>
    </div>

</div>
@endsection
