<template>
  <layout>
      <template v-slot:header>
        <simple-header title="Editar gasto" button-text="Listado de gastos" button-link='/expenses' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form v-if="!loadingSelects" :fields="form.fields" :button-text="form.buttonText" @submited="updateExpense"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import moment from 'moment';
    import UPDATE_EXPENSE from './../../graphql/expenses/update-expense.graphql';
    import GET_EXPENSE from './../../graphql/expenses/expense.graphql';
    import EXPENSE_SELECT_DATA from './../../graphql/expenses/expenses-data.graphql';

    export default {
        data() {
          return {
            loadingSelects: true,
            expense: null,
            form: {
              fields: [
                {
                  type: 'select',
                  name: 'payment_method_id',
                  placeholder: 'Medio de pago',
                  required: true,
                  value: null,
                  label: 'Medio de pago',
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
              buttonText: "Actualizar gasto"
            },
            errors: null,
            loading: false
          }
        },
        created() {
          this.getExpense();
        },
        methods: {
          async getExpense() {
            this.loading = true;
            try {
                const response = await this.$apollo.query({
                    query: GET_EXPENSE,
                    variables: {
                        id: this.$route.params.id
                    }
                });
                this.loading = false;
                this.expense = response.data.expense;
                this.form.fields = this.form.fields.map(item => {
                  if (response.data.expense[item.name] !== undefined) {
                    item.value = response.data.expense[item.name];
                  }
                  return item;
                });
                this.getSelectsData();
            } catch (e) {
                console.log(e);
            }
          },
          async getSelectsData() {
            this.loadingSelects = true;
            try {
              const response = await this.$apollo.query({
                  query: EXPENSE_SELECT_DATA
              });
              this.form.fields[0].options = response.data.paymentMethods.map(item => {
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
          async updateExpense(fields) {
            this.loading = true;
            this.errors = null;
            const input = {};
            fields.forEach(item => {
              input[item.name] = item.value;
            });
            try {
                const response = await this.$apollo.mutate({
                    mutation: UPDATE_EXPENSE,
                    variables: {
                      id: this.expense.id,
                      input
                    }
                });
                this.loading = false;
                if (response.data) {
                    this.$toasted.success('Gasto actualizado satisfactoriamente!', {
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
