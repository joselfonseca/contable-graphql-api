<template>
    <div class="w-full">
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="account">
                Cuenta
                <select id="account" v-model="form.account_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4">
                    <option :value="account.id" v-for="account in accounts">{{ account.name }}</option>
                </select>
            </label>
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2" for="category">
                Categoría
                <select id="category" v-model="form.category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4">
                    <option :value="category.id" v-for="category in categories">{{ category.name }}</option>
                </select>
            </label>
        </div>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="type">
                Tipo de transacción
                <select id="type" v-model="form.type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4">
                    <option value="INCOME">Ingreso</option>
                    <option value="EXPENSE">Gasto</option>
                </select>
            </label>
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2" for="amount">
                Valor
                <input v-model="form.amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="amount" type="number" min="0" placeholder="0">
            </label>
        </div>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="description">
                Descripción
                <input v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="description" type="text" placeholder="Descripción de la transacción">
            </label>
        </div>
        <div class="mb-4">
            <loading :loading="loading"></loading>
            <button v-if="!loading" class="button-primary" @click="submit">Crear transacción</button>
        </div>
    </div>
</template>

<script>
    import Loading from './../../components/common/loading';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    import GET_SELECT_DATA from "../../graphql/transactions/create-transaction-data.graphql";
    import CREATE_TRANSACTION from '../../graphql/transactions/create-transaction.graphql';

  export default {
    name: "create",
    components: {
      Loading, GraphqlErrorToast
    },
    data() {
      return {
        loading: true,
        accounts: [],
        categories: [],
        form: {
          account_id: null,
          category_id: null,
          type: 'INCOME',
          amount: 0,
          description: null
        },
        errors: null
      }
    },
    created() {
      this.getSelectsData();
    },
    methods: {
      async getSelectsData() {
        const response = await this.$apollo.query({
          query: GET_SELECT_DATA
        });
        this.accounts = response.data.accounts.data.map(item => {
          return {
            id: item.id,
            name: item.name
          };
        });
        this.categories = response.data.categories.data.map(item => {
          return {
            id: item.id,
            name: item.name
          };
        });
        this.loading = this.$apollo.loading;
      },
      async submit () {
        this.loading = true;
        this.errors = null;
        try {
            const response = await this.$apollo.mutate({
              mutation: CREATE_TRANSACTION,
              variables: {
                input: this.form
              }
            });
            this.loading = false;
            if (response.data) {
                return this.$router.push('/transactions');
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
