<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{url('storage/img/logo/favicon-Notischool.png')}}">
    <title>Administración de notificaciones</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- archvio compilado con laravel Mix -->
    <link href="css/plantilla.css" rel="stylesheet">

    <!-- bootstrap-datepicker sandbox -->
    <!-- <link href="css/bootstrap-datepicker.css" rel="stylesheet"> -->    
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app">
    <!--componentes app-->
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


            <!-- Menu desplegable -->
            <ul class="navbar-nav ml-auto">

                <b-nav-item-dropdown right class="nav-menu-usuario">
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <img src="{{ asset('storage/'.Auth::user()->avatar)  }}" class="rounded-circle"
                        alt="Foto de perfil" width="50px" height="50px">
                        <em style="font-weight: bold;">{{ Auth::user()->usuario }}</em>
                    </template>
                    
                    <template v-if="showItemUsuario">
                        <div class="nav-item b-nav-dropdown dropdown nav-item-menu-usuario">
                            <div class="dropdown-header text-center">
                                <strong>Cuenta</strong>
                            </div>
                            <a class="nav-link item-menu-usuario" href="#" @click="menu=10" v-b-hover="hoverPerfil" v-bind:style="colorHover.perfil"
                            style="border-bottom:  1px solid #D2D2D2;">
                                <div class="text-left">
                                    <i class="fa fa-user"></i> Perfil
                                </div>
                            </a>
                            <a class="nav-link item-menu-usuario" v-b-hover="hoverCerrar" v-bind:style="colorHover.cerrar"
                            href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="text-left">
                                    <i class="fa fa-lock"></i> Cerrar sesión
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </template>
                </b-nav-item-dropdown>
            </ul>  

        </header>


        <div class="app-body">         
            @if(Auth::check())
                @if(Auth::user()->id_rol == 1)
                    @include('plantilla.sidebarAdministrador')
                @elseif(Auth::user()->id_rol == 2)
                    @include('plantilla.sidebarCoordinador')
                @elseif(Auth::user()->id_rol == 3)
                    @include('plantilla.sidebarAsistente')
                @elseif(Auth::user()->id_rol == 4)
                    @include('plantilla.sidebarDocente')
                @else 

                @endif
            @endif
            <!-- Contenido Principal -->
            @yield('contenido')
            <!-- /Fin del contenido principal -->
        </div>
    <!--componentes app-->    
    </div>

    <footer class="app-footer">
        <span><a href="#">NotiSchool</a> &copy; 2020</span>
        <span class="ml-auto">Desarrollado por <a href="#">NotiSchool</a></span>
    </footer>
    
    <!-- Archivos js compilados con Laravel mix -->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>

    <!-- bootstrap-datepicker sandbox -->
    <!-- <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-datepicker.es.min.js"></script> -->
</body>
</html>