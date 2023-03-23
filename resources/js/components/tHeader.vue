<script setup>

    import {ref} from "vue";
    const props = defineProps({
        input_search: {
            type: Boolean,
            default: true,
        },
        search_items: {
            type: Object,
            default: ' ',
        },
        module:{
            type: String,
            default: '',
        }

    }),
    // emits
    emit = defineEmits(["emitCategories","emitCarDetails"]),
    tModule = ref(props.module),
    th_classes = 'px-4 py-3 border border-hex-e1e1 border-2 text-left ',
    th_div_div_classes = 'text-white whitespace-nowrap  text-center',
    orderColumn = ref('created_at'),
    orderDirection = ref('desc')

    function updateOrdering(column)
    {
        orderColumn.value = column;
        orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
        if(tModule.value === "carDetails"){
            emit('emitCarDetails', {
                page: 1,
                search_global : '',
                order_column: orderColumn.value,
                order_direction:orderDirection.value
            })
        }
        else if(tModule.value === "categories"){
            emit('emitCategories', {
                page: 1,
                search_global : '',
                order_column: orderColumn.value,
                order_direction:orderDirection.value
            })
        }

    }

</script>

<template>
    <thead>
    <tr>
        <th :class="'bg-hex-4141 '+th_classes" v-for="(row,key) in search_items">
            <div v-if="key === 'action'" :class="th_div_div_classes" >
                <span class="font-normal">{{row}}</span>
            </div>
            <div v-else :class="th_div_div_classes" @click="updateOrdering(key)">
                <div :class="'flex justify-center font-normal items-center '+th_div_div_classes" role="button">
                    <span :class="{ 'text-hex-aa00 ': orderColumn === key }">
                        {{row}}
                    </span>
                    <div class="flex ml-2">
                        <svg class="float-right w-[12px]" :class="orderDirection === 'asc' && orderColumn === key ? 'fill-[#ffaa00]' : orderDirection !== '' && orderDirection !== 'asc' && orderColumn === key ? 'hidden fill-white' : 'fill-white'" id="Layer_2"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.604 6.863">
                            <g id="Ikoner"><polygon points="5.802 0 0 5.803 1.061 6.863 5.802 2.121 10.543 6.863 11.604 5.803 5.802 0"/></g>
                        </svg>
                        <svg class="float-right ml-1 w-[12px]" :class="orderDirection === 'desc' && orderColumn === key ? 'fill-[#ffaa00]' : orderDirection !== '' && orderDirection !== 'desc' && orderColumn === key ? 'hidden fill-white' : 'fill-white'" id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.604 6.863">
                            <g id="Ikoner"><polygon points="5.802 4.742 1.061 0 0 1.061 5.802 6.863 11.604 1.061 10.543 0 5.802 4.742"/></g>
                        </svg>
                    </div>
                </div>

            </div>
        </th>
    </tr>
    </thead>
</template>
