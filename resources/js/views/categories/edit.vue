<template>
    <div class="w-full">
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="name">
                Nombre de la categoría
                <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="name" type="text" placeholder="Nombre">
            </label>
        </div>
        <div class="mb-4">
            <loading :loading="loading"></loading>
            <button v-if="!loading" class="button-primary" @click="submit">Editar categoría</button>
        </div>
    </div>
</template>

<script>
    import GET_CATEGORY from './../../graphql/categories/category.graphql';
    import UPDATE_CATEGORY from './../../graphql/categories/update-category.graphql';
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
                category: null
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
                        query: GET_CATEGORY,
                        variables: {
                            id: this.$route.params.id
                        }
                    });
                    this.loading = false;
                    this.category = response.data.category;
                    this.form.name = response.data.category.name;
                } catch (e) {
                    console.log(e);
                }
            },
            async submit() {
                this.loading = true;
                this.errors = null;
                try {
                    const response = await this.$apollo.mutate({
                        mutation: UPDATE_CATEGORY,
                        variables: {
                            id: this.category.id,
                            input: {
                                name: this.form.name
                            }
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        return this.$router.push('/categories');
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
