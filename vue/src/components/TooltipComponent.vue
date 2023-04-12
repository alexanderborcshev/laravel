<template>
    <div class="" :class="{'tooltip-overlay': mobileVer && show}">
        <div class="w-tooltip"
            :style="{display: inline ? 'inline-block' : 'block'}"
            :class="[{'opened': show}, addClassWrap]"
            ref="tooltipWrap"
            @focusout="tooltipClose"
            tabindex="0">

            <span ref="tooltipBtn" class="tooltip__btn"
                @click.stop="btnClick"
                @focus="mouseOver"
                @blur="mouseLeave"
                :class="addClassBtn" @mouseover="mouseOver" @mouseleave="mouseLeave">
                <slot name="tooltipBtn"></slot>
            </span>

            <transition name="fade-popup">
                <div class="tooltip"
                     ref="tooltip"
                     v-if="show"
                     :class="[addClass, tooltipDirection, {'--close-btn-big': btnBig}]"
                     :style="addStyle">
                    <div v-if="isBtnClose" class="tooltip__close" @click.prevent="btnClick"></div>
                    <div class="tooltip__content" :style="{'padding':!isPadding ? '0': ''}">
                        <slot name="tooltipContent"></slot>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'TooltipComponent',
    data() {
        return {
            show: false,
            tooltipDirection: this.direction,
            mobileVer: false,
        };
    },
    props: {
        inline: { default: false },
        direction: { default: 'top-center-direction' },
        addStyle: { default: '' },
        addClass: { default: '' },
        addClassWrap: { default: '' },
        addClassBtn: { default: '' },
        tempID: { default: '' },
        isChangeablePos: {
            default() {
                return true;
            },
        },
        isBtnClose: {
            default() {
                return true;
            },
        },
        btnBig: {
            default() {
                return false;
            },
        },
        isPadding: {
            default() {
                return true;
            },
        },
        showOnHover: {
            default() {
                return false;
            },
        },
    },
    mounted() {

    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
    methods: {
        closeMobileTooltip() {
            if (document.querySelector('body').classList.contains('mobile-version') && this.show) {
                this.tooltipClose();
            }
        },
        mouseLeave() {
            if (this.showOnHover) {
                this.tooltipClose();
            }
        },
        mouseOver() {
            if (this.showOnHover) {
                this.tooltipShow();
            }
        },
        btnClick() {
            if (this.show) {
                this.tooltipClose();
            } else {
                this.tooltipShow();
            }
        },
        tooltipClose() {
            this.show = false;
            setTimeout(() => {
                this.$emit('tooltipclose', this.tempID);
            }, 100);
            if (this.mobileVer) {
                document.querySelector('body').classList.remove('noscroll');
            }
        },
        tooltipShow() {
            this.show = true;
            this.$emit('tooltipshow', this.tempID);
            this.tooltipDirection = this.direction;
            const self = this;
            setTimeout(() => {
                const element = document.querySelector('.w-tooltip.opened .tooltip');
                self.tooltipVisible(element);
                if (self.mobileVer) {
                    document.querySelector('body').classList.add('noscroll');
                }
            }, 10);
        },

        tooltipVisible(target) {
            // Все позиции элемента
            const targetPosition = {
                top: window.pageYOffset + target.getBoundingClientRect().top,
                left: window.pageXOffset + target.getBoundingClientRect().left,
                right: window.pageXOffset + target.getBoundingClientRect().right,
                bottom: window.pageYOffset + target.getBoundingClientRect().bottom,
            };
            // Получаем позиции окна
            const windowPosition = {
                top: window.pageYOffset,
                left: window.pageXOffset,
                right: window.pageXOffset + document.documentElement.clientWidth,
                bottom: window.pageYOffset + document.documentElement.clientHeight,
            };
            /* if (targetPosition.bottom > windowPosition.top && // Если позиция нижней части элемента больше позиции верхней чайти окна, то элемент виден сверху
              targetPosition.top < windowPosition.bottom && // Если позиция верхней части элемента меньше позиции нижней чайти окна, то элемент виден снизу
              targetPosition.right > windowPosition.left && // Если позиция правой стороны элемента больше позиции левой части окна, то элемент виден слева
              targetPosition.left < windowPosition.right) {
              */
            if (windowPosition.bottom - targetPosition.top < target.offsetHeight && this.isChangeablePos) { // Если позиция левой стороны элемента меньше позиции правой чайти окна, то элемент виден справа
                this.tooltipDirection = this.direction.replace('bottom', 'top');// 'top-center-direction';
            }
        },

    },
    emits: ['tooltipshow', 'tooltipclose'],
    directives: {
        /* eslint-disable */
        clickoutside: {
            mounted: function(el, binding, vNode) {
                if (typeof binding.value !== 'function') {
                    const compName = vNode.context.name;
                    let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                    if (compName) { warn += `Found in component '${compName}'` }
                }
                const bubble = binding.modifiers.bubble;
                const handler = (e) => {
                    if (bubble || (!el.contains(e.target) && el !== e.target)) {
                        binding.value(e)
                    }
                }
                el.__vueClickOutside__ = handler;
                document.addEventListener('click', handler);
            },

            unmounted: function(el, binding) {
                document.removeEventListener('click', el.__vueClickOutside__);
                el.__vueClickOutside__ = null;
            },
        },
    },
};

</script>

<style scoped>
    .fade-popup-enter-active, .fade-popup-leave-active {
        transition: opacity .15s;
    }
    .fade-popup-enter, .fade-popup-leave-to {
        opacity: 0;
    }
</style>
