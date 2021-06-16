/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//Uso de bootstrap vue en el proyecto
import BootstrapVue from 'bootstrap-vue' //Importing
Vue.use(BootstrapVue)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//COMPONENTES GLOBALES
Vue.component('carrera', require('./components/Carrera.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);
Vue.component('user', require('./components/User.vue').default);
Vue.component('matricula', require('./components/Matricula.vue').default);
Vue.component('alumno', require('./components/Alumno.vue').default);
Vue.component('aviso', require('./components/Aviso.vue').default);
Vue.component('tabla-avisos', require('./components/Tabla_avisos.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

//Pruebas de un Alumno registrandose
Vue.component('registro', require('./components/Registro.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const app = new Vue({
    el: '#app',
    data : {
        //"No modificar" --- selecciona el componente a mostrar
        menu : 0, 
        //"No modificar" --- variable para mostrar el template de cerrar sesión
        showItemUsuario : false,
        //objeto para el manejo de estilos
        colorHover : {
            perfil : '',
            cerrar : ''
        }
    },
    methods : {
        show_menu_cuenta(){
            this.showItemUsuario = true;
        },
        hoverPerfil(hover){
            if(hover){
                this.colorHover.perfil = {'background':'rgb(234, 250, 241, 0.7)'};
            }else{
                this.colorHover.perfil = '';
            }
        },
        hoverCerrar(hover){
            if(hover){
                this.colorHover.cerrar = {'background':'rgb(234, 250, 241, 0.7)'};
            }else{
                this.colorHover.cerrar = '';
            }
        }
    },
    mounted(){
        this.show_menu_cuenta();
    }
});

