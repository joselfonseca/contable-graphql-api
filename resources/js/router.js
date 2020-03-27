
import VueRouter from "vue-router";

import Transactions from './views/transactions/index';
import Accounts from './views/accounts/index';

const routes = [
    {
        path: '/transactions',
        component: Transactions
    },
    {
        path: '/accounts',
        component: Accounts
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
