<template>
    <div>
        Counter: {{ counter }}
        <button @click="add">Add</button>
    </div>
</template>

<script>
    export default {
        name: "test-component",
        data() {
            return {
                counter: 0
            }
        },
        methods: {
            add() {
                this.counter++;
            }
        }
    }
</script>

<style scoped>

</style>