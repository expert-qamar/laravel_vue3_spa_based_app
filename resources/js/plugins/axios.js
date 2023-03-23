
import axios from 'axios';
import Cookies from "js-cookie";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
import {useAuth} from '../store/auth'
window.axios.interceptors.response.use(
    response =>response,
    error => {
        const auth = useAuth()

        if (error.response?.status === 401 || error.response?.status === 404 || error.response?.status === 419 || error.response?.status === 403 || error.response?.status === 500 || error.response?.status === 429) {
            if(error.response?.status === 419)
                location.reload();
            else if(error.response?.status === 500)
                alert('Something is wrong. Please contact support.')
            else if(error.response?.status === 404)
                location.assign('/page-not-found')
            else if(error.response?.status === 401 || error.response?.status === 403){
                Cookies.set('loggedIn', false);
                location.assign('/login')
            }
            else if (Cookies.get('loggedIn') || Cookies.get('LoggedRoleId') || error.response?.status === 403)
                Cookies.set('loggedIn', false);
        }
        return Promise.reject(error)
    }
);
