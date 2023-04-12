const state = {
    items: {
        howWorksModal: {
            name: 'howWorksModal',
            show: false,
        },
        catalogNav: {
            name: 'catalogNav',
            show: false,
        },
        contractorModal: {
            name: 'contractorModal',
            show: false,
        },
        attentionModal: {
            name: 'attentionModal',
            show: false,
        },
        requestModal: {
            name: 'requestModal',
            show: false,
        },
        successModal: {
            name: 'successModal',
            show: false,
        },
        contractOfferModal: {
            name: 'contractOfferModal',
            show: false,
        },
        contactModal: {
            name: 'contactModal',
            show: false,
        },
        privacyPolicy: {
            name: 'privacyPolicy',
            show: false,
        },
        modalMenu: {
            name: 'modalMenu',
            show: false,
        },
    },
    notify: {
        articleMoved: 'Статья успешно перемещена',
    },
};

// getters
const getters = {

};

const actions = {
    open(context, data) {
        if (data.name && state.items[data.name]) {
            if (!context.rootState.isDesktop || data.name !== 'catalogNav') {
                document.getElementsByTagName('body')[0].classList.add('noscroll');
            }
            setTimeout(() => {
                context.commit('open', { name: data.name });
            }, 10);
        }
    },
    close(context, data) {
        if (data.name && state.items[data.name]) {
            setTimeout(() => {
                context.commit('close', { name: data.name });
            }, 10);
        }
    },
    showNotify(context, data) {
        if (data.name && state.items[data.name]) {
            context.commit('showNotify', { name: data.name });
            setTimeout(() => {
                context.commit('close', { name: data.name });
            }, 3000);
        }
    },
};

const mutations = {
    close(state, data) {
        if (data.name && state.items[data.name]) {
            state.items[data.name].show = false;
            if (data.name === 'addRule') {
                if (document.querySelector('.rules')) {
                    document.querySelector('.rules').style.opacity = '';
                }
            }
            document.getElementsByTagName('body')[0].classList.remove('noscroll');
        }
    },
    open(state, data) {
        if (data.name && state.items[data.name]) {
            state.items[data.name].show = true;
        }
    },
    showNotify(state, data) {
        if (data.name && state.items[data.name]) {
            state.items[data.name].show = true;
            setTimeout(() => {
                state.items[data.name].show = false;
            }, 3000);
        }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
