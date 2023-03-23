<script setup>
const
     props = defineProps({
         buttonName: { type: String, default: ' ' },
         isLoading: { type: Boolean, default: false },
         bType: { type: String, default: 'submit' },
         classes: { type:String, default:'rounded-full inline-flex items-center px-8 py-2 bg-hex-aa00 disabled:opacity-75 disabled:cursor-not-allowed' }
     })

</script>
<template>
    <div class="py-2 text-center">
        <button :disabled="isLoading" :type="bType" :class="(isLoading ? 'opacity-25 px-4 ' : ' ') + classes ">
            <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></div>
            <span v-if="isLoading" >processing...</span>
            <span v-else>
               {{ buttonName }}
            </span>
        </button>
    </div>
</template>

