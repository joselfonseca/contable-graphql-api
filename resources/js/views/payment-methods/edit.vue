<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Editar medio de pago" button-text="Listado de medios de pago" button-link='/payment-methods' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="updatePaymentMethod"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import GET_PAYMENT_METHOD from './../../graphql/payment-methods/payment-method.graphql';
    import UPDATE_PAYMENT_METHOD from './../../graphql/payment-methods/update-payment-method.graphql';

    export default {
        data() {
            return {
                form: {
                  fields: [
                    {
                      type: 'text',
                      name: 'name',
                      placeholder: 'Nombre de tu medio de pago',
                      required: true,
                      value: null,
                      label: 'Nombre de tu medio de pago',
                      disabled: false
                    }
                  ],
                  buttonText: 'Actualizar medio de pago'
                },
                errors: null,
                loading: false,
                paymentMethod: null
            }
        },
        mounted() {
            this.getPaymentMethod();
        },
        methods: {
            async getPaymentMethod() {
                this.loading = true;
                try {
                    const response = await this.$apollo.query({
                        query: GET_PAYMENT_METHOD,
                        variables: {
                            id: this.$route.params.id
                        }
                    });
                    this.loading = false;
                    this.paymentMethod = response.data.paymentMethod;
                    this.form.fields = this.form.fields.map(item => {
                      if (response.data.paymentMethod[item.name] !== undefined) {
                        item.value = response.data.paymentMethod[item.name];
                      }
                      return item;
                    });
                } catch (e) {
                    console.log(e);
                }
            },
            async updatePaymentMethod(fields) {
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
                        mutation: UPDATE_PAYMENT_METHOD,
                        variables: {
                            id: this.paymentMethod.id,
                            input
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        this.$toasted.success('Medio de pago actualizada satisfactoriamente!', {
                            position: "top-center",
                            duration : 5000
                        });
                        return this.$router.push('/payment-methods');
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
