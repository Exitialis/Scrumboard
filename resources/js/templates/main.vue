<template>
  <div style="height: 100%;">
    <div v-if="$auth.ready()" style="height: 100%;">
      <navbar></navbar>
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
          <div>
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
export default {
  components: { navbar }
};
</script>

