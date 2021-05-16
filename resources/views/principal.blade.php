<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/logo_NotiSchool.png">
    <title>Administracion de notificaciones</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <!-- archvio compilado con laravel Mix -->
    <link href="css/plantilla.css" rel="stylesheet">
    <link rel="stylesheet" type = "text/css" href="css/trix.css">

    <!-- bootstrap-datepicker sandbox -->
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app">
        
        <header class="app-header navbar">
            <!-- Boton de espacio - versión móvil -->
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                <span class="navbar-toggler-icon"></span>
            </button> 

            <a class="navbar-brand" href="#"></a>

            <!-- boton para Submenus de categorias -->
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Configuraciones  -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item px-3 active">
                    <a class="nav-link" href="#">Escritorio</a>
                </li>
                <li class="nav-item px-3 active">
                    <a class="nav-link" href="#">Configuraciones</a>
                </li>
            </ul>


            <!-- Menu desplegable -->
            <ul class="navbar-nav ml-auto">
                <div id="menu-notificaciones" class="nav-item d-md-down-none px-2">
                    <input type="checkbox" id="btn-menu-notificaciones" checked>
                    <label for="btn-menu-notificaciones">
                        <i class="icon-bell"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                        Notificaciones
                    </label>
                    <nav id="despliega-menu-notificaciones" class="dropdown-menu-right">
                        <ul>
                            <li id="cabecera-item"><strong>Bandeja</strong></li>
                            <a href="">
                                <li id="item">
                                    <i class="fa fa-envelope-o"></i> Correos
                                    <span class="badge badge-success">3</span>
                                </li>
                            </a>
                            <a href="">
                                <li id="item">
                                    <i class="fa fa-tasks"></i> Solicitudes
                                    <span class="badge badge-danger">2</span>
                                </li>
                            </a>
                        </ul>
                    </nav>
                </div>
             

                <div id="menu-usuario" class="nav-item px-5">
                    <input type="checkbox" id="btn-menu-usuario" checked>
                    <label for="btn-menu-usuario">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        {{ Auth::user()->usuario }}
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    </label>
                    <nav id="despliega-menu-usuario" class="dropdown-menu-right">
                        <ul>
                            <li id="cabecera-item"><strong>Cuenta</strong></li>
                            <a href="">
                                <li id="item">
                                    <i class="fa fa-user"></i> Perfil
                                </li>
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <li id="item">
                                    <i class="fa fa-lock"></i> Cerrar sesión
                                </li>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </nav>
                </div>
            </ul>  

        </header>


        <div class="app-body">
            
            @if(Auth::check())
                @if(Auth::user()->id_rol == 1){

                    @include('plantilla.sidebar')

                    <!-- Contenido Principal -->
                    @yield('contenido')
                    <!-- /Fin del contenido principal -->
                }
                @endif
            @endif

        </div>
    </div>
    

    <footer class="app-footer">
        <span><a href="#">NotiSchool</a> &copy; 2020</span>
        <span class="ml-auto">Desarrollado por <a href="#">NotiSchool</a></span>
    </footer>

    <!-- Archivos js compilados con Laravel mix -->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script type="text/javascript" src="js/trix.js"></script>

    <!-- bootstrap-datepicker sandbox -->
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-datepicker.es.min.js"></script>

</body>

</html>