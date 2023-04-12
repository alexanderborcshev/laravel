/*
 * vue-inputmask
 *
 * (C) 2016 Simon Clériot
 * MIT LICENCE
 *
 */
import Inputmask from 'inputmask';

const inputmaskPlugin = {
    install(Vue) {
        Vue.directive('mask', {
            mounted(el, binding) {
                Inputmask(binding.value).mask(el);
            },
        });
    },
};

export default inputmaskPlugin;
