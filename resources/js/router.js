
import VueRouter from "vue-router";

import Transactions from './views/transactions/index';
import Accounts from './views/accounts/index';
import CreateAccount from './views/accounts/create';
import EditAccount from './views/accounts/edit';

const routes = [
    {
        path: '/transactions',
        component: Transactions
    },
    {
        path: '/accounts',
        component: Accounts
    },
    {
        path: '/accounts/create',
        component: CreateAccount
    },
    {
        path: '/accounts/:id/edit',
        component: EditAccount
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
