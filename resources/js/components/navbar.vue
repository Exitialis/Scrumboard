<template>
  <header class="header-global">
    <headroom>
      <nav
        class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light"
        v-click-outside="close"
      >
        <div class="container">
          <router-link class="navbar-brand" to="/">Scrumboard</router-link>
          <button class="navbar-toggler" type="button" @click.prevent="show = true">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" :class="{'show': show}">
            <div class="navbar-collapse-header">
              <div class="row">
                <div class="col-6 collapse-brand">
                  <a href="#">
                    <!-- <img src=""> -->
                  </a>
                </div>
                <div class="col-6 collapse-close">
                  <button type="button" class="navbar-toggler" @click.prevent="show = false">
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              <li v-if="!$auth.check()" class="nav-item">
                <router-link class="nav-link" to="/auth/login">Войти</router-link>
              </li>
              <li v-if="!$auth.check()" class="nav-item">
                <router-link class="nav-link" to="/auth/register">Регистрация</router-link>
              </li>
              <li v-if="$auth.check()" class="nav-item">
                <router-link class="nav-link" to="/board">Доска</router-link>
              </li>
              <li v-if="$auth.check()" class="nav-item">
                <router-link class="nav-link" to="/backlog">Бэклог</router-link>
              </li>
              <li v-if="$auth.check()" class="nav-item dropdown" v-dropdown>
                <a class="nav-link dropdown-toggle">
                  <i class="ni ni-single-02"></i>
                  <span>{{ user.username }}</span>
                  <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <router-link class="dropdown-item" to="/auth/logout">Выйти</router-link>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </headroom>
  </header>
</template>

<script>
import ClickOutside from "vue-click-outside";
import { headroom } from "vue-headroom";
export default {
  components: {
    headroom
  },
  directives: {
    ClickOutside
  },
  data() {
    return {
      show: false
    };
  },
  computed: {
    user() {
      return this.$auth.user();
    }
  },
  methods: {
    close() {
      if (this.show) {
        this.show = false;
      }
    }
  }
};
</script>

