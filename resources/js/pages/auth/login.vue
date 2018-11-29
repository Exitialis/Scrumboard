<template>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-white">
                <p class="text-center text-muted">Войти</p>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
                <form method="POST" @submit.prevent="login">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control" v-model="email" placeholder="Email" type="email" name="email" required autofocus>
                            <!-- <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control" v-model="password" name="password" required>
                            <!-- @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif -->
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                                Войти
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
      email: "",
      password: ""
    };
  },
  methods: {
    login() {
      var app = this;
      this.$auth.login({
        params: {
          email: app.email,
          password: app.password
        },
        success: function() {},
        error: function() {},
        rememberMe: true,
        redirect: "/profile",
        fetchUser: true
      });
    }
  }
};
</script>

