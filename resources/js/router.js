
import VueRouter from "vue-router";

import Transactions from './views/transactions/index';
import CreateTransaction from './views/transactions/create';

import Accounts from './views/accounts/index';
import CreateAccount from './views/accounts/create';
import EditAccount from './views/accounts/edit';

import Categories from './views/categories/index';
import CreateCategory from './views/categories/create';
import EditCategory from './views/categories/edit';

const routes = [
    {
        path: '/transactions',
        component: Transactions
    },
    {
        path: '/transactions/create',
        component: CreateTransaction
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
    },
    {
        path: '/categories',
        component: Categories
    },
    {
        path: '/categories/create',
        component: CreateCategory
    },
    {
        path: '/categories/:id/edit',
        component: EditCategory
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
