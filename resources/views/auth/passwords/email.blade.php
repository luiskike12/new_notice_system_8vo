@extends('auth.contenido')

@section('content')

    <div class="row justify-content-center" >
        <div class="col-md-4 text-center logo-login-notischool">
            <img class="rounded-circle" src="{{url('storage/img/logo/logo-NotiSchool-login.jpg')}}">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header titulo-email-reset">
                    {{ __('Restablecer contraseña') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" novalidate>
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md text-center">
                                    <label for="email" class="col-md-4 col-form-label text-center">{{ __('Dirección Email') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="mx-auto text-center" style="max-width: 400px">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar enlace de restablecimiento') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="col-md text-center">
                        <a class="pb-0 pt-0 btn btn-link font-weight-bold" href="{{ route('login') }}">{{ __('Regresar al Login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
