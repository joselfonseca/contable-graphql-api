<template>
    <div class="w-full">
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
        <div class="flex justify-between mb-4">
            <label class="w-1/2 block text-gray-700 text-sm font-bold mb-2 pr-2" for="name">
                Nombre de la categoria
                <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-4" id="name" type="text" placeholder="Nombre">
            </label>
        </div>
        <div class="mb-4">
            <loading :loading="loading"></loading>
            <button v-if="!loading" class="button-primary" @click="submit">Crear categoría</button>
        </div>
    </div>
</template>

<script>
    import CREATE_CATEGORY from './../../graphql/categories/create-category.graphql';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    import Loading from './../../components/common/loading';

    export default {
        components: {GraphqlErrorToast, Loading},
        data() {
              return {
                  form: {
                      name: null,
                  },
                  errors: null,
                  loading: false
              }
        },
        methods: {
            async submit() {
                this.loading = true;
                this.errors = null;
                try {
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_CATEGORY,
                        variables: {
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
