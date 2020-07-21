<template>
  <div class="flex justify-between items-center">
    <h1 class="text-lg font-semibold text-gray-900">
      {{ title }}
    </h1>
    <router-link :to='buttonLink'>
      <button class="btn btn-primary">
        {{ buttonText }}
      </button>
    </router-link>
  </div>
</template>
<script>
export default {
  props: ['title', 'buttonText', 'buttonLink']
}
</script>
