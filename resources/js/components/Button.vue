<script type="application/javascript">

const props = {
    title: {
        type: String,
        default: '',
    },
    classes: {
        type: String,
        default: "border font-semibold px-5 py-1 rounded  bg-hex-aa00 text-hex-2427"
    },
    isSlot:{
      type: Boolean,
      default: false,
    },
    button_texts: {
        type: String,
        default: '',
    },
};
export default {
    name: 'ElButton',
    props,
    emits: ["clicked"],
    setup(props,{ emit }) {

        function clickEvents() {
            emit("clicked")
        }

        return {
            clickEvents,
        };
    }
}

</script>

<template>
    <button @click="clickEvents" :class="'rounded-full px-5 py-1 '+classes"  :title="title" >
        <slot v-if="isSlot"></slot>
        <span v-else>{{button_texts}}</span>
    </button>
</template>
