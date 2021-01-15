@extends('auth.contenido')

@section('login')
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
</footer>
@endsection
