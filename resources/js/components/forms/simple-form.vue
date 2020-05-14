<template>
  <div>
    <div class="mt-5 md:mt-0 md:col-span-2">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
          <div class="grid grid-cols-1 gap-6">
            <div class="col-span-1 sm:col-span-1" v-for="field in fields">
              <text-field :field="field" v-if="field.type === 'text'"></text-field>
              <numeric-field :field="field" v-if="field.type === 'numeric'"></numeric-field>
            </div>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
            {{buttonText}}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TextField from './fields/text-field';
import NumericField from './fields/numeric-field';
export default {
  components: { TextField, NumericField },
  props: {
    fields: {
      type: Array,
      required: true
    },
    buttonText: {
      type: String,
      required: true
    }
  }
}
</script>
