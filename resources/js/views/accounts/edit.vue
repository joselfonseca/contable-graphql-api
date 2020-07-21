<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Editar cuenta" button-text="Listado de cuentas" button-link='/accounts' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="updateAccount"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import GET_ACCOUNT from './../../graphql/accounts/account.graphql';
    import UPDATE_ACCOUNT from './../../graphql/accounts/update-account.graphql';

    export default {
        data() {
            return {
                form: {
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
                  buttonText: 'Actualizar cuenta'
                },
                errors: null,
                loading: false,
                account: null
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
                        query: GET_ACCOUNT,
                        variables: {
                            id: this.$route.params.id
                        }
                    });
                    this.loading = false;
                    this.account = response.data.account;
                    this.form.fields = this.form.fields.map(item => {
                      if (response.data.account[item.name] !== undefined) {
                        item.value = response.data.account[item.name];
                      }
                      return item;
                    });
                } catch (e) {
                    console.log(e);
                }
            },
            async updateAccount(fields) {
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
                        mutation: UPDATE_ACCOUNT,
                        variables: {
                            id: this.account.id,
                            input
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        this.$toasted.success('Cuenta actualizada satisfactoriamente!', {
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
