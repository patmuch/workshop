import Vuex from 'vuex';
import Vue from 'vue';
import receive from './modules/receive';

// Load Vuex
Vue.use(Vuex);

// Create store
export default new Vuex.Store({
  modules: {
    receive
  }
});