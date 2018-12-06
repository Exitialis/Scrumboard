<template>
  <div class="backlog container">
    <div class="card">
      <div class="card-header">
        <p v-if="sprint">Задачи в {{ sprint.name }}</p>
        <p v-else>Нет доступного спринта</p>
        <a v-if="!sprint" href="#" v-b-modal.newSprint class="text-muted">Создать?</a>
      </div>

      <ul class="list-group list-group-flush" v-if="sprint">
        <draggable v-model="sprintTasks" :options="{group:'tasks'}" style="min-height: 50px">
          <li
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
            v-for="task in sprintTasks"
            :key="task.id"
          >
            <p>{{ task.name }}</p>
            <div class="d-flex wrap">
              <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
              <span class="badge badge-info badge-pill" v-if="task.status === 0">К ВЫПОЛНЕНИЮ</span>
              <span class="badge badge-info badge-pill" v-if="task.status === 1">В РАБОТЕ</span>
              <span class="badge badge-info badge-pill" v-if="task.status === 2">ТЕСТИРУЕТСЯ</span>
              <span class="badge badge-info badge-pill" v-if="task.status === 3">ВЫПОЛНЕНА</span>
              <span class="badge badge-success badge-pill" v-if="task.executor">
                <i class="ni ni-single-02"></i>
                {{ task.executor.username }}
              </span>
              <span class="badge badge-warning badge-pill" v-else>
                <i class="ni ni-single-02"></i>
                Не назначен
              </span>
            </div>
          </li>
        </draggable>
      </ul>
    </div>

    <div class="card">
      <div class="card-header">Все задачи</div>
      <ul class="list-group list-group-flush">
        <draggable v-model="availableTasks" :options="{group:'tasks'}" style="min-height: 50px">
          <li
            class="list-group-item list-group-item-action"
            v-for="task in availableTasks"
            :key="task.id"
          >
            <a
              href="#"
              class="d-flex justify-content-between align-items-center"
              @click.prevent="$store.commit('tasks/setCurrent', task)"
              v-b-modal.taskModal
            >
              <p>{{ task.name }}</p>
              <div>
                <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
                <span class="badge badge-info badge-pill" v-if="task.status === 0">К ВЫПОЛНЕНИЮ</span>
                <span class="badge badge-info badge-pill" v-if="task.status === 1">В РАБОТЕ</span>
                <span class="badge badge-info badge-pill" v-if="task.status === 2">ТЕСТИРУЕТСЯ</span>
                <span class="badge badge-info badge-pill" v-if="task.status === 3">ВЫПОЛНЕНА</span>
                <span class="badge badge-success badge-pill" v-if="task.executor">
                  <i class="ni ni-single-02"></i>
                  {{ task.executor.username }}
                </span>
                <span class="badge badge-warning badge-pill" v-else>
                  <i class="ni ni-single-02"></i>
                  Не назначен
                </span>
              </div>
            </a>
          </li>
        </draggable>
      </ul>
    </div>
    <create-sprint @created="getSprint"></create-sprint>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import createSprint from "../components/createSprint";
export default {
  components: {
    draggable,
    createSprint
  },
  data() {
    return {
      sprintModal: false
    };
  },
  computed: {
    tasks() {
      return this.$store.state.tasks.tasks;
    },
    sprint() {
      return this.$store.state.tasks.sprint;
    },
    availableTasks: {
      get() {
        return this.tasks.filter(task => {
          if (this.sprint) {
            return task.sprint !== this.sprint.id;
          }
          return task.status !== 3;
        });
      },
      set(value) {
        if (this.availableTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.availableTasks.includes(task)) {
            this.updateTask(task, null);
          }
        }
      }
    },
    sprintTasks: {
      get() {
        if (!this.sprint) {
          return [];
        }
        return this.tasks.filter(task => task.sprint === this.sprint.id);
      },
      set(value) {
        if (this.sprintTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.sprintTasks.includes(task)) {
            this.updateTask(task, this.sprint.id);
          }
        }
      }
    }
  },
  methods: {
    getTasks() {
      this.$http.get("task").then(res => {
        this.$store.commit("tasks/setTasks", res.data.data);
      });
    },
    getSprint() {
      this.$http.get("sprint").then(res => {
        this.$store.commit("tasks/setSprint", res.data.data);
      });
    },
    updateTask(task, sprint) {
      this.$store.commit("tasks/setTaskSprint", {
        task,
        sprint: sprint
      });
      this.$http
        .put("task/" + task.id, {
          sprint,
          status: task.status
        })
        .then(res => {
          this.$store.commit("tasks/updateTask", res.data.data);
        })
        .catch(err => {
          task.sprint = task.sprint ? null : this.sprint.id;
        });
    },
    reload() {
      this.getSprint();
      this.getTasks();
    }
  },
  created() {
    this.reload();
  }
};
</script>

<style>
.backlog .card {
  margin-top: 15px;
}
.backlog .badge {
  min-width: 109px;
}
.backlog .list-group-item {
  cursor: move;
  padding: 0.2em;
}
.backlog .list-group-item p {
  margin: 0 20px;
}
</style>


