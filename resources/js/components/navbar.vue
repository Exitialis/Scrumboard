<template>
    <header class="header-global">
            <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
                <div class="container">
                    <router-link class="navbar-brand" to="/">
                        Scrumboard
                    </router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Открыть меню">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                                <li v-if="!user" class="nav-item">
                                    <router-link class="nav-link" to="/auth/login">Войти</router-link>
                                </li>
                                <li v-if="!user" class="nav-item">
                                    <router-link class="nav-link" to="/auth/register">Регистрация</router-link>
                                </li>
                                <li v-if="user" class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="ni ni-single-02"></i>{{ user.username }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <router-link class="dropdown-item" to="/auth/logout">
                                            Выйти
                                        </router-link>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$auth.user();
    }
  }
};
</script>

