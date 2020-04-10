<template>
    <div></div>
</template>

<script>
  export default {
      name: 'graphql-error-toast',
      props: ['errors'],
      mounted() {
          const { graphQLErrors } = this.errors;
          graphQLErrors.forEach( ( err ) => {
              switch ( err.extensions.category ) {
                  case 'validation':
                      let error = '';
                      for (let [key, value] of Object.entries(err.extensions.validation)) {
                          error += `${value}`
                      }
                      this.$toasted.error(error, {
                          theme: "bubble",
                          position: "top-right",
                          duration : 5000
                      })
                      break;
                  default:
                      console.log( `[GraphQL error]: ${err}` ); // eslint-disable-line
              }
          });
      }
  }
</script>

<style scoped>

</style>
