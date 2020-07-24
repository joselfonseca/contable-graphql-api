<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Medios de pago" button-text="Crear medio de pago" button-link='/payment-methods/create' />
      </template>
      <template v-slot:content>
        <simple-table :headings="headings" :data="paymentMethods" :loading="loading" @editRecord="editRecord" @deleteRecord="deleteRecord"></simple-table>
      </template>
    </layout>
</template>

<script>
    import PAYMENT_METHODS from '../../graphql/payment-methods/payment-methods.graphql';
    import DELETE_PAYMENT_METHOD from '../../graphql/payment-methods/delete-payment-method.graphql';
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data() {
            return {
                headings: [
                    'Nombre'
                ],
                paymentMethods: [],
                loading: true
            }
        },
        mounted() {
            this.getPaymentMethods();
        },
        methods: {
            async getPaymentMethods() {
                const response = await this.$apollo.query({
                    query: PAYMENT_METHODS
                });
                this.paymentMethods = response.data.paymentMethods.map(item => {
                    return {
                        id: item.id,
                        name: item.name
                    };
                });
                this.loading = this.$apollo.loading;
            },
            editRecord(record) {
                this.$router.push(`/payment-methods/${record.id}/edit`);
            },
            deleteRecord(record) {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: `Quieres eliminar el medio de pago ${record.name}?, esto no es reversible.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.loading = true;
                        return this.$apollo.mutate({
                            mutation: DELETE_PAYMENT_METHOD,
                            variables: {
                                id: record.id
                            }
                        });
                    }
                }).then(response => {
                    this.$toasted.success('Medio de pago eliminado satisfactoriamente!', {
                          position: "top-center",
                          duration : 5000
                      });
                    this.getPaymentMethods();
                })
            }
        }
    }
</script>

<style scoped>

</style>
