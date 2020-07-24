<template>
    <layout>
      <template v-slot:header>
        <simple-header title="Crear medio de pago" button-text="Listado de medios de pago" button-link='/payment-methods' />
      </template>
      <template v-slot:content>
        <div class="w-full flex justify-center">
          <div class="w-2/4">
            <graphql-error-toast v-if="errors" :errors="errors"></graphql-error-toast>
            <simple-form :fields="form.fields" :button-text="form.buttonText" @submited="createPaymentMethod"></simple-form>
          </div>
        </div>
      </template>
    </layout>
</template>

<script>
    import CREATE_PAYMENT_METHOD from './../../graphql/payment-methods/create-payment-method.graphql';

    export default {
        data() {
              return {
                  form: {
                      name: null,
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
                      buttonText: "Crear medio de pago"
                  },
                  errors: null,
                  loading: false
              }
        },
        methods: {
            async createPaymentMethod(fields) {
                this.loading = true;
                this.errors = null;
                const input = {};
                fields.forEach(item => {
                  input[item.name] = item.value;
                });
                try {
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_PAYMENT_METHOD,
                        variables: {
                            input
                        }
                    });
                    this.loading = false;
                    if (response.data) {
                        this.$toasted.success('Medio de pago creado satisfactoriamente!', {
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
