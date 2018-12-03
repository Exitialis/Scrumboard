<template>
  <div class="backlog container">
    <div class="card">
      <div class="card-header">
        <p v-if="sprint">Задачи в {{ sprint.name }}</p>
        <p v-else>Нет доступного спринта</p>
      </div>
      <ul class="list-group list-group-flush">
        <draggable v-model="sprintTasks" :options="{group:'tasks'}" style="min-height: 100%">
          <li
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
            v-for="task in sprintTasks"
            :key="task.id"
          >
            <p>{{ task.name }}</p>
            <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
          </li>
        </draggable>
      </ul>
    </div>

    <div class="card">
      <div class="card-header">Все задачи</div>
      <ul class="list-group list-group-flush">
        <draggable v-model="availableTasks" :options="{group:'tasks'}" style="min-height: 100%">
          <li
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
            v-for="task in availableTasks"
            :key="task.id"
          >
            <p>{{ task.name }}</p>
            <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
          </li>
        </draggable>
      </ul>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  components: {
    draggable
  },
  data() {
    return {
      sprint: null,
      tasks: []
    };
  },
  computed: {
    availableTasks: {
      get() {
        return this.tasks.filter(task => task.sprint === null);
      },
      set(value) {
        if (this.availableTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.availableTasks.includes(task)) {
            this.tasks[this.tasks.indexOf(task)].sprint = null;
            this.updateTask(task);
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
            this.tasks[this.tasks.indexOf(task)].sprint = this.sprint.id;
            this.updateTask(task);
          }
        }
      }
    }
  },
  methods: {
    getTasks() {
      this.$http.get("task").then(res => {
        this.tasks = res.data.data;
      });
    },
    getSprint() {
      this.$http.get("sprint").then(res => {
        this.sprint = res.data.data;
      });
    },
    updateTask(task) {
      this.$http
        .put("task/" + task.id, {
          sprint: this.sprint.id,
          status: task.status
        })
        .then(res => {
          console.log(res);
        });
    }
  },
  created() {
    this.getSprint();
    this.getTasks();
  }
};
</script>

<style>
.backlog .card {
  margin-top: 15px;
}
.backlog .list-group-item {
  cursor: move;
  padding: 0.2em;
}
.backlog .list-group-item p {
  margin: 0 20px;
}
</style>


