<script setup>
    import Cookies from 'js-cookie'
    import userAuth from "../composables/auth";
    import {reactive, onMounted, inject} from "vue";

    /* we create a 'auth.js' composable file for some common functionality perform into our login or register components*/
    const { validateFields, validationErrors, auth, router, isLoading } = userAuth(),
        emitter = inject('emitter'),
        loginForm = reactive({
            email: '',
            password: '',
        }),
    /* request for login user */
    submitLogin = async () => {
        isLoading.value = true
        validationErrors.value = {}
        /*validation*/
        let responseValidate = validateFields(loginForm);
        if(responseValidate === false) {
            isLoading.value = false
            return false
        }

        axios.post('/login', loginForm)
            .then((response) => {
                Cookies.set('loggedIn', true);
                auth.setToken(response.data.data.token)
                auth.user = response.data.data
                router.push({ path: '/car-details' })
            })
            .catch(error => {
                if(error.response?.data)
                    validationErrors.value = error.response.data.errors
            }).finally(() => {
                isLoading.value = false
            })
    }

    onMounted(()=>{
        /* when authenticate user go back to login page this go back to registration dashboard */
        if (Cookies.get('loggedIn'))
            router.push({name: 'Dashboard.index'})
    })

</script>

<template>
    <div class="bg-hex-e1e1 lg:px-0 flex items-center flex-1">
        <div class="lg:w-2/5 md:w-3/5 h-4/5 sm:w-4/5  w-full items-center mx-auto sm:px-0 px-6 mx-auto">
            <div class="items-center">
                <h1 class="text-[35px] font-bold text-center py-4">Welcome</h1>
                <div class="text-md text-center">
                    Log in using your email address and password
                </div>
                <!--in this form we create svg icon, input, error components because multiple lines odf code repeats-->
                <form class="mt-4" @submit.prevent="submitLogin">
                    <div>
                        <div class="flex rounded">
                            <el-icon v-bind:icon="'envelope'" />
                            <el-input type="email" v-model="loginForm.email" placeholder="Email address"  @change="delete validationErrors['email']" autofocus autocomplete="username" classes="border-0 block focus:border-0 focus:ring-0" />
                        </div>
                        <el-error v-bind:errors="validationErrors?.email" />
                        <div class="mt-4 flex">
                            <el-icon v-bind:icon="'lock'" />
                            <el-input type="password" v-model="loginForm.password" placeholder="Password"  @change="delete validationErrors['password']" autocomplete="off" classes="border-0 block focus:border-0 focus:ring-0" />
                        </div>
                        <el-error v-bind:errors="validationErrors?.password" />
                        <div class="flex items-center justify-center mt-8">
                            <save-button :buttonName="'Log in'" :isLoading="isLoading" bType="submit" />
                        </div>
                        <div class="block mt-4 text-center ">
                            <router-link class="btn btn-link mt-2 underline" to="/register" exact>Sign up here</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
