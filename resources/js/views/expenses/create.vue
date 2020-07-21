<template>
  <layout>
      <template v-slot:header>
        <div class="flex justify-between items-center">
          <h1 class="text-lg font-semibold text-gray-900">
            Crear gasto
          </h1>
          <router-link to='/expenses'>
            <button class="btn btn-primary">
              Listado de gastos
            </button>
          </router-link>
        </div>
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form v-if="!loadingSelects" :fields="form.fields" :button-text="form.buttonText" @submited="createExpense"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import moment from 'moment';
    import Layout from './../../components/common/layout';
    import CREATE_EXPENSE from './../../graphql/expenses/create-expense.graphql';
    import EXPENSE_SELECT_DATA from './../../graphql/expenses/expenses-data.graphql';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    import Loading from './../../components/common/loading';
    import SimpleForm from './../../components/forms/simple-form';

    export default {
        components: {GraphqlErrorToast, Loading, Layout, SimpleForm},
        data() {
          return {
            loadingSelects: true,
            form: {
              fields: [
                {
                  type: 'select',
                  name: 'account_id',
                  placeholder: 'Cuenta',
                  required: true,
                  value: null,
                  label: 'Cuenta',
                  disabled: false
                },
                {
                  type: 'select',
                  name: 'category_id',
                  placeholder: 'Categoría',
                  required: true,
                  value: null,
                  label: 'Categoría',
                  disabled: false
                },
                {
                  type: 'date',
                  name: 'date',
                  placeholder: 'Fecha de tu gasto',
                  required: true,
                  value: moment().format('YYYY-MM-DD'),
                  label: 'Fecha de tu gasto',
                  disabled: false
                },
                {
                  type: 'money',
                  name: 'amount',
                  placeholder: 'Valor de tu gasto',
                  required: true,
                  value: 0,
                  label: 'Valor de tu gasto',
                  disabled: false
                },
                {
                  type: 'text',
                  name: 'description',
                  placeholder: 'Descripción de tu gasto',
                  required: false,
                  value: null,
                  label: 'Descripción de tu gasto',
                  disabled: false
                }
              ],
              buttonText: "Crear gasto"
            },
            errors: null,
            loading: false
          }
        },
        created() {
          this.getSelectsData();
        },
        methods: {
          async getSelectsData() {
            this.loadingSelects = true;
            try {
              const response = await this.$apollo.query({
                  query: EXPENSE_SELECT_DATA
              });
              this.form.fields[0].options = response.data.accounts.map(item => {
                return {
                  id: item.id,
                  value: item.name
                }
              });
              this.form.fields[1].options = response.data.categories.map(item => {
                return {
                  id: item.id,
                  value: item.name
                }
              });
              this.loadingSelects = false;
            } catch (error) {
                this.loadingSelects = false;
                this.errors = error;
            }
          },
          async createExpense(fields) {
            this.loading = true;
            this.errors = null;
            const input = {};
            fields.forEach(item => {
              input[item.name] = item.value;
            });
            try {
                const response = await this.$apollo.mutate({
                    mutation: CREATE_EXPENSE,
                    variables: {
                        input
                    }
                });
                this.loading = false;
                if (response.data) {
                    this.$toasted.success('Gasto creado satisfactoriamente!', {
                        position: "top-center",
                        duration : 5000
                    });
                    return this.$router.push('/expenses');
                }
            } catch (error) {
                this.loading = false;
                this.errors = error;
            }
          }
        }
    }
</script>

<style scoped>

</style>
