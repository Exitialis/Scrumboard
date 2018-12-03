try {
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');
} catch (e) { }

import router from './router';
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from './App.vue';
import Snotify, { SnotifyPosition } from 'vue-snotify'
import bModal from 'bootstrap-vue/es/components/modal/modal'
import bModalDirective from 'bootstrap-vue/es/directives/modal/modal'

axios.defaults.baseURL = 'http://scrum.test/api';

Vue.router = router;
Vue.use(VueAxios, axios);

Vue.use(require('@websanova/vue-auth'), {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  fetchData: { url: 'auth/me' }
});

Vue.use(Snotify, {
  toast: {
    position: SnotifyPosition.rightTop
  }
});

Vue.component('b-modal', bModal);
Vue.directive('b-modal', bModalDirective);

let $vm = new Vue({
  components: { App },
  router,
  template: '<App/>'
}).$mount('#app')

axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  console.log(error.response);
  if (error.response.status === 422) {
    $vm.$snotify.error('При заполнении данных формы произошла ошибка')
  } else if (error.response.status === 403) {
    $vm.$snotify.error(error.response.data.error);
  }
  return Promise.reject(error);
});
