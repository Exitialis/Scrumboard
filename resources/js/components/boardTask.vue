<template>
  <div class="board-task">
    <div class="header">
      <span class="badge badge-primary badge-pill">TASK-{{ task.id }}</span>
      <span class="badge badge-success badge-pill" v-if="task.executor">
        <i class="ni ni-single-02"></i>
        {{ task.executor.username }}
      </span>
      <span class="badge badge-warning badge-pill" v-else>
        <i class="ni ni-single-02"></i>
        Не назначен
      </span>
    </div>
    <div class="name">{{ task.name }}</div>
  </div>
</template>

<script>
export default {
  props: {
    task: {
      required: true,
      type: Object
    }
  }
};
</script>

<style>
.board-task {
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

.board-task .header {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-bottom: 15px;
}
</style>


