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
          <div style="height: 100%">
            <router-view></router-view>
          </div>
        </section>
        <b-modal id="newSprint" title="Создание нового спринта">
          <div class="input-daterange datepicker row align-items-center">
            <div class="col">
              <date-picker lang="ru" v-model="dateStart" type="date"></date-picker>
            </div>
          </div>
        </b-modal>
      </main>
    </div>

    <div v-if="!$auth.ready()">
      <div style="text-align:center; padding-top:50px;">Loading site...</div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import navbar from "../components/navbar";
export default {
  data() {
    return {
      dateStart: ""
    };
  },
  components: { navbar, DatePicker }
};
</script>

