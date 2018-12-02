try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

import router from './router';
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import App from './App.vue';

axios.defaults.baseURL = 'http://scrumboard.test/api';

Vue.router = router;
Vue.use(VueAxios, axios);

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

new Vue({
    components: { App },
    router,
    template: '<App/>'
}).$mount('#app')
