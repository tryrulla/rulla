import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    values: {},
};

const mutations = {
    setValue (state, { key, value }) {
        console.log({ key, value });
        state.values = { ...state.values, [key]: value };
    }
};

const actions = {
    setValue({ commit }, { key, value }) {
        commit('setValue', { key, value });
    }
};

const getters = {
    values: (state) => state.values,
};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});
