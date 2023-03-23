import { defineStore } from 'pinia'
import Cookies from 'js-cookie'
import { useRouter } from 'vue-router'
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
            user: null,
            logoutStatus: logInSession,
            token: Cookies.get('token') || '',
            validationErrors: {},
            registerForm: registerObjectForm,
        }
    },

    getters: {
        check: state => state.user !== null,
    },
    actions: {
        async logout(){
            const router = useRouter()
            let cookiesRemoverArray = ['loggedIn', 'LoggedRoleId', 'token']
            await axios.post('/logout')
                .then((response)=>{
                    this.user = null
                    this.logoutStatus = true
                    this.setToken('')
                    cookiesRemoverArray.forEach(function(currentValue,index){
                        Cookies.remove(currentValue)
                    })
                    router.push({ name: 'login' })
                })

        },
        async getAuthUser(){
            const router = useRouter()
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
