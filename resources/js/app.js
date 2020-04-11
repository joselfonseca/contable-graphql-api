require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueApollo from 'vue-apollo';
import Toasted from 'vue-toasted';
import { VueSpinners } from '@saeris/vue-spinners';

import Router from './router';
import apolloClient from './apollo/client';

Vue.use(VueRouter);
Vue.use(VueApollo);
Vue.use(Toasted);
Vue.use(VueSpinners);

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})

new Vue({
    router: Router,
    apolloProvider
}).$mount('#app')
