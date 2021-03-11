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
                <i class="fa fa-align-justify"></i> Avisos
                <!-- <button type="button" @click="abrirModal('matricula', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button> -->
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="titulo">Título</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarAvisos(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarAvisos(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Carrera</th>
                            <th>Turno</th>
                            <th>Grado</th>
                            <th>Titulo</th>
                            <th>Contenido</th>
                            <!-- <th>Documento</th> -->
                            <th>Reenvio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="aviso in arrayAvisos" :key="aviso.id">
                            <td>
                                <button type="button" @click="abrirModal('aviso', 'actualizar', aviso)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button" @click="abrirModal('aviso', 'eliminar', aviso)"  class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <th v-text="aviso.nombre_carrera"></th>
                            <th v-text="aviso.turno"> </th>
                            <th>
                                <div v-if="aviso.grado == 'General'">
                                    {{aviso.grado}}
                                </div>
                                <div v-else>
                                    {{aviso.grado}}º
                                </div>
                            </th>
                            <th v-text="aviso.titulo"></th>
                            <th>
                                <button type="button" @click="abrirModal('aviso', 'contenido', aviso)"  class="btn btn-success btn-sm">
                                    Ver
                                </button>
                            </th>
                            <!-- <th v-text="aviso.url_documento"></th> -->
                            <th>
                                <span class="badge badge-primary">Reenviar</span>
                                <!-- <button type="button" class="badge badge-success">Reenviar</button> -->
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
                            <label class="col-md-3 form-control-label" for="text-input">Carrera (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="id_carrera">
                                    <option value="0" disabled selected>Seleccione una carrera</option>
                                    <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                        {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Lista de matrículas(*)</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="num_lista">
                                    <option value="0" disabled selected>Seleccione la lista para agrupar las matrículas</option>
                                    <option v-for="lista in arrayListas" :key="lista.id" :value="lista.id">
                                        {{lista.id}} - Lista (Matrículas) 
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Matrícula (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="matricula" class="form-control" placeholder="Matrícula del alumno">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Nombre (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del alumno">
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
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarMatricula()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarMatricula()">Actualizar</button>
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
                    <p>Estas seguro de eliminar este aviso?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-danger" @click="eliminarMatricula()">Eliminar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->


    <!-- Inicio del modal Contenido del aviso -->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal_contenido}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
               <!-- contenido del aviso -->
                <div class="modal-body">
                    <div class="form-group">
                        <h4 v-text="titulo_aviso" style="text-align:center"></h4>
                    </div>
                    <div class="form-group">
                        <div v-html="contenido_aviso"></div>
                    </div>
                    <div class="form-group">
                        <img :src="'storage/' + documento" style="width: 250px; height: 250px; display:block; margin:auto;">
                    </div>
                </div>
                <!-- Fin contenido del aviso -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Contenido del aviso -->

    
</main>
</template>

<script>
    export default {
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                id_aviso: 0,
                titulo_aviso: '',
                contenido_aviso: '',
                documento: '',


                id_matricula : 0,
                id_carrera : 0,
                num_lista : 0,
                matricula : '',
                nombre : '',
                arrayAvisos : [],
                arrayCarrera : [],
                arrayListas : [{id:1},{id:2},{id:3},{id:4},{id:5},{id:6},{id:7},{id:8},
                {id:9},{id:10},{id:11},{id:12}],
                

                //variables para las funciones especificas del componente
                modal : 0,
                modal_eliminar : 0,
                modal_contenido : 0,
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
                criterio : 'titulo',
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
            listarAvisos(page, buscar, criterio){
                let me = this;
                var url = '/aviso?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //devuelve lo que regresa el controlador de la url /user
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAvisos = respuesta.avisos.data;
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
                me.listarAvisos(page, buscar, criterio);
            },
            seleccionarCarrera(){//se puede modificar
                //obtener el valor de un <select>
                let me = this;
                var url = '/carrera/selectCarrera';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCarrera = respuesta.carreras;
                })
                .catch(function (error){
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            registrarMatricula(){//se puede modificar, funcion guardar
                if(this.validarMatricula()){
                    return;
                }
                
                let me = this;
                //          url del controlador donde se guarda
                axios.post('/matricula/registrar', {
                    //Clave  :    Valor    (poner las variables tal y como estan en la DB)
                    'id_carrera' : this.id_carrera,
                    'num_lista' : this.num_lista,
                    'matricula' : this.matricula,
                    'nombre' : this.nombre
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarAvisos(1, '', 'titulo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            actualizarMatricula(){//se puede modificar, aqui se actualiza
                if(this.validarMatricula()){
                    return;
                }
                
                let me = this;
                //          url del controlador
                axios.put('/matricula/actualizar', {
                    'id_carrera' : this.id_carrera,
                    'num_lista' : this.num_lista,
                    'matricula' : this.matricula,
                    'nombre' : this.nombre,
                    'id' : this.id_matricula
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarAvisos(1, '', 'titulo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            eliminarMatricula(){

                let me = this;

                axios.delete('/matricula/eliminar', {
                    params : {
                        id : this.id_matricula
                    }
                }).then(function (response){
                    me.cerrarModal();
                    me.listarAvisos(1, '', 'titulo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            switchON(id){// se puede modificar, solo lo que esta en español

                let me = this;
                //          url del controlador
                axios.put('/matricula/activar', {
                    'id' : id
                }).then(function (response){//no modificar
                    me.listarAvisos(1, '', 'titulo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            switchOFF(id){//se puede modificar, solo lo que esta en español

                let me = this;
                //          url del controlador
                axios.put('/matricula/desactivar', {
                    'id' : id
                }).then(function (response){//no modificar
                    me.listarAvisos(1, '', 'titulo');
                }).catch(function (error){
                    console.log(error)
                });
            },
            validarMatricula(){// se puede modificar, solo los mensajes de validacion
                this.errorUsers = 0;
                this.errorMostrarMsjUser = [];

                if(this.id_carrera==0){
                    this.errorMostrarMsjUser.push("Seleccione la carrera, a la que esta inscrito el alumno");
                }
                if(this.num_lista==0){
                    this.errorMostrarMsjUser.push("Seleccione el número de lista, a la que pertenecerá la matrícula");
                }
                if(!this.matricula){
                    this.errorMostrarMsjUser.push("El campo matrícula, no puede estar vacío");
                }
                if(!this.nombre){
                    this.errorMostrarMsjUser.push("El campo nombre, no puede estar vacío");
                }
                
                if(this.errorMostrarMsjUser.length){
                    this.errorUsers = 1;
                }

                return this.errorUsers;

            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.modal_eliminar = 0;//no
                this.modal_contenido = 0;//no
                this.tituloModal = '';//no
                this.id_matricula = 0;
                this.num_lista = 0;
                this.id_carrera = 0;
                this.matricula = '';
                this.nombre = '';
                //variables del aviso
                this.titulo_aviso = '';
                this.contenido_aviso = '';
                this.documento = '';
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                this.seleccionarCarrera();
                switch(modelo){
                    case "aviso":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar Aviso';
                                // this.id_matricula = data['id'];
                                // this.id_carrera = data['id_carrera'];
                                // this.num_lista = data['num_lista'];
                                // this.matricula = data['matricula'];
                                // this.nombre = data['nombre'];
                                this.tipoAccion = 2;//no
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal_eliminar = 1;//no
                                this.tituloModal = 'Eliminar Aviso';
                                // this.id_matricula = data['id'];
                                break;
                            }
                            case 'contenido':
                            {
                                this.tituloModal = 'Contenido del Aviso';
                                this.modal_contenido = 1;//no
                                this.titulo_aviso = data['titulo'];
                                this.contenido_aviso = data['contenido'];
                                this.documento = data['url_documento'];
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {//no modificar
            this.listarAvisos(1, this.buscar, this.criterio);
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

    /* botones circulares */
    .xyz { 
        background-size: auto; 
        text-align: center; 
        padding-top: 100px; 
    } 
    .btn-circle.btn-sm { 
        width: 30px; 
        height: 30px; 
        padding: 0px 0px; /* ponerlo a 0 para que quede en el centro */
        border-radius: 15px; 
        font-size: 16px; /* tamaño de letra del boton */
        text-align: center; 
    } 
    .btn-circle.btn-md { 
        width: 50px; 
        height: 50px; 
        padding: 7px 10px; 
        border-radius: 25px; 
        font-size: 10px; 
        text-align: center; 
    } 
    .btn-circle.btn-xl { 
        width: 70px; 
        height: 70px; 
        padding: 10px 16px; 
        border-radius: 35px; 
        font-size: 12px; 
        text-align: center; 
    }

</style>
