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
                <input v-model="form.balance" disabled="disabled" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="balance" type="number" min="0" placeholder="0">
            </label>
        </div>
        <div class="mb-4">
            <loading :loading="loading"></loading>
            <button v-if="!loading" class="button-primary" @click="submit">Editar cuenta</button>
        </div>
    </div>
</template>

<script>
    import GET_ACCOUNT from './../../graphql/accounts/account.graphql';
    import UPDATE_ACCOUNT from './../../graphql/accounts/update-account.graphql';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    import Loading from './../../components/common/loading';
    export default {
        components: {GraphqlErrorToast, Loading},
        data() {
            return {
                form: {
                    name: null,
                    balance:0
                },
                errors: null,
                loading: false,
                account: null
            }
        },
        mounted() {
            this.getAccount();
        },
        methods: {
            async getAccount() {
                this.loading = true;
                try {
                    const response = await this.$apollo.query({
                        query: GET_ACCOUNT,
                        variables: {
                            id: this.$route.params.id
                        }
                    });
                    this.loading = false;
                    this.account = response.data.account;
                    this.form.name = response.data.account.name;
                    this.form.balance = response.data.account.balance;
                } catch (e) {
                    console.log(e);
                }
            },
            async submit() {
                this.loading = true;
                this.errors = null;
                try {
                    const response = await this.$apollo.mutate({
                        mutation: UPDATE_ACCOUNT,
                        variables: {
                            id: this.account.id,
                            input: {
                                name: this.form.name
                            }
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        return this.$router.push('/accounts');
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
