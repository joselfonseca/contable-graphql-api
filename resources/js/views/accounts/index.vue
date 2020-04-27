<template>
    <div class="w-full">
        <div class="flex justify-between">
            <h2 class="h2">Cuentas</h2>
            <button class="button-primary" @click="goToCreate">Crear</button>
        </div>
        <simple-table :headings="headings" :data="accounts" :loading="loading" @editRecord="editRecord" @deleteRecord="deleteRecord"></simple-table>
    </div>
</template>

<script>
    import SimpleTable from './../../components/tables/simple-table';
    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';
    import DELETE_ACCOUNT from '../../graphql/accounts/delete-account.graphql';
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data() {
            return {
                headings: [
                    'ID',
                    'Nombre',
                    'Saldo actual'
                ],
                accounts: [],
                loading: true
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
                this.loading = this.$apollo.loading;
            },
            goToCreate() {
                this.$router.push('/accounts/create');
            },
            editRecord(record) {
                this.$router.push(`/accounts/${record.id}/edit`);
            },
            deleteRecord(record) {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: `Quieres eliminar la cuenta ${record.name}?, esto no es reversible.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.loading = true;
                        return this.$apollo.mutate({
                            mutation: DELETE_ACCOUNT,
                            variables: {
                                id: record.id
                            }
                        });
                    }
                }).then(response => {
                    this.getAccounts();
                })
            }
        }
    }
</script>

<style scoped>

</style>
