require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueApollo from 'vue-apollo'

import Router from './router';
import apolloClient from './apollo/client';

Vue.use(VueRouter);
Vue.use(VueApollo)

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})

new Vue({
    router: Router,
    apolloProvider
}).$mount('#app')
