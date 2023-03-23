import {createRouter, createWebHistory} from "vue-router"

import AuthenticatedLayout from '../layouts/Authenticated.vue';
import {useAuth} from "../store/auth"
const routes = [
    {
        path: '/',
        redirect: {name: 'login'},
        component: AuthenticatedLayout,
        children:[
            {
                path: '/login',
                name: 'login',
                component: ()=> import('../views/Login.vue'),
            },
            {
                path: '/register',
                component: ()=> import('../views/RegisterUser.vue'),
                name: 'HelpDesk',
            },

            {
                path: '/:pathMatch(.*)*',
                component: () => import('../views/ErrorPage/404.vue'),
                name: 'PathNotFound',

            },
            {
                path: '/car-details',
                component: () => import('../views/Dashboard/index.vue'),
                name: 'Dashboard.index',
                meta: {
                    title: 'Car Details page',
                },
                beforeEnter: async (to, from, next) => {
                   const auth = useAuth()
                    if (!auth.check  && !!auth.token)
                        auth.getAuthUser()
                    else if( !auth.check  && !auth.token)
                        return next('/login')

                    return next();
                },
            },
            {
                path: '/categories',
                component: () => import('../views/Dashboard/categories.vue'),
                name: 'Dashboard.categories',
                meta: {
                    title: 'Categories page',
                },
                beforeEnter: async (to, from, next) => {
                    const auth = useAuth()
                    if (!auth.check  && !!auth.token)
                        auth.getAuthUser()
                    else if( !auth.check  && !auth.token)
                        return next('/login')

                    return next();
                },
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router
