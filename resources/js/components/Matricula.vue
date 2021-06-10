<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Alumnos</li>
        <li class="breadcrumb-item active">Registro de Matrículas</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-id-card-o"></i>Matrículas
                <button type="button" @click="abrirModal('matricula', 'registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row scroll-busqueda-filtro">
                        <div class="col-md-6 scroll-busqueda-filtro-x">    
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="id_carrera">Carrera</option>
                                    <option value="tipo_modalidad">Modalidad</option>
                                    <option value="switch">Switch</option>
                                    <option value="matricula">Matrícula</option>
                                    <option value="nombre">Nombre</option>
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
                                <select v-else-if="criterio==='switch'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">En servicio</option>
                                    <option value="0">Fuera de servicio</option>
                                </select>
                                <select v-else-if="criterio==='condicion'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Registrado</option>
                                    <option value="0">No registrado</option>
                                    <option value="2">Desactivado</option>
                                </select>
                                <input v-else type="text" id="buscar" v-model="buscar" @keyup.enter="listarMatriculas(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMatriculas(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                            <th class="text-center">Switch</th>
                            <th class="text-center">Matrícula</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="matricula in arrayMatriculas" :key="matricula.id">
                            <td>
                                <button type="button" @click="abrirModal('matricula', 'actualizar', matricula)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button" @click="abrirModal('matricula', 'eliminar', matricula)"  class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                            <th v-text="matricula.nombre_carrera"></th>
                            <th v-text="matricula.modalidad_carrera"></th>
                            <th class="text-center">
                                <div v-if="matricula.switch">
                                    <button type="button" class="btn btn-primary btn-circle btn-sm" @click=" switchOFF(matricula.id)">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </button> 
                                </div>
                                <div v-else>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm" @click="switchON(matricula.id)">
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                    </button> 
                                </div>
                            </th>
                            <th v-text="matricula.matricula"></th>
                            <th v-text="matricula.nombre"></th>
                            <th>
                                <div v-if="matricula.switch">
                                    <div v-if="matricula.condicion">
                                        <span class="badge badge-success">Registrado</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-dark">No Registrado</span>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="matricula.condicion">
                                        <span class="badge badge-danger">Desactivado</span>
                                        <span class="badge badge-success">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                    </div>
                                    
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
                            <label class="col-md-3 form-control-label" for="text-input">Carrera (*)</label>
                            <div class="col-md-9">
                                <select class="form-control" id="carrera" v-model="id_carrera" @click="tecleo">
                                    <option value="0" disabled selected>Seleccione una carrera</option>
                                    <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                        {{carrera.nombre}} - {{carrera.tipo_modalidad}}
                                    </option>
                                </select>
                            </div>
                            <msj-validacion v-if="msjValidacion[0].carrera==1">{{msjValidacion[0].mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Matrícula (*)</label>
                            <div class="col-md-9">
                                <input type="text" id="matricula" v-model="matricula" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Matrícula del alumno">
                            </div>
                            <msj-validacion v-if="msjValidacion[1].matricula==1">{{msjValidacion[1].mensaje}}</msj-validacion>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Nombre (*)</label>
                            <div class="col-md-9">
                                <input type="text" id="nombre" v-model="nombre" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Nombre del alumno">
                            </div>
                            <msj-validacion v-if="msjValidacion[2].nombre==1">{{msjValidacion[2].mensaje}}</msj-validacion>
                        </div>
                        <!-- mostrar los errores de la validadción -->
                        <!-- <div class="form-group row div-error" v-show="errorUsers">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjUser" :key="error" v-text="error"></div>
                            </div>
                        </div> -->
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
                    <p class="mensaje-eliminar">¿Estas seguro de eliminar esta matrícula?</p>
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
                id_carrera : 0,
                matricula : '',
                nombre : '',
                arrayMatriculas : [],
                arrayCarrera : [],
                //variables para las funciones especificas del componente
                modal : 0,
                modal_eliminar : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorUsers : 0,
                errorMostrarMsjUser : [],
                //Validación de campos
                numErrors : 0,
                msjValidacion : [
                    {carrera : 0, mensaje : ''},
                    {matricula : 0, mensaje : ''},
                    {nombre : 0, mensaje : ''}
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
                if(opcion=='switch')this.buscar = '';
                if(opcion=='matricula')this.buscar = '';
                if(opcion=='nombre')this.buscar = '';
                if(opcion=='condicion')this.buscar = '';
            }
        },
        methods : {
            listarMatriculas(page, buscar, criterio){
                let me = this;
                var url = '/matricula?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //devuelve lo que regresa el controlador de la url /user
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayMatriculas = respuesta.matriculas.data;
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
            limpiarTextBuscar(){
                $('#buscar').val('');
                this.buscar = '';
            },
            cambiarPagina(page, buscar, criterio){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarMatriculas(page, buscar, criterio);
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
            registrarMatricula(){//se puede modificar, funcion guardar
                if(this.validarMatricula()){
                    return;
                }
                
                let me = this;
                //          url del controlador donde se guarda
                axios.post('/matricula/registrar', {
                    //Clave  :    Valor    (poner las variables tal y como estan en la DB)
                    'id_carrera' : this.id_carrera,
                    'matricula' : this.matricula,
                    'nombre' : this.nombre
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarMatriculas(1, '', 'matricula');
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
                    'matricula' : this.matricula,
                    'nombre' : this.nombre,
                    'id' : this.id_matricula
                }).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarMatriculas(1, '', 'matricula');
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
                    me.listarMatriculas(1, '', 'matricula');
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
                    me.listarMatriculas(1, '', 'matricula');
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
                    me.listarMatriculas(1, '', 'matricula');
                }).catch(function (error){
                    console.log(error)
                });
            },
            validarMatricula(){// se puede modificar, solo los mensajes de validacion
                this.numErrors = 0;

                if(this.id_carrera==0){
                    this.numErrors = 1;
                    document.getElementById('carrera').style.cssText = this.colorError;
                    this.msjValidacion[0].carrera = 1;
                    this.msjValidacion[0].mensaje = "Seleccione la carrera en la que esta inscrito el alumno";
                }else{
                    this.msjValidacion[0].mensaje = "";
                    document.getElementById('carrera').style.cssText = this.colorGood;
                }

                if(!this.matricula){
                    this.numErrors = 1;
                    document.getElementById('matricula').style.cssText = this.colorError;
                    this.msjValidacion[1].matricula = 1;
                    this.msjValidacion[1].mensaje = "El campo matrícula no puede estar vacío";
                }else{
                    this.msjValidacion[1].mensaje = "";
                    document.getElementById('matricula').style.cssText = this.colorGood;
                }

                if(!this.nombre){
                    this.numErrors = 1;
                    document.getElementById('nombre').style.cssText = this.colorError;
                    this.msjValidacion[2].nombre = 1;
                    this.msjValidacion[2].mensaje = "El campo nombre no puede estar vacío";
                }else{
                    this.msjValidacion[2].mensaje = "";
                    document.getElementById('nombre').style.cssText = this.colorGood;
                }
                
                return this.numErrors;
            },
            cerrarModal(){//modificar solo variables
                this.modal = 0;//no
                this.modal_eliminar = 0;//no
                this.tituloModal = '';//no
                this.id_matricula = 0; 
                this.id_carrera = 0; document.getElementById('carrera').style.cssText = this.colorGood;
                this.matricula = ''; document.getElementById('matricula').style.cssText = this.colorGood;
                this.nombre = ''; document.getElementById('nombre').style.cssText = this.colorGood;

                this.numErrors = 0;
                this.msjValidacion = [
                    {carrera : 0, mensaje : ''},
                    {matricula : 0, mensaje : ''},
                    {nombre : 0, mensaje : ''}
                ];
                //Busqueda por filtro
                this.arrayCarrera = [];
                this.seleccionarCarrera();
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables
                this.seleccionarCarrera();
                switch(modelo){
                    case "matricula":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;//no
                                this.tituloModal = 'Registrar Matrícula';
                                this.id_matricula = 0;
                                this.id_carrera = 0;
                                this.matricula = '';
                                this.nombre = '';
                                this.tipoAccion = 1;//no
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar Matrícula';
                                this.id_matricula = data['id'];
                                this.id_carrera = data['id_carrera'];
                                this.matricula = data['matricula'];
                                this.nombre = data['nombre'];
                                this.tipoAccion = 2;//no
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal_eliminar = 1;//no
                                this.tituloModal = 'Eliminar Matrícula';
                                this.id_matricula = data['id'];
                                break;
                            }
                        }

                    }
                }

            },
            tecleo : function (){
                if(this.numErrors==1){
                    this.numErrors = this.validarMatricula();
                }
            }
        },
        mounted() {//no modificar
            this.listarMatriculas(1, this.buscar, this.criterio);
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
