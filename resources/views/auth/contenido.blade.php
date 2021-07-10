<!DOCTYPE html>
<html lang="es">
<head>    
    <link rel="shortcut icon" href="{{asset('storage/img/logo/favicon-Notischool.png')}}">
    <title>Notischool</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de administración de notificaciones">
    <meta name="author" content="NotiSchool">
    <meta name="keyword" content="Sistema de notificaciones, administración, gestion, acceso">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Estilos -->
    <link href="{{ asset('css/plantilla.css') }}" rel="stylesheet">
</head>  
<body class="app flex-row align-items-center">

    <div class="container">
        @yield('content')
    </div>
    
    <!-- Archivos js compilados con Laravel mix -->
    <script src="{{ asset('js/plantilla.js')}}"></script>
</body> 
</html>