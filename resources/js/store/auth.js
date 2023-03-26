import { defineStore } from 'pinia'
import Cookies from 'js-cookie'
const logInSession = ( !Cookies.get('loggedIn')),
        registerObjectForm = {
            name: '',
            email: '',
            password:'',
            password_confirmation: '',
        }
export const useAuth = defineStore('auth', {
    state: () => {
        return {
            user: {}, // user instance object here
            logoutStatus: logInSession, // logout icon show on header
            token: Cookies.get('token') || '',
            registerForm: registerObjectForm, //user register form
        }
    },

    //this getter check weather user login or not
    getters: {
        check: state => state.user !== null,
    },
    actions: {
        async logout(router){
            let cookiesRemoverArray = ['loggedIn', 'token']
            await axios.post('/logout')
                .then((response)=>{
                    this.user = null
                    this.logoutStatus = true
                    this.setToken('')
                    cookiesRemoverArray.forEach(function(currentValue,index){
                        Cookies.remove(currentValue)
                    })
                    // Make sure that the router instance is available
                        if (router)
                            router.push('/login')
                })

        },

        /* this function call when user is login but page refresh then user instance recall */

        async getAuthUser(router){
            await axios.get('/api/user')
                .then( (response) => {
                    if(!!response.data.data){
                        Cookies.set('loggedIn', true);
                        this.user = response.data.data
                        this.setToken(response.data.data.token)
                    }
                    router.push({path: '/car-details'})
                })
                .catch((error)=>{
                    this.user = null
                })

        },
        /* Token check verify for user request. if token exist then user is login on page refresh*/
        setToken(value){
            if(!!value)
            {
                this.logoutStatus = false
                this.token = value
                Cookies.set('token', value)
            }
        }
    }

});
