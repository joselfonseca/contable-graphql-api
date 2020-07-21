<template>
  <layout>
      <template v-slot:header>
        <simple-header title="Crear categoría" button-text="Listado de categorías" button-link='/categories' />
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
    import CREATE_CATEGORY from './../../graphql/categories/create-category.graphql';

    export default {
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
                        this.$toasted.success('Categoría creada satisfactoriamente!', {
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
