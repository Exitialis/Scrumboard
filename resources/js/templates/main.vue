<template>
  <div style="height: 100%;">
    <div v-if="$auth.ready()" style="height: 100%;">
      <navbar></navbar>
      <main style="height: 100%;">
        <router-view></router-view>
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

