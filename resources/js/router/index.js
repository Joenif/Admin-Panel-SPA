import Vue from 'vue';
import Gate from '../Gate';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from '../store'
Vue.prototype.$gate = new Gate(store.state.user);


let routes = [
    {
        path: '/',
        name: 'homepage',
        component: require('../components/Home.vue').default,
        meta: {
            guest: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: require('../components/Login.vue').default,
        meta: {
            guest: true
        }
    },
    { 
        path: '/dashboard', 
    name: 'dashboard',
        component: require('../components/Dashboard.vue').default, 
        meta: {auth: true}
    },
    { 
        path: '/developer', 
        component: require('../components/Developer.vue').default,
        meta: {auth: true, is_admin: true}               
    },
    { 
        path: '/profile', 
        name: 'profile',
        component: require('../components/Profile.vue').default,
        meta: {auth: true}
    },
    { 
        path: '/users', 
        name: 'users',
        component: require('../components/Users.vue').default,
        meta: {auth: true, is_admin: true}
    },
    { 
        path: '*', 
        component: require('../components/404Page.vue').default,
        meta: {auth: true, }
    }
  ];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.state.token == null || localStorage.getItem('token') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            if (to.matched.some(record => record.meta.is_admin)) {
                if (this.$gate.isAdmin == 'admin') {
                    next()
                } else {
                    next({name: 'dashboard'})
                }
            } else {
                next()
            }
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (store.state.token == null || localStorage.getItem('token') == null) {
            next()
        } else {
            next({path: '/dashboard'})
        }
    }  else {
        next()
    }
})

export default router