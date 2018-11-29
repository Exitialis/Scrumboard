<template>
    <div>
        <navbar></navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import navbar from "../components/navbar";
export default {
  components: { navbar }
};
</script>

