<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"> Escritorio </a></li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="icon-speedometer"></i> Escritorio
            </div>

            <div class="card-body">
            <!-- card-body -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="estilo-header-footer-escritorio">Reporte de avisos</h5>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="graficaAvisos"></canvas>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <p class="estilo-header-footer-escritorio">
                                    Reporte de avisos por mes del año <span id="year"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="estilo-header-footer-escritorio">Datos personales</h5>
                            </div>
                            <div class="card-content">
                                
                                <p>Xd</p>

                            </div>
                            <div class="card-footer text-center">
                                <p class="estilo-header-footer-escritorio">Datos del usuario</p>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- card-body -->
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
        }
    },
    methods : {
        getReporteAvisos(){
            let me = this;
            var url = '/dashboard';
            //devuelve los avisos enviados en determinado mes
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayAvisos = respuesta.avisosEnviados;
                
                //carga los datos en el chart
                me.mostrarReporteAvisos();
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
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

        }
    },
    mounted(){
        this.getReporteAvisos();
        this.anioActual();
    }
}
</script>

<style scoped>
    .card-content{
        padding-left: 10px;
        padding-right: 10px;
    }

    .estilo-header-footer-escritorio{
        font-weight: bold;
        color: rgb(0, 0, 0, 0.7);
        margin-bottom: 0;
    }

</style>

