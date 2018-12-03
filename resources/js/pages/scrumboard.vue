<template>
  <div class="board">
    <div class="board-col">
      <div class="header">К ВЫПОЛНЕНИЮ</div>
      <div class="content">
        <draggable v-model="createdTasks" :options="{group:'tasks'}" style="min-height: 100%">
          <div class="task" v-for="(task, index) in createdTasks" :key="index">
            <div class="header">
              <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
              <p class="text-muted executor">{{ task.executor }}</p>
            </div>
            <div class="name">{{ task.name }}</div>
          </div>
        </draggable>
      </div>
    </div>
    <div class="board-col">
      <div class="header">В РАБОТЕ</div>
      <div class="content">
        <draggable v-model="performedTasks" :options="{group:'tasks'}" style="min-height: 100%">
          <div class="task" v-for="(task, index) in performedTasks" :key="index">
            <div class="header">
              <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
              <p class="text-muted executor">{{ task.executor }}</p>
            </div>
            <div class="name">{{ task.name }}</div>
          </div>
        </draggable>
      </div>
    </div>
    <div class="board-col">
      <div class="header">ТЕСТИРУЕТСЯ</div>
      <div class="content">
        <draggable v-model="tasksInTesting" :options="{group:'tasks'}" style="min-height: 100%">
          <div class="task" v-for="(task, index) in tasksInTesting" :key="index">
            <div class="header">
              <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
              <p class="text-muted executor">{{ task.executor }}</p>
            </div>
            <div class="name">{{ task.name }}</div>
          </div>
        </draggable>
      </div>
    </div>
    <div class="board-col">
      <div class="header">ГОТОВО</div>
      <div class="content">
        <draggable v-model="doneTasks" :options="{group:'tasks'}" style="min-height: 100%">
          <div class="task" v-for="(task, index) in doneTasks" :key="index">
            <div class="header">
              <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
              <p class="text-muted executor">{{ task.executor }}</p>
            </div>
            <div class="name">{{ task.name }}</div>
          </div>
        </draggable>
      </div>
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
  justify-content: space-between;
  flex-wrap: nowrap;
  align-items: stretch;
  overflow-x: auto;
  padding: 15px;
  height: 100%;
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

.task {
  display: flex;
  flex-wrap: wrap;
  margin: 5px;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0px 1px 2px 0px rgba(9, 30, 66, 0.25);
  border: 0;
  border-radius: 2px;
  color: #333;
  cursor: move;
}

.task .header {
  display: flex;
  justify-content: space-between;
  width: 100%;
}
</style>


