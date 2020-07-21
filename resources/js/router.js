
import VueRouter from "vue-router";

import Accounts from './views/accounts/index';
import CreateAccount from './views/accounts/create';
import EditAccount from './views/accounts/edit';

import Categories from './views/categories/index';
import CreateCategory from './views/categories/create';
import EditCategory from './views/categories/edit';

import Incomes from './views/incomes/index';
import CreateIncome from './views/incomes/create';
import EditIncome from './views/incomes/edit';

const routes = [
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
    },
    {
      path: '/incomes',
      component: Incomes
    },
    {
      path: '/incomes/create',
      component: CreateIncome
    },
    {
      path: '/incomes/:id/edit',
      component: EditIncome
    },
    {
        path: '/',
        redirect: '/accounts'
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
