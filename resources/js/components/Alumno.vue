<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Alumnos</li>
        <li class="breadcrumb-item active">Tabla de alumnos</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list-ul" aria-hidden="true"></i>Alumnos
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row scroll-busqueda-filtro">
                        <div class="col-md-6 scroll-busqueda-filtro-x">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="id_carrera">Carrera</option>
                                    <option value="tipo_modalidad">Modalida</option>
                                    <option value="matricula">Matrícula</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="correo">Correo</option>
                                    <option value="grado">No. Grado</option>
                                    <option value="turno">Turno</option>
                                    <option value="condicion">Estado</option>
                                </select>
                                <select v-if="criterio==='id_carrera'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una carrera</option>
                                    <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                        {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                    </option>
                                </select>
                                <select v-else-if="criterio==='tipo_modalidad'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Escolarizado</option>
                                    <option value="2">Semiescolarizado</option>
                                </select>
                                <select v-else-if="criterio==='turno'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Matutino</option>
                                    <option value="2">Vespertino</option>
                                    <option value="3">Nocturno</option>
                                    <option value="4">Mixto</option>
                                </select>
                                <select v-else-if="criterio==='condicion'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Desactivado</option>
                                </select>
                                <input v-else type="text" id="buscar" v-model="buscar" @keyup.enter="listarAlumnos(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarAlumnos(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Opciones</th>
                            <th class="text-center">Carrera</th>
                            <th class="text-center">Modalidad</th>
                            <th class="text-center">Matrícula</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Grado</th>
                            <th class="text-center">Turno</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="alumno in arrayAlumnos" :key="alumno.id">
                            <td>
                                <button type="button" @click="abrirModal('alumno', 'actualizar', alumno)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button" @click="abrirModal('alumno', 'eliminar', alumno)" class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <th v-text="alumno.nombre_carrera"></th>
                            <th v-text="alumno.modalidad_carrera"></th>
                            <th v-text="alumno.matricula_alumno"></th>
                            <th v-text="alumno.nombre_alumno"></th>
                            <th v-text="alumno.correo"></th>
                            <th>{{alumno.grado}}º</th>
                            <th>
                                <div v-if="alumno.turno==1">Matutino</div>
                                <div v-else-if="alumno.turno==2">Vespertino</div>
                                <div v-else-if="alumno.turno==3">Nocturno</div>
                                <div v-else-if="alumno.turno==4">Mixto</div>
                            </th>
                            <th>
                                <div v-if="alumno.condicion">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>
                            </th>
                        </tr>
                        <!-- vista de los elementos de la tabla users -->
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
                            <label class="col-md-3 form-control-label" for="email-input">Contraseña (*)</label>
                            <div class="col-md-9">
                                <input type="password" v-model="password" class="form-control" placeholder="Restabelcer la contraseña del alumno">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Correo (*)</label>
                            <div class="col-md-9">
                                <input type="text" id="correo" v-model="correo" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Email del alumno">
                            </div>
                            <msj-validacion v-if="msjValidacion[0].correo==1">{{msjValidacion[0].mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Grado (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" @click="tecleo" id="grado" v-model="grado">
                                    <option value="0" disabled selected>Seleccione el grado</option>
                                    <option v-for="grupo in arrayGrados" :key="grupo.num" :value="grupo.num">
                                        {{grupo.num}}º
                                    </option>
                                </select>
                                <!-- <input type="text" id="grado" v-model="grado" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Grado al que pertenece"> -->
                            </div>
                            <msj-validacion v-if="msjValidacion[1].grado==1">{{msjValidacion[1].mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Turno (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" id="turno" v-model="turno" @click="tecleo">
                                    <option value="0" disabled selected>Seleccione un turno</option>
                                    <option value="1" v-if="t_matutino==1">Matutino</option>
                                    <option value="2" v-if="t_vespertino==1">Vespertino</option>
                                    <option value="3" v-if="t_nocturno==1">Nocturno</option>
                                    <option value="4" v-if="t_mixto==1">Mixto</option>
                                </select>
                            </div>
                            <msj-validacion v-if="msjValidacion[2].turno==1">{{msjValidacion[2].mensaje}}</msj-validacion>
                        </div>
                        <!-- inputs del Modal agregar -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="actualizarAlumno()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!-- Inicio del modal Eliminar -->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal_eliminar}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mensaje-eliminar">¿Estas seguro de eliminar el alumno?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-danger" @click="eliminarAlumno()">Eliminar</button>
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
    import MensajeValidacion from './local-components/MsjValidacion.vue';

    export default {
        components : {
            'msj-validacion' : MensajeValidacion 
        },
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                id_matricula : 0,
                password : '',
                correo : '',
                grado : 0,
                turno : 0,
                arrayAlumnos : [],
                arrayTurnos : [],
                arrayGrados : [],
                t_matutino : 0,
                t_vespertino : 0,
                t_nocturno : 0,
                t_mixto : 0,
                //Variables para busqueda por filtro
                arrayCarrera : [],
                //variables para las funciones especificas del componente
                modal : 0,
                modal_eliminar : 0,
                tituloModal : '',
                tipoAccion : 0,
                //Validación de campos
                numErrors : 0,
                msjValidacion : [
                    {correo : 0, mensaje : ''},
                    {grado : 0, mensaje : ''},
                    {turno : 0, mensaje : ''}
                ],
                colorError : 'border: 2px solid rgba(231, 76, 60, 0.5);',
                colorGood : 'border: 1px solid #BBCDD5;',
                pagination:{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                //Busqueda por filtro
                criterio : 'id_carrera',
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
        watch : {
            criterio : function(opcion){
                if(opcion=='id_carrera')this.buscar = '';
                if(opcion=='tipo_modalidad')this.buscar = '';
                if(opcion=='matricula')this.buscar = '';
                if(opcion=='nombre')this.buscar = '';
                if(opcion=='correo')this.buscar = '';
                if(opcion=='grado')this.buscar = '';
                if(opcion=='turno')this.buscar = '';
                if(opcion=='condicion')this.buscar = '';
            }
        },
        methods : {
            listarAlumnos(page, buscar, criterio){
                let me = this;
                var url = '/alumno?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //devuelve lo que regresa el controlador de la url /user
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAlumnos = respuesta.alumnos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                    me.limpiarTextBuscar();
                });
            },
            cambiarPagina(page, buscar, criterio){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarAlumnos(page, buscar, criterio);
            },
            limpiarTextBuscar(){
                $('#buscar').val('');
                this.buscar = '';
            },
            seleccionarCarrera(){//se puede modificar
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
            seleccionarTurno(id_alumno){//se puede modificar
                //obtener el valor de un <select>
                let me = this;
                var url = '/alumno/listarTurnos?id_alumno='+id_alumno;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTurnos = respuesta.turnos;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                    me.obtenerTuplaTurnos();
                });
            },
            obtenerTuplaTurnos(){
                this.t_matutino = this.arrayTurnos["0"]["turno_matutino"];
                this.t_vespertino = this.arrayTurnos["0"]["turno_vespertino"];
                this.t_nocturno = this.arrayTurnos["0"]["turno_nocturno"];
                this.t_mixto = this.arrayTurnos["0"]["turno_mixto"];
            },
            listarGrados(numGrados){
                for(var i = 1; i <= numGrados; i++){
                    this.arrayGrados.push({num: i})
                }
            },
            actualizarAlumno(){//se puede modificar, aqui se actualiza
                if(this.validarAlumno()){
                    return;
                }
                
                let me = this;
                //          url del controlador
                axios.put('/alumno/actualizar', {
                    'id_matricula' : this.id_matricula,
                    'password' : this.password,
                    'correo' : this.correo,
                    'grado' : this.grado,
                    'turno' : this.turno
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarAlumnos(1, '', 'correo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            eliminarAlumno(){

                let me = this;

                axios.delete('/alumno/eliminar', {
                    params : {
                        id_alumno : this.id_matricula
                    }
                }).then(function (response){
                    me.cerrarModal();
                    me.listarAlumnos(1, '', 'correo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            validarAlumno(){// se puede modificar, solo los mensajes de validacion
                this.numErrors = 0;

                var validarEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                if(!this.correo){
                    this.numErrors = 1;
                    document.getElementById('correo').style.cssText = this.colorError;
                    this.msjValidacion[0].correo = 1;
                    this.msjValidacion[0].mensaje = "El campo correo no puede estar vacío";
                }else if(validarEmail.test(this.correo)==false){
                    this.numErrors = 1;
                    document.getElementById('correo').style.cssText = this.colorError;
                    this.msjValidacion[0].correo = 1;
                    this.msjValidacion[0].mensaje = "El correo no esta bien escrito";
                }else{
                    this.msjValidacion[0].mensaje = "";
                    document.getElementById('correo').style.cssText = this.colorGood;
                }

                if(this.grado==0){
                    this.numErrors = 1;
                    document.getElementById('grado').style.cssText = this.colorError;
                    this.msjValidacion[1].grado = 1;
                    this.msjValidacion[1].mensaje = "No dejar vacío el campo No. Grado";
                }else{
                    this.msjValidacion[1].mensaje = "";
                    document.getElementById('grado').style.cssText = this.colorGood;
                }

                if(this.turno==0){
                    this.numErrors = 1;
                    document.getElementById('turno').style.cssText = this.colorError;
                    this.msjValidacion[2].turno = 1;
                    this.msjValidacion[2].mensaje = "Seleccione un turno";
                }else{
                    this.msjValidacion[2].mensaje = "";
                    document.getElementById('turno').style.cssText = this.colorGood;
                }

                return this.numErrors;
            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.modal_eliminar = 0;//no
                this.tituloModal = '';//no
                this.id_matricula = 0;
                this.password = '';
                this.correo = ''; document.getElementById('correo').style.cssText = this.colorGood;
                this.grado = 0; document.getElementById('grado').style.cssText = this.colorGood;
                this.turno = 0; document.getElementById('turno').style.cssText = this.colorGood;

                this.numErrors = 0;
                this.msjValidacion = [
                    {correo : 0, mensaje : ''},
                    {grado : 0, mensaje : ''},
                    {turno : 0, mensaje : ''}
                ];
                //Numero de grados de la carrera asignada
                this.arrayGrados = [];
                //variables de seleccion de turno
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;
                //arreglo para el filtro por busqueda
                this.arrayCarrera = [];
                this.seleccionarCarrera();
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                switch(modelo){
                    case "alumno":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar Alumno';
                                this.id_matricula = data['id_matricula'];
                                this.password = data['password'];
                                this.correo = data['correo'];
                                this.grado = data['grado'];
                                this.turno = data['turno'];
                                this.tipoAccion = 1;//no
                                this.listarGrados(data['num_grados']);
                                this.seleccionarTurno(this.id_matricula);
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal_eliminar = 1;
                                this.tituloModal = 'Eliminar Alumno';
                                this.id_matricula = data['id_matricula'];
                                break;
                            }
                        }

                    }
                }

            },
            tecleo : function (){
                if(this.numErrors==1){
                    this.numErrors = this.validarAlumno();
                }
            }
        },
        mounted() {//no modificar
            this.listarAlumnos(1, this.buscar, this.criterio);
            this.seleccionarCarrera();
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
