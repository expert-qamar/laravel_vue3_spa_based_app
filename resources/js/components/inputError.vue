<script setup>
const props = defineProps({
    errors: { Array, default: '' }
})
</script>

<template>
    <div class="text-red-600 mt-1">
        <div v-for="message in errors">
            {{ message }}
        </div>
    </div>
</template>
