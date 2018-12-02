<template>
  <div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-white">
                <h3 class="text-center text-muted">Регистрация</h3>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
                <form @submit.prevent="register">
                    <div class="form-group mb-3" :class="{'has-danger': errors.username }">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                            </div>
                            <input class="form-control" :class="{'is-invalid' : errors.username}" placeholder="Имя пользователя" type="text" v-model="username" required autofocus>

                            <span v-if="errors.username" class="invalid-feedback" role="alert">
                                <strong>{{ errors.username }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3" :class="{'has-danger': errors.email }">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control" :class="{'is-invalid' : errors.email}" placeholder="email@mail" type="email" v-model="email" required>

                            <span v-if="errors.email" class="invalid-feedback" role="alert">
                                <strong>{{ errors.email }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3" :class="{'has-danger': errors.password }">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control" :class="{'is-invalid' : errors.password}" placeholder="Пароль" type="password" v-model="password" required>

                            <span v-if="errors.password" class="invalid-feedback" role="alert">
                                <strong>{{ errors.password }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-3" :class="{'has-danger': errors.password_confirmation }">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input class="form-control" :class="{'is-invalid' : errors.password_confirmation}" placeholder="Повторите пароль" type="password" v-model="password_confirmation" required>

                            <span v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                                <strong>{{ errors.password_confirmation }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                                Зарегистрироваться
                        </button>
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
              <router-link class="text-light" to="/auth/login">
                  <small>Войти</small>
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
      username: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: {},
    }
  },
  methods: {
    register() {
      this.$auth.register({
        data: {
          username: this.username,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        },
        success: function () {},
        error: function (err) {
          if (err.response.status === 422) {
            for (let prop in err.response.data.data) {
              this.$set(this.errors, prop, err.response.data.data[prop][0]);
            }
          }
        },
        autoLogin: true,
        rememberMe: true,
        redirect: {name: 'account'},
      });
    }
  }
}
</script>

