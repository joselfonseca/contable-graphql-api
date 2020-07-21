<template>
  <div>
    <div class="mt-5 md:mt-0 md:col-span-2">
      <form @submit="submit">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
          <div class="grid grid-cols-1 gap-6">
            <div class="col-span-1 sm:col-span-1" v-for="field in fields" :key="field.name">
              <text-field :field="field" v-if="field.type === 'text'" @updated="syncValue"></text-field>
              <numeric-field :field="field" v-if="field.type === 'numeric'" @updated="syncValue"></numeric-field>
              <money-field :field="field" v-if="field.type === 'money'" @updated="syncValue"></money-field>
              <select-field :field="field" v-if="field.type === 'select'" @updated="syncValue"></select-field>
              <date-field :field="field" v-if="field.type === 'date'" @updated="syncValue"></date-field>
            </div>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
            {{buttonText}}
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</template>
<script>
import TextField from './fields/text-field';
import NumericField from './fields/numeric-field';
import MoneyField from './fields/money-field';
import SelectField from './fields/select-field';
import DateField from './fields/date-field';
export default {
  components: { TextField, NumericField, MoneyField, SelectField, DateField },
  props: {
    fields: {
      type: Array,
      required: true
    },
    buttonText: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      updatedFields: this.fields
    }
  },
  methods: {
    syncValue(field) {
      this.updatedFields = this.updatedFields.map(item => {
        if (item.name === field.name) {
          return field;
        }
        return item;
      });
    },
    submit (e) {
      e.preventDefault();
      this.$emit('submited', this.updatedFields);
    }
  }
}
</script>
