/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import login from '../js/components/Admin/LoginComponent';
import register from '../js/components/Admin/RegisterComponent';
import editUser from '../js/components/Admin/User/EditUserComponent';
import createJob from '../js/components/Admin/Job/CreateJobComponent';
import editJob from '../js/components/Admin/Job/EditJobComponent';
import deleteButton from '../js/components/Admin/Helper/DeleteButton';
import createSchedule from '../js/components/Admin/Schedule/CreateScheduleComponent';
import editSchedule from '../js/components/Admin/Schedule/EditScheduleComponent';
import statusButton from '../js/components/Admin/Helper/StatusButton';
import editRole from '../js/components/Admin/Role/EditRoleComponent';
import Toasted from 'vue-toasted';
import VueSocketIO from 'vue-socket.io'

var toastOptions = {
    duration: 4000,
    theme: 'toasted-primary',
    position: 'top-right'
};

Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://192.168.1.100:3000',
}))
Vue.use(Toasted, toastOptions)


const app = new Vue({
    el: '#app',
    components: {
        login,
        register,
        editUser,
        createJob,
        editJob,
        deleteButton,
        createSchedule,
        editSchedule,
        statusButton,
        editRole,
    },
    sockets: {
        connect: function () {
            console.log('socket connected')
        }
    },
    mounted: function() {
        let that = this;
        this.sockets.subscribe('laravel_database_private-schedule_channel:App\\Events\\AddSchedule', (data) => {
            console.log(data)
            that.$toasted.show('Worker Add Schedule: '+data.schedule.name, {
                type: 'success',
            });
        });
    }

});
