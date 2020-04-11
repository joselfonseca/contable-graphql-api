<template>
    <div class="text-center my-4">
        <beat-loader class="" :loading="loading" :color="color" :size="15" :sizeUnit="sizeUnit"></beat-loader>
    </div>
</template>

<script>
    import { BeatLoader } from '@saeris/vue-spinners'
    export default {
        components: { BeatLoader },
        name: "loading",
        props: ['loading'],
        data() {
            return {
                color: "#2a4365",
                sizeUnit: "px"
            }
        }
    }
</script>

<style scoped>

</style>
