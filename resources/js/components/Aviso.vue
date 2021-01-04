<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card" style="min-height: 426px;"> 
            <!-- div del contenedor -->
            <div class="card-header">
                <i class="fa fa-align-justify"></i>Crear Aviso
            </div>

            <!--******************************************************************************* -->
            <form @submit.prevent="guardar_aviso" enctype="multipart/form-data" class="form-horizontal">

                <!-- División de tarjetas IZQUIERDA Y DERECHA -->
                <div class="card-group">
                    <!-- terjeta IZQUIERDA -->
                    <div class="card izquierda">
                        <div class="form-group">
                            <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Título del aviso</label>
                            <div class="col-md">
                                <input type="text" v-model="titulo_aviso" class="form-control" placeholder="Ingrese el título del aviso">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Documento</label>
                            <div class="col-md">
                                <input type="file" class="form-control" @change="getDocumento" placeholder="Seleccione un documento">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Contenido del aviso</label>
                            <div class="col-md">
                                <input type="hidden" id="contenido_aviso">
                                <trix-editor input="contenido_aviso"  class="trix-editor"></trix-editor>
                            </div>
                        </div>
                    </div>
                    <!--FIN terjeta IZQUIERDA -->

                    <!--terjeta DERECHA -->
                    <div class="card derecha">
                        <div class="form-group" style="margin: 0; border-bottom: 1px solid #C6D7D1;">
                            <table class="table" style="margin: 0;">
                                <tbody>
                                    <tr>
                                        <td style="border-top: none;">Envío a...</td>
                                        <td style="border-top: none;">
                                            <input class="form-check-input" type="radio" id="radio_todas" @change="tipo_de_envio($event)" v-model="tipo_envio" value="1">
                                            todas las carreras.
                                        </td>
                                        <td style="border-top: none;">
                                            <input class="form-check-input" type="radio" id="radio_una" @change="tipo_de_envio($event)" v-model="tipo_envio" value="0">
                                            solo una carrera.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Carreras</label>
                            <div class="col-md">
                                <!-- Seleccionar carrera -->
                                <div v-if="tipo_envio == 1">
                                    <select class="form-control" v-model="id_carrera">
                                        <option value="1" disabled selected>Todas las carreras</option>
                                    </select>
                                </div>
                                <div v-else-if="tipo_envio == 0">
                                    <select class="form-control" @change="mostrar_turnos_y_grados_carrera($event)" v-model="id_carrera">
                                        <option value="1" disabled selected>Seleccione una carrera</option>
                                        <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                            {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                        </option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <!-- sección de parametros especificos de la carrera seleccionada -->
                        <div class="container-1">
                            <div class="row">
                                <div class="col" style="padding: 0 !important;">
                                    <div class="form-group">
                                        <label class="col-md form-control-label font-weight-bold text-center" for="text-input">Turno</label>
                                        <div class="col-md">
                                            <div v-if="tipo_envio == 1">
                                                <select class="form-control" id="turno">
                                                    <option value="0" disabled selected>Todos los turnos</option>
                                                </select>
                                            </div>
                                            <div v-else-if="tipo_envio == 0">
                                                <div v-if="id_carrera != 0">
                                                    <select class="form-control" v-model="turno" id="turno">
                                                        <option value="0" disabled selected>Seleccione el turno</option>
                                                        <option value="1" v-if="t_matutino==1">Matutino</option>
                                                        <option value="2" v-if="t_vespertino==1">Vespertino</option>
                                                        <option value="3" v-if="t_nocturno==1">Nocturno</option>
                                                        <option value="4" v-if="t_mixto==1">Mixto</option>
                                                    </select>
                                                </div>
                                                <div v-else>
                                                    <select class="form-control" id="turno">
                                                        <option value="0" disabled selected>Seleccione una carrera</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col" style="padding: 0 !important;">
                                    <div class="form-group">
                                        <label class="col-md form-control-label font-weight-bold text-center" for="text-input">Grado</label>
                                        <div class="col-md">
                                            <div v-if="tipo_envio == 1">
                                                <select class="form-control">
                                                    <option value="0" disabled selected>Todos los grados</option>
                                                </select>
                                            </div>
                                            <div v-else-if="tipo_envio == 0">
                                                <div v-if="id_carrera != 0">
                                                    <select class="form-control" v-model="grado">
                                                        <option value="0" disabled selected>Seleccione el grado</option>
                                                        <option v-for="grupo in array_num_grados" :key="grupo.num" :value="grupo.num">
                                                            {{grupo.num}}º
                                                        </option>
                                                    </select>
                                                </div>
                                                <div v-else>
                                                    <select class="form-control" v-model="grado">
                                                        <option value="0" disabled selected>Seleccione una carrera</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fecha programada -->
                        <div class="form-group" style="margin: 0;">
                            <table class="table" style="margin: 0;">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center" style="border-bottom: none;">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                            Envío programado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="border-top: none; padding-right: 0;">
                                            <span class="input-group-addon" style="border-right: none;">Fecha:</span>
                                        </td>
                                        <td class="text-center" style="border-top: none; padding-left: 0;">
                                            <!-- datepicker -->
                                            <div class="input-group date asignar-fecha">
                                                <input type="text" class="form-control">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center" style="border-top: none; padding-right: 0;">
                                            <span class="input-group-addon" style="border-right: none;">Hora:</span>
                                        </td>
                                        <td class="text-center" style="border-top: none; padding-left: 0;">
                                            <!-- datepicker -->

                                            <div class="input-group date asignar-fecha">
                                                <input type="text" class="form-control">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 

                        <div class="form-group" style="margin: 0;">
                            <table class="table" style="margin: 0;">
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="border-top: none;">
                                            <input class="form-check-input" type="radio" id="radio_guardar" value="option1">
                                            Solo guardar.
                                        </td>
                                        <td class="text-center" style="border-top: none;">
                                            <input class="form-check-input" type="radio" id="radio_enviar" value="option2">
                                            Guardar y enviar.
                                        </td>
                                        <td class="text-center" style="border-top: none;">
                                            <input type="submit" class="btn btn-primary" value="Enviar aviso" style="cursor:pointer;">
                                            <!-- <button type="button" class="btn btn-primary" @click="guardar_aviso()">Enviar</button> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>    

                    </div>
                    <!--FIN terjeta DERECHA -->
                </div>
                <!-- fin del div card-group -->
            </form>
            <!-- *************************************************************************************** -->
        
        <!-- div del contenedor -->
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    
</main>
</template>

<script>
    export default {
        data(){
            return{
                //Variables para guardar y actualizar el aviso
                tipo_envio: 0,
                id_carrera: 1,
                turno : 0,
                grado : 0,
                titulo_aviso : '',
                documento: '',
                contenido_aviso : '',
                //Identificadores de apoyo en el select Turno
                t_matutino: 0,
                t_vespertino: 0,
                t_nocturno: 0,
                t_mixto: 0,
                //Arrays para mostrar datos en select
                arrayCarrera : [],
                array_num_grados: [],
                //identificadores de validacion
                errorCarrera: 0,
            }
        },
        methods : {
            obtener_carreras(){//se puede modificar
                //obtener el valor de un <select>
                let me = this;
                var url = '/carrera/selectCarrera';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCarrera = respuesta.carreras;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            mostrar_turnos_y_grados_carrera(event){
                this.turno = 0;
                this.grado = 0;
                this.array_num_grados = [];
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;

                if(event.target.value != 0){
                    var grados = 0;
                    
                    for(var i = 0; i < this.arrayCarrera.length; i++){
                        if(this.arrayCarrera[i]["id"] == this.id_carrera){
                            this.t_matutino = this.arrayCarrera[i]["turno_matutino"];
                            this.t_vespertino = this.arrayCarrera[i]["turno_vespertino"];
                            this.t_nocturno = this.arrayCarrera[i]["turno_nocturno"];
                            this.t_mixto = this.arrayCarrera[i]["turno_mixto"];
                            grados = this.arrayCarrera[i]["num_grados"];
                        }
                    }

                    for(var i = 1; i <= grados; i++){
                        this.array_num_grados.push({num: i})
                    }
                }     
            },
            tipo_de_envio(event){
                this.seleccion_de_envio();
            },
            seleccion_de_envio(){
                if(this.tipo_envio == 1){
                    this.id_carrera = 1;
                    this.turno = 0;
                    this.grado = 0;
                    //Identificadores de apoyo en el select Turno
                    this.t_matutino = 0;
                    this.t_vespertino = 0;
                    this.t_nocturno = 0;
                    this.t_mixto = 0;
                    //Arrays para mostrar datos en select
                    this.arrayCarrera = [];
                    this.array_num_grados = [];
                }
                else if(this.tipo_envio == 0){
                    this.obtener_carreras();
                }
            },
            getDocumento(event){
                let file = event.target.files[0];
                this.documento = file;
            },
            guardar_aviso(){
                // if(this.validarCarrera()){
                //     return;
                // }
                let me = this;
                this.contenido_aviso = document.getElementById('contenido_aviso').value;

                let data = new FormData();
                data.append('id_carrera', this.id_carrera);
                data.append('turno', this.turno);
                data.append('grado', this.grado);
                data.append('titulo', this.titulo_aviso);
                data.append('contenido', this.contenido_aviso);
                data.append('documento', this.documento);
                data.append('general', this.tipo_envio);

                axios.post('/aviso/guardar_aviso', data).then(function (response){//no modificar
                    // always executed
                    //console.log(response.data)
                    me.limpiar_campos();
                }).catch(function (error){
                    console.log(error)
                });
                console.log(this.contenido_aviso)

            },
            limpiar_campos(){
                document.getElementById('contenido_aviso').value = "";
                //Variables para guardar y actualizar el aviso
                //this.tipo_envio = 0;
                this.id_carrera = 1;
                this.turno = 0;
                this.grado = 0;
                this.titulo_aviso = '';
                this.documento = '';
                this.contenido_aviso = '';
                //Identificadores de apoyo en el select Turno
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;
                //Arrays para mostrar datos en select
                this.arrayCarrera = [];
                this.array_num_grados = [];
            },
            validarCarrera(){// se puede modificar, solo los mensajes de validacion
                this.errorCarrera = 0;
                this.errorMostrarMsjCarrera = [];

                if(!this.nombre){
                    this.errorMostrarMsjCarrera.push("El campo nombre de la carrera, no puede estar vacío");
                }

                if(this.errorMostrarMsjCarrera.length){
                    this.errorCarrera = 1;
                }

                return this.errorCarrera;
            }
        },
        mounted() {//no modificar
            this.seleccion_de_envio();

            $('.asignar-fecha').datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                autoclose: true,
                todayHighlight: true
            });

        }
    }
</script>

<style>
    /* no modificar */
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #110f0fc0  !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    button{
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }
    .trix-editor{
        min-height: 217px;
        max-height: 217px !important;   /*#set whatever height you want*/
        overflow-y: auto;
    }
    .izquierda{
        margin: 0 !important;
        border-top: none;
    }
    .derecha{
        margin: 0 !important;
        max-width: 422px !important;
        border-top: none;
        
    }
    /*.container-1{
        border: 1px solid black;
    }*/
</style>
