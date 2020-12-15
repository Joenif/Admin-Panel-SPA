
require('./bootstrap');

// window._ = require('lodash');

window.Vue = require('vue');
import App from './App.vue'
import router from './router'
import store from './store'


Vue.prototype.$store = store;

require("./utilities");

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/404Page.vue').default
);

const app = new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>',
    data: {
        user: store.state.user,
        token: store.state.token
    },

    methods: {
        // searchit: _debounce(() => {
        //     Fire.$emit('searching');
        // }, 2000)
    }

});
