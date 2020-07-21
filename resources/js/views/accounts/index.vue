<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Cuentas" button-text="Crear cuenta" button-link='/accounts/create' />
      </template>
      <template v-slot:content>
        <simple-table :headings="headings" :data="accounts" :loading="loading" @editRecord="editRecord" @deleteRecord="deleteRecord"></simple-table>
      </template>
    </layout>
</template>

<script>
    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';
    import DELETE_ACCOUNT from '../../graphql/accounts/delete-account.graphql';
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data() {
            return {
                headings: [
                    'Nombre'
                ],
                accounts: [],
                loading: true
            }
        },
        mounted() {
            this.getAccounts();
        },
        methods: {
            async getAccounts() {
                const response = await this.$apollo.query({
                    query: ACCOUNTS
                });
                this.accounts = response.data.accounts.map(item => {
                    return {
                        id: item.id,
                        name: item.name
                    };
                });
                this.loading = this.$apollo.loading;
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
                    this.$toasted.success('Cuenta eliminada satisfactoriamente!', {
                          position: "top-center",
                          duration : 5000
                      });
                    this.getAccounts();
                })
            }
        }
    }
</script>

<style scoped>

</style>
