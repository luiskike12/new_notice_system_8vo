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
                <i class="fa fa-align-justify"></i> PRUEBAS Registro del alumno
                <button type="button" @click="abrirModal('alumno', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Registrarse
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <!-- <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="matricula">Matrícula</option>
                                <option value="nombre">Nombre</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarMatriculas(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarMatriculas(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div> -->
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Carrera</th>
                            <th>Modalidad</th>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Grado</th>
                            <th>Turno</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="alumno in arrayAlumnos" :key="alumno.id">
                            <td>
                                <button type="button" @click="abrirModal('alumno', 'actualizar', alumno)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button>
                            </td>
                            <th v-text="alumno.nombre_carrera"></th>
                            <th v-text="alumno.modalidad_carrera"></th>
                            <th v-text="alumno.matricula_alumno"></th>
                            <th v-text="alumno.nombre_alumno"></th>
                            <th v-text="alumno.correo"></th>
                            <th v-text="alumno.grado"></th>
                            <th v-text="alumno.turno"></th>
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
                    <form action="" method="post" enctype="multipart/form-data" class="form-inline">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Matrícula (*)
                                <span v-if="id_matricula!=0" class="badge badge-success">
                                    <i class="fa fa-check"></i>
                                </span>
                            </label>
                            
                            <div class="col-md-9">
                                <input type="text" v-model="matricula" class="form-control" placeholder="Ingrese su matrícula">
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-success btn-sm" @click="verificarMatricula()">Confirmar Matrícula</button>
                        
                        <!-- <span v-else class="badge badge-danger">
                            <i class="fa fa-times"></i>
                        </span> -->
                    </form>
                    
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <!-- inputs del Modal agregar -->
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">ID del dispositivo</label>
                            <div class="col-md-9">
                                <input type="text" v-model="id_dispositivo" id="id_dispositivo" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Contraseña (*)</label>
                            <div class="col-md-9">
                                <input type="password" v-model="password" id="password" class="form-control" placeholder="Ingrese una contraseña" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Correo (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="correo" id="correo" class="form-control" placeholder="Ingrese su correo electrónico" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Grado (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="grado" id="grado" class="form-control" placeholder="Grado al que pertenece" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Turno (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="turno" id="turno" disabled>
                                    <option value="0" disabled selected>Seleccione un turno</option>
                                    <option value="1" v-if="t_matutino==1">Matutino</option>
                                    <option value="2" v-if="t_vespertino==1">Vespertino</option>
                                    <option value="3" v-if="t_nocturno==1">Nocturno</option>
                                    <option value="4" v-if="t_mixto==1">Mixto</option>
                                </select>
                            </div>
                        </div>
                        <!-- mostrar los errores de la validadción -->
                        <div class="form-group row div-error" v-show="errorUsers">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjUser" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <!-- inputs del Modal agregar -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" id="guardar" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAlumno()" disabled>Guardar</button>
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
                id_matricula : 0,
                id_dispositivo : 0,
                password : '',
                correo : '',
                grado : 0,
                turno : 0,
                arrayAlumnos : [],
                arrayMatricula : [],
                t_matutino : 0,
                t_vespertino : 0,
                t_nocturno : 0,
                t_mixto : 0,

                //variable para verificar matricula
                matricula : '',

                //variables para las funciones especificas del componente
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsers : 0,
                errorMostrarMsjUser : [],
                pagination:{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'matricula',
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
            listarMatriculas(page, buscar, criterio){
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
                });
            },
            cambiarPagina(page, buscar, criterio){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarMatriculas(page, buscar, criterio);
            },
            verificarMatricula(){
                //confirmar la matricula y obtener el id_matricula
                let me = this;
                var url = '/alumno/confirmar_matricula?matricula='+me.matricula;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayMatricula = respuesta.elementos_alumno;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                    me.id_matricula = 0;
                    me.t_matutino  = 0;
                    me.t_vespertino = 0;
                    me.t_nocturno = 0;
                    me.t_mixto = 0;
                    if(me.arrayMatricula["0"]!=null){
                        me.obtener_ID_matricula_Turnos();
                    }else{
                        me.id_matricula = 0;
                        me.password = '';
                        me.correo = '';
                        me.grado = 0;
                        me.turno = 0;
                        $( '#password' ).prop( "disabled", true );
                        $( '#correo' ).prop( "disabled", true );
                        $( '#grado' ).prop( "disabled", true );
                        $( '#turno' ).prop( "disabled", true );
                        $( '#guardar' ).prop( "disabled", true );
                    }
                });
            },
            obtener_ID_matricula_Turnos(){
                $( '#id_dispositivo' ).prop( "disabled", false );
                $( '#password' ).prop( "disabled", false );
                $( '#correo' ).prop( "disabled", false );
                $( '#grado' ).prop( "disabled", false );
                $( '#turno' ).prop( "disabled", false );
                $( '#guardar' ).prop( "disabled", false );
                this.id_matricula = this.arrayMatricula["0"]["id"];
                this.t_matutino = this.arrayMatricula["0"]["turno_matutino"];
                this.t_vespertino = this.arrayMatricula["0"]["turno_vespertino"];
                this.t_nocturno = this.arrayMatricula["0"]["turno_nocturno"];
                this.t_mixto = this.arrayMatricula["0"]["turno_mixto"];
            },
            registrarAlumno(){//se puede modificar, funcion guardar
                if(this.validarMatricula()){
                    return;
                }
                
                
                console.log("id_matricula: "+this.id_matricula)
                console.log("id_dispositivo: "+this.id_dispositivo)
                console.log("password: "+this.password)
                console.log("correo: "+this.correo)
                console.log("grado: "+this.grado)
                console.log("turno: "+this.turno)
                
                let me = this;
                axios.post('/alumno/registrar', {
                    'id_matricula' : this.id_matricula,
                    'id_dispositivo' : this.id_dispositivo,
                    'password' : this.password,
                    'correo' : this.correo,
                    'grado' : this.grado,
                    'turno' : this.turno
                }).then(function (response){
                    me.cerrarModal();
                    me.listarMatriculas(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error)
                });
            },
            validarMatricula(){// se puede modificar, solo los mensajes de validacion
                this.errorUsers = 0;
                this.errorMostrarMsjUser = [];

                if(!this.password){
                    this.errorMostrarMsjUser.push("El password no puede estra vacio");
                }
                if(!this.correo){
                    this.errorMostrarMsjUser.push("El campo correo, no puede estar vacío");
                }
                if(this.grado==0){
                    this.errorMostrarMsjUser.push("El campo grado, no puede estar vacío");
                }
                if(this.turno==0){
                    this.errorMostrarMsjUser.push("Seleccione un turno");
                }
                
                if(this.errorMostrarMsjUser.length){
                    this.errorUsers = 1;
                }

                return this.errorUsers;

            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.tituloModal = '';//no
                this.id_matricula = 0;
                this.id_dispositivo = 0;
                this.password = '';
                this.correo = '';
                this.grado = 0;
                this.turno = 0;
                //variables de seleccion de turno
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;
                //verificar matricula
                this.matricula = '';
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                switch(modelo){
                    case "alumno":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;//no
                                this.tituloModal = 'Registrar Alumno Test';
                                this.id_matricula = 0;
                                this.id_dispositivo = 0;
                                this.password = '';
                                this.correo = '';
                                this.grado = 0;
                                this.turno = 0;
                                //verificar matricula
                                this.matricula = '';
                                this.tipoAccion = 1;//no
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {//no modificar
            this.listarMatriculas(1, this.buscar, this.criterio);
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
