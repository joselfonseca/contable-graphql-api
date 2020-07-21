import Vue from 'vue';
import VueRouter from 'vue-router';
import VueApollo from 'vue-apollo';
import Toasted from 'vue-toasted';
import { VueSpinners } from '@saeris/vue-spinners';
import money from 'v-money';

import Router from './router';
import apolloClient from './apollo/client';

// common components
import Layout from './components/common/layout';
import SimpleHeader from './components/common/simple-header';
import GraphqlErrorToast from './components/errors/graphql-error-toast';
import Loading from './components/common/loading';
import SimpleForm from './components/forms/simple-form';
import SimpleTable from './components/tables/simple-table'

Vue.use(VueRouter);
Vue.use(VueApollo);
Vue.use(Toasted);
Vue.use(VueSpinners);
Vue.use(money);

Vue.component('layout', Layout);
Vue.component('simple-header', SimpleHeader);
Vue.component('graphql-error-toast', GraphqlErrorToast);
Vue.component('loading', Loading);
Vue.component('simple-form', SimpleForm);
Vue.component('simple-table', SimpleTable);

const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
})

new Vue({
  router: Router,
  apolloProvider
}).$mount('#app')
