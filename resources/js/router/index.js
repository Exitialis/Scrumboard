import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

const router = new Router({
  mode: 'history',
  routes: [{
    path: '/',
    name: 'main',
    component: require('../templates/main.vue'),
    redirect: '/board',
    children: [{
      path: '/auth/',
      name: 'auth',
      component: require('../pages/auth/auth.vue'),
      children: [{
        meta: {
          auth: false
        },
        path: 'login',
        name: 'login',
        component: require('../pages/auth/login.vue')
      },
      {
        meta: {
          auth: false
        },
        path: 'register',
        name: 'register',
        component: require('../pages/auth/register.vue')
      },
      {
        meta: {
          auth: true
        },
        path: '/auth/logout',
        name: 'logout',
        component: require('../pages/auth/logout.vue'),
      },
      ]
    },
    {
      meta: {
        auth: true
      },
      path: '/board',
      name: 'board',
      component: require('../pages/scrumboard.vue'),
    },
    {
      meta: {
        auth: true
      },
      path: '/backlog',
      name: 'backlog',
      component: require('../pages/backlog.vue'),
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
