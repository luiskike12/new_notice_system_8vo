<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="icon-speedometer"></i> Escritorio
            </div>
            <div class="card-body">
            <!-- card-body padre-->
                <div class="row">
                    <!-- columna del card-grafica-avisos -->
                    <div class="col-md-6 col-grafica-avisos">

                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="estilo-header-footer-escritorio">Reporte de avisos</h5>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="graficaAvisos" class="estilo-grafica-avisos"></canvas>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <p class="estilo-header-footer-escritorio">
                                    Reporte de avisos por mes del año <span id="year"></span>
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- columna de datos del usuario -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="estilo-header-footer-escritorio">Tarjeta de datos</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- sección izquierda -->
                                    <div class="col-sm-6 seccion-izquierda-datos-personales">
                                        <div class="form-group">
                                            <div class="col-sm col-contenedor-reloj">
                                                <table class="contenedor-reloj">
                                                    <tbody>
                                                        <tr>
                                                            <td class="icono-reloj">                
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                </span>
                                                            </td>
                                                            <td class="caja-reloj">
                                                                <div class="borde-caja-reloj">
                                                                    <p class="reloj" id="reloj"></p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm text-center col-imagen-perfil">
                                                <img v-if="avatar" class="rounded-circle" :src="'storage/' + avatar" width="80px" height="80px">
                                                <img v-else class="rounded-circle" :src="'img/avatars/avatar.png'" width="80px" height="80px">
                                            </div>
                                            <div class="col-sm text-center" style="margin-bottom: 18px;">
                                                <p style="font-weight: bold;color: rgb(0, 0, 0, 0.7);">Imagen de perfil</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sección derecha -->
                                    <div class="col-sm-6 seccion-derecha-datos-personales">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm text-center">
                                                    <table class="table tabla-info-usuario">
                                                        <thead>
                                                            <tr class="row">
                                                                <td class="col-sm text-center" style="border-top: none;">Información del usuario</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="row etiqueta">
                                                                <td class="col-sm text-center">Rol</td>
                                                            </tr>
                                                            <tr class="row descripcion">
                                                                <td class="col-sm text-center" v-text="rol"></td>
                                                            </tr>
                                                            <tr class="row etiqueta">
                                                                <td class="col-sm text-center">Carrera</td>
                                                            </tr>
                                                            <tr class="row descripcion">
                                                                <td class="col-sm text-center" v-text="carrera"></td>
                                                            </tr>
                                                            <tr class="row etiqueta">
                                                                <td class="col-sm text-center">Nombre</td>
                                                            </tr>
                                                            <tr class="row descripcion">
                                                                <td class="col-sm text-center" v-text="nombre"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <p class="estilo-header-footer-escritorio">Datos del usuario</p>
                            </div>
                        </div>
                    </div>
                <!-- row del card-body padre -->
                </div>
            <!-- card-body padre-->
            </div>

        </div>
    </div>
</main>
</template>

<script>
export default {
    data() {
        return {
            //arreglo de meses del año a mostrar
            mesesAnio : ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            
            //Se vincula con el id del canvas a donde se envian los datos
            varReporteAviso : null,
            //crea el grafico char alimentados por valores vinculados con el id del objeto canvas
            charReporteAviso : null,
            //Obtiene el listado de los avisos
            arrayAvisos : [],
            //Aqui se almacena el número de avisos que fueron enviados en el mes
            avisosEnviados : [],
            //Aqui se almacena el número de avisos que fueron guardados en el mes
            avisosGuardados : [],
            //Aqui se almacenan los nombres de los meses
            varMesAvisos : [],

            //Datos del usuario
            arrayDatosUsuario : [],
            rol : '',
            carrera : '',
            nombre : '',
            avatar : ''
        }
    },
    methods : {
        getReporteAvisos(){
            let me = this;
            var url = '/dashboard';
            //devuelve los avisos enviados en determinado mes
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayAvisos = respuesta.reporteAvisos;
                me.arrayDatosUsuario = respuesta.datosUsuario;
                
                //carga los datos en el chart
                me.mostrarReporteAvisos();
                //mostrar datos del usuario
                me.mostrarDatosUsuario();
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        },
        mostrarDatosUsuario(){
            let me = this;
            
            me.rol = me.arrayDatosUsuario[0]['nombre_rol'];
            me.carrera = me.arrayDatosUsuario[0]['nombre_carrera'];
            me.nombre = me.arrayDatosUsuario[0]['nombre'];
            me.avatar = me.arrayDatosUsuario[0]['avatar'];
        },
        mostrarReporteAvisos(){
            let me = this;
            me.arrayAvisos.map(function(x){
                me.varMesAvisos.push(me.mesesAnio[x.mes-1]);
                me.avisosEnviados.push(x.avisos_enviados);
                me.avisosGuardados.push(x.avisos_guardados);
            });

            me.varReporteAviso = document.getElementById('graficaAvisos').getContext('2d');

            me.charReporteAviso = new Chart(me.varReporteAviso, {
                type: 'bar',
                data: {
                    //se muestra el arreglo de columnas de los meses
                    labels: me.varMesAvisos,
                    datasets: [
                        {
                            label: 'Avisos enviados',
                            //arreglo del total de avisos por mes
                            data: me.avisosEnviados,
                            backgroundColor: 'rgba(52, 152, 219, 0.4)',
                            borderColor: 'rgba(52, 152, 219, 0.4)',
                            borderWidth: 1
                        },
                        {
                            label: 'Avisos guardados',
                            //arreglo del total de avisos por mes
                            data: me.avisosGuardados,
                            backgroundColor: 'rgba(133, 146, 158, 0.4)',
                            borderColor: 'rgba(133, 146, 158, 0.4)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });


        },
        anioActual(){
            const fecha = new Date();
            const anoActual = fecha.getFullYear();
            document.getElementById('year').innerHTML = anoActual.toString();

        },
        mostrarReloj(){
            /**
             * Muestra la hora del 
             * servidor en tiempo real 
             * en el formato de 12 horas
             */
            const HORA = () => {

                // Constante que almacena el id del elemento donde
                // se va a mostrar el reloj
                const ID_ELEMENT = document.getElementById("reloj");

                // Función que añade un cero a la izquierda
                // a la hora, minutos y segundos cuando el
                // valor de estos es inferior a 10 
                const CERO = n => n = n < 10 ? "0"+n: n;
                let hora, minutos, segundos, meridiano;

                // Funcion que retorna el Reloj
                const RELOJ = () => {
                    const DATE = new Date();
                    hora = DATE.getHours();
                    minutos = DATE.getMinutes();
                    segundos = DATE.getSeconds();

                    // Determinar el meridiano
                    meridiano = hora < 12 ? "am" : "pm";

                    // Dar formato de 12 horas ya que por defecto el formato es de 24 horas
                    hora = hora == 0 ? 12 : hora || hora > 12 ? hora -= 12 : hora;

                    return (
                        ID_ELEMENT.textContent = 
                        `${CERO(hora)}:${CERO(minutos)}:${CERO(segundos)} ${meridiano}`
                    );
                }

                // Llama a la función RELOJ cada segundo
                // para que se vaya actualizando la hora
                return setInterval(RELOJ, 1000);
            }

            // Llama a la funcion HORA cuando el DOM se haya cargado
            document.addEventListener("DOMContentLoaded", HORA);
        }
    },
    mounted(){
        this.getReporteAvisos();
        this.anioActual();
        this.mostrarReloj();
    }
}
</script>

<style scoped>
    .card-content{
        padding-left: 10px;
        padding-right: 10px;
    }

    @media only screen and (max-width:1130px){
        
        .estilo-grafica-avisos{
            /* max-height: 243px; */
            min-height: auto;
        }

    }

    @media only screen and (min-width: 1131px){
        .estilo-grafica-avisos{
            max-height: 243px;
        }
    }
    

    .estilo-header-footer-escritorio{
        font-weight: bold;
        color: rgb(0, 0, 0, 0.7);
        margin-bottom: 0;
    }

    .seccion-izquierda-datos-personales > .form-group{
        margin-bottom: 22px;
    }

    .seccion-derecha-datos-personales > .form-group{
        margin-bottom: 22px;
    }

    /* -------------- estilos para el reloj -----------------------*/
    .col-contenedor-reloj{
        padding-bottom: 18px;
    }
    .contenedor-reloj{
        width: 150px;
        margin: auto;
    }
    .contenedor-reloj > tbody > tr > .icono-reloj{
        padding-right: 0;
    }

    .icono-reloj{
        width: 20%;
    }
    .icono-reloj > span{
        font-size: 17px;
    }

    .caja-reloj{
        padding: 0;
    }
    .caja-reloj > .borde-caja-reloj{
        height: 35px;
        border: 1px solid #BBCDD5;
        border-left: none;
        display: flex;
    }
    .caja-reloj > .borde-caja-reloj > .reloj{
        margin: auto;
        font-weight: bold;
        color: rgb(0, 0, 0, 0.7 );
    }

    /*@media only screen and (max-width:768px){
        .tr-reloj > .col-md-2{
            width: 34px;
        }
    } */

    /* estilos de columna de imagen de perfil */

    .col-imagen-perfil{
        margin-bottom: 18px;
    }

    .rounded-circle{
        overflow: hidden !important;
    }


    /* ----------- Estilos de la tabla de infrmacion del usuario ----------*/
    .tabla-info-usuario{
        margin-bottom: 0;
        border: 1px solid #BBCDD5;
    }

    .tabla-info-usuario > thead > .row{
        margin: auto;
        background-color: rgba(213, 219, 219, 0.3);
        /* background: linear-gradient(to bottom, rgb(128, 139, 150, 0.3), white 100%); */
    }

    .tabla-info-usuario > thead > .row > td{
        color: rgb(39, 55, 70, 0.9);
        font-weight: bold;
        font-size: 15px;
    }

    .tabla-info-usuario > tbody > .row{
        margin: auto;
    }

    .tabla-info-usuario > tbody > .row > .col-sm{
        padding-top: 0;
        padding-bottom: 0;
    }

    .tabla-info-usuario > tbody > .etiqueta{
        background-color: rgba(244, 246, 246, 0.7);       
    }

    .tabla-info-usuario > tbody > .etiqueta > td{
        font-weight: bold;
        color: rgb(39, 55, 70, 0.8);        
    }

    .tabla-info-usuario > tbody > .descripcion{
        background-color: white;
    }
</style>

