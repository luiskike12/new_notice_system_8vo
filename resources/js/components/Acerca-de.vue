<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Acerca de...</li>
    </ol>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="icon-info"></i> Acerca de Notischool
            </div>
            <div class="card-body">
            <!-- card-body Principal -->
                <div class="card-group">
                    <!-- card izquierda -->
                    <div class="card card-carrusel-izquierda">
                        <div class="card-body">
                        <!-- card-body izquierda -->
                            <div class="alert alert-dark text-center" role="alert">
                                <img :src="'storage/img/logo/acerda-de-notischool.jpg'" alt="NotiSchool" 
                                class="rounded-circle" width="50px" height="50px">
                                <strong>Notischool</strong>
                            </div>
                            <div id="info">
                                <p>
                                    <em> 
                                        <b>Notischool</b> es un sistema basado en computadoras y dispositivos móviles, que provee una interfaz, 
                                        para asistir a las actividades de comunicación, entre alumnos e institución educativa, y que también 
                                        administra la información, tanto del remitente como el destinatario, creando un <b>ambiente colaborativo</b>, 
                                        a través del envío de avisos escolares, del sistema de administración a la aplicación móvil.
                                    </em>
                                </p>
                                <p style="margin-bottom: 0;">
                                    <em> 
                                        Este sistema propone una forma diferente de dar los avisos escolares, que <span style="color:red;">busca mejorar 
                                        el proceso</span> al momento de dar un aviso a los alumnos, con un sistema de administración 
                                        de avisos y una aplicación móvil.
                                    </em>
                                </p>
                            </div>
                            


                        <!-- card-body izquierda -->
                        </div>
                    </div>

                    <!-- card derecha -->
                    <div class="card card-carrusel-derecha">
                        <div class="card-body">
                        <!-- card-body derecha -->
                            <div id="carrusel-imagenes-notischool" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="0" class="active"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="1"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="2"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="3"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="4"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="5"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="6"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="7"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="8"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="9"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="10"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="11"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="12"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="13"></li>
                                    <li data-target="#carrusel-imagenes-notischool" data-slide-to="14"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="storage/img/acerca-de/1.jpg" alt="Primera diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/2.jpg" alt="Segunda diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/3.jpg" alt="Tercera diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/4.jpg" alt="Cuarta diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/5.jpg" alt="Quinta diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/6.jpg" alt="Sexta diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/7.jpg" alt="Septima diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/8.jpg" alt="Octava diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/9.jpg" alt="Novena diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/10.jpg" alt="Décima diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/11.jpg" alt="Décima primera diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/12.jpg" alt="Décima segunda diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/13.jpg" alt="Décima tercera diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/14.jpg" alt="Décima cuarta diapositiva">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="storage/img/acerca-de/15.jpg" alt="Décima quinta diapositiva">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carrusel-imagenes-notischool" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carrusel-imagenes-notischool" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>
                        <!-- card-body derecha -->
                        </div>
                    </div>

                </div>
            <!-- card-body Principal -->
            </div>

        </div>
    </div>

</main>

</template>

<script>
export default{
    name : 'acerca-de'
}
</script>

<style scoped>
.card-carrusel-izquierda{
    margin-bottom: 0;
}

.card-carrusel-derecha{
    margin-bottom: 0;
}

.carousel-indicators{
    margin-bottom: 3px;
}
</style>