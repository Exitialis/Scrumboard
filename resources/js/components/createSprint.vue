<template>
  <b-modal id="newSprint" centered size="sm" hide-header hide-footer>
    <div class="card bg-secondary shadow border-0">
      <div class="card-header bg-white pb-5">
        <h3 ckass="text-center mb-3">Создать спринт</h3>
      </div>
      <div class="card-body px-lg-5 py-lg-5">
        <form>
          <div class="form-group mb-3" :class="{'has-danger': errors.name}">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-tag"></i>
                </span>
              </div>
              <input class="form-control" placeholder="Название спринта" v-model="name" type="text">
              <span v-if="errors.name" class="invalid-feedback" role="alert">
                <strong>{{ errors.name[0] }}</strong>
              </span>
            </div>
          </div>
          <div class="form-group mb-3" :class="{'has-danger': errors.date_start}">
            <date-picker lang="ru" v-model="dateStart" type="date"></date-picker>
            <span v-if="errors.date_start" class="invalid-feedback" role="alert">
              <strong>{{ errors.date_start[0] }}</strong>
            </span>
          </div>
          <div class="form-group mb-3" :class="{'has-danger': errors.date_finish}">
            <date-picker lang="ru" v-model="dateEnd" type="date"></date-picker>
            <span v-if="errors.date_finish" class="invalid-feedback" role="alert">
              <strong>{{ errors.date_finish[0] }}</strong>
            </span>
          </div>
          <div class="text-center">
            <button type="button" @click.prevent="saveSprint" class="btn btn-primary my-4">Создать</button>
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>

<script>
import DatePicker from "./datepicker";
export default {
  components: {
    DatePicker
  },
  data() {
    return {
      dateStart: "",
      dateEnd: "",
      name: "",
      errors: {}
    };
  },
  methods: {
    saveSprint() {
      let requestData = {
        name: this.name
      };

      if (this.dateStart) {
        requestData.date_start = this.dateStart;
      }
      if (this.dateEnd) {
        requestData.date_finish = this.dateEnd;
      }
      this.$http
        .post("sprint", requestData)
        .then(res => {})
        .catch(err => {
          if (err.response.status === 422) {
            this.errors = err.response.data.data;
          }
        });
    }
  }
};
</script>

<style>
#newSprint___BV_modal_body_ {
  padding: 0;
}
#newSprint___BV_modal_body_ .mx-datepicker {
  width: auto;
  display: block;
}
#newSprint___BV_modal_body_ .invalid-feedback {
  display: block;
}
</style>


