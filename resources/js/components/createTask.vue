<template>
  <b-modal id="createTask" centered size="sm" hide-header hide-footer>
    <div class="card bg-secondary shadow border-0">
      <div class="card-header bg-white pb-5">
        <h3 ckass="text-center mb-3">Создать задачу</h3>
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
              <input class="form-control" placeholder="Название задачи" v-model="name" type="text">
              <span v-if="errors.name" class="invalid-feedback" role="alert">
                <strong>{{ errors.name[0] }}</strong>
              </span>
            </div>
          </div>
          <div class="form-group mb-3" :class="{'has-danger': errors.description}">
            <div class="input-group input-group-alternative">
              <textarea
                class="form-control form-control-alternative"
                rows="3"
                v-model="description"
                placeholder="Write a large text here ..."
              ></textarea>
              <span v-if="errors.description" class="invalid-feedback" role="alert">
                <strong>{{ errors.description[0] }}</strong>
              </span>
            </div>
          </div>
          <div class="form-group mb-3" :class="{'has-danger': errors.executor}">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-single-02"></i>
                </span>
              </div>
              <select class="custom-select" v-model="executor">
                <option :value="null">Не назначен</option>
                <option
                  v-if="executors"
                  v-for="executor in executors"
                  :key="executor.id"
                  :value="executor.id"
                >{{ executor.username }}</option>
                <option v-else>Не удалось получить список исполнителей</option>
              </select>
              <span v-if="errors.executor" class="invalid-feedback" role="alert">
                <strong>{{ errors.executor[0] }}</strong>
              </span>
            </div>
          </div>

          <div class="form-group text-center">
            <button type="button" @click.prevent="save" class="btn btn-primary">Сохранить</button>
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      description: "",
      executor: null,
      executors: null,
      errors: {}
    };
  },
  methods: {
    loadExecutors() {
      this.$http
        .get("users", {
          params: {
            executors: true
          }
        })
        .then(res => {
          this.executors = res.data.data;
        });
    },
    save() {
      this.$http
        .post("task", {
          name: this.name,
          description: this.description,
          executor: this.executor
        })
        .then(res => {
          this.$snotify.success("Задача сохранена");
          let task = res.data.data;
          task.status = 0;
          this.name = "";
          this.description = "";
          this.executor = null;
          this.$store.commit("tasks/setTask", res.data.data);
          this.$root.$emit("bv::hide::modal", "createTask");
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.errors = err.response.data.data;
          }
        });
    }
  },
  created() {
    this.loadExecutors();
  }
};
</script>

<style>
#createTask___BV_modal_body_ {
  padding: 0;
}
</style>

