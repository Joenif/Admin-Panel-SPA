import Vue from "vue";

const store = Vue.observable({
    state: {
        user: [],
        token: null,
    },
    add(user, token) {
        store.state.user.push(user);
        store.state.token = token
    },
    remove() {
        store.state.user = [];
        store.state.token = null;
        localStorage.removeItem('token');
    }
});

export default store