<template>
  <b-modal
    id="newSprint"
    title="Создание нового спринта"
    :cancel-disabled="true"
    :ok-disabled="true"
  >
    <div class="row align-items-center">
      <div class="card bg-secondary shadow border-0">
        <div class="card-header bg-white pb-5">
          <h3 ckass="text-center mb-3">Создать спринт</h3>
        </div>
        <div class="card-body px-lg-5 py-lg-5">
          <form>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="ni ni-tag"></i>
                  </span>
                </div>
                <input
                  class="form-control"
                  placeholder="Название спринта"
                  v-model="name"
                  type="text"
                >
              </div>
            </div>
            <div class="form-group mb-3">
              <date-picker lang="ru" v-model="dateStart" bootstrap-styling type="date"></date-picker>
            </div>
            <div class="form-group mb-3">
              <date-picker lang="ru" v-model="dateEnd" type="date">
                <div class="input-group-prepend" slot="calendar-icon">
                  <span class="input-group-text">
                    <i class="ni ni-calendar-grid-58"></i>
                  </span>
                </div>
              </date-picker>
            </div>
            <div class="text-center">
              <button type="button" class="btn btn-primary my-4">Создать</button>
            </div>
            <div class="input-group input-group-alternative">
              <input
                class="form-control datepicker"
                placeholder="Select date"
                type="text"
                value="06/20/2018"
              >
            </div>
          </form>
        </div>
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
      name: ""
    };
  }
};
</script>

