<template>
  <div class="board">
    <div class="board-col"></div>
    <div class="board-col"></div>
    <div class="board-col"></div>
    <div class="board-col"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tasks: []
    };
  },
  computed: {
    createdTasks() {},
    performedTasks() {},
    tasksInTesting() {},
    doneTasks() {}
  },
  methods: {
    getTasks() {
      this.$http.get("task").then(res => {});
    },
    getSprint() {
      this.$http.get("sprint?status=1").then(res => {
        console.log(res);
      });
    }
  },
  created() {
    this.getSprint();
  }
};
</script>

<style>
.board {
  display: flex;
  padding: 15px;
  justify-content: space-between;
  flex-wrap: nowrap;
  align-items: stretch;
  overflow-x: auto;
}
.board-col {
  min-width: 195px;
  min-height: 300px;
  background-color: #f4f5f7;
}
</style>


