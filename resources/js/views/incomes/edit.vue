<template>
  <layout>
      <template v-slot:header>
        <simple-header title="Editar ingreso" button-text="Listado de ingresos" button-link='/incomes' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form v-if="!loadingSelects" :fields="form.fields" :button-text="form.buttonText" @submited="updateIncome"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import moment from 'moment';
    import UPDATE_INCOME from './../../graphql/incomes/update-income.graphql';
    import GET_INCOME from './../../graphql/incomes/income.graphql';
    import INCOME_SELECT_DATA from './../../graphql/incomes/incomes-data.graphql';

    export default {
        data() {
          return {
            loadingSelects: true,
            income: null,
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
                  placeholder: 'Fecha de tu ingreso',
                  required: true,
                  value: moment().format('YYYY-MM-DD'),
                  label: 'Fecha de tu ingreso',
                  disabled: false
                },
                {
                  type: 'money',
                  name: 'amount',
                  placeholder: 'Valor de tu ingreso',
                  required: true,
                  value: 0,
                  label: 'Valor de tu ingreso',
                  disabled: false
                },
                {
                  type: 'text',
                  name: 'description',
                  placeholder: 'Descripción de tu ingreso',
                  required: false,
                  value: null,
                  label: 'Descripción de tu ingreso',
                  disabled: false
                }
              ],
              buttonText: "Actualizar ingreso"
            },
            errors: null,
            loading: false
          }
        },
        created() {
          this.getIncome();
        },
        methods: {
          async getIncome() {
            this.loading = true;
            try {
                const response = await this.$apollo.query({
                    query: GET_INCOME,
                    variables: {
                        id: this.$route.params.id
                    }
                });
                this.loading = false;
                this.income = response.data.income;
                this.form.fields = this.form.fields.map(item => {
                  if (response.data.income[item.name] !== undefined) {
                    item.value = response.data.income[item.name];
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
                  query: INCOME_SELECT_DATA
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
          async updateIncome(fields) {
            this.loading = true;
            this.errors = null;
            const input = {};
            fields.forEach(item => {
              input[item.name] = item.value;
            });
            try {
                const response = await this.$apollo.mutate({
                    mutation: UPDATE_INCOME,
                    variables: {
                      id: this.income.id,
                      input
                    }
                });
                this.loading = false;
                if (response.data) {
                    this.$toasted.success('Ingreso actualizado satisfactoriamente!', {
                        position: "top-center",
                        duration : 5000
                    });
                    return this.$router.push('/incomes');
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
