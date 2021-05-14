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
                <i class="fa fa-align-justify"></i> Usuarios
                <button type="button" @click="abrirModal('usuario', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="usuario">Usuario</option>
                                <option value="nombre">Nombre</option>
                                <option value="correo">Correo</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarUser(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarUser(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Rol</th>
                            <th>Carrera</th>
                            <th>Modalidad</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="user in arrayUsers" :key="user.id">
                            <td>
                                <button type="button" @click="abrirModal('usuario', 'actualizar', user)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEliminar">
                                    <i class="icon-trash"></i>
                                </button> -->
                            </td>
                            <th v-text="user.nombre_rol"></th>
                            <th >
                                <div v-if="user.nombre_carrera==='Funciones Generales'">
                                    <span class="badge badge-dark">Funciones Generales</span>
                                </div>
                                <div v-else>
                                    <p v-text="user.nombre_carrera"></p> 
                                </div>
                            </th>
                            <th>
                                <div v-if="user.tipo_modalidad==1">Escolarizado</div>
                                <div v-else-if="user.tipo_modalidad==2">Semiescolarizado</div>
                                <div v-else><span class="badge badge-dark">N/A</span></div>
                            </th>
                            <th v-text="user.usuario"></th>
                            <th v-text="user.nombre"></th>
                            <th v-text="user.correo"></th>
                            <th>
                                <div v-if="user.condicion">
                                    <button type="button" class="badge badge-success" id="btn-activo" @click=" desactivarUser(user.id)">
                                        Activo
                                    </button>
                                </div>
                                <div v-else>
                                    <button type="button" class="badge badge-danger" @click=" activarUser(user.id)">
                                        Desactivado
                                    </button>
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
                            <label class="col-md-3 form-control-label" for="text-input">Rol (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" @change="obtenerIdRol($event)" v-model="id_rol">
                                    <option value="0" disabled selected>Seleccione un rol</option>
                                    <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Carrera (*)</label>
                            <div class="col-md-9">
                                <div v-if="id_rol==1">
                                    <select class="form-control">
                                        <option value="1" disabled selected>Funciones Generales</option>
                                    </select>
                                </div>
                                <div v-else>
                                    <select class="form-control" v-model="id_carrera">
                                        <option value="0" disabled selected>Seleccione una carrera</option>
                                        <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                            {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                        </option>
                                    </select>
                                 </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Usuario (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Contraseña (*)</label>
                            <div class="col-md-9">
                                <input type="password" v-model="password" class="form-control" placeholder="Contraseña de acceso">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Nombre (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Correo (*)</label>
                            <div class="col-md-9">
                                <input type="email" v-model="correo" class="form-control"  placeholder="Email de la persona acargo">
                            </div>
                        </div>

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
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUser()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUser()">Actualizar</button>
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
                    <h4 class="modal-title">Eliminar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Estas seguro de eliminar el usuario?</p>
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
                id_usuario : 0,
                id_carrera : 0,
                id_rol : 0,
                usuario : '',
                password : '',
                nombre : '',
                correo : '',
                arrayUsers : [],  
                arrayRol : [],
                arrayCarrera : [],

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
                criterio : 'usuario',
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
            listarUser(page, buscar, criterio){
                let me = this;
                var url = '/user?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //devuelve lo que regresa el controlador de la url /user
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayUsers = respuesta.users.data;
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
                me.listarUser(page, buscar, criterio);
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
            seleccionarRoles(){
                //obtener el valor de un <select>
                let me = this;
                var url = '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            registrarUser(){//se puede modificar, funcion guardar
                if(this.validarUser()){
                    return;
                }
                
                let me = this;
                //          url del controlador donde se guarda
                axios.post('/user/registrar', {
                    //Clave  :    Valor    (poner las variables tal y como estan en la DB)
                    'id_carrera' : this.id_carrera,
                    'id_rol' : this.id_rol,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'nombre' : this.nombre,
                    'correo' : this.correo
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarUser(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error)
                });
            },
            actualizarUser(){//se puede modificar, aqui se actualiza
                if(this.validarUser()){
                    return;
                }
                
                let me = this;
                //          url del controlador
                axios.put('/user/actualizar', {
                    'id_carrera' : this.id_carrera,
                    'id_rol' : this.id_rol,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'nombre' : this.nombre,
                    'correo' : this.correo,
                    'id' : this.id_usuario
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarUser(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error)
                });
            },
            activarUser(id){// se puede modificar, solo lo que esta en español
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                
                swalWithBootstrapButtons.fire({
                    title: 'Desea activar el usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        //          url del controlador
                        axios.put('/user/activar', {
                            'id' : id
                        }).then(function (response){
                            me.listarUser(1, '', 'nombre');  
                            swalWithBootstrapButtons.fire(
                            'Usuario Activado!',
                            'El usuario ha sido activado con éxito.',
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
            desactivarUser(id){//se puede modificar, solo lo que esta en español
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro en desactivar este usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                        //          url del controlador
                        axios.put('/user/desactivar', {
                            'id' : id
                        }).then(function (response){
                            me.listarUser(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                            'Usuario Desactivado!',
                            'El usuario ha sido desactivado con éxito.',
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
            validarUser(){// se puede modificar, solo los mensajes de validacion
                this.errorUsers = 0;
                this.errorMostrarMsjUser = [];

                if(this.id_carrera==0){
                    this.errorMostrarMsjUser.push("Seleccione la carrera, acargo del usuario");
                }
                if(this.id_rol==0){
                    this.errorMostrarMsjUser.push("Seleccione el rol del usuario");
                }
                if(!this.usuario){
                    this.errorMostrarMsjUser.push("El campo usuario, no puede estar vacío");
                }
                if(!this.password){
                    this.errorMostrarMsjUser.push("El campo contraña, no puede estar vacío");
                }
                if(!this.nombre){
                    this.errorMostrarMsjUser.push("El campo nombre, no puede estar vacío");
                }
                
                var validarEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                if(!this.correo){
                    this.errorMostrarMsjUser.push("El campo correo, no puede estar vacío");
                }
                else if(validarEmail.test(this.correo)==false){
                    this.errorMostrarMsjUser.push("El correo no esta bien escrito");
                }
                
                if(this.errorMostrarMsjUser.length){
                    this.errorUsers = 1;
                }

                return this.errorUsers;

            },
            obtenerIdRol($event){
                //obtener el valor del <select> plan de estudio
                var rol = event.target.value;
                if(rol==1){
                    this.id_carrera = 1;
                }else{
                    this.id_carrera = 0;
                }
            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.tituloModal = '';//no
                this.id_usuario = 0;
                this.id_carrera = 0;
                this.id_rol = 0;
                this.usuario = '';
                this.password = '';
                this.nombre = '';
                this.correo = '';
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                this.seleccionarCarrera();
                this.seleccionarRoles();
                switch(modelo){
                    case "usuario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;//no
                                this.tituloModal = 'Registrar Usuario';
                                this.id_usuario = 0;
                                this.id_carrera = 0;
                                this.id_rol = 0;
                                this.usuario = '';
                                this.password = '';
                                this.nombre = '';
                                this.correo = '';
                                this.tipoAccion = 1;//no
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar Usuario';
                                this.id_usuario = data['id'];
                                this.id_carrera = data['id_carrera'];
                                this.id_rol = data['id_rol'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                this.nombre = data['nombre'];
                                this.correo = data['correo'];
                                this.tipoAccion = 2;//no
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {//no modificar
            this.listarUser(1, this.buscar, this.criterio);
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
