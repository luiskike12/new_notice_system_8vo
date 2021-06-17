<template>
    
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Perfil de usuario</li>
    </ol>
    <div class="container-fluid">
        <!-- Tarjeta de Perfil -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-user"></i>Perfil
            </div>
            <div class="card-group cards-perfil">
                
                <!-- card izquierda -->
                <div class="card">
                    <div class="card-body">
                    <!-- contenido card izquierda -->
                        <div class="form-group">
                            <i class="fa fa-address-card-o" style="font-size: 18px;"></i>
                            <strong>Datos de la cuenta</strong>
                        </div>

                        <div class="form-group">
                            <div class="row estilo-fila">
                                
                                <div class="col-md-2 estilo-columna-imagen">
                                    <img v-if="imagenEs === 'objeto'" class="img-thumbnail imagen" :src="imagen" width="80px" height="80px">
                                    <img v-else-if="imagenEs === 'string'" class="img-thumbnail imagen" :src="'storage/' + avatar" width="80px" height="80px">
                                    <img v-else class="img-thumbnail imagen" :src="'img/avatars/avatar.png'" width="80px" height="80px">
                                </div>
                                <div class="col-md-10 my-auto estilo-columna-imagen">
                                    <form @submit.prevent="guardarImagen" enctype="multipart/form-data" class="form-horizontal">
                                        <table class="seccion-archivo-imagen">
                                            <tbody>
                                                <tr class="row descripcion">
                                                    <span><em>Actualizar imagen de perfil</em></span>
                                                </tr>
                                                <tr class="row botones">
                                                    <td>
                                                        <div v-if="botonImagen == 0">
                                                            <label class="btn btn-outline-secondary btn-sm archivo-imagen" v-bind:style="msjValidacion.avatar.color">
                                                                <input type="file" @change="getDocumento"/>
                                                                Seleccionar imagen
                                                            </label>
                                                        </div>
                                                        <div v-else>
                                                            <button class="btn btn-outline-warning btn-sm" @click="deseleccionarImagen($event)">
                                                                Deseleccionar
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="submit" name="submit"  id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <!-- mensaje de error del campo imagen -->
                                <msj-validacion v-if="msjValidacion.avatar.mensaje">{{msjValidacion.avatar.mensaje}}</msj-validacion>
                                <div class="col-md estilo-columna-imagen">
                                    <em>Se recomienda usar una imagen de proporciones iguales</em>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    *Rol asignado (<span style="color: red;">Default</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <p class="form-control text-center" id="rol">{{rol}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    *Carrera asignada (<span style="color: red;">Default</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <p class="form-control text-center" id="rol">{{carrera}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    *Usuario asignado (<span style="color: blue;">Opcional</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <p class="form-control text-center" id="rol">{{usuario}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    *Correo electrónico asignado (<span style="color: blue;">Opcional</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <p class="form-control text-center" id="rol">{{email}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    *Nombre asignado (<span style="color: blue;">Opcional</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <p class="form-control text-center" id="rol">{{nombre}}</p>
                            </div>
                        </div>
                    <!-- contenido card izquierda -->
                    </div>
                </div>
                <!-- Fin card izquierda -->


                <!-- card derecha -->
                <div class="card">
                    <div class="card-body">
                        <!-- contenido card derecha -->
                        <div class="form-group">
                            <i class="fa fa-cog" style="font-size: 18px;"></i>
                            <strong>Configuración</strong>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="password">
                                <em>Para modificar su informacón, deberá confirmar su identidad 
                                    con su <b>Contraseña actual</b>, rellenando el campo y oprimiendo el boton 
                                    <b>Confirmar identidad</b>.
                                </em>
                            </label>
                            <label class="col-md estilo-columna-global" for="password">
                                <em>Modificar información (<span style="color: red;">requerido</span>)</em>
                            </label>
                            <div class="col-md estilo-columna-confirmar-contrasena">
                                <form action="">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" placeholder="Contraseña actual">
                                        <input type="submit" name="submit"  id="submit" class="btn btn-danger btn-sm" value="Confirmar identidad" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="form-group">
                                <label class="col-md estilo-columna-global" for="rol">
                                    <em>
                                        Nombre (<span style="color: red;">requerido</span>)
                                    </em>
                                </label>
                                <div class="col-md estilo-columna-global">
                                    <form action="">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-addon"><i class="fa fa-id-badge" style="font-size: 17px;"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup"
                                            style="border-left: none;" v-bind:placeholder="nombre">
                                            <input type="submit" name="submit"  id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                        </div>
                                    </form>
                                </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Usuario (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form action="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-user-o" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup"
                                        style="border-left: none;" v-bind:placeholder="usuario">
                                        <input type="submit" name="submit"  id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Correo electrónico (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form action="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-at" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup"
                                        style="border-left: none;" v-bind:placeholder="email">
                                        <input type="submit" name="submit"  id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Nueva contraseña (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form action="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-key" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="password" class="form-control" id="inlineFormInputGroup"
                                        style="border-left: none;" placeholder="Ingrese la nueva contraseña">
                                        <input type="submit" name="submit"  id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                        </div>

                    <!-- contenido card derecha -->
                    </div>
                </div>
                <!-- Fin card derecha -->

            </div>
        </div>
        <!-- Fin de la tarjeta padre perfil-->
    </div>
</main>

</template>


<script>
import MensajeValidacion from './local-components/msjValidacion-Perfil.vue';
export default {
    components : {
        'msj-validacion' : MensajeValidacion
    },
    data(){
        return {
            rol : '',
            carrera : '',
            usuario : '',
            email : '',
            nombre : '',
            avatar : '',

            //eventos de seleccion de imagen
            botonImagen : 0,
            imagenAnterior : '',
            //Datos del usuario
            arrayDatos : [],

            //Variables para el manejo de imagenes
            imagenEs : '',
            imagenSeleccionada: '',

            //Validación de campos
            numErrors : 0,
            colorError : {'border':'2px solid rgba(231, 76, 60, 0.5)'},
            msjValidacion : {
                avatar : {mensaje : '', color : '' },
            },

        }
    },
    computed : {
        imagen(){
            return this.imagenSeleccionada;
        }
    },
    methods : {
        obtenerDatosUsuario(){
            let me = this;

            axios.get('/perfil').then(function (response) {
                var respuesta = response.data;
                me.arrayDatos = respuesta.datosUsuario;

                me.rol = me.arrayDatos[0]['nombre_rol'];
                me.carrera = me.arrayDatos[0]['nombre_carrera'];
                me.usuario = me.arrayDatos[0]['usuario'];
                me.email = me.arrayDatos[0]['email'];
                me.nombre = me.arrayDatos[0]['nombre'];
                if( typeof(me.arrayDatos[0]['avatar']) === 'string'){
                    me.imagenEs = 'string';
                }
                me.avatar = me.arrayDatos[0]['avatar'];
                me.imagenAnterior = me.avatar;
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        },
        getDocumento(event){
            let file = event.target.files[0];
            
            if (!window.FileReader){
                this.msjValidacion.avatar.color = this.colorError;
                this.msjValidacion.avatar.mensaje = "El navegador no soporta este tipo de archivos";
                return;
            }else{
                if (!(/\.(jpg|png)$/i).test(file.name)){
                    this.msjValidacion.avatar.color = this.colorError;
                    this.msjValidacion.avatar.mensaje = "El archivo debe ser una imagen (jpg, png)";
                }
                else if (file.size > 200000){
                    this.msjValidacion.avatar.color = this.colorError;
                    this.msjValidacion.avatar.mensaje = "El peso mínimo requerido de la imagen es de 200kb";
                }
                else{    
                    this.msjValidacion.avatar.color = '';
                    this.msjValidacion.avatar.mensaje = '';
                    this.avatar = file;
                    this.imagenEs = 'objeto';
                    this.cargarImagen(file);
                    this.botonImagen = 1;
                }
            }

        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagenSeleccionada = e.target.result;
            }
            reader.readAsDataURL(file);
        },
        deseleccionarImagen(event){
            event.preventDefault();
            this.imagenSeleccionada = '';
            if( typeof(this.imagenAnterior) === 'string'){
                this.imagenEs = 'string';
            }else{
                this.imagenEs = '';
            }
            this.avatar = this.imagenAnterior;
            this.botonImagen = 0;
        },
        guardarImagen(){
            let me = this;

            let data = new FormData();
            data.append('avatar', me.avatar);
            let conf = {headers: {'Content-Type': 'multipart/form-data' }};

            axios.post('/perfil/guardarImagen', data, conf).then(function (response){//no modificar
                // always executed
                me.limpiar_campos();
                me.obtenerDatosUsuario();
                Swal.fire({
                    icon: 'success',
                    title: '¡Genial...!',
                    text: 'Se ha guardado correctamente'
                })
            }).catch(function (error){
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups...!',
                    text: 'Algo salio mal'
                })
                console.log(error)
            });

        },
        limpiar_campos(){
            
            this.rol = '';
            this.carrera = '';
            this.usuario = '';
            this.email = '';
            this.nombre = '';
            this.avatar = '';

            //eventos de seleccion de imagen
            this.botonImagen = 0;
            this.imagenAnterior = '';
            //Datos del usuario
            this.arrayDatos = [];

            //Variables para el manejo de imagenes
            this.imagenEs = '';
            this.imagenSeleccionada = '';
        }
    },
    mounted(){
        this.obtenerDatosUsuario();
    }
}
</script>

<style scoped>
/* ajustes en las tarjetas */ 
.cards-perfil > .card{
    margin-bottom: 0;
}

/* estilo de ajuestes para las columna*/
.estilo-fila{
    padding-left: 15px;
    padding-right: 15px;
}

.estilo-columna-global{
    padding: 0;
}



/* input file foto de perfil */
input[type="file"] {
    display: none;
}

/* boton de seleccion de imagen */
.archivo-imagen{
    margin: 0;
    cursor: pointer;
}

/* seccion actualizar imagen */
.estilo-columna-imagen{
    padding: 0;
    display: flex;
}

.seccion-archivo-imagen > tbody > .row{
    margin-left: 10px;
}

.seccion-archivo-imagen > tbody > .descripcion > span{
    margin: auto;
}

@media only screen and (max-width: 768px){
    .estilo-columna-imagen{
        padding: 0;
        display: flex;
    }
    .estilo-columna-imagen > form{
        margin: auto;
    }
    .imagen{
        margin: auto;
    }
    .seccion-archivo-imagen{
        margin: auto;
    }
    .estilo-columna-imagen > em{
        text-align: center;
    }
    .seccion-archivo-imagen > tbody > .row{
        margin-left: 0;
    }
}

/* modificacion de estilo confirmar contraseña */
.estilo-columna-confirmar-contrasena{
    padding: 0;
}
.estilo-columna-confirmar-contrasena > form{
    max-width: 310px;
}
</style>