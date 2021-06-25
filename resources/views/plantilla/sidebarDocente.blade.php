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

            <!-- Alumnos (añadir y actulizar) -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user-follow"></i>Alumnos</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list-ul"></i>Tabla de Alumnos</a>
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
                <a class="nav-link" href="#" ><i class="icon-info"></i> Acerca de...
                    <span class="acerca-de-notischool">
                        <img src="{{ url('storage/img/logo/acerda-de-notischool.jpg') }}" alt="NotiSchool" 
                        class="rounded-circle" width="22px" height="22px">
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>