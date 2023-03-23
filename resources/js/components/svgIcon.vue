<script setup>

    const props = defineProps({
        icon: String,
        parentClass:{
          type: Boolean,
          default: true,
        },
        svg:{
            type:Boolean,
            default:false,
        },
    })
</script>
<template>
    <div v-if="svg">
        <img v-if="icon === 'delete' " class="w-[16px]" src="/icon/Bin.svg" />
        <svg v-else-if="icon === 'rightArrow'" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path class="fill-black" d="M502.6 278.6l-128 128c-12.51 12.51-32.76 12.49-45.25 0c-12.5-12.5-12.5-32.75 0-45.25L402.8 288H32C14.31 288 0 273.7 0 255.1S14.31 224 32 224h370.8l-73.38-73.38c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l128 128C515.1 245.9 515.1 266.1 502.6 278.6z"/>
        </svg>
        <svg v-else-if="icon === 'leftArrow'" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path class="fill-black" d="M9.375 233.4l128-128c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L109.3 224H480c17.69 0 32 14.31 32 32s-14.31 32-32 32H109.3l73.38 73.38c12.5 12.5 12.5 32.75 0 45.25c-12.49 12.49-32.74 12.51-45.25 0l-128-128C-3.125 266.1-3.125 245.9 9.375 233.4z"/>
        </svg>
        <img v-else-if="icon === 'logout'" class="width-set px-2" src="/icon/Logout.svg" alt="">
    </div>
    <div v-else :class="parentClass ? ' font-[600] py-2 px-4 bg-white' : ' ' ">
        <img v-if="icon === 'lock'" class="w-[20px]" src="/icon/Password.svg" alt="">
        <img v-else-if="icon === 'envelope'" class="w-[25px] mt-1" src="/icon/Mail.svg" alt="">
        <svg v-else-if="icon === 'cross'" id="Layer_2" data-name="Layer 2" fill="#FFF" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.233 27.233">
            <g id="Ikoner">
                <g>
                    <polygon points="18.146 8.027 13.617 12.556 9.088 8.027 8.027 9.088 12.556 13.616 8.027 18.145 9.088 19.206 13.617 14.677 18.146 19.206 19.206 18.145 14.677 13.616 19.206 9.088 18.146 8.027"/>
                    <path d="M13.617,0C6.108,0,0,6.108,0,13.617s6.108,13.616,13.617,13.616,13.616-6.108,13.616-13.616S21.125,0,13.617,0Zm0,25.733c-6.682,0-12.117-5.436-12.117-12.116S6.936,1.5,13.617,1.5s12.116,5.436,12.116,12.117-5.436,12.116-12.116,12.116Z"/>
                </g>
            </g>
        </svg>
    </div>


</template>
