require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';

Vue.use(VueRouter);
Vue.use(Vuelidate);

import App from './components/App.vue';
import Main from './components/Main.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Music from './components/Music.vue';


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Main
        },
        {
            path: '/auth/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/auth/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/music',
            name: 'music',
            component: Music,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
