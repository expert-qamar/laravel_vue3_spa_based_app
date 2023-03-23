<script setup>
    import useDebouncedRef from "../composables/useDebouncedRef";
    import {watch} from "vue"
    const searchGlobal = useDebouncedRef('', 800)
    const props = defineProps({
        globalType : {
            type : String,
            default : '',
        },
        classes:{
            type: String,
            default: 'w-full'
        }

    })
    const emit = defineEmits(["watchEvent"])

    watch(searchGlobal, (current) => {
        emit('watchEvent', { current: current, module: props.globalType})
    });
</script>

<template>
    <el-input v-model="searchGlobal" type="text" placeholder="Search"  :classes="'rounded-full '+classes"/>
</template>
