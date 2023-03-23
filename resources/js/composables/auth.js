import commonCode from "./common";
import { useAuth } from "../store/auth"
import Cookies from 'js-cookie'

export default function userAuth() {
    const
        { router, Toast, validationErrors, isLoading }= commonCode(),
        auth = useAuth(),
        validateFields = (loginForm) => {
            let emailError,
                passwordError,
                response = true
            if(!loginForm.email){
                 emailError = ['The email field is required.'];
                validationErrors.value.email = emailError;
                response = false;
            }
            if(!loginForm.password)
            {
                passwordError = ['The password field is required.'];
                validationErrors.value.password = passwordError;
                response = false;
            }
            return response;

        },
        logout = async ( mod = '') => {
        if(isLoading.value) return;
        isLoading.value = true;
        let cookiesRemoverArray = ['loggedIn', 'token']
        axios.post('/logout')
            .then(response =>  {
                auth.logoutStatus = true
                auth.setToken('')
                cookiesRemoverArray.forEach(function(currentValue,index){
                    Cookies.remove(currentValue)
                })
                router.push({ name: 'login' })
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong'
                })
            })
            .finally(() => {
                isLoading.value = false;
            })
    }

    return {
        validateFields,  Toast, validationErrors, isLoading,
        router, logout, auth,
    }
}
