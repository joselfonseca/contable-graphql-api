<template>
    <div class="flex flex-col">
      <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
          <table class="min-w-full">
            <thead>
              <tr>
                <th v-for="heading in headings" :key="heading" class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{heading}}</th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!loading" class="bg-white" v-for="item in data" :key="item.id">
                <td v-if="columnKey != 'id'" v-for="column, columnKey in item" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900">
                  {{ column }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                  <button class="btn btn-primary" @click="editRecord(item)">Editar</button>
                  <button class="btn btn-danger" @click="deleteRecord(item)">Eliminar</button>
                </td>
              </tr>
              <tr v-if="data.length === 0" class="bg-white">
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900 text-center" :colspan="headings.length + 1">
                  Sin datos para mostrar
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</template>

<script>
    import Loading from './../../components/common/loading';
    export default {
        name: "simple-table",
        props: [
            'headings',
            'data',
            'loading'
        ],
        components: {
            Loading
        },
        computed: {
            columns() {
                return this.headings.length + 1;
            }
        },
        methods: {
            editRecord(record) {
                this.$emit('editRecord', record);
            },
            deleteRecord(record) {
                this.$emit('deleteRecord', record);
            }
        }
    }
</script>

<style scoped>

</style>
