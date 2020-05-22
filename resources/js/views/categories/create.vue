<template>
  <layout>
      <template v-slot:header>
        <div class="flex justify-between items-center">
          <h1 class="text-lg font-semibold text-gray-900">
            Crear categoria
          </h1>
          <router-link to='/categories'>
            <button class="btn btn-primary">
              <svg class="-ml-0.5 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z" clip-rule="evenodd"/>
              </svg>
              Listado de categorias
            </button>
          </router-link>
        </div>
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="createCategory"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import Layout from './../../components/common/layout';
    import CREATE_CATEGORY from './../../graphql/categories/create-category.graphql';
    import GraphqlErrorToast from './../../components/errors/graphql-error-toast';
    import Loading from './../../components/common/loading';
    import SimpleForm from './../../components/forms/simple-form';

    export default {
        components: {GraphqlErrorToast, Loading, Layout, SimpleForm},
        data() {
              return {
                  form: {
                      fields: [
                        {
                          type: 'text',
                          name: 'name',
                          placeholder: 'Nombre de tu categoria',
                          required: true,
                          value: null,
                          label: 'Nombre de tu categoria',
                          disabled: false
                        }
                      ],
                      buttonText: "Crear categoria"
                  },
                  errors: null,
                  loading: false
              }
        },
        methods: {
            async createCategory(fields) {
                this.loading = true;
                this.errors = null;
                const input = {};
                fields.forEach(item => {
                  input[item.name] = item.value;
                });
                try {
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_CATEGORY,
                        variables: {
                            input
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
