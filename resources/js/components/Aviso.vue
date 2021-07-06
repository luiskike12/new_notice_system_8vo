<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Avisos</li>
        <li class="breadcrumb-item active">Crear avisos</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card" style="min-height: 426px;"> 
            <!-- div del contenedor -->
            <div class="card-header">
                <i class="icon-note"></i>Crear Aviso
            </div>

            <!--******************************************************************************* -->
            <form @submit.prevent="guardar_o_enviar_aviso" enctype="multipart/form-data" class="form-horizontal">

                <!-- División de tarjetas IZQUIERDA Y DERECHA -->
                <div class="card-group">
                    <!-- terjeta IZQUIERDA -->
                    <div class="card card-izquierda scroll-card-izquierda">

                            <div class="form-group">
                                <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Título del aviso</label>
                                <div class="col-md">
                                    <input type="text" id="titulo_aviso" v-model="titulo_aviso" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Ingrese el título del aviso">
                                </div>
                                <msj-validacion v-if="msjValidacion[0].titulo_aviso==1">{{msjValidacion[0].mensaje}}</msj-validacion>
                            </div>
                            <div class="form-group">
                                <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Archivo</label>
                                <div class="col-md">
                                    <input type="file" id="campoDocumento" class="form-control" @change="getDocumento" placeholder="Seleccione un documento">
                                </div>
                                <msj-validacion v-if="msjValidacionDocumento">{{msjValidacionDocumento}}</msj-validacion>
                            </div>
                            <!-- mostrar la imagen seleccionada -->
                            <div class="form-group text-center">
                                <div v-if="imagenSeleccionada">
                                    <div class="col-md">
                                        <img :src="imagen" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md">
                                        <button class="btn btn-secondary" @click="eliminarImagen" style="margin-top:10px;">Eliminar imagen</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Contenido del aviso</label>
                                <div class="col-md">
                                    <input type="hidden" id="contenido_aviso">
                                    <trix-editor input="contenido_aviso" id="contenido_del_aviso" @keypress="tecleo" @keyup.delete="tecleo" class="trix-editor"></trix-editor>
                                </div>
                                <msj-validacion v-if="msjValidacion[1].contenido_aviso==1">{{msjValidacion[1].mensaje}}</msj-validacion>
                            </div>
                      
                    <!--FIN terjeta IZQUIERDA -->
                    </div>
                    

                    <!--terjeta DERECHA -->
                    <div class="card card-derecha">
                        <div class="card-body">

                            <div class="form-group" style="border-bottom: 1px solid #C6D7D1;">
                                <table class="table" style="margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td style="border-top: none;">Envío a...</td>
                                            <td style="border-top: none;">
                                                <input class="form-check-input" type="radio" id="radio_todas" v-bind:disabled="rolUsuario == false"
                                                @change="tipo_de_envio($event)" v-model="tipo_envio" value="1">
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
                                <label class="col-md-12 form-control-label font-weight-bold text-center" for="email-input">Carreras</label>
                                <div class="col-md-12 select-carrera">
                                    <!-- Seleccionar carrera -->
                                    <div v-if="tipo_envio == 1">
                                        <select class="form-control" v-model="id_carrera">
                                            <option value="1" disabled selected>Todas las carreras</option>
                                        </select>
                                    </div>
                                    <div v-else-if="tipo_envio == 0">
                                        <select class="form-control" @click="tecleo" id="id_carrera" @change="mostrar_turnos_y_grados_carrera($event)" v-model="id_carrera">
                                            <option value="1" disabled selected>Seleccione una carrera</option>
                                            <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                                {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <msj-validacion v-if="msjValidacion[2].id_carrera==1">{{msjValidacion[2].mensaje}}</msj-validacion>
                            </div>

                            <!-- sección de parametros especificos de la carrera seleccionada -->
                            <div class="form-group" style="border-bottom: 1px solid #C6D7D1;">
                                <div class="row">
                                    <div class="col-6" style="padding: 0 !important;">
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
                                                        <select class="form-control" @click="tecleo" id="grado" v-model="grado">
                                                            <option value="" disabled selected>Seleccione el grado</option>
                                                            <option v-for="grupo in array_num_grados" :key="grupo.num" :value="grupo.num">
                                                                <div v-if="grupo.num===0">
                                                                    General
                                                                </div>
                                                                <div v-else>
                                                                    {{grupo.num}}º
                                                                </div>
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div v-else>
                                                        <select class="form-control" id="grado" v-model="grado">
                                                            <option value="0" disabled selected>Seleccione una carrera</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <msj-validacion v-if="msjValidacion[4].grado==1">{{msjValidacion[4].mensaje}}</msj-validacion>
                                        </div>
                                    </div>
                                    <div class="col-6" style="padding: 0 !important;">
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
                                                        <select class="form-control" @click="tecleo" id="turno" v-model="turno">
                                                            <option value="" disabled selected>Seleccione el turno</option>
                                                            <option value="0" v-if="id_carrera > 2">General</option>
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
                                            <msj-validacion v-if="msjValidacion[3].turno==1">{{msjValidacion[3].mensaje}}</msj-validacion>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fecha programada -->
                            <!-- <div class="form-group" style="margin: 0;">
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
                                                -- datepicker --
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
                                                -- datepicker --
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
                            </div> -->
                            
                            <!-- Sección de enviar el avios -->
                            <div class="form-group" style="border-bottom: 1px solid #C6D7D1;">
                                <div class="row">
                                    <div class="col-md-6 text-center" style="margin-bottom: 16px;">
                                        <input class="form-check-input" type="radio" id="radio_guardar" v-model="guardar_enviar" value="0">
                                        Solo guardar.
                                    </div>
                                    <div class="col-md-6 text-center" style="margin-bottom: 16px;">
                                        <input class="form-check-input" type="radio" id="radio_enviar" v-model="guardar_enviar" value="1">
                                        Guardar y enviar.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md text-center">
                                    <input v-if="guardar_enviar==0" type="submit" class="btn btn-secondary" value="Guardar aviso" style="cursor:pointer;">
                                    <input v-else-if="guardar_enviar==1" type="submit" class="btn btn-primary" value="Enviar aviso" style="cursor:pointer;">
                                </div>
                            </div>
                        <!-- Fin del card-body DERECHA-->
                        </div>  
                    <!--FIN terjeta DERECHA -->
                    </div>
                <!-- fin del div card-group -->
                </div>
            </form>
            <!-- *************************************************************************************** -->
        
        <!-- div del contenedor -->
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    
</main>
</template>

<script>
    import MensajeValidacion from './local-components/ValidacionAviso.vue';
    
    export default {
        components : {
            'msj-validacion' : MensajeValidacion 
        },
        data(){
            return{
                //Variables para guardar y actualizar el aviso
                tipo_envio: 0,
                id_carrera: 1,
                grado : '',
                turno : '',
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
                //variable para mostrar imagen seleccionada
                imagenSeleccionada : '',
                //identificadores de validacion
                errorCarrera: 0,
                //seleccion de guardar o enviar el aviso
                guardar_enviar: 1,
                //Validación de campos
                numErrors : 0,
                msjValidacion : [
                    {titulo_aviso : 0, mensaje : ''},
                    {contenido_aviso : 0, mensaje : ''},
                    {id_carrera : 0, mensaje : ''},
                    {turno : 0, mensaje : ''},
                    {grado : 0, mensaje : ''}
                ],
                msjValidacionDocumento : '',
                colorError : 'border: 2px solid rgba(231, 76, 60, 0.5);',
                colorGood : 'border: 1px solid #BBCDD5;',
                //Habilitar o desabilitar campos
                rolUsuario : false,
            }
        },
        computed : {
            imagen(){//muestra la imagen seleccionada
                return this.imagenSeleccionada;
            }
        },
        methods : {
            rol_de_usuario(){
                let me = this;
                axios.get('/perfil/rolUsuario')
                .then(function (response) {
                    var respuesta = response.data;
                    me.rolUsuario = respuesta.rolUsuario;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
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
                this.grado = '';
                this.turno = '';
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

                    for(var i = 0; i <= grados; i++){
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
                    this.turno = '';
                    this.grado = '';
                    //Identificadores de apoyo en el select Turno
                    this.t_matutino = 0;
                    this.t_vespertino = 0;
                    this.t_nocturno = 0;
                    this.t_mixto = 0;
                    //Arrays para mostrar datos en select
                    this.arrayCarrera = [];
                    this.array_num_grados = [];
                    //Limpiar validacion
                    this.msjValidacion[2].mensaje = "";
                    document.getElementById('id_carrera').style.cssText = this.colorGood;
                    this.msjValidacion[3].mensaje = "";
                    document.getElementById('turno').style.cssText = this.colorGood;
                    this.msjValidacion[4].mensaje = "";
                    document.getElementById('grado').style.cssText = this.colorGood;
                }
                else if(this.tipo_envio == 0){
                    this.obtener_carreras();
                }
            },
            getDocumento(event){
                let file = event.target.files[0];

                var campoDocumento = document.getElementById('campoDocumento');
                
                if (!window.FileReader){
                    campoDocumento.style.cssText = this.colorError;
                    this.msjValidacionDocumento = "El navegador no soporta la lectura de archivos";
                    campoDocumento.value = "";
                    return;
                }else{
                    if (!(/\.(jpg|png|gif)$/i).test(file.name)){
                        campoDocumento.style.cssText = this.colorError;
                        this.msjValidacionDocumento = "El archivo a adjuntar debe ser una imagen (jpg, png, gif)";
                        campoDocumento.value = "";
                    }
                    else if (file.size > 200000){
                        campoDocumento.style.cssText = this.colorError;
                        this.msjValidacionDocumento = "El peso mínimo requerido de la imagen es de 200kb";
                        campoDocumento.value = "";
                    }
                    else{    
                        campoDocumento.style.cssText = this.colorGood;
                        this.msjValidacionDocumento = "";
                        this.documento = file;
                        this.cargarImagen(file);
                    }
                }
            },
            cargarImagen(file){//Mostrarle al usuario la imagen que eligio
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagenSeleccionada = e.target.result;
                }
                reader.readAsDataURL(file);
            },
            eliminarImagen(){
                this.documento = '';
                this.imagenSeleccionada = '';
                var campoDocumento = document.getElementById('campoDocumento');
                campoDocumento.value = '';
            },
            guardar_o_enviar_aviso(){
                if(this.validarAviso()){
                    return;
                }

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
                data.append('estado', this.guardar_enviar);
                let conf = {headers: {'Content-Type': 'multipart/form-data' }};

                if(this.guardar_enviar == 0){
                    axios.post('/aviso/guardar_aviso', data, conf).then(function (response){//no modificar
                        // always executed
                        me.limpiar_campos();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Genial...!',
                            text: 'Se ha guardado correctamente'
                        })
                    }).catch(function (error){
                        Swal.fire({
                            icon: 'error',
                            title: '¡Ups...!',
                            text: 'Algo salio mal'
                        })
                        console.log(error)
                    });
                }else if(this.guardar_enviar == 1){
                    axios.post('/aviso/guardar_y_enviar_aviso', data, conf).then(function (response){//no modificar
                        // always executed
                        me.limpiar_campos();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Genial...!',
                            text: 'Se ha enviado correctamente'
                        })
                    }).catch(function (error){
                        Swal.fire({
                            icon: 'error',
                            title: '¡Ups...!',
                            text: 'Algo salio mal'
                        })
                        console.log(error)
                    });
                }

            },
            limpiar_campos(){
                var campoDocumento = document.getElementById('campoDocumento');
                campoDocumento.value = '';

                var element = document.querySelector("trix-editor");
                //atajo para restablecer trix-editor
                element.value = "";
                //Variables para guardar y actualizar el aviso
                //this.tipo_envio = 0;
                this.id_carrera = 1; 
                this.turno = ''; 
                this.grado = ''; 
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
                //guardar o enviar aviso
                this.guardar_enviar = 1;
                //Validacion
                this.numErrors = 0;
                this.msjValidacion = [
                    {titulo_aviso : 0, mensaje : ''},
                    {contenido_aviso : 0, mensaje : ''},
                    {id_carrera : 0, mensaje : ''},
                    {turno : 0, mensaje : ''},
                    {grado : 0, mensaje : ''}
                ];
                //variable para mostrar imagen seleccionada
                this.imagenSeleccionada = '';
                //Recargar carreras a seleccionar
                this.obtener_carreras();
            },
            validarAviso(){// se puede modificar, solo los mensajes de validacion
                this.numErrors = 0;

                if(!this.titulo_aviso){
                    this.numErrors = 1;
                    document.getElementById('titulo_aviso').style.cssText = this.colorError;
                    this.msjValidacion[0].titulo_aviso = 1;
                    this.msjValidacion[0].mensaje = "No puede estar vacío el título del aviso";
                }else{
                    this.msjValidacion[0].mensaje = "";
                    document.getElementById('titulo_aviso').style.cssText = this.colorGood;
                }

                this.contenido_aviso = document.getElementById('contenido_aviso').value;
                if(!this.contenido_aviso){
                    this.numErrors = 1;
                    document.getElementById('contenido_del_aviso').style.cssText = this.colorError;
                    this.msjValidacion[1].contenido_aviso = 1;
                    this.msjValidacion[1].mensaje = "No puede estar vacío el contenido del aviso";
                }else{
                    this.msjValidacion[1].mensaje = "";
                    document.getElementById('contenido_del_aviso').style.cssText = this.colorGood;
                }

                if(this.tipo_envio==0){
                    if(this.id_carrera==1){
                        this.numErrors = 1;
                        document.getElementById('id_carrera').style.cssText = this.colorError;
                        this.msjValidacion[2].id_carrera = 1;
                        this.msjValidacion[2].mensaje = "Seleccione una carrera";
                    }else{
                        this.msjValidacion[2].mensaje = "";
                        document.getElementById('id_carrera').style.cssText = this.colorGood;
                    }

                    if(this.turno === ''){
                        this.numErrors = 1;
                        document.getElementById('turno').style.cssText = this.colorError;
                        this.msjValidacion[3].turno = 1;
                        this.msjValidacion[3].mensaje = "Seleccione un turno";
                    }else{
                        this.msjValidacion[3].mensaje = "";
                        document.getElementById('turno').style.cssText = this.colorGood;
                    }

                    if(this.grado === ''){
                        this.numErrors = 1;
                        document.getElementById('grado').style.cssText = this.colorError;
                        this.msjValidacion[4].grado = 1;
                        this.msjValidacion[4].mensaje = "Seleccione el grado";
                    }else{
                        this.msjValidacion[4].mensaje = "";
                        document.getElementById('grado').style.cssText = this.colorGood;
                    }
                }

                return this.numErrors;
            },
            tecleo : function (){
                if(this.numErrors==1){
                    this.numErrors = this.validarAviso();
                }
            }
        },
        mounted() {//no modificar
            this.rol_de_usuario();
            this.seleccion_de_envio();
            
            // $('.asignar-fecha').datepicker({
            //     format: "dd/mm/yyyy",
            //     language: "es",
            //     autoclose: true,
            //     todayHighlight: true
            // });

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
    /* TRIX-EDITOR  */ 
    .trix-editor{
        min-height: 217px;
        max-height: 217px !important;   /*#set whatever height you want*/
        overflow-y: auto;
    }
    /*  No mostrar el boton de seleccionar archivo  en trix-editor*/
    trix-toolbar .trix-button-group--file-tools{
        display: none;
    }

    /*  Posisionamiento de los cards */
    .card-izquierda{
        margin: 0 !important;
        border-top: none;
    }
    .scroll-card-izquierda{
        max-height: 510px;
        overflow-y: auto;
    }
    .card-derecha{
        margin: 0 !important;
        max-width: 422px !important;
        border-top: none;
        
    }
    .card-derecha .card-body{
        padding: 18px !important;
    }
    .select-carrera{
        padding: 0;
    }
</style>
