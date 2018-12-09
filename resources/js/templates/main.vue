<template>
  <div style="height: 100%;">
    <div v-if="$auth.ready()" style="height: 100%;" class="page-wrapper">
      <navbar></navbar>
      <vue-snotify></vue-snotify>
      <main class="section-shaped">
        <div class="shape shape-style-1 auth-bg">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div>
          <router-view></router-view>
        </div>
      </main>
      <footer class="footer" style="padding: 1rem 0;">
        <div class="container">
          <div class="row row-grid align-items-center">
            <div class="col-12 btn-wrapper">
              <a
                target="_blank"
                href="https://github.com/exitialis/scrumboard"
                class="btn btn-neutral btn-icon-only btn-github btn-round btn-lg"
                data-toggle="tooltip"
                data-original-title="Star on Github"
              >
                <i class="fa fa-github"></i>
              </a>
            </div>
          </div>
          <hr style="margin: 0.5rem 0;">
          <div class="row align-items-center justify-content-md-between">
            <div class="col-md-6">
              <div class="copyright">
                © 2018
                <a href="https://github.com/exitialis" target="_blank">Exitialis</a>.
              </div>
            </div>
            <div class="col-md-6">
              <ul class="nav nav-footer justify-content-end">
                <li class="nav-item">
                  <a href="https://github.com/exitialis" class="nav-link" target="_blank">Автор</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <task-modal></task-modal>
    <div v-if="!$auth.ready()">
      <div style="text-align:center; padding-top:50px;">Loading site...</div>
    </div>
  </div>
</template>

<script>
import navbar from "../components/navbar";
import taskModal from "../components/taskModal";
export default {
  components: { navbar, taskModal }
};
</script>

<style>
.section-shaped {
  padding: 70px 0;
}
.page-wrapper {
  display: flex;
  flex-direction: column;
}
.page-wrapper main {
  flex: 1 0 auto;
}
.page-wrapper .footer {
  flex-shrink: 0;
}
</style>


