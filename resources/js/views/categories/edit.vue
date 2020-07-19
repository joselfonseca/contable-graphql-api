<template>
    <layout>
      <template v-slot:header>
        <div class="flex justify-between items-center">
          <h1 class="text-lg font-semibold text-gray-900">
            Editar categoria
          </h1>
          <router-link to='/accounts'>
            <button class="btn btn-primary">
              Listado de categorias
            </button>
          </router-link>
        </div>
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="updateCategory"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import Layout from './../../components/common/layout';
    import GET_CATEGORY from './../../graphql/categories/category.graphql';
    import UPDATE_CATEGORY from './../../graphql/categories/update-category.graphql';
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
                  buttonText: 'Actualizar categoria'
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
                    this.form.fields = this.form.fields.map(item => {
                      if (response.data.category[item.name] !== undefined) {
                        item.value = response.data.category[item.name];
                      }
                      return item;
                    });
                } catch (e) {
                    console.log(e);
                }
            },
            async updateCategory(fields) {
                this.loading = true;
                this.errors = null;
                const input = {};
                fields.forEach(item => {
                  if (!item.disabled) {
                    input[item.name] = item.value;
                  }
                });
                try {
                    const response = await this.$apollo.mutate({
                        mutation: UPDATE_CATEGORY,
                        variables: {
                            id: this.category.id,
                            input
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        this.$toasted.success('Categoría actualizada satisfactoriamente!', {
                            position: "top-center",
                            duration : 5000
                        });
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
