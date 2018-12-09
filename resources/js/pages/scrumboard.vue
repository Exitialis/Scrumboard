<template>
  <div style="height: 100%">
    <div class="board" v-if="sprint">
      <div class="header">
        <h3>Спринт {{ sprint.name }}</h3>
        <div>
          <span>
            <i class="ni ni-time-alarm"></i>
            Дней осталось: {{ daysUntilFinish }}
          </span>
          <a href="#" @click.prevent="finishSprint" class="btn btn-primary ml-2">Завершить спринт</a>
        </div>
      </div>
      <div class="board-row" v-if="sprint">
        <div class="board-col">
          <div class="header">К ВЫПОЛНЕНИЮ</div>
          <div class="content">
            <draggable v-model="createdTasks" :options="{group:'tasks'}" style="min-height: 100%">
              <boardTask v-for="(task, index) in createdTasks" :key="index" :task="task"></boardTask>
            </draggable>
          </div>
        </div>
        <div class="board-col">
          <div class="header">В РАБОТЕ</div>
          <div class="content">
            <draggable v-model="performedTasks" :options="{group:'tasks'}" style="min-height: 100%">
              <boardTask v-for="(task, index) in performedTasks" :key="index" :task="task"></boardTask>
            </draggable>
          </div>
        </div>
        <div class="board-col">
          <div class="header">ТЕСТИРУЕТСЯ</div>
          <div class="content">
            <draggable v-model="tasksInTesting" :options="{group:'tasks'}" style="min-height: 100%">
              <boardTask v-for="(task, index) in tasksInTesting" :key="index" :task="task"></boardTask>
            </draggable>
          </div>
        </div>
        <div class="board-col">
          <div class="header">ГОТОВО</div>
          <div class="content">
            <draggable v-model="doneTasks" :options="{group:'tasks'}" style="min-height: 100%">
              <boardTask v-for="(task, index) in doneTasks" :key="index" :task="task"></boardTask>
            </draggable>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="col-lg-5 col-8">
        <div class="card">
          <div class="card-header">
            <h3>Спринт не найден</h3>
          </div>
          <div class="card-body">
            <p>Для начала, необходимо запланировать спринт</p>
          </div>
          <div class="card-footer">
            <router-link to="/backlog" class="btn btn-primary">Запланировать</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import boardTask from "../components/boardTask";
export default {
  components: {
    draggable,
    boardTask
  },
  data() {
    return {};
  },
  computed: {
    tasks() {
      return this.$store.getters["tasks/boardTasks"];
    },
    sprint() {
      return this.$store.state.tasks.sprint;
    },
    createdTasks: {
      get() {
        return this.tasks.filter(task => task.status === 0);
      },
      set(value) {
        if (this.createdTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.createdTasks.includes(task)) {
            this.updateTask(task, 0);
            return;
          }
        }
      }
    },
    performedTasks: {
      get() {
        return this.tasks.filter(task => task.status === 1);
      },
      set(value) {
        if (this.performedTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.performedTasks.includes(task)) {
            this.updateTask(task, 1);
            return;
          }
        }
      }
    },
    tasksInTesting: {
      get() {
        return this.tasks.filter(task => task.status === 2);
      },
      set(value) {
        if (this.tasksInTesting.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.tasksInTesting.includes(task)) {
            this.updateTask(task, 2);
            return;
          }
        }
      }
    },
    doneTasks: {
      get() {
        return this.tasks.filter(task => task.status === 3);
      },
      set(value) {
        if (this.doneTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.doneTasks.includes(task)) {
            this.updateTask(task, 3);
            return;
          }
        }
      }
    },
    daysUntilFinish() {
      if (!this.sprint) return null;
      if (!this.sprint.date_finish) return null;
      return Math.round(
        (new Date(this.sprint.date_finish).getTime() - new Date().getTime()) /
          (1000 * 60 * 60 * 24)
      );
    }
  },
  methods: {
    loadBoard() {
      this.getSprint().then(() => {
        if (this.sprint) {
          this.getTasks(this.sprint.id);
        }
      });
    },
    getTasks(sprint) {
      return this.$http.get("task?sprint=" + sprint).then(res => {
        this.$store.commit("tasks/setTasks", res.data.data);
      });
    },
    getSprint() {
      return this.$http.get("sprint?status=1").then(res => {
        this.$store.commit("tasks/setSprint", res.data.data);
      });
    },
    updateTask(task, status) {
      this.$store.commit("tasks/setTaskStatus", {
        task,
        status
      });
      return this.$http
        .put("task/" + task.id, {
          status
        })
        .then(res => {
          this.$store.commit("tasks/updateTask", res.data.data);
        });
    },
    finishSprint() {
      this.sprint.status = 2;
      this.$http.put("sprint/" + this.sprint.id, this.sprint).then(() => {
        this.loadBoard();
      });
    }
  },
  created() {
    this.loadBoard();
  }
};
</script>

<style>
.board {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  height: 100%;
  width: 100%;
  padding: 15px;
}
.board > .header {
  flex: 1;
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-bottom: 30px;
  color: #fff;
}
.board > .header > h3 {
  color: #fff;
}
.board-row {
  display: flex;
  justify-content: space-between;
  flex-wrap: nowrap;
  align-items: stretch;
  width: 100%;
}
.board-col:first-child {
  margin-left: 0;
}
.board-col:last-child {
  margin-right: 0;
}
.board-col {
  flex: 1;
  margin: 0 7.5px;
  min-height: 300px;
}
.board-col > .header {
  background-color: #f4f5f7;
  margin-bottom: 15px;
  text-align: center;
  padding: 10px 0;
}

.board-col .content {
  height: 100%;
  background-color: #f4f5f7;
}
</style>


