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
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Carreras
                <button type="button" @click="abrirModal('carrera', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Carrera</option>
                                <option value="num_grados">No. Grados</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarCarrera(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarCarrera(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Carrera</th>
                            <th>Plan de estudio</th>
                            <th>Modalidad</th>
                            <th>No. Grados</th>
                            <th>Matutino</th>
                            <th>Vespertino</th>
                            <th>Nocturno</th>
                            <th>Mixto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla Carreras -->
                        <tr v-for="carrera in arrayCarrera" :key="carrera.id">
                            <td>
                                <button type="button" @click="abrirModal('carrera', 'actualizar', carrera)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEliminar">
                                    <i class="icon-trash"></i>
                                </button> -->
                            </td>
                            <th v-text="carrera.nombre"></th>
                            <th>
                                <div v-if="carrera.tipo_plan==6">
                                    Semestral
                                </div>
                                <div v-if="carrera.tipo_plan==4">
                                    Cuatrimestral
                                </div>
                            </th>
                            <th>
                                <div v-if="carrera.tipo_modalidad==1">
                                    Escolarizado
                                </div>
                                <div v-if="carrera.tipo_modalidad==2">
                                    Semiescolarizado
                                </div>
                            </th>
                            <th v-text="carrera.num_grados"></th>
                            <th>
                                <div v-if="carrera.turno_matutino">
                                    <button type="button" class="badge badge-success" id="btn-activo" @click=" desactivarMatutino(carrera.id)">
                                        Activo
                                    </button>
                                </div>
                                <div v-else>
                                    <button type="button" class="badge badge-danger" @click=" activarMatutino(carrera.id)">
                                        Desactivado
                                    </button>
                                </div>
                            </th>
                            <th>
                                <div v-if="carrera.turno_vespertino">
                                    <button type="button" class="badge badge-success" id="btn-activo" @click=" desactivarVespertino(carrera.id)">
                                        Activo
                                    </button>
                                </div>
                                <div v-else>
                                    <button type="button" class="badge badge-danger" @click=" activarVespertino(carrera.id)">
                                        Desactivado
                                    </button>
                                </div>
                            </th>
                            <th>
                                <div v-if="carrera.turno_nocturno">
                                    <button type="button" class="badge badge-success" id="btn-activo" @click=" desactivarNocturno(carrera.id)">
                                        Activo
                                    </button>
                                </div>
                                <div v-else>
                                    <button type="button" class="badge badge-danger" @click=" activarNocturno(carrera.id)">
                                        Desactivado
                                    </button>
                                </div>
                            </th>
                            <th>
                                <div v-if="carrera.turno_mixto">
                                    <button type="button" class="badge badge-success" id="btn-activo" @click=" desactivarMixto(carrera.id)">
                                        Activo
                                    </button>
                                </div>
                                <div v-else>
                                    <button type="button" class="badge badge-danger" @click=" activarMixto(carrera.id)">
                                        Desactivado
                                    </button>
                                </div>
                            </th>
                        </tr>
                        <!-- vista de los elementos de la tabla Carreras -->
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
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
                                <select class="form-control" @change="obtenerPlanEstudio($event)" v-model="tipo_plan">
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
                                <input type="text" v-model="num_grados" class="form-control" placeholder="Número de grados que tiene la carrera">
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
    <!-- Inicio del modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Carrera</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estas seguro de eliminar la carrera?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
    
</main>
</template>

<script>
    export default {
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                carrera_id : 0,
                nombre : '',
                tipo_plan : '',
                num_grados : '',
                tipo_modalidad : '',

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
                this.tipo_plan = event.target.value;
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
                    'tipo_plan' : this.tipo_plan,
                    'num_grados' : this.num_grados,
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
                    'tipo_plan' : this.tipo_plan,
                    'num_grados' : this.num_grados,
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
            activarVespertino(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Desea activar el turno Vespertino?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/activar_vespertino', {
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
            desactivarVespertino(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de desactivar el turno Vespertino?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/desactivar_vespertino', {
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
            activarNocturno(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Desea activar el turno Nocturno?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/activar_nocturno', {
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
            desactivarNocturno(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de desactivar el turno Nocturno?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/desactivar_nocturno', {
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
            activarMixto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Desea activar el turno Mixto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/activar_turno_mixto', {
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
            desactivarMixto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de desactivar el turno Mixto?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        axios.put('/carrera/desactivar_turno_mixto', {
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
                this.tipo_plan = '';
                this.num_grados = '';
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
                                this.tipo_plan = '';
                                this.num_grados = '';
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
                                this.tipo_plan = data['tipo_plan'];
                                this.num_grados = data['num_grados'];
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
</style>
