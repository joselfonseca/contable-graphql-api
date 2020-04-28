<template>
    <div class="w-full">
        <div class="flex justify-between">
            <h2 class="h2">Categorías</h2>
            <button class="button-primary" @click="goToCreate">Crear</button>
        </div>
        <simple-table :headings="headings" :data="categories" :loading="loading" @editRecord="editRecord" @deleteRecord="deleteRecord"></simple-table>
    </div>
</template>

<script>
    import SimpleTable from './../../components/tables/simple-table';
    import CATEGORIES from '../../graphql/categories/categories.graphql';
    import DELETE_CATEGORY from '../../graphql/categories/delete-category.graphql';
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        data() {
            return {
                headings: [
                    'ID',
                    'Nombre'
                ],
                categories: [],
                loading: true
            }
        },
        components: {
            SimpleTable
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            async getCategories() {
                const response = await this.$apollo.query({
                    query: CATEGORIES,
                    variables: {
                        first: 20,
                        page: 1
                    }
                });
                this.categories = response.data.categories.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name
                    };
                });
                this.loading = this.$apollo.loading;
            },
            goToCreate() {
                this.$router.push('/categories/create');
            },
            editRecord(record) {
                this.$router.push(`/categories/${record.id}/edit`);
            },
            deleteRecord(record) {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: `Quieres eliminar la categoría ${record.name}?, esto no es reversible.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.loading = true;
                        return this.$apollo.mutate({
                            mutation: DELETE_CATEGORY,
                            variables: {
                                id: record.id
                            }
                        });
                    }
                }).then(response => {
                    this.getCategories();
                })
            }
        }
    }
</script>

<style scoped>

</style>
