<template>
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card bg-secondary shadow border-0">
        <div class="card-header bg-white">
          <h3 class="text-center text-muted">Войти</h3>
        </div>

        <div class="card-body px-lg-5 py-lg-5">
          <form @submit.prevent="login">
            <div class="form-group mb-3" :class="{'has-danger': errors.username }">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="ni ni-single-02"></i>
                  </span>
                </div>
                <input
                  class="form-control"
                  :class="{'is-invalid' : errors.username}"
                  placeholder="Имя пользователя"
                  type="text"
                  v-model="username"
                  required
                >

                <span v-if="errors.username" class="invalid-feedback" role="alert">
                  <strong>{{ errors.username }}</strong>
                </span>
              </div>
            </div>
            <div class="form-group mb-3" :class="{'has-danger': errors.password }">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="ni ni-lock-circle-open"></i>
                  </span>
                </div>
                <input
                  class="form-control"
                  :class="{'is-invalid' : errors.password}"
                  placeholder="Пароль"
                  type="password"
                  v-model="password"
                  required
                >

                <span v-if="errors.password" class="invalid-feedback" role="alert">
                  <strong>{{ errors.password }}</strong>
                </span>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Войти</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <router-link class="text-light" to="/auth/forgot">
            <small>Забыли пароль?</small>
          </router-link>
        </div>
        <div class="col-6 text-right">
          <router-link class="text-light" to="/auth/register">
            <small>Зарегистрироваться</small>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: {},
      username: "",
      password: ""
    };
  },
  methods: {
    login() {
      var app = this;
      this.errors = {};
      this.$auth.login({
        data: {
          username: app.username,
          password: app.password
        },
        success: function() {},
        error: function(err) {
          if (err.response.status === 422) {
            app.errors = err.response.data.data;
          }
        },
        rememberMe: true,
        redirect: "/board",
        fetchUser: true
      });
    }
  }
};
</script>

