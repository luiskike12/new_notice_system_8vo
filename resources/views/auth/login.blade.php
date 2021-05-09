@extends('auth.contenido')

@section('login')

<!--
<section >    
    <div class="baslik">
        <img src="img/logo_NotiSchool_login.png">
    </div>
    <section >
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="envioLogin">
                <div class="loginbaslik">Login Dashboard</div>
                <hr style="border: 1px solid #ccc;">
                <input class="giris" type="text" name="usuario" id="usuario" placeholder="Usuario">
                <input class="giris" type="password" name="password" id="password" placeholder="Contraseña">
                <input class="butonlogin" type="submit" name="" value="Iniciar sesión">
            </div>
        </form>
    </section>

</section>

<footer style="margin-top: 40px;">
    <span style="font-size: 25px; text-align: center; display: block; color: #E6E6E6;
    ">Panel de acceso a la administración de notificaciones</span>
    
    <span style="font-size: 18px; text-align: center; display: block; color: #fff;
    ">www.notischool.com</span>
</footer>-->




  
    <div class="row justify-content-center">
      <img src="img/logo_NotiSchool_login.png">
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
