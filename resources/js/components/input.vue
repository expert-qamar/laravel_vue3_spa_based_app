<script type="application/javascript">
export default {
    name: 'ElInput',

    componentName: 'ElInput',

    props: {
        modelValue: [Number, String],
        attrs: [String, Number],
        value: [String, Number],
        model_value:[String, Number],
        readonly: Boolean,
        type: {
            type: String,
            default: 'text'
        },
        autosize: {
            type: [Boolean, Object],
            default: false
        },
        autoComplete: {
            type: String,
            default: 'off'
        },
        /** @Deprecated in next major version */
        validateEvent: {
            type: Boolean,
            default: true
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        label:{
            type: String,
            default: "",
        },
        clearable: {
            type: Boolean,
            default: false
        },
        showPassword: {
            type: Boolean,
            default: false
        },
        showWordLimit: {
            type: Boolean,
            default: false
        },
        classes: {
            type: String,
            default: " ",
        },
        placeholder:{
            type: String,
            default: " ",
        }
    },
    emits: ["change","keyPress", "blur","focus","update:modelValue"],
    setup(props,{ emit }) {

        function handleChange() {
            emit("change")
        }
        function keyChange() {
            emit("keyPress")
        }
        function handleBlur() {
            emit("blur")
        }
        function handleFocus() {
            emit("focus")
        }
        return {
            handleChange,
            handleBlur,
            handleFocus,
            keyChange,
        };
    }
}
</script>
<template>
        <input
            class="border-gray-300  w-full"
            :class="classes"
            v-bind="$attrs"
            :value="modelValue"
            :type="type"
            :disabled="disabled"
            :readonly="readonly"
            :autocomplete="autoComplete"
            :placeholder="placeholder"
            ref="input"
            @input="$emit('update:modelValue', $event.target.value)"
            @focus="handleFocus"
            @blur="handleBlur"
            @change="handleChange"
            @keypress="keyChange"
            :aria-label="label" >
</template>
