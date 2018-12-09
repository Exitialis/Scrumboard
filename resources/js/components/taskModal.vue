<template>
  <b-modal id="taskModal" centered size="lg" :title="'Просмотр задачи'">
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
      <div class="form-group mb-3" :class="{'has-danger': errors.status}">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="ni ni-sound-wave"></i>
            </span>
          </div>
          <select class="custom-select" v-model="status">
            <option
              v-for="status in statuses"
              :key="status.value"
              :value="status.value"
            >{{ status.text }}</option>
          </select>
          <span v-if="errors.status" class="invalid-feedback" role="alert">
            <strong>{{ errors.status[0] }}</strong>
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
          <select class="custom-select" v-model="executorId">
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
    </form>

    <div class="text-center" slot="modal-footer">
      <button type="button" @click.prevent="saveTask" class="btn btn-primary">Сохранить</button>
    </div>
  </b-modal>
</template>

<script>
export default {
  data() {
    return {
      statuses: [
        {
          text: "К ВЫПОЛНЕНИЮ",
          value: 0
        },
        {
          text: "В РАБОТЕ",
          value: 1
        },
        {
          text: "ТЕСТИРУЕТСЯ",
          value: 2
        },
        {
          text: "ГОТОВА",
          value: 3
        }
      ],
      errors: {},
      executors: null
    };
  },
  computed: {
    task() {
      return this.$store.state.task;
    },
    name: {
      get() {
        return this.$store.state.task.name;
      },
      set(value) {
        this.$store.commit("task/setName", value);
      }
    },
    description: {
      get() {
        return this.$store.state.task.description;
      },
      set(value) {
        this.$store.commit("task/setDescription", value);
      }
    },
    status: {
      get() {
        return this.$store.state.task.status;
      },
      set(value) {
        this.$store.commit("task/setStatus", value);
      }
    },
    creator: {
      get() {
        return this.$store.state.task.creator;
      },
      set(value) {
        this.$store.commit("task/setCreator", value);
      }
    },
    executorId: {
      get() {
        return this.$store.state.task.executor
          ? this.$store.state.task.executor.id
          : null;
      },
      set(value) {
        let index = this.executors.findIndex(exec => exec.id === value);
        this.$store.commit("task/setExecutor", this.executors[index]);
      }
    },
    executor: {
      get() {
        return this.$store.state.task.executor;
      },
      set(value) {
        this.$store.commit("task/setExecutor", value);
      }
    },
    sprint: {
      get() {
        return this.$store.state.task.sprint;
      },
      set(value) {
        this.$store.commit("task/setSprint", value);
      }
    }
  },
  methods: {
    saveTask() {
      this.errors = {};
      this.$http
        .put("task/" + this.task.id, {
          name: this.name,
          description: this.description,
          status: this.status,
          executor: this.executor ? this.executor.id : null
        })
        .then(res => {
          this.$snotify.success("Задача сохранена");
          this.$store.dispatch("task/saveTask", res.data.data);
          this.$root.$emit("bv::hide::modal", "taskModal");
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.errors = err.response.data.data;
          }
        });
    },
    getExecutors() {
      this.$http
        .get("users", {
          params: {
            executors: true
          }
        })
        .then(res => {
          this.executors = res.data.data;
        });
    }
  },
  mounted() {
    this.getExecutors();
  }
};
</script>

