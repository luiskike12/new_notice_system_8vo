<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <!-- dashboard -->
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>

            <!-- Accesos al sistema -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-key"></i>Accesos</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-people"></i>Tabla de Usuarios</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-address-book-o"></i>Roles de Usuario</a>
                    </li>
                </ul>
            </li>

            <!-- Alumnos (añadir y actulizar) -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user-follow"></i>Alumnos</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list-ul"></i>Tabla de Alumnos</a>
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-id-card-o"></i>Registro de Matrículas</a>
                    </li>
                </ul>
            </li>

            <!-- Carreras (añadir y actulizar) -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graduation"></i>Carreras</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list-ul"></i>Tabla de carreras</a>
                    </li>
                </ul>
            </li>

            <!-- Avisos (crear, enviar y actulizar) -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-envelope"></i>Avisos</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list-ul"></i>Tabla de avisos</a>
                    </li>
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i>Crear avisos</a>
                    </li>
                </ul>
            </li>
            
            <!-- Manual de usuario -->
            <li @click="menu=8" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
            </li>

            <!-- Acerda del sistema... -->
            <li @click="menu=9" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>