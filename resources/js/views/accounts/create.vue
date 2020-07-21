<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Crear cuenta" button-text="Listado de cuentas" button-link='/accounts' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="createAccount"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import CREATE_ACCOUNT from './../../graphql/accounts/create-account.graphql';

    export default {
        data() {
              return {
                  form: {
                      name: null,
                      balance: 0,
                      fields: [
                        {
                          type: 'text',
                          name: 'name',
                          placeholder: 'Nombre de tu cuenta',
                          required: true,
                          value: null,
                          label: 'Nombre de tu cuenta',
                          disabled: false
                        }
                      ],
                      buttonText: "Crear cuenta"
                  },
                  errors: null,
                  loading: false
              }
        },
        methods: {
            async createAccount(fields) {
                this.loading = true;
                this.errors = null;
                const input = {};
                fields.forEach(item => {
                  input[item.name] = item.value;
                });
                try {
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_ACCOUNT,
                        variables: {
                            input
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        this.$toasted.success('Cuenta creada satisfactoriamente!', {
                            position: "top-center",
                            duration : 5000
                        });
                        return this.$router.push('/accounts');
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
