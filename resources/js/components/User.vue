<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Accesos</li>
        <li class="breadcrumb-item active">Tabla de Usuarios</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="icon-people"></i>Usuarios
                <button type="button" @click="abrirModal('usuario', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row scroll-busqueda-filtro">
                        <div v-bind:class="{'col-md-6': col6, 'col-md-8': col8}" class="scroll-busqueda-filtro-x">
                            <div class="input-group">
                                <select :class="{'col-md-2': col2, 'col-md-3': col3}" class="form-control" v-model="criterio">
                                    <option value="id_carrera">Carrera</option>
                                    <option value="id_rol">Rol</option>
                                    <option value="tipo_modalidad">Modalidad</option>
                                    <option value="usuario">Usuario</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="correo">Correo</option>
                                    <option value="condicion">Estado</option>
                                </select>
                                <select v-if="criterio==='id_carrera'" class="form-control" v-model="buscar" @click="expandir_filtro">
                                    <option value="" disabled selected>Seleccione una carrera</option>
                                    <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                        {{carrera.nombre}} ({{carrera.tipo_plan}}) - {{carrera.tipo_modalidad}}
                                    </option>
                                </select>
                                <select v-else-if="criterio==='id_rol'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option v-if="rolUsuario === 1" value="1">Administrador</option>
                                    <option v-if="rolUsuario === 1" value="2">Coordinador</option>
                                    <option value="3">Asistente</option>
                                    <option value="4">Docente</option>
                                </select>
                                <select v-else-if="criterio==='tipo_modalidad'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0">N/A</option>
                                    <option value="1">Escolarizado</option>
                                    <option value="2">Semiescolarizado</option>
                                </select>
                                <select v-else-if="criterio==='condicion'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Desactivado</option>
                                </select>
                                <input v-else type="text" id="buscar" v-model="buscar" @keyup.enter="listarUser(1, criterio, buscar, buscar2)" class="form-control" placeholder="Texto a buscar">
                                <!-- opciones de filtro enlazadas -->
                                <!-- roles -->
                                <select v-if="criterio==='id_carrera' && buscar !== ''" class="col-md-2 form-control" v-model="buscar2">
                                    <option value="" disabled selected>Rol</option>
                                    <option v-if="rolUsuario === 1" value="1">Administrador</option>
                                    <option v-if="rolUsuario === 1" value="2">Coordinador</option>
                                    <option v-if="rolUsuario === 1 || rolUsuario === 2" value="3">Asistente</option>
                                    <option value="4">Docente</option>
                                </select>
                                <!-- opciones de filtro enlazadas -->
                                <button type="submit" @click="listarUser(1, criterio, buscar, buscar2)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Opciones</th>
                            <th class="text-center">Carrera</th>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Modalidad</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="user in arrayUsers" :key="user.id">
                            <td>
                                <button type="button" @click="abrirModal('usuario', 'actualizar', user)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> 
                            </td>
                            <th >
                                <div v-if="user.nombre_carrera==='Funciones Generales'">
                                    <span class="badge badge-dark">Funciones Generales</span>
                                </div>
                                <div v-else>
                                    <p v-text="user.nombre_carrera"></p> 
                                </div>
                            </th>
                            <th v-text="user.nombre_rol"></th>
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
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, criterio, buscar, buscar2)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, criterio, buscar, buscar2)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, criterio, buscar, buscar2)">Sig</a>
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
                                <select class="form-control" :style="msjValidacion.rol.color" @change="obtenerIdRol($event)" v-model="id_rol" @click="tecleo">
                                    <option value="0" disabled selected>Seleccione un rol</option>
                                    <option v-if="rolUsuario === 1" value="1">Administrador</option>
                                    <option v-if="rolUsuario === 1" value="2">Coordinador</option>
                                    <option v-if="rolUsuario === 1 || rolUsuario === 2" value="3">Asistente</option>
                                    <option value="4">Docente</option>
                                </select>
                            </div>
                            <msj-validacion v-if="msjValidacion.rol.mensaje != ''">{{msjValidacion.rol.mensaje}}</msj-validacion>
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
                                    <select class="form-control" :style="msjValidacion.carrera.color" v-model="id_carrera" @click="tecleo">
                                        <option value="0" disabled selected>Seleccione una carrera</option>
                                        <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                            {{carrera.nombre}} ({{carrera.tipo_plan}}) - {{carrera.tipo_modalidad}}
                                        </option>
                                    </select>
                                 </div>
                            </div>
                            <msj-validacion v-if="msjValidacion.carrera.mensaje != ''">{{msjValidacion.carrera.mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Usuario (*)</label>
                            <div class="col-md-9">
                                <input type="text" v-model="usuario" :style="msjValidacion.usuario.color" id="usuario" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Nombre del usuario">
                            </div>
                            <msj-validacion v-if="msjValidacion.usuario.mensaje != ''">{{msjValidacion.usuario.mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Contraseña (*)</label>
                            <div class="col-md-9">
                                <input type="password" id="password" :style="msjValidacion.password.color" v-model="password" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Contraseña de acceso">
                            </div>
                            <msj-validacion v-if="msjValidacion.password.mensaje != ''">{{msjValidacion.password.mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Nombre (*)</label>
                            <div class="col-md-9">
                                <input type="text" id="nombre" :style="msjValidacion.nombre.color" v-model="nombre" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Nombre de la persona">
                            </div>
                            <msj-validacion v-if="msjValidacion.nombre.mensaje != ''">{{msjValidacion.nombre.mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Correo (*)</label>
                            <div class="col-md-9">
                                <input type="email" id="correo" :style="msjValidacion.correo.color" v-model="correo" @keypress="tecleo" @keyup.delete="tecleo" class="form-control"  placeholder="Email de la persona acargo">
                            </div>
                            <msj-validacion v-if="msjValidacion.correo.mensaje != ''">{{msjValidacion.correo.mensaje}}</msj-validacion>
                        </div>
                        <!-- inputs del Modal agregar -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="verificar_y_validar('Guardar')">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="verificar_y_validar('Actualizar')">Actualizar</button>
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
    import MensajeValidacion from './local-components/MsjValidacion.vue';

    export default {
        components : {
            'msj-validacion' : MensajeValidacion 
        },
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                id_usuario : 0,
                id_carrera : 0,
                id_rol : 0,
                usuario : '',
                usuarioExiste : '',//mensaje en caso de que ya exista el nombre de usuario
                password : '',
                nombre : '',
                correo : '',
                correoExiste : '',//mensaje en caso de que ya este en uso un correo
                arrayUsers : [],
                arrayCarrera : [],

                //variables para las funciones especificas del componente
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                //Validación de campos
                numErrors : 0,
                msjValidacion : {
                    rol : {mensaje : '', color : ''},
                    carrera : {mensaje : '', color : ''},
                    usuario : {mensaje : '', color : ''},
                    password : {mensaje : '', color : ''},
                    nombre : {mensaje : '', color : ''},
                    correo : {mensaje : '', color : ''}
                },
                colorError : '2px solid rgba(231, 76, 60, 0.5)',
                colorGood : '1px solid #BBCDD5',
                pagination:{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id_carrera',
                buscar : '',
                buscar2 : '',
                //Habilitar o desabilitar campos
                rolUsuario : 0,
                //Control del ancho de la columna de busqueda por filtro
                col2 : false,
                col3 : true,
                col6 : true,
                col8 : false,
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
                /*busqueda_por_filtro(campoBuscar = true, col2 = false, col3 = true, col6 = true, col8 = false)*/
                if(opcion=='id_carrera')this.busqueda_por_filtro();
                if(opcion=='id_rol')this.busqueda_por_filtro();
                if(opcion=='tipo_modalidad')this.busqueda_por_filtro();
                if(opcion=='usuario')this.busqueda_por_filtro();
                if(opcion=='nombre')this.busqueda_por_filtro();
                if(opcion=='correo')this.busqueda_por_filtro();
                if(opcion=='condicion')this.busqueda_por_filtro();
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
            listarUser(page, criterio, buscar, buscar2){
                let me = this;
                var url = '', criterio2 = '';
                if(buscar2 !== '') criterio2 = 'id_rol';

                url = '/user?page='+page+'&criterio='+criterio+'&buscar='+buscar+'&criterio2='+criterio2+'&buscar2='+buscar2;
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
                    if(criterio2 === 'id_rol'){
                        /*busqueda_por_filtro(campoBuscar, col2, col3, col6, col8)*/
                        me.busqueda_por_filtro(false,true,false,false,true);
                    }else{
                        me.busqueda_por_filtro();
                    }
                });
            },
            busqueda_por_filtro(campoBuscar = true, col2 = false, col3 = true,col6 = true, col8 = false){
                if(campoBuscar){
                    $('#buscar').val('');
                    this.buscar = '';
                    this.buscar2 = '';
                }
                this.col2 = col2;
                this.col3 = col3;
                this.col6 = col6;
                this.col8 = col8;
            },
            expandir_filtro(){
                if(this.buscar !== ''){
                    this.busqueda_por_filtro(false,true,false,false,true);
                }
            },
            cambiarPagina(page, criterio, buscar, buscar2){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarUser(page, criterio, buscar, buscar2);
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
                    me.listarUser(1, '', '', '');
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
                    me.listarUser(1, '', '', '');
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
                            me.listarUser(1, '', '', '');
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
                this.numErrors = 0;

                if(this.id_rol==0){
                    this.numErrors = 1;
                    this.msjValidacion.rol.color = {'border':this.colorError};
                    this.msjValidacion.rol.mensaje = "Seleccione el rol del usuario";
                }else{
                    this.msjValidacion.rol.color = {'border':this.colorGood};
                    this.msjValidacion.rol.mensaje = '';
                }

                if(this.arrayCarrera.length){
                    if(this.id_carrera == 0 && this.id_rol!= 1 && this.id_rol != 4){
                        this.numErrors = 1;
                        this.msjValidacion.carrera.color = {'border':this.colorError};
                        this.msjValidacion.carrera.mensaje = "Seleccione una carrera";
                    }else{
                        this.msjValidacion.carrera.color = {'border':this.colorGood};
                        this.msjValidacion.carrera.mensaje = '';
                    }
                }else{
                    if(this.id_rol!= 1 && this.id_rol!= 4){
                        this.numErrors = 1;
                        this.msjValidacion.carrera.color = {'border':this.colorError};
                        this.msjValidacion.carrera.mensaje = "Actualmente no se ha creado ningún programa";
                    }
                }
                
                if(!this.usuario){
                    this.numErrors = 1;
                    this.msjValidacion.usuario.color = {'border':this.colorError};
                    this.msjValidacion.usuario.mensaje = "El campo usuario no puede estar vacío";
                }
                else if(this.usuarioExiste != ''){
                    this.numErrors = 1;
                    this.msjValidacion.usuario.color = {'border':this.colorError};
                    this.msjValidacion.usuario.mensaje = this.usuarioExiste;
                }
                else{
                    this.msjValidacion.usuario.color = {'border':this.colorGood};
                    this.msjValidacion.usuario.mensaje = '';
                }

                if(!this.password){
                    this.numErrors = 1;
                    this.msjValidacion.password.color = {'border':this.colorError};
                    this.msjValidacion.password.mensaje = "El campo contraña no puede estar vacío";
                }
                else if(this.password.length < 8){
                    this.numErrors = 1;
                    this.msjValidacion.password.color = {'border':this.colorError};
                    this.msjValidacion.password.mensaje = "La contraseña debe contener minimo 8 caracteres";
                }
                else{
                    this.msjValidacion.password.color = {'border':this.colorGood};
                    this.msjValidacion.password.mensaje = '';
                }

                if(!this.nombre){
                    this.numErrors = 1;
                    this.msjValidacion.nombre.color = {'border':this.colorError};
                    this.msjValidacion.nombre.mensaje = "El campo nombre no puede estar vacío";
                }else{
                    this.msjValidacion.nombre.color = {'border':this.colorGood};
                    this.msjValidacion.nombre.mensaje = '';
                }
                
                var validarEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                if(!this.correo){
                    this.numErrors = 1;
                    this.msjValidacion.correo.color = {'border':this.colorError};
                    this.msjValidacion.correo.mensaje = "El campo correo no puede estar vacío";
                }
                else if(validarEmail.test(this.correo)==false){
                    this.numErrors = 1;
                    this.msjValidacion.correo.color = {'border':this.colorError};
                    this.msjValidacion.correo.mensaje = "El correo no esta bien escrito";
                }
                else if(this.correoExiste != ''){
                    this.numErrors = 1;
                    this.msjValidacion.correo.color = {'border':this.colorError};
                    this.msjValidacion.correo.mensaje = this.correoExiste;
                }
                else{
                    this.msjValidacion.correo.color = {'border':this.colorGood};
                    this.msjValidacion.correo.mensaje = '';
                }

                this.usuarioExiste = '';
                this.correoExiste = '';

                return this.numErrors;
            },
            verificar_y_validar(opcion){

                let me = this;
                
                if(opcion === 'Guardar'){
                    var url = '/user/verificarUsuarioEmail_guardar?usuario=' + this.usuario + '&email=' + this.correo;
                    axios.get(url).then(function (response){
                        var respuesta = response.data;
                        me.usuarioExiste = respuesta.respuestaUsuario;
                        me.correoExiste = respuesta.respuestaEmail;

                        //Ejecutar la funcion guardar
                        me.registrarUser();
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

                }else if(opcion === 'Actualizar'){

                    var url = '/user/verificarUsuarioEmail_actualizar?usuario=' + this.usuario + '&email=' + this.correo +'&id_usuario='+ this.id_usuario;
                    axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.usuarioExiste = respuesta.respuestaUsuario;
                        me.correoExiste = respuesta.respuestaEmail;

                        //Ejecutar la funcion guardar
                        me.actualizarUser();
                    })
                    .catch(function (error){
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

                }

            },
            obtenerIdRol($event){
                //obtener el valor del <select> plan de estudio
                var rol = event.target.value;
                if(rol==1){
                    this.id_carrera = 1;
                }else if(rol==4){
                    this.id_carrera = 2;
                }
                else{
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

                this.numErrors = 0;
                this.msjValidacion = {
                    rol : {mensaje : '', color : ''},
                    carrera : {mensaje : '', color : ''},
                    usuario : {mensaje : '', color : ''},
                    password : {mensaje : '', color : ''},
                    nombre : {mensaje : '', color : ''},
                    correo : {mensaje : '', color : ''}
                };
                this.usuarioExiste = '';
                this.correoExiste = '';

                this.seleccionarCarrera();
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                this.seleccionarCarrera();
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

            },
            tecleo : function (){
                if(this.numErrors==1){
                    this.numErrors = this.validarUser();
                }
            }
        },
        mounted() {//no modificar
            this.rol_de_usuario();
            this.listarUser(1, this.criterio, this.buscar, this.buscar2);
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
