
import VueRouter from "vue-router";

import PaymentMethods from './views/payment-methods/index';
import CreatePaymentMethod from './views/payment-methods/create';
import EditPaymentMethod from './views/payment-methods/edit';

import Categories from './views/categories/index';
import CreateCategory from './views/categories/create';
import EditCategory from './views/categories/edit';

import Incomes from './views/incomes/index';
import CreateIncome from './views/incomes/create';
import EditIncome from './views/incomes/edit';

import Expenses from './views/expenses/index';
import CreateExpense from './views/expenses/create';
import EditExpense from './views/expenses/edit';

const routes = [
    {
        path: '/payment-methods',
        component: PaymentMethods
    },
    {
        path: '/payment-methods/create',
        component: CreatePaymentMethod
    },
    {
        path: '/payment-methods/:id/edit',
        component: EditPaymentMethod
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
      path: '/expenses',
      component: Expenses
    },
    {
      path: '/expenses/create',
      component: CreateExpense
    },
    {
      path: '/expenses/:id/edit',
      component: EditExpense
    },
    {
        path: '/',
        redirect: '/incomes'
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
