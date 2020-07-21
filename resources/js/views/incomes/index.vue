<template>
    <layout>
      <template v-slot:header>
        <div class="flex justify-between items-center">
          <h1 class="text-lg font-semibold text-gray-900">
            Ingresos
          </h1>
          <router-link to='/incomes/create'>
            <button class="btn btn-primary">
              Crear ingreso
            </button>
          </router-link>
        </div>
      </template>
      <template v-slot:content>
        <simple-table :headings="headings" :data="incomes" :loading="loading" @editRecord="editRecord" @deleteRecord="deleteRecord"></simple-table>
      </template>
    </layout>
</template>

<script>
    import moment from 'moment';
    import Layout from './../../components/common/layout';
    import SimpleTable from './../../components/tables/simple-table';
    import INCOMES from '../../graphql/incomes/incomes.graphql';
    import DELETE_INCOME from '../../graphql/incomes/delete-income.graphql';
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data() {
            return {
                headings: [
                    'Fecha',
                    'Categoría',
                    'Cuenta',
                    'Valor'
                ],
                incomes: [],
                loading: true
            }
        },
        components: {
            SimpleTable,
            Layout
        },
        mounted() {
            this.getIncomes();
        },
        methods: {
            async getIncomes() {
                const response = await this.$apollo.query({
                    query: INCOMES,
                    variables: {
                      first: 20
                    }
                });
                this.incomes = response.data.incomes.edges.map(item => {
                    return {
                        id: item.node.id,
                        date: moment(item.node.date).format('MM/DD/YYYY'),
                        category: item.node.category.name,
                        account: item.node.account.name,
                        value: new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(item.node.amount),
                    };
                });
                this.loading = this.$apollo.loading;
            },
            editRecord(record) {
                this.$router.push(`/incomes/${record.id}/edit`);
            },
            deleteRecord(record) {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: `Quieres eliminar el ingreso?, esto no es reversible.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.loading = true;
                        return this.$apollo.mutate({
                            mutation: DELETE_INCOME,
                            variables: {
                                id: record.id
                            }
                        });
                    }
                }).then(response => {
                    this.$toasted.success('Ingreso eliminado satisfactoriamente!', {
                        position: "top-center",
                        duration : 5000
                    });
                    this.getIncomes();
                })
            }
        }
    }
</script>

<style scoped>

</style>
