<script setup>
    import commonCode from "../composables/common";
    const { router, auth, isLoading} = commonCode()

</script>
<template>
    <div class="min-h-screen flex flex-col relative">
        <!--Top header -->
        <nav class="bg-hex-4141">
            <div class="items-center mx-auto sm:max-w-6xl sm:py-2">
                <div class="sm:flex mx-auto justify-between items-center text-white px-3">
                    <div class="sm:flex items-center text-center">
                        <div class="ml-2 whitespace-nowrap sm:ml-0 lg:text-[32px] sm:text-[24px] text-[17px] uppercase font-[600] !inline-block" role="button">
                            <router-link to="/login">Laravel & Vue 3 Crud app </router-link>
                        </div>
                    </div>

                    <!--logout icon show with the help of pinia store-->
                    <div  class="flex mx-auto sm:mx-0 justify-center sm:justify-end items-center">
                        <div v-if="!auth.logoutStatus" role="button">
                            <a href="javascript:void(0)" class="flex items-center mx-2" @click="auth.logout(router)" :class="{ 'opacity-25': isLoading }" :disabled="isLoading" role="button">
                                <div class="text-center items-center sm:text-[13px] md:text-[16px] font-normal">Log out</div>
                                <el-icon :svg="true" v-bind:icon="'logout'" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!--Dynamic components render here with the help of vue-router -->
        <router-view :key="$route.path" />
        <!-- footer -->
        <footer class="bg-hex-e1e1">
            <div class="lg:w-2/5 md:w-3/5 h-4/5 sm:w-4/5 w-full justify-center items-center flex mx-auto py-5">
                <div class="sm:text-[11px] md:text-[12px] lg:text-[15px] md:px-4 lg:px-0 sm:px-6 px-2 text-[10px]  mt-7 sm:mt-0">
                    <p class="text-center">© 2022 Copyright</p>
                </div>
            </div>
        </footer>
    </div>
</template>

