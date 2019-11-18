
import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './components/App';
import Home from "./components/Home";
import About from "./components/About";

const router = new VueRouter({
    mode: 'history',
    routes : [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component:About
        }
    ]
});




const app = new Vue({
    el: '#app',
    router,
    components: { App },
});

export default app;
