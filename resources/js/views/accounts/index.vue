<template>
    <div class="w-full">
        <div class="flex justify-between">
            <h2 class="h2">Cuentas</h2>
            <button class="button-primary" @click="goToCreate">Crear</button>
        </div>
        <simple-table :headings="headings" :data="accounts"></simple-table>
    </div>
</template>

<script>
    import SimpleTable from './../../components/tables/simple-table';

    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';

    export default {
        data() {
            return {
                headings: [
                    'ID',
                    'Nombre',
                    'Saldo actual'
                ],
                accounts: []
            }
        },
        components: {
            SimpleTable
        },
        mounted() {
            this.getAccounts();
        },
        methods: {
            async getAccounts() {
                const response = await this.$apollo.query({
                    query: ACCOUNTS,
                    variables: {
                        first: 20,
                        page: 1
                    }
                });
                this.accounts = response.data.accounts.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name,
                        balance: item.balance
                    };
                });
            },
            goToCreate() {
                this.$router.push('/accounts/create');
            }
        }
    }
</script>

<style scoped>

</style>
