<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Avisos</li>
        <li class="breadcrumb-item active">Tabla de avisos</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list-ul"></i>Avisos
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row scroll-busqueda-filtro">
                        <div v-bind:class="{'col-md-6': col6, 'col-md-10': col10}" class="scroll-busqueda-filtro-x">
                            <div class="input-group">
                                <select :class="{'col-md-2': col2, 'col-md-3': col3}" class="form-control" v-model="criterio">
                                    <option value="id_carrera">Carrera</option>
                                    <option value="tipo_modalidad">Modalidad</option>
                                    <option value="grado">Grado</option>
                                    <option value="turno">Turno</option>
                                    <option value="titulo">Título</option>
                                    <option value="estado">Estado</option>
                                </select>
                                <select v-if="criterio==='id_carrera'" class="form-control" v-model="buscar" @click="listarGradosCarrera()">
                                    <option value="" disabled selected>Seleccione una carrera</option>
                                    <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                        {{carrera.nombre}} ({{carrera.tipo_plan}}) - {{carrera.tipo_modalidad}}
                                    </option>
                                </select>
                                <select v-else-if="criterio==='tipo_modalidad'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0">General</option>
                                    <option value="1">Escolarizado</option>
                                    <option value="2">Semiescolarizado</option>
                                </select>
                                <select v-else-if="criterio==='turno'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0">General</option>
                                    <option value="1">Matutino</option>
                                    <option value="2">Vespertino</option>
                                    <option value="3">Nocturno</option>
                                    <option value="4">Mixto</option>
                                </select>
                                <select v-else-if="criterio==='estado'" class="form-control" v-model="buscar">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Enviado</option>
                                    <option value="0">Guardado</option>
                                </select>
                                <input v-else type="text" id="buscar" v-model="buscar" @keyup.enter="listarAvisos(1, criterio, buscar, buscar2, buscar3)" class="form-control" placeholder="Texto a buscar">
                                <!-- opciones de filtro enlazadas -->
                                <!-- grados -->
                                <select v-if="criterio==='id_carrera' && buscar !== ''" class="form-control col-md-2" v-model="buscar2">
                                    <option value="" disabled selected>Grado</option>
                                    <option v-for="grado in array_num_grados" :key="grado.num" :value="grado.num">
                                        <div v-if="grado.num===0">
                                            General
                                        </div>
                                        <div v-else>
                                            {{grado.num}}º
                                        </div>
                                    </option>
                                </select>
                                <!-- turnos -->
                                <select v-if="criterio==='id_carrera' && buscar !== ''" class="form-control col-md-2" v-model="buscar3">
                                    <option value="" disabled selected>Turno</option>
                                    <option value="0">General</option>
                                    <option value="1">Matutino</option>
                                    <option value="2">Vespertino</option>
                                    <option value="3">Nocturno</option>
                                    <option value="4">Mixto</option>
                                </select>
                                <!-- opciones de filtro enlazadas -->
                                <button type="submit" @click="listarAvisos(1, criterio, buscar, buscar2, buscar3)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                            <th class="text-center">Grado</th>
                            <th class="text-center">Turno</th>
                            <th class="text-center">Título</th>
                            <th class="text-center">Contenido</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Reenvío</th>
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
                            <th v-text="aviso.tipo_modalidad"></th>
                            <th>
                                <div v-if="aviso.grado == 0">
                                    General
                                </div>
                                <div v-else>
                                    {{aviso.grado}}º
                                </div>
                            </th>
                            <th>
                                <div v-if="aviso.turno==1">Matutino</div>
                                <div v-else-if="aviso.turno==2">Vespertino</div>
                                <div v-else-if="aviso.turno==3">Nocturno</div>
                                <div v-else-if="aviso.turno==4">Mixto</div>
                                <div v-else>General</div>
                            </th>
                            <th v-text="aviso.titulo"></th>
                            <th>
                                <button type="button" @click="abrirModal('aviso', 'contenido', aviso)"  class="btn btn-success btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th>
                                <div v-if="aviso.estado == 0">
                                    <span class="btn btn-secondary btn-circle btn-sm">
                                        <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <div v-else-if="aviso.estado == 1">
                                    <span class="btn btn-primary btn-circle btn-sm">
                                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </th>
                            <th>
                                <button type="button" class="badge badge-primary" id="btn-activo" @click=" reenviar_aviso(aviso.id)">
                                    Reenviar
                                </button>
                            </th>
                        </tr>
                        <!-- vista de los elementos de la tabla users -->
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, criterio, buscar, buscar2, buscar3)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, criterio, buscar, buscar2, buscar3)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, criterio, buscar, buscar2, buscar3)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin de tabla Listado -->
    </div>

    <!--Inicio del modal ACTUALIZAR AVISO-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-md" role="document">
            <div class="modal-content">
                <form @submit.prevent="actualizarAviso" enctype="multipart/form-data" class="form-horizontal">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                                
                            <!-- Formulario inputs del Modal actualizar -->
                            <div class="form-group">
                                <div class="col-md-auto text-center">
                                    <label class="form-control-label font-weight-bold" for="email-input">Título del aviso</label>
                                </div>
                                <div class="col-md-auto">
                                    <input type="text" id="titulo_aviso" :style="removeRedColor" v-model="titulo_aviso" @keypress="tecleo" @keyup.delete="tecleo" class="form-control" placeholder="Ingrese el título del aviso">
                                </div>
                                <msj-validacion v-if="msjValidacion[0].titulo_aviso==1">{{msjValidacion[0].mensaje}}</msj-validacion>
                            </div>
                            <div class="form-group">
                                <div class="col-md-auto text-center">
                                    <label class="form-control-label font-weight-bold" for="email-input">Archivo</label>
                                </div>
                                <div class="col-md-auto">
                                    <input type="file" id="campoDocumento" class="form-control" @change="getDocumento" placeholder="Seleccione un documento">
                                </div>
                                <msj-validacion v-if="msjValidacionDocumento">{{msjValidacionDocumento}}</msj-validacion>
                            </div>
                            <!-- mostrar la imagen seleccionada -->
                            <div class="form-group text-center">
                                <div v-if="imagenEs === 'string'">
                                    <img :src="'storage/' + documento" class="img-fluid img-thumbnail">
                                </div>
                                <div v-else-if="imagenEs === 'objeto'">
                                    <div class="col-md">
                                        <img :src="imagen" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md">
                                        <button class="btn btn-secondary" @click="eliminarImagen" style="margin-top:10px;">Eliminar imagen</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-auto text-center">
                                    <label class="form-control-label font-weight-bold" for="email-input">Contenido del aviso</label>
                                </div>
                                <div class="col-md-auto">
                                    <input type="hidden" id="contenido_aviso">
                                    <trix-editor input="contenido_aviso" id="contenido_del_aviso" :style="removeRedColor" @keypress="tecleo" @keyup.delete="tecleo" class="trix-editor"></trix-editor>
                                </div>
                                <msj-validacion v-if="msjValidacion[1].contenido_aviso==1">{{msjValidacion[1].mensaje}}</msj-validacion>
                            </div>

                            <!-- Segunda seccion -->
                            <div class="form-group" style="border-top: 1px solid #C6D7D1; border-bottom: 1px solid #C6D7D1;">
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
                                <label class="col-md-12 form-control-label font-weight-bold text-center" for="email-input">Carreras</label>
                                <div class="col-md-12 select-carrera">
                                    <!-- Seleccionar carrera -->
                                    <div v-if="tipo_envio == 1">
                                        <select class="form-control"  v-model="id_carrera">
                                            <option value="1" disabled selected>Todas las carreras</option>
                                        </select>
                                    </div>
                                    <div v-else-if="tipo_envio == 0">
                                        <select class="form-control" @click="tecleo" id="id_carrera" @change="mostrar_turnos_y_grados_carrera($event)" v-model="id_carrera">
                                            <option value="1" disabled selected>Seleccione una carrera</option>
                                            <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id">
                                                {{carrera.nombre}} ({{carrera.tipo_plan}}) - {{carrera.tipo_modalidad}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <msj-validacion v-if="msjValidacion[2].id_carrera==1">{{msjValidacion[2].mensaje}}</msj-validacion>
                            </div>

                            <!-- sección de parametros especificos de la carrera seleccionada -->
                            <div class="form-group">
                                <div class="row">
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
                                            <msj-validacion v-if="msjValidacion[3].turno==1">{{msjValidacion[3].mensaje}}</msj-validacion>
                                        </div>
                                    </div>
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
                                                            <option value="0" disabled selected>Seleccione el grado</option>
                                                            <option v-for="grado in array_num_grados" :key="grado.num" :value="grado.num">
                                                                <div v-if="grado.num===0">
                                                                    General
                                                                </div>
                                                                <div v-else>
                                                                    {{grado.num}}º
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
                                </div>
                            </div>

                            <!-- fecha programada del aviso-->
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
                            </div>  -->

                        <!-- Formulario inputs del Modal actualizar -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <input type="submit" name="submit"  id="submit" class="btn btn-primary" value="Actualizar" style="cursor:pointer;">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--FIN de ACTUALIZAR AVISO-->


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
                    <p class="mensaje-eliminar">¿Estas seguro de eliminar este aviso?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-danger" @click="aliminarAviso()">Eliminar</button>
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
                    <div class="form-group text-center">
                        <div v-if="imagenEs === 'string'">
                            <img :src="'storage/' + documento" class="img-fluid img-thumbnail">
                        </div>
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
    import MensajeValidacion from './local-components/ValidacionAviso.vue';

    export default {
        components : {
            'msj-validacion' : MensajeValidacion
        },
        data(){
            return{
                //Variables para guardar y actualizar en la DB, se pueden modificar
                id_aviso: 0,
                titulo_aviso: '',
                contenido_aviso: '',
                documento: '',
                grado : 0,
                turno : 0,
                tipo_envio : 0,
                //variable para mostrar imagen seleccionada
                imagenSeleccionada : '',
                imagenEs : '',
                documentoAnterior : '',
                //Identificadores de apoyo en el select Turno
                t_matutino: 0,
                t_vespertino: 0,
                t_nocturno: 0,
                t_mixto: 0,
                //Arrays para mostrar datos en select
                arrayCarrera : [],
                array_num_grados: [],
                //identificadores de validacion
                id_carrera : 0,
                arrayAvisos : [],
                //seleccion de guardar o enviar el aviso
                guardar_enviar: 1,
                //variables para las funciones especificas del componente
                modal : 0,
                modal_eliminar : 0,
                modal_contenido : 0,
                tituloModal : '',
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
                buscar : '',
                buscar2 : '',
                buscar3 : '',
                //Control del ancho de la columna de busqueda por filtro
                col2 : false,
                col3 : true,
                col6 : true,
                col10 : false,
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
            },
            imagen(){//muestra la imagen seleccionada
                return this.imagenSeleccionada;
            },
            removeRedColor : function(){
                if(this.modal == 0){
                    return {
                        'border' : '1px solid #BBCDD5'
                    }
                }
            }
        },
        watch : {
            criterio : function(opcion){
                /*busqueda_por_filtro(campoBuscar = true, col2 = false, col3 = true, col6 = true, col10 = false)*/
                if(opcion=='id_carrera')this.busqueda_por_filtro();
                if(opcion=='tipo_modalidad')this.busqueda_por_filtro();
                if(opcion=='turno')this.busqueda_por_filtro();
                if(opcion=='grado')this.busqueda_por_filtro();
                if(opcion=='titulo')this.busqueda_por_filtro();
                if(opcion=='estado')this.busqueda_por_filtro();
            }
        },
        methods : {
            listarAvisos(page, criterio, buscar, buscar2, buscar3){
                let me = this;
                var url = '';
                var criterio2 = '', criterio3 = '';

                if(buscar2 !== '') criterio2 = 'grado';
                if(buscar3 !== '') criterio3 = 'turno';
                
                url = '/aviso?page='+page+'&criterio='+criterio+'&buscar='+buscar+
                '&criterio2='+criterio2+'&buscar2='+buscar2+'&criterio3='+criterio3+'&buscar3='+buscar3;
                //devuelve lo que regresa el controlador de la url /user
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayAvisos = respuesta.avisos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                    if(criterio2 === 'grado' || criterio3 === 'turno'){
                        /*busqueda_por_filtro(campoBuscar, col2, col3, col6, col10)*/
                        me.busqueda_por_filtro(false,true,false,false,true);
                    }else{
                        me.busqueda_por_filtro();
                    }
                });
            },
            busqueda_por_filtro(campoBuscar = true, col2 = false, col3 = true,col6 = true, col10 = false){
                if(campoBuscar){
                    $('#buscar').val('');
                    this.buscar = '';
                    this.buscar2 = '';
                    this.buscar3 = '';
                }
                this.col2 = col2;
                this.col3 = col3;
                this.col6 = col6;
                this.col10 = col10;
            },
            cambiarPagina(page, criterio, buscar, buscar2, buscar3){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarAvisos(page, criterio, buscar, buscar2, buscar3);
            },
            obtener_carreras(){//se puede modificar
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
            listarGradosCarrera(){
                this.buscar2 = '';
                this.buscar3 = '';
                if(typeof(this.buscar)==='number'){
                    /* busqueda_por_filtro(campoBuscar, col2, col3, col6, col10) */
                    this.busqueda_por_filtro(false,true,false,false,true);
                    this.array_num_grados = [];
                    var numGrados = 0;
                    for(var i = 0; i < this.arrayCarrera.length; i++){
                        if(this.buscar == this.arrayCarrera[i]['id']){
                            numGrados = this.arrayCarrera[i]['num_grados'];
                            for(var i = 0; i <= numGrados; i++){
                                this.array_num_grados.push({num: i})
                            }
                        }
                    }
                }
            },
            mostrar_turnos_y_grados_carrera(event){
                this.turno = 0;
                this.grado = 0;
                this.array_num_grados = [];
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;
                
                this.id_carrera = event.target.value;

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
            turnos_y_grados_aviso(){
                this.turno = 0;
                this.grado = 0;
                this.array_num_grados = [];
                this.t_matutino = 0;
                this.t_vespertino = 0;
                this.t_nocturno = 0;
                this.t_mixto = 0;

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
                    //Limpiar validacion
                    this.msjValidacion[2].mensaje = "";
                    document.getElementById('id_carrera').style.cssText = this.colorGood;
                    this.msjValidacion[3].mensaje = "";
                    document.getElementById('turno').style.cssText = this.colorGood;
                    this.msjValidacion[4].mensaje = "";
                    document.getElementById('grado').style.cssText = this.colorGood;
                }else if(this.tipo_envio == 0){
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
                        this.imagenEs = 'objeto';
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
                this.imagenSeleccionada = '';
                var campoDocumento = document.getElementById('campoDocumento');
                campoDocumento.value = '';

                if( typeof(this.documentoAnterior) === 'string'){
                    this.imagenEs = 'string';
                }else{
                    this.imagenEs = '';
                }
                this.documento = this.documentoAnterior;
            },
            actualizarAviso(){//se puede modificar, aqui se actualiza
                if(this.validarAviso()){
                    return;
                }
                
                let me = this;
                this.contenido_aviso = document.getElementById('contenido_aviso').value;

                let data = new FormData();
                data.append('id',this.id_aviso);
                data.append('id_carrera', this.id_carrera);
                data.append('turno', this.turno);
                data.append('grado', this.grado);
                data.append('titulo', this.titulo_aviso);
                data.append('contenido', this.contenido_aviso);
                data.append('documento', this.documento);
                data.append('general', this.tipo_envio);
                //data.append('_method', 'put');
                let conf = {headers: {'Content-Type': 'multipart/form-data' }};
                axios.post('/aviso/actualizar_aviso', data, conf).then(function (response){//no modificar
                    me.cerrarModal();
                    me.listarAvisos(1, '', '', '', '');
                }).catch(function (error){
                    console.log(error)
                });
            },
            aliminarAviso(){
                let me = this;
          
                axios.delete('/aviso/eliminar_aviso', {
                    params : {
                        id : this.id_aviso
                    }
                }).then(function (response){
                    me.cerrarModal();
                    me.listarAvisos(1, '', '', '', '');
                }).catch(function (error){
                    console.log(error)
                });
            },
            reenviar_aviso(id_reenvio){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Desea reenviar este aviso?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;
                
                        axios.put('/aviso/reenviar_aviso', {
                            'id' : id_reenvio
                        }).then(function (response){
                            me.cerrarModal();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Genial...!',
                                text: 'Se ha enviado correctamente'
                            })
                            me.listarAvisos(1, '', '', '', '');
                        }).catch(function (error){
                            Swal.fire({
                                icon: 'error',
                                title: '¡Ups...!',
                                text: 'Algo salio mal'
                            })
                            console.log(error)
                        });
                    
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                })
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

                    if(this.turno == 0){
                        this.numErrors = 1;
                        document.getElementById('turno').style.cssText = this.colorError;
                        this.msjValidacion[3].turno = 1;
                        this.msjValidacion[3].mensaje = "Seleccione un turno";
                    }else{
                        this.msjValidacion[3].mensaje = "";
                        document.getElementById('turno').style.cssText = this.colorGood;
                    }

                    if(this.grado == 0){
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
            cerrarModal(){//modificar solo variables
                var campoDocumento = document.getElementById('campoDocumento');
                campoDocumento.value = '';
                campoDocumento.style.cssText = this.colorGood;

                var element = document.querySelector("trix-editor");
                //atajo para restablecer trix-editor
                element.value = "";

                //Variables manejo de funciones de los modales
                this.modal = 0;//no
                this.modal_eliminar = 0;//no
                this.modal_contenido = 0;//no
                this.tituloModal = '';//no

                //Variables de actualizar el aviso
                this.id_carrera = 1; 
                this.turno = 0; 
                this.grado = 0; 
                this.titulo_aviso = ''; 
                this.documento = '';
                this.contenido_aviso = ''; 
                //variables del archivo imagen
                this.imagenSeleccionada = '';
                this.imagenEs = '';
                this.documentoAnterior = '';
                this.msjValidacionDocumento = '';
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
                this.obtener_carreras();
            },
            abrirModal(modelo, accion, data = []){//modificar solo variables  
                switch(modelo){
                    case "aviso":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                var element = document.querySelector("trix-editor");
                                this.modal=1;//no
                                this.tituloModal = 'Actualizar Aviso';
                                this.id_aviso = data['id'];
                                this.titulo_aviso = data['titulo'];
                                this.contenido_aviso = data['contenido'];
                                element.value = this.contenido_aviso;
                                this.documento = data['url_documento'];
                                this.documentoAnterior = this.documento;
                                if( typeof(this.documento) === 'string'){
                                    this.imagenEs = 'string';
                                }
                                this.tipo_envio = data['general'];
                                this.id_carrera = data['id_carrera'];
                                this.turnos_y_grados_aviso();
                                this.turno = data['turno'];
                                this.grado = data['grado'];
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal_eliminar = 1;//no
                                this.tituloModal = 'Eliminar Aviso';
                                this.id_aviso = data['id'];
                                break;
                            }
                            case 'contenido':
                            {
                                this.tituloModal = 'Contenido del Aviso';
                                this.modal_contenido = 1;//no
                                this.titulo_aviso = data['titulo'];
                                this.contenido_aviso = data['contenido'];
                                this.documento = data['url_documento'];
                                if( typeof(this.documento) === 'string'){
                                    this.imagenEs = 'string';
                                }
                                break;
                            }
                        }

                    }
                }

            },
            tecleo : function (){
                if(this.numErrors==1){
                    this.numErrors = this.validarAviso();
                }
            }
        },
        mounted() {//no modificar
            this.listarAvisos(1, this.criterio, this.buscar, this.buscar2, this.buscar3);
            this.obtener_carreras();
            // $('#boton-actualizar').click(function() {
            //     $('#submit').click();
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

    .select-carrera{
        padding: 0;
    }

    /*  No mostrar el boton de seleccionar archivo  en trix-editor*/
    trix-toolbar .trix-button-group--file-tools{
        display: none;
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
        font-size: 18px; /* tamaño de letra del boton */
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
