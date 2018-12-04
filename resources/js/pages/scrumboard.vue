<template>
  <div class="board">
    <div class="header" v-if="sprint">
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
    <div class="card">
      <div class="card-header">
        <h3>Спринт не найден</h3>
      </div>
      <div class="card-body">
        <p>Для начала, необходимо запланировать спринт</p>
      </div>
      <div class="card-footer"></div>
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
    return {
      tasks: [],
      sprint: null
    };
  },
  computed: {
    createdTasks: {
      get() {
        return this.tasks.filter(task => task.status === 0);
      },
      set(value) {
        if (this.createdTasks.length > value.length) return;
        for (let i = 0; i < value.length; i++) {
          let task = value[i];
          if (!this.createdTasks.includes(task)) {
            task.status = 0;
            this.updateTask(task);
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
            task.status = 1;
            this.updateTask(task);
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
            task.status = 2;
            this.updateTask(task);
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
            task.status = 3;
            this.updateTask(task);
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
        this.tasks = res.data.data;
      });
    },
    getSprint() {
      return this.$http.get("sprint?status=1").then(res => {
        this.sprint = res.data.data;
      });
    },
    updateTask(task) {
      return this.$http
        .put("task/" + task.id, {
          status: task.status
        })
        .then(res => {
          let index = this.tasks.findIndex(task => {
            task.id === res.data.data.id;
          });
          this.tasks[index] = res.data.data;
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
  overflow-x: auto;
  width: 100%;
  height: 100%;
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
  background-color: #f4f5f7;
  height: 100%;
}
</style>


