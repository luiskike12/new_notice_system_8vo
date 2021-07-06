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
                                    <img v-else class="img-thumbnail imagen" :src="'storage/img/avatars/avatar.png'" width="80px" height="80px">
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
                                                        <div v-if="botonImagen === 0">
                                                            <label class="btn btn-outline-secondary btn-sm archivo-imagen" v-bind:style="msjValidacion.avatar.color">
                                                                <input type="file" id="archivoImagen" @change="getDocumento"/>
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
                                <em>Para actualizar su informacón, deberá confirmar su identidad 
                                    con su <b>Contraseña actual</b>, rellenando el campo y oprimiendo el boton 
                                    <b>Confirmar identidad</b>.
                                </em>
                            </label>
                            <label class="col-md estilo-columna-global" for="password">
                                <em>Actualizar información (<span style="color: red;">requerido</span>)</em>
                            </label>
                            <div class="col-md estilo-columna-confirmar-contrasena">
                                <form @submit.prevent="confirmarIdentidad" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="identifyPassword" v-model="passwordActual" :style="msjValidacion.identidad.color" placeholder="Contraseña actual">
                                        <input type="submit" name="submit"  id="identifySubmit" class="btn btn-danger btn-sm" value="Confirmar identidad" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                            <msj-validacion v-if="msjValidacion.identidad.mensaje">{{msjValidacion.identidad.mensaje}}</msj-validacion>
                        </div>

                        <div class="form-group" v-bind:style="msjValidacion.informacion.color">
                            <div class="row row-seleccion-campos">
                                <label class="col-md col-seleccion-campos text-center" style="margin-bottom: 0;" for="descripcion">
                                    <em>Seleccione la información ha actualizar</em>
                                </label>
                            </div>
                            <div class="row row-seleccion-campos">
                            <!-- fila del contenido -->
                                <div class="col-md-6 col-seleccion-campos">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon">
                                                <input type="checkbox" id="seleccionNombre" v-model="camposSeleccionados" @change="seleccionNombre" value="nombre">
                                            </div>
                                        </div>
                                        <label class="form-control label-seleccion-campos" for="nombre">
                                            <em class="texto-label">Nombre</em>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-seleccion-campos">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon">
                                                <input type="checkbox" id="seleccionUsuario" v-model="camposSeleccionados" @change="seleccionUsuario" value="usuario">
                                            </div>
                                        </div>
                                        <label class="form-control label-seleccion-campos" for="usuario">
                                            <em class="texto-label">Usuario</em>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-seleccion-campos">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon">
                                                <input type="checkbox" id="seleccionEmail" v-model="camposSeleccionados" @change="seleccionEmail" value="email">
                                            </div>
                                        </div>
                                        <label class="form-control label-seleccion-campos" for="email">
                                            <em class="texto-label">Correo electrónico</em>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-seleccion-campos">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon">
                                                <input type="checkbox" id="seleccionPassword" v-model="camposSeleccionados" @change="seleccionPassword" value="password">
                                            </div>
                                        </div>
                                        <label class="form-control label-seleccion-campos" for="email">
                                            <em class="texto-label">Nueva contraseña</em>
                                        </label>
                                    </div>
                                </div>
                            <!-- fila del contenido -->
                            </div>
                            <div class="row row-seleccion-campos">
                                <msj-validacion v-if="msjValidacion.informacion.mensaje">{{msjValidacion.informacion.mensaje}}</msj-validacion>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Nombre (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form @submit.prevent="actualizarNombre" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-id-badge" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="text" v-model="nombre" class="form-control" id="nombre"
                                        style="border-left: none;" v-bind:placeholder="nombre"
                                        v-bind:style="msjValidacion.nombre.color"
                                        v-bind:disabled="habilitarCambios.nombre.campo==false">
                                        <input v-if="habilitarCambios.nombre.campo==true" type="submit" name="submit"  id="submit" 
                                        class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                            <msj-validacion v-if="msjValidacion.nombre.mensaje">{{msjValidacion.nombre.mensaje}}</msj-validacion>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Usuario (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form @submit.prevent="validar_y_actualizarUsuario" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-user-o" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="text" v-model="usuario" class="form-control" id="usuario"
                                        style="border-left: none;" v-bind:placeholder="usuario"
                                        v-bind:style="msjValidacion.usuario.color"
                                        v-bind:disabled="habilitarCambios.usuario.campo==false">
                                        <input v-if="habilitarCambios.usuario.campo==true" type="submit" name="submit"  
                                        id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                            <msj-validacion v-if="msjValidacion.usuario.mensaje">{{msjValidacion.usuario.mensaje}}</msj-validacion>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Correo electrónico (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form @submit.prevent="validar_y_actualizarEmail" enctype="multipart/form-data" novalidate>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-at" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="email" v-model="email" class="form-control" id="email"
                                        style="border-left: none;" v-bind:placeholder="email"
                                        v-bind:style="msjValidacion.email.color"
                                        v-bind:disabled="habilitarCambios.email.campo==false">
                                        <input v-if="habilitarCambios.email.campo==true" type="submit" name="submit"  
                                        id="submit" class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                            <msj-validacion v-if="msjValidacion.email.mensaje">{{msjValidacion.email.mensaje}}</msj-validacion>
                        </div>

                        <div class="form-group">
                            <label class="col-md estilo-columna-global" for="rol">
                                <em>
                                    Nueva contraseña (<span style="color: red;">requerido</span>)
                                </em>
                            </label>
                            <div class="col-md estilo-columna-global">
                                <form @submit.prevent="actualizarPassword" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-addon"><i class="fa fa-key" style="font-size: 17px;"></i></div>
                                        </div>
                                        <input type="password" v-model="nuevoPassword" class="form-control" id="password"
                                        style="border-left: none;" placeholder="Ingrese la nueva contraseña" 
                                        v-bind:style="msjValidacion.password.color"
                                        v-bind:disabled="habilitarCambios.password.campo==false">
                                        <input v-if="habilitarCambios.password.campo==true" type="submit" name="submit"  id="submit" 
                                        class="btn btn-primary btn-sm" value="Actualizar" style="cursor:pointer;">
                                    </div>
                                </form>
                            </div>
                            <msj-validacion v-if="msjValidacion.password.mensaje">{{msjValidacion.password.mensaje}}</msj-validacion>
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
            nuevoPassword : '',

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
                identidad : {mensaje : '', color : '' },
                informacion : {mensaje : '', color : '' },
                nombre : {mensaje : '', color : '' },
                usuario : {mensaje : '', color : '' },
                email : {mensaje : '', color : '' },
                password : {mensaje : '', color : '' },
            },

            //campos a desabilitar y habilitar
            habilitarCambios : {
                nombre : {campo : false, boton : false},
                usuario : {campo : false, boton : false},
                email : {campo : false, boton : false},
                password : {campo : false, boton : false},
            },
            camposSeleccionados : [],
            passwordActual : '',
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
                if(this.validar_archivo_imagen(file)){
                    return;
                }else{
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
            if(this.validar_archivo_imagen(this.avatar)){
                return;
            }

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
                    text: 'Se ha actualizado la imagen correctamente'
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
        validar_archivo_imagen(archivo){
            this.numErrors = 0;
            var campoImagen = document.getElementById('archivoImagen');

            if(typeof(archivo) !== 'object'){
                this.numErrors = 1;
                this.msjValidacion.avatar.color = this.colorError;
                this.msjValidacion.avatar.mensaje = "Seleccione una imagen";
                campoImagen.value = '';
            }
            else if(!(/\.(jpg|png)$/i).test(archivo.name)){
                this.numErrors = 1;
                this.msjValidacion.avatar.color = this.colorError;
                this.msjValidacion.avatar.mensaje = "El archivo debe ser una imagen (jpg, png)";
                campoImagen.value = '';
            }
            else if (archivo.size > 200000){
                this.numErrors = 1;
                this.msjValidacion.avatar.color = this.colorError;
                this.msjValidacion.avatar.mensaje = "El peso mínimo requerido de la imagen es de 200kb";
                campoImagen.value = '';
            }
            else{    
                this.msjValidacion.avatar.color = '';
                this.msjValidacion.avatar.mensaje = '';
            }

            return this.numErrors;
        },
        confirmarIdentidad(){
            if(!this.passwordActual){
                this.numErrors = 1;
                this.msjValidacion.identidad.color = this.colorError;
                this.msjValidacion.identidad.mensaje = "No dejar el campo vacío";
            }else{
                this.msjValidacion.identidad.color = '';
                this.msjValidacion.identidad.mensaje = '';

                let me = this;
                var identidad = null;
                var url = '/perfil/confirmarIdentidad?passwordActual=' + me.passwordActual;

                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    identidad = respuesta.identidad;
                    me.informacion_a_modificar(identidad);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            }

        },
        informacion_a_modificar(identidad){
            if(identidad){
                this.msjValidacion.identidad.color = '';
                this.msjValidacion.identidad.mensaje = '';
                this.passwordActual = '';
                
                if(this.camposSeleccionados.length > 0){
                    this.msjValidacion.informacion.color = {'border': 'none'};
                    this.msjValidacion.informacion.mensaje = '';

                    for(var i = 0; i < this.camposSeleccionados.length; i++){
                        if(this.camposSeleccionados[i]==='nombre'){
                            this.habilitarCambios.nombre.campo = true;
                            this.habilitarCambios.nombre.boton = true;
                        }
                        else if(this.camposSeleccionados[i]==='usuario'){
                            this.habilitarCambios.usuario.campo = true;
                            this.habilitarCambios.usuario.boton = true;
                        }
                        else if(this.camposSeleccionados[i]==='email'){
                            this.habilitarCambios.email.campo = true;
                            this.habilitarCambios.email.boton = true;
                        }
                        else if(this.camposSeleccionados[i]==='password'){
                            this.habilitarCambios.password.campo = true;
                            this.habilitarCambios.password.boton = true;
                        }
                    }
                }else{
                    this.msjValidacion.informacion.color = this.colorError;
                    this.msjValidacion.informacion.mensaje = "Seleccione la información a modificar";
                }
            }else{
                this.msjValidacion.identidad.color = this.colorError;
                this.msjValidacion.identidad.mensaje = "Contraseña invalida";
            }

        },
        actualizarNombre(){
            if(this.validacionCampos()){
                return;
            }

            let me = this;
            //          url del controlador
            axios.put('/perfil/actualizarNombre', {
                'nombre' : me.nombre
            }).then(function (response){
                me.limpiarSeleccionModificada('nombre');
                me.obtenerDatosUsuario();        
                Swal.fire({
                    icon: 'success',
                    title: '¡Genial...!',
                    text: 'Se ha actualizado el nombre correctamente'
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
        validar_y_actualizarUsuario(){
            if(this.validacionCampos()){
                return;
            }
            let me = this;
            var respuestaUsuario = '';
            //          url del controlador
            var url = '/perfil/validarUsuario?usuario=' + this.usuario;
            axios.get(url).then(function (response){
                var respuesta = response.data;
                respuestaUsuario = respuesta.respuestaUsuario;
                me.actualizarUsuario(respuestaUsuario);        
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        },
        actualizarUsuario(respuesta){
            if(respuesta){
                this.msjValidacion.usuario.color = this.colorError;
                this.msjValidacion.usuario.mensaje = respuesta;
            }
            else{
                let me = this;
                this.msjValidacion.usuario.color = '';
                this.msjValidacion.usuario.mensaje = '';
                //  url del controlador
                axios.put('/perfil/actualizarUsuario', {
                    'usuario' : this.usuario
                }).then(function (response){
                    me.limpiarSeleccionModificada('usuario');
                    me.obtenerDatosUsuario();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Genial...!',
                        text: 'Se ha actualizado el usuario correctamente'
                    })
                }).catch(function (error){
                    Swal.fire({
                        icon: 'error',
                        title: '¡Ups...!',
                        text: 'Algo salio mal'
                    })
                    console.log(error)
                });
            }  
        },
        validar_y_actualizarEmail(){
            if(this.validacionCampos()){
                return;
            }
            let me = this;
            var respuestaEmail = '';
            //          url del controlador
            var url = '/perfil/validarEmail?email=' + this.email;
            axios.get(url).then(function (response){
                var respuesta = response.data;
                respuestaEmail = respuesta.respuestaEmail;
                me.actualizarEmail(respuestaEmail);        
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        },
        actualizarEmail(respuesta){
            if(respuesta){
                this.msjValidacion.email.color = this.colorError;
                this.msjValidacion.email.mensaje = respuesta;
            }
            else{
                let me = this;
                this.msjValidacion.email.color = '';
                this.msjValidacion.email.mensaje = '';
                //  url del controlador
                axios.put('/perfil/actualizarEmail', {
                    'email' : this.email
                }).then(function (response){
                    me.limpiarSeleccionModificada('email');
                    me.obtenerDatosUsuario();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Genial...!',
                        text: 'Se ha actualizado el correo electrónico correctamente'
                    })
                }).catch(function (error){
                    Swal.fire({
                        icon: 'error',
                        title: '¡Ups...!',
                        text: 'Algo salio mal'
                    })
                    console.log(error)
                });
            }
        },
        actualizarPassword(){
            if(this.validacionCampos()){
                return;
            }

            let me = this;
            //  url del controlador
            axios.put('/perfil/actualizarPassword', {
                'nuevoPassword' : this.nuevoPassword
            }).then(function (response){
                me.limpiarSeleccionModificada('password');
                me.obtenerDatosUsuario();
                Swal.fire({
                    icon: 'success',
                    title: '¡Genial...!',
                    text: 'Se ha actualizado la contraseña correctamente'
                })
            }).catch(function (error){
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups...!',
                    text: 'Algo salio mal'
                })
                console.log(error)
            }).then(function () {
                // always executed
                me.nuevoPassword = '';
            });
        },
        limpiarSeleccionModificada(opcion){
            const eleccion = (element) => element === opcion;
            var indice = this.camposSeleccionados.findIndex(eleccion);
            this.camposSeleccionados.splice(indice, 1);
            
            if(opcion==='nombre'){
                this.habilitarCambios.nombre.campo = false;
                this.habilitarCambios.nombre.boton = false;
            }
            else if(opcion==='usuario'){
                this.habilitarCambios.usuario.campo = false;
                this.habilitarCambios.usuario.boton = false;
            }
            else if(opcion==='email'){
                this.habilitarCambios.email.campo = false;
                this.habilitarCambios.email.boton = false;
            }
            else if(opcion==='password'){
                this.habilitarCambios.password.campo = false;
                this.habilitarCambios.password.boton = false;
            }

            if(this.camposSeleccionados.length == 0){
                this.limpiar_campos();        
            }
        },
        seleccionNombre(){
            if(!document.getElementById('seleccionNombre').checked){
                this.habilitarCambios.nombre.campo = false;
                this.habilitarCambios.nombre.boton = false;
            }
        },
        seleccionUsuario(){
            if (!document.getElementById('seleccionUsuario').checked){
                this.habilitarCambios.usuario.campo = false;
                this.habilitarCambios.usuario.boton = false;
            }
        },
        seleccionEmail(){
            if (!document.getElementById('seleccionEmail').checked){
                this.habilitarCambios.email.campo = false;
                this.habilitarCambios.email.boton = false;
            }
        },
        seleccionPassword(){
            if (!document.getElementById('seleccionPassword').checked){
                this.habilitarCambios.password.campo = false;
                this.habilitarCambios.password.boton = false;
            }
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

            //Campos a desabilitar y habilitar
            this.camposSeleccionados = [];
            this.passwordActual = '';
            this.nuevoPassword = '';

            //Mensajes de validación
            this.msjValidacion = {
                avatar : {mensaje : '', color : '' },
                identidad : {mensaje : '', color : '' },
                informacion : {mensaje : '', color : '' },
                nombre : {mensaje : '', color : '' },
                usuario : {mensaje : '', color : '' },
                email : {mensaje : '', color : '' },
                password : {mensaje : '', color : '' },
            };
        },
        validacionCampos(){
            this.numErrors = 0;

            if(!this.nombre){
                this.numErrors = 1;
                this.msjValidacion.nombre.color = this.colorError;
                this.msjValidacion.nombre.mensaje = "No dejar el campo vacío";
            }else{
                this.msjValidacion.nombre.color = '';
                this.msjValidacion.nombre.mensaje = '';
            }

            if(!this.usuario){
                this.numErrors = 1;
                this.msjValidacion.usuario.color = this.colorError;
                this.msjValidacion.usuario.mensaje = "No dejar el campo vacío";
            }else{
                this.msjValidacion.usuario.color = '';
                this.msjValidacion.usuario.mensaje = '';
            }
            
            var validarEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            if(!this.email){
                this.numErrors = 1;
                this.msjValidacion.email.color = this.colorError;
                this.msjValidacion.email.mensaje = "No dejar el campo vacío";
            }
            else if(validarEmail.test(this.email)==false){
                this.numErrors = 1;
                this.msjValidacion.email.color = this.colorError;
                this.msjValidacion.email.mensaje = "El correo no esta bien escrito";
            }
            else{
                this.msjValidacion.email.color = '';
                this.msjValidacion.email.mensaje = '';
            }
            
            if(this.habilitarCambios.password.campo == true){
                if(!this.nuevoPassword){
                    this.numErrors = 1;
                    this.msjValidacion.password.color = this.colorError;
                    this.msjValidacion.password.mensaje = "No dejar el campo vacío";
                }
                else if(this.nuevoPassword.length < 8){
                    this.numErrors = 1;
                    this.msjValidacion.password.color = this.colorError;
                    this.msjValidacion.password.mensaje = "La contraseña debe contener minimo 8 caracteres";
                }
                else{
                    this.msjValidacion.password.color = '';
                    this.msjValidacion.password.mensaje = '';
                }
            }

            return this.numErrors;
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

/* estilos y justes a la sección de elección de campos */
.row-seleccion-campos{
    padding-left: 15px;
    padding-right: 15px;
}

.col-seleccion-campos{
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
}

.label-seleccion-campos{
    padding-top: 5px; 
    padding-bottom: 5px;
    border-left: none;
    overflow: hidden;
}
.label-seleccion-campos > .texto-label{
    white-space: nowrap;
}

</style>