<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Escritorio</li>
        <li class="breadcrumb-item">Alumnos</li>
        <li class="breadcrumb-item active">Tabla de alumnos</li>
    </ol>
    <div class="container-fluid">
        <!-- tabla Listado de alumnos -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list-ul" aria-hidden="true"></i>Alumnos
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
                                    <option value="matricula">Matrícula</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="correo">Correo</option>
                                    <option value="condicion">Estado</option>
                                </select>
                                <select v-if="criterio==='id_carrera'" class="form-control col-md" v-model="buscar" @click="listarGradosCarrera()">
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
                                <input v-else type="text" id="buscar" v-model="buscar" @keyup.enter="listarAlumnos(1, criterio, buscar, buscar2, buscar3)" class="form-control" placeholder="Texto a buscar">
                                <!-- opciones de filtro enlazadas -->
                                <!-- grados -->
                                <select v-if="criterio==='id_carrera' && buscar !== ''" class="form-control col-md-2" v-model="buscar2">
                                    <option value="" disabled selected>Grado</option>
                                    <option v-for="grado in arrayGrados" :key="grado.num" :value="grado.num">
                                        {{grado.num}}º
                                    </option>
                                </select>
                                <!-- turnos -->
                                <select v-if="criterio==='id_carrera' && buscar !== ''" class="form-control col-md-2" v-model="buscar3">
                                    <option value="" disabled selected>Turno</option>
                                    <option value="1">Matutino</option>
                                    <option value="2">Vespertino</option>
                                    <option value="3">Nocturno</option>
                                    <option value="4">Mixto</option>
                                </select>
                                <!-- opciones de filtro enlazadas -->
                                <button type="submit" @click="listarAlumnos(1, criterio, buscar, buscar2, buscar3)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Carrera</th>
                            <th class="text-center">Modalidad</th>
                            <th class="text-center">Grado</th>
                            <th class="text-center">Turno</th>
                            <th class="text-center">Matrícula</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- vista de los elementos de la tabla users -->
                        <tr v-for="alumno in arrayAlumnos" :key="alumno.id">
                            <th v-text="alumno.nombre_carrera"></th>
                            <th v-text="alumno.modalidad_carrera"></th>
                            <th>{{alumno.grado}}º</th>
                            <th>
                                <div v-if="alumno.turno==1">Matutino</div>
                                <div v-else-if="alumno.turno==2">Vespertino</div>
                                <div v-else-if="alumno.turno==3">Nocturno</div>
                                <div v-else-if="alumno.turno==4">Mixto</div>
                            </th>
                            <th v-text="alumno.matricula_alumno"></th>
                            <th v-text="alumno.nombre_alumno"></th>
                            <th v-text="alumno.correo"></th>
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
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,  criterio, buscar, buscar2, buscar3)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,  criterio, buscar, buscar2, buscar3)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,  criterio, buscar, buscar2, buscar3)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin de la tabla Listado de alumnos-->
    </div>
</main>
</template>

<script>
    export default {
        data(){
            return{
                //Alumnos
                arrayAlumnos : [],
                //Variables para busqueda por filtro
                arrayCarrera : [],
                arrayGrados : [],
                //Paginación de la tabla alumnos
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
            }
        },
        watch : {
            criterio : function(opcion){
                /*busqueda_por_filtro(campoBuscar = true, col2 = false, col3 = true, col6 = true, col10 = false)*/
                if(opcion=='id_carrera')this.busqueda_por_filtro();
                if(opcion=='tipo_modalidad')this.busqueda_por_filtro();
                if(opcion=='matricula')this.busqueda_por_filtro();
                if(opcion=='nombre')this.busqueda_por_filtro();
                if(opcion=='correo')this.busqueda_por_filtro();
                if(opcion=='grado')this.busqueda_por_filtro();
                if(opcion=='turno')this.busqueda_por_filtro();
                if(opcion=='condicion')this.busqueda_por_filtro();
            }
        },
        methods : {
            listarAlumnos(page, criterio, buscar, buscar2, buscar3){
                let me = this;
                var url = '';
                var criterio2 = '', criterio3 = '';

                if(buscar2 !== '') criterio2 = 'grado';
                if(buscar3 !== '') criterio3 = 'turno';
                
                url = '/alumno?page='+page+'&criterio='+criterio+'&buscar='+buscar+
                '&criterio2='+criterio2+'&buscar2='+buscar2+'&criterio3='+criterio3+'&buscar3='+buscar3;
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
                    if(criterio2 === 'grado' || criterio3 === 'turno'){
                        /*busqueda_por_filtro(campoBuscar, col2, col3, col6, col10)*/
                        me.busqueda_por_filtro(false,true,false,false,true);
                    }else{
                        me.busqueda_por_filtro();
                    }
                });
            },
            cambiarPagina(page, criterio, buscar, buscar2, buscar3){//No mover
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina, es para buscar
                me.listarAlumnos(page, criterio, buscar, buscar2, buscar3);
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
            listarGradosCarrera(){
                this.buscar2 = '';
                this.buscar3 = '';
                if(typeof(this.buscar)==='number'){
                    /* busqueda_por_filtro(campoBuscar, col2, col3, col6, col10) */
                    this.busqueda_por_filtro(false,true,false,false,true);
                    this.arrayGrados = [];
                    var numGrados = 0;
                    for(var i = 0; i < this.arrayCarrera.length; i++){
                        if(this.buscar == this.arrayCarrera[i]['id']){
                            numGrados = this.arrayCarrera[i]['num_grados'];
                            for(var i = 1; i <= numGrados; i++){
                                this.arrayGrados.push({num: i})
                            }
                        }
                    }
                }
            },
        },
        mounted() {//no modificar
            this.listarAlumnos(1, this.criterio, this.buscar, this.buscar2, this.buscar3);
            this.seleccionarCarrera();
        }
    }
</script>

<style>
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
