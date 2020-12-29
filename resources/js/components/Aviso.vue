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
           <!-- División de tarjetas IZQUIERDA Y DERECHA -->
            <div class="card-group">
                <!-- terjeta IZQUIERDA -->
                <div class="card izquierda">
                    <div class="form-group">
                        <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Título del aviso</label>
                        <div class="col-md">
                            <input type="text" v-model="titulo_aviso" class="form-control" placeholder="Ingrese un título a su aviso">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Documento</label>
                        <div class="col-md">
                            <input type="file" class="form-control" placeholder="Seleccione un documento">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Contenido del aviso</label>
                        <div class="col-md">
                            <input type="hidden" id="contenido_aviso"  v-model="contenido_aviso">
                            <trix-editor input="contenido_aviso" class="trix-editor"></trix-editor>
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
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        todas las carreras.
                                    </td>
                                    <td style="border-top: none;">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option2">
                                        solo una carrera.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label class="col-md form-control-label font-weight-bold text-center" for="email-input">Carreras</label>
                        <div class="col-md">
                            <select class="form-control" @change="obtenerPlanEstudio($event)" v-model="carrera">
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="6">Semestral</option>
                                <option value="4">Cuatrimestral</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="container-1">
                        <div class="row">
                            <div class="col" style="padding: 0 !important;">
                                <div class="form-group">
                                    <label class="col-md form-control-label font-weight-bold text-center" for="text-input">Turno</label>
                                    <div class="col-md">
                                        <select class="form-control" v-model="turno">
                                            <option value="0" disabled selected>Seleccione un turno</option>
                                            <option value="1">Matutino</option>
                                            <option value="2">Vespertino</option>
                                            <option value="3">Nocturno</option>
                                            <option value="4">Mixto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col" style="padding: 0 !important;">
                                <div class="form-group">
                                    <label class="col-md form-control-label font-weight-bold text-center" for="text-input">Grado</label>
                                    <div class="col-md">
                                        <select class="form-control" v-model="grado">
                                            <option value="0" disabled selected>Seleccione el grado</option>
                                            <option value="1">1º</option>
                                            <option value="2">2º</option>
                                            <option value="3">3º</option>
                                            <option value="4">4º</option>
                                            <option value="1">5º</option>
                                            <option value="2">6º</option>
                                            <option value="3">7º</option>
                                            <option value="4">8º</option>
                                            <option value="4">9º</option>
                                        </select>
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
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        Solo guardar.
                                    </td>
                                    <td class="text-center" style="border-top: none;">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option2">
                                        Guardar y enviar.
                                    </td>
                                    <td class="text-center" style="border-top: none;">
                                        <button type="button" class="btn btn-primary">Enviar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    

                </div>
                <!--FIN terjeta DERECHA -->
            </div>
           



        <!-- div del contenedor -->
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>



    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <!-- inputs del Modal agregar -->
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la carrera">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Plan de estudios</label>
                            <div class="col-md-9">
                                <select class="form-control" @change="obtenerPlanEstudio($event)" v-model="carrera">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="6">Semestral</option>
                                    <option value="4">Cuatrimestral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Modalidad</label>
                            <div class="col-md-9">
                                <select class="form-control" @change="obtenerModalidad($event)" v-model="tipo_modalidad">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Escolarizado</option>
                                    <option value="2">Semiescolarizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">No. Grados</label>
                            <div class="col-md-9">
                                <input type="text" v-model="titulo_aviso" class="form-control" placeholder="Número de grados que tiene la carrera">
                            </div>
                        </div>
                        <div class="form-group row div-error" v-show="errorCarrera">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCarrera" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <!-- inputs del Modal agregar -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCarrera()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCarrera()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    
</main>
</template>

<script>
    export default {
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                carrera_id : 0,
                nombre : '',
                carrera : '',
                titulo_aviso : '',
                tipo_modalidad : '',
                contenido_aviso : '',
                turno : 0,
                grado : 0,

                //variables para las funciones especificas del componente
                arrayCarrera : [],            
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCarrera : 0,
                errorMostrarMsjCarrera : [],
                pagination:{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed : {
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elementos de la funcion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarCarrera(page, buscar, criterio){
                let me = this;
                var url = '/carrera?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //devuelve lo que regresa el controlador de la url /carrera
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCarrera = respuesta.carreras.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            cambiarPagina(page, buscar, criterio){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarCarrera(page, buscar, criterio);
            },
            obtenerPlanEstudio(event){//se puede modificar
                //obtener el valor de un <select>
                this.carrera = event.target.value;
            },
            obtenerModalidad(event){//se puede modificar
                //obtener el valor de un <select>
                this.tipo_modalidad = event.target.value;
            },
            registrarCarrera(){//se puede modificar, funcion guardar
                if(this.validarCarrera()){
                    return;
                }
                
                let me = this;
                //          url del controlador donde se guarda
                axios.post('/carrera/registrar', {
                    //Clave  :    Valor    (poner las variables tal y como estan en la DB)
                    'nombre' : this.nombre,
                    'carrera' : this.carrera,
                    'titulo_aviso' : this.titulo_aviso,
                    'tipo_modalidad' : this.tipo_modalidad
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarCarrera(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error)
                });
            },
            actualizarCarrera(){//se puede modificar, aqui se actualiza
                if(this.validarCarrera()){
                    return;
                }
                
                let me = this;
                //          url del controlador
                axios.put('/carrera/actualizar', {
                    'nombre' : this.nombre,
                    'carrera' : this.carrera,
                    'titulo_aviso' : this.titulo_aviso,
                    'tipo_modalidad' : this.tipo_modalidad,
                    'id' : this.carrera_id,
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarCarrera(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error)
                });
            },
            activarMatutino(id){// se puede modificar, solo lo que esta en español
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                
                swalWithBootstrapButtons.fire({
                    title: 'Desea activar el turno Matutino?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        //          url del controlador
                        axios.put('/carrera/activar_matutino', {
                            'id' : id
                        }).then(function (response){
                            me.listarCarrera(1, '', 'nombre');  
                            swalWithBootstrapButtons.fire(
                            'Turno Activado!',
                            'El turno ha sido activado con éxito.',
                            'success'
                            )
                        }).catch(function (error){
                            console.log(error)
                        });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                })
            },
            desactivarMatutino(id){//se puede modificar, solo lo que esta en español
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de desactivar el turno Matutino?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        //          url del controlador
                        axios.put('/carrera/desactivar_matutino', {
                            'id' : id
                        }).then(function (response){
                            me.listarCarrera(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                            'Turno Desactivado!',
                            'El turno ha sido desactivada con éxito.',
                            'success'
                            )
                        }).catch(function (error){
                            console.log(error)
                        });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                })
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

            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.tituloModal = '';//no
                this.nombre = '';
                this.carrera = '';
                this.titulo_aviso = '';
                this.tipo_modalidad = '';
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                switch(modelo){
                    case "carrera":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;//no
                                this.tituloModal = 'Registrar Carrera';
                                this.nombre = '';
                                this.carrera = '';
                                this.titulo_aviso = '';
                                this.tipo_modalidad = '';
                                this.tipoAccion = 1;//no
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar carrera';
                                this.tipoAccion = 2;//no
                                this.carrera_id = data['id'];
                                this.nombre = data['nombre'];
                                this.carrera = data['carrera'];
                                this.titulo_aviso = data['titulo_aviso'];
                                this.tipo_modalidad = data['tipo_modalidad'];
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {//no modificar
            this.listarCarrera(1, this.buscar, this.criterio);

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
