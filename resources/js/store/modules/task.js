const state = {
  id: null,
  name: '',
  description: '',
  status: 0,
  creator: null,
  executor: null,
  sprint: null
}

const mutations = {
  setTask(state, task) {
    state.id = task.id;
    state.name = task.name;
    state.description = task.description;
    state.status = task.status;
    state.creator = task.creator;
    state.executor = task.executor;
    state.sprint = task.sprint;
  },
  setName(state, name) {
    state.name = name;
  },
  setDescription(state, description) {
    state.description = description;
  },
  setStatus(state, status) {
    state.status = status;
  },
  setCreator(state, creator) {
    state.creator = creator;
  },
  setExecutor(state, executor) {
    state.executor = executor;
  },
  setSprint(state, sprint) {
    state.sprint = sprint;
  }
}

const actions = {
  saveTask({
    commit,
    state
  }) {
    commit('tasks/updateTask', {
      id: state.id,
      name: state.name,
      description: state.description,
      status: state.status,
      creator: state.creator,
      executor: state.executor,
      sprint: state.sprint,
    }, {
      root: true
    })
  }
}

export default {
  state,
  mutations,
  actions
}
