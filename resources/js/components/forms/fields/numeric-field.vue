<template>
  <div>
    <label :for="field.name" class="block text-sm font-medium leading-5 text-gray-700">{{ field.label }}</label>
    <input type="number" :id="field.name" :name="field.name" :placeholder="field.placeholder" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
  </div>
</template>
<script>
export default {
  props: ['field']
}
</script>
