<script setup>

const props = defineProps({
    text: { String, default: '' },
})
</script>
<template>
    <label class="mt-4 font-[600] tex-sm">
        {{text}}
    </label>
</template>
