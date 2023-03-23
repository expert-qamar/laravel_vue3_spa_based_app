<script setup>
    import {useAuth} from "../store/auth"
    import Cookies from "js-cookie";
    import commonCode from "../composables/common";
    /* we create a 'common.js' composable file for some common functionality perform into our different components*/
    const
        { router, Toast, validationErrors, isLoading} = commonCode(),
        /* pinia global state call */
        auth = useAuth(),
        /*register user function start*/
        registrationForm = async () => {
            isLoading.value = true;
            validationErrors.value = {};
            /*validation*/
            let responseValidate = validateFields(auth.registerForm);
            if( responseValidate === 'false') {isLoading.value = false; return}
            axios.post('/register', auth.registerForm)
                .then( async(response)=>{
                    Cookies.set('loggedIn', true);
                    auth.user = response.data.data
                    await auth.setToken(response.data.data.token)
                    await router.push({name: 'Dashboard.index'})
                    auth.registerForm =  {}
                    Toast.fire({ icon: 'success', title: 'successfully'})
                })
                .catch(error => {
                    if(error.response?.data)
                        validationErrors.value = error.response.data.errors
                })
                .finally(()=>isLoading.value = false)

        },
        /*register user function end*/
        /*All inputs validate*/
        validateFields = (form) => {
            let response = true
            if(!form.name){
                validationErrors.value.name  = ['The name field is required.'];
                response = false;
            }
            if(!form.email){
                validationErrors.value.email = ['The email field is required.'];
                response = false;
            }
            if(!form.password){
                validationErrors.value.password = ['The password field is required.'];
                response = false;
            }
            if(!form.password_confirmation)
            {
                validationErrors.value.password_confirmation = ['The confirmed field is required.'];
                response = false;
            }
            if(!!form.password && !!form.password_confirmation )
            {
                if(form.password !== form.password_confirmation){
                    validationErrors.value.password_confirmation = ['Your password confirmation does not match.'];
                    response = false;
                }
            }
            return response;
        }

</script>

<template>
<!-- User Registration Form   -->
        <div class="bg-hex-e1e1 lg:px-0 flex items-center flex-1">
            <div class="lg:w-2/5 md:w-3/5 h-4/5 sm:w-4/5  w-full flex items-center mx-auto sm:px-0 px-6 mx-auto">
                <form  @submit.prevent="registrationForm" class="w-full">
                    <div class="my-2 text-[30px] font-[600] text-center">
                        Registration form
                    </div>
                    <div class="mb-5">
                        <el-label v-bind:text="'Enter name'" />
                        <div class="flex rounded">
                            <el-icon v-bind:icon="'envelope'" />
                            <el-input type="text" v-model="auth.registerForm.name" placeholder="Name"  @change="delete validationErrors['name']" autofocus autocomplete="username" classes="border-0 block focus:border-0 focus:ring-0" />
                        </div>
                        <el-error v-bind:errors="validationErrors?.name" />
                    </div>
                    <div class="mb-5">
                        <el-label v-bind:text="'Enter email'" />
                        <div class="flex rounded">
                            <el-icon v-bind:icon="'envelope'" />
                            <el-input type="email" v-model="auth.registerForm.email" placeholder="Email address"  @change="delete validationErrors['email']" autofocus autocomplete="email" classes="border-0 block focus:border-0 focus:ring-0" />
                        </div>
                        <el-error v-bind:errors="validationErrors?.email" />
                    </div>
                  <div class="mb-5">
                      <el-label v-bind:text="'New password'" />
                      <div class="flex">
                          <el-icon v-bind:icon="'lock'" />
                          <el-input type="password" v-model="auth.registerForm.password" placeholder="*********"  @change="delete validationErrors['password']"  classes="border-0 block focus:border-0 focus:ring-0" />
                      </div>
                      <el-error v-bind:errors="validationErrors?.password" />
                  </div>
                    <div class="mb-5">
                        <el-label v-bind:text="'Please Reenter new password'" />
                        <div class=" flex">
                            <el-icon v-bind:icon="'lock'" />
                            <el-input type="password" v-model="auth.registerForm.password_confirmation" placeholder="*********"  @change="delete validationErrors['password_confirmation']"  classes="border-0 block focus:border-0 focus:ring-0" />
                        </div>
                        <el-error v-bind:errors="validationErrors?.password_confirmation" />
                    </div>
                    <save-button :buttonName="'Submit'" :isLoading="isLoading" bType="submit" />
                    <div class="text-center my-3">
                        <router-link class="btn btn-link mt-2 underline" to="/login" exact>Click here to log in</router-link>
                    </div>
                </form>
            </div>
        </div>
</template>

