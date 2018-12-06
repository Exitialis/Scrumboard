import Vue from 'vue';

const state = {
  sprint: null,
  tasks: [],
  current: null
}

const mutations = {
  setSprint(state, sprint) {
    state.sprint = sprint
  },
  setTask(state, task) {
    state.tasks.push(task)
  },
  setTasks(state, tasks) {
    state.tasks = tasks;
  },
  updateTask(state, task) {
    let index = state.tasks.findIndex(item => item.id === task.id);
    if (index === -1) return;
    Vue.set(state.tasks, index, task);
  },
  setTaskSprint(state, obj) {
    let index = state.tasks.findIndex(item => item.id === obj.task.id);
    if (index === -1) return;
    Vue.set(state.tasks[index], 'sprint', obj.sprint);
  },
  setTaskStatus(state, obj) {
    let index = state.tasks.findIndex(item => item.id === obj.task.id);
    if (index === -1) return;
    Vue.set(state.tasks[index], 'status', obj.status);
  },
  setCurrent(state, task) {
    state.current = task;
  }
}

const getters = {
  boardTasks(state) {
    if (!state.sprint) return [];
    return state.tasks.filter(task => task.sprint === state.sprint.id);
  }
}

export default {
  state,
  mutations,
  getters
}
