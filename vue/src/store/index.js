import { createStore } from 'vuex';
import popups from './modules/popups';
import offer from './modules/offer';
import category from './modules/category';

export default createStore({
    state: {
        isDesktop: false,
    },
    getters: {
    },
    mutations: {
        setIsDesktop(state, data) {
            state.isDesktop = data;
        },
    },
    actions: {
        setIsDesktop(context, data) {
            context.commit('setIsDesktop', data);
        },
    },
    modules: {
        popups,
        offer,
        category,
    },
});
