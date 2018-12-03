<template>
  <div class="container pt-lg-md">
    <router-view></router-view>
  </div>
</template>

<script>
import navbar from "../../components/navbar";
export default {
  components: { navbar }
};
</script>
