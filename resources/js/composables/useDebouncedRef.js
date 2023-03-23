import { ref, customRef } from 'vue'

/*this file  use for delay the request when user type to search anything in table input search*/
const debounce = (fn, delay = 0, immediate = false) => {
    let timeout
    return (...args) => {
        if (immediate && !timeout) fn(...args)
        clearTimeout(timeout)

        timeout = setTimeout(() => {
            fn(...args)
        }, delay)
    }
}

const useDebouncedRef = (initialValue, delay, immediate) => {
    const state = ref(initialValue)
    const debouncedRef = customRef((track, trigger) => ({
        get() {
            track()
            return state.value
        },
        set: debounce(
            value => {
                state.value = value
                trigger()
            },
            delay,
            immediate
        ),
    }))
    return debouncedRef
}

export default useDebouncedRef
