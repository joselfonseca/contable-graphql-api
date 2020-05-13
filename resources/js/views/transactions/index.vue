<template>
    <div class="w-full">
        <div class="flex justify-between">
            <button class="button-primary" @click="goToCreate">Crear</button>
        </div>
    </div>
</template>

<script>
  export default {
      mounted() {
      },
      data() {
          return {
              data: [],
          }
      },
      methods: {
        goToCreate() {
          this.$router.push('/transactions/create');
        }
      }
  }
</script>

<style scoped>

</style>
