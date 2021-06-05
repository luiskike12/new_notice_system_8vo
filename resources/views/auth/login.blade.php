@extends('auth.contenido')

@section('login')  
    <div class="row justify-content-center" style="margin-bottom: 15px;">
      <img class="rounded-circle" src="img/logo-NotiSchool-login.jpg">
    </div>

    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card-group mb-0">
          <div class="card p-4">
            <form class="form-horizontal was-validated" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-body">
                    
                    <div class="titulo-login">Login Dashboard</div>
                    <hr style="border: 1px solid #ccc;">
                    <div class="input-group mb-3 {{ $errors->has('usuario' ? 'is-invalid' : '') }}">
                        <span class="input-group-addon"><i class="icon-user"></i></span>
                        <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                        <!--{!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}-->
                    </div>
                    {!!$errors->first('usuario','<div class="row">
                                                  <div class="col">
                                                    <p style="color: red;">:message</p>
                                                  </div>
                                                </div>')!!}
                    
                    <div class="input-group mb-3 {{ $errors->has('password' ? 'is-invalid' : '') }}">
                        <span class="input-group-addon"><i class="icon-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                        <!--{!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}-->
                    </div>
                    {!!$errors->first('password','<div class="row">
                                                  <div class="col">
                                                    <p style="color: red;">:message</p>
                                                  </div>
                                                </div>')!!}
                    
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block"><b>Acceder</b></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center">
                        <button type="button" class="btn btn-link px-0">¿Olvidaste tu contraseña?</button>
                        </div>
                    </div>

                </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div class="row justify-content-center">
      <span style="font-size: 25px; text-align: center; display: block; color: #E6E6E6;
          ">Panel de acceso a la administración de notificaciones</span>
    </div>
    <div class="row justify-content-center">
      <span style="font-size: 18px; text-align: center; display: block; color: #fff;
          ">www.notischool.com</span>
    </div>
@endsection
