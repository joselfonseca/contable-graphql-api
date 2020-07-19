<template>
  <div>
    <label :for="field.name" class="block text-sm font-medium leading-5 text-gray-700">{{ field.label }}</label>
    <div class="inline-block relative w-full">
      <select v-model="value" :disabled="field.disabled" type="text" :id="field.name" :name="field.name" :placeholder="field.placeholder" :required="field.required" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
        <option v-for="option in field.options" :key="option.id" :value="option.id">{{ option.value }}</option>
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['field'],
  data () {
    return {
      value: null
    };
  },
  watch: {
    value() {
      const updatedField = this.field;
      updatedField.value = this.value;
      this.$emit('updated', updatedField);
    },
    'field.value': {
      handler() {
        this.value = this.field.value;
      },
      immediate: true
    }
  }
}
</script>
