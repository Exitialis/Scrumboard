<template>
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
    <div class="container pt-lg-md">
      <router-view></router-view>
    </div>
  </section>
</template>

<script>
import navbar from "../../components/navbar";
export default {
  components: { navbar }
};
</script>
