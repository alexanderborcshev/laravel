import api from '@/store/api';

const state = {
    items: [],
    item: {},
    load: false,
};
const getters = {};
const actions = {
    getItems(context, data) {
        context.commit('setItems', []);
        context.commit('setLoad', true);
        api.get('/offer', { filter: { code: data.code, popular: data.popular } }).then((r) => {
            context.commit('setItems', r);
            context.commit('setLoad', false);
        });
    },
    getItem(context, data) {
        context.commit('setItem', {});
        context.commit('setLoad', true);
        api.get(`/offer/${data.id}`, {}).then((r) => {
            context.commit('setItem', r);
            context.commit('setLoad', false);
        });
    },
    sendOrder(context, data) {
        api.post('/offer/order', {}, data).then(() => {});
    },
};
const mutations = {
    setLoad(state, data) {
        state.load = data;
    },
    setItems(state, data) {
        state.items = data;
    },
    setItem(state, data) {
        state.item = data;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
