
import './bootstrap';
import Vue from 'vue';
import routes from './routes/router'
import VueRouter from 'vue-router';
import App from './components/App';
import store from './store/index.js'

Vue.use(VueRouter);


const router = new VueRouter({
    mode: 'history',
    routes
});


router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware

    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context
    })
})

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});

export default app;
