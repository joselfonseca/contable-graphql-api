<template>
    <div class="w-full">
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="name">
                Nombre de la cuenta
                <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="name" type="text" placeholder="Nombre">
            </label>
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2" for="name">
                Saldo actual
                <input v-model="form.balance" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="balance" type="number" min="0" placeholder="0">
            </label>
        </div>
        <div class="mb-4">
            <button class="button-primary" @click="submit">Crear cuenta</button>
        </div>
    </div>
</template>

<script>
    import CREATE_ACCOUNT from './../../graphql/accounts/create-account.graphql';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    export default {
        components: {GraphqlErrorToast},
        data() {
              return {
                  form: {
                      name: null,
                      balance: 0
                  },
                  errors: null
              }
        },
        methods: {
            async submit() {
                this.errors = null;
                try {
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_ACCOUNT,
                        variables: {
                            input: {
                                name: this.form.name,
                                balance: this.form.balance
                            }
                        }
                    });
                    if (response.data) {
                        return this.$router.push('/accounts');
                    }
                } catch (error) {
                    this.errors = error;
                }

          }
        }
    }
</script>

<style scoped>

</style>
