<template>
    <div>
        <h1>Transactions</h1>
        <pre>{{data}}</pre>
    </div>
</template>

<script>
    import gql from 'graphql-tag'
    export default {
        mounted() {
            this.getCategories();
        },
        data() {
            return {
                data: [],
            }
        },
        methods: {
            async getCategories() {
                const response = await this.$apollo.query({
                    query: gql(`
                        {
                            categories(first: 20) {data {id name}}
                            accounts(first: 20) {data {id name}}
                        }
                    `)
                })
                this.data = response.data;
            }
        }
    }
</script>

<style scoped>

</style>
