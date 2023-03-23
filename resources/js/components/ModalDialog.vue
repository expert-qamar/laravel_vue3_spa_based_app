<template>
  <teleport to="body">
    <transition enter-active-class="transition ease-out duration-200 transform" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200 transform" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div ref="modal-backdrop" class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50" v-show="showModal">
        <div class="flex items-start justify-center min-h-screen pt-24 text-center">
          <transition enter-active-class="transition ease-out duration-300 transform " enter-from-class="opacity-0 translate-y-10 scale-95" enter-to-class="opacity-100 translate-y-0 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 translate-y-0 scale-100" leave-to-class="opacity-0 translate-y-10 translate-y-0 scale-95">
            <div class="relative bg-gray-100 text-left  shadow-xl " :class="modalWidth" role="dialog" ref="modal" aria-modal="true" v-show="showModal" aria-labelledby="modal-headline">
              <div v-if="!!showHeader" class="bg-hex-4141 py-2 flex justify-between p-8 py-5 ">
                  <h3  class="text-white">
                      <span v-if="showHeader !== 'none'">{{showHeader}}</span>
                  </h3>
                  <button class="text-white" @click="closeModal">
                      <svg id="Layer_2" data-name="Layer 2" fill="#FFF" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.233 27.233">
                          <g id="Ikoner">
                              <g>
                                  <polygon points="18.146 8.027 13.617 12.556 9.088 8.027 8.027 9.088 12.556 13.616 8.027 18.145 9.088 19.206 13.617 14.677 18.146 19.206 19.206 18.145 14.677 13.616 19.206 9.088 18.146 8.027"/>
                                  <path d="M13.617,0C6.108,0,0,6.108,0,13.617s6.108,13.616,13.617,13.616,13.616-6.108,13.616-13.616S21.125,0,13.617,0Zm0,25.733c-6.682,0-12.117-5.436-12.117-12.116S6.936,1.5,13.617,1.5s12.116,5.436,12.116,12.117-5.436,12.116-12.116,12.116Z"/>
                              </g>
                          </g>
                      </svg>
                  </button>
              </div>
                <slot ></slot>
            </div>
          </transition>
        </div>
      </div>
    </transition>
  </teleport>
</template>
<script type="application/javascript">
    import { ref, watch } from 'vue';
    const props = {
        show: {
            type: Boolean,
            default: false,
        },
        title:{
            default:''
        },
        width:{
            default:'md:w-2/5 sm:w-3/5 w-4/5',
        },
    };
    export default {
        name: 'ModalDialog',
        props,
        emits: ["close"],
        setup(props, { emit }) {
            const showModal = ref(false),
                showHeader = ref(''),
                modalWidth = ref('')

            function closeModal() {
                showModal.value = false;
                emit("close")
            }

            watch(
                () => props.show,
                (show) => {
                    showModal.value = show;
                    showHeader.value = props.title;
                    modalWidth.value = props.width;
                },
            );
            return {
                showHeader,
                closeModal,
                showModal,
                modalWidth,
                close,
            };
        }
    };
</script>
