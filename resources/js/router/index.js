import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'main',
            component: require('../templates/main.vue'),
            children: [
                {
                    path: '/auth/login',
                    name: 'login',
                    component: require('../pages/auth/login.vue')
                },
                // {
                //     path: '/auth/register',
                //     name: 'register',
                //     component: require('../pages/auth/register').default
                // },
                // {
                //     path: '/auth/logout',
                //     name: 'logout',
                //     component: require('../pages/auth/logout').default,
                //     //beforeEnter: IsLoggedIn
                // },
                {
                    meta: { auth: true },
                    path: '/profile',
                    name: 'profile',
                    component: require('../pages/profile.vue'),
                    //beforeEnter: IsLoggedIn
                },
            ]
        },
        {
            path: '*',
            redirect: '/auth/login'
        }
    ],
    linkActiveClass: "active"
});

export default router;
