import axios from 'axios';

const state = {
  materials:[],
  suppliers:[],
  paymentTypes:[],
  selectedMaterials:[]

};

const getters = {
  allMaterials: state => state.materials,
  allSuppliers: state => state.suppliers,
  allPaymentTypes: state => state.paymentTypes,
  allSelectedMaterials: state => state.selectedMaterials

};

const actions = {
  async fetchMaterials({ commit }) {
    const response = await axios.get(
      'api/material/list'
    );

    commit('setMaterials', response.data.data);
  },

  async fetchSuppliers({ commit }) {
    const response = await axios.get(
      'api/supplier/list'
    );

    commit('setSuppliers', response.data.data);
  },

  async fetchPaymentTypes({ commit }) {
    const response = await axios.get(
      'api/paymentType/list'
    );

    commit('setPaymentTypes', response.data.data);
  },


 /* async addTodo({ commit }, title) {
    const response = await axios.post(
      'https://jsonplaceholder.typicode.com/todos',
      { title, completed: false }
    );

    commit('newTodo', response.data);
  },
  async deleteTodo({ commit }, id) {
    await axios.delete(`https://jsonplaceholder.typicode.com/todos/${id}`);

    commit('removeTodo', id);
  },
  async filterTodos({ commit }, e) {
    // Get selected number
    const limit = parseInt(
      e.target.options[e.target.options.selectedIndex].innerText
    );

    const response = await axios.get(
      `https://jsonplaceholder.typicode.com/todos?_limit=${limit}`
    );

    commit('setTodos', response.data);
  },
  async updateTodo({ commit }, updTodo) {
    const response = await axios.put(
      `https://jsonplaceholder.typicode.com/todos/${updTodo.id}`,
      updTodo
    );

    console.log(response.data);

    commit('updateTodo', response.data);
  }
  */

};

const mutations = {
  setMaterials: (state, materials) => (state.materials = materials),
  setSuppliers: (state, suppliers) => (state.suppliers = suppliers),
  setPaymentTypes: (state, paymentTypes) => (state.paymentTypes = paymentTypes),

  /*
  newTodo: (state, todo) => state.todos.unshift(todo),
  removeTodo: (state, id) =>
    (state.todos = state.todos.filter(todo => todo.id !== id)),
  updateTodo: (state, updTodo) => {
    const index = state.todos.findIndex(todo => todo.id === updTodo.id);
    if (index !== -1) {
      state.todos.splice(index, 1, updTodo);
    }
  }
  */
};

export default {
  state,
  getters,
  actions,
  mutations
};
