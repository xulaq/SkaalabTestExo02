<template>
    <input
        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        :value="modelValue"
        @input="updateInput"
        v-bind="$attrs"
    />
</template>

<script>
export default {
    name: "Input",
    props: ['error', 'modelValue'],
    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        }
    }

}
</script>

<style scoped>

</style>
