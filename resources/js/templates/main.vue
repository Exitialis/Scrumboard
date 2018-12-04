<template>
  <div style="height: 100%;">
    <div v-if="$auth.ready()" style="height: 100%;">
      <navbar></navbar>
      <vue-snotify></vue-snotify>
      <main style="height: 100%;">
        <section class="section section-shaped section-lg" style="height: 100%;">
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
          <create-sprint></create-sprint>
          <div style="height: 100%">
            <router-view></router-view>
          </div>
        </section>
      </main>
    </div>

    <div v-if="!$auth.ready()">
      <div style="text-align:center; padding-top:50px;">Loading site...</div>
    </div>
  </div>
</template>

<script>
import navbar from "../components/navbar";
import createSprint from "../components/createSprint";
export default {
  components: { navbar, createSprint }
};
</script>

