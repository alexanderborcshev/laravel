import api from '@/store/api';

const state = {
    items: [],
    load: false,
};
const getters = {};
const actions = {
    getItems(context) {
        context.commit('setItems', []);
        context.commit('setLoad', true);
        api.get('/category', {}).then((r) => {
            context.commit('setItems', r);
            context.commit('setLoad', false);
        });
    },
    getCsrf() {
        return api.get('/sanctum/csrf-cookie').then(() => {});
    },
};
const mutations = {
    setLoad(state, data) {
        state.load = data;
    },
    setItems(state, data) {
        state.items = data;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
