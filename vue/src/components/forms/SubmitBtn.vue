<template>
    <component :is="tag" :class="style" class="btn" :disabled="disabled">
        <svg-icon :name="'preloader'" :width="24" :height="24" class="preloader mr4"></svg-icon>
        <slot></slot>
    </component>
</template>
<script>
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    components: {
        SvgIcon,
    },
    props: {
        type: {
            default() {
                return 'normal';
            },
        },
        hasIcon: {
            default() {
                return true;
            },
        },
        tag: {
            type: String,
            default: 'button',
        },
        size: {
            type: String,
            default: 'normal', // варианты: small
        },
    },
    computed: {
        disabled() {
            return (this.type !== 'normal');
        },
        style() {
            if (this.type === 'load') {
                return `btn--preloader ${this.isIcon ? 'has-icon' : ''}`;
            }
            if (this.type === 'ok') {
                return `btn--preloader --ok ${this.isIcon ? 'has-icon' : ''}`;
            }
            return '';
        },
    },
    watch: {
        type(newVal) {
            if (newVal === 'load') {
                setTimeout(() => {
                    this.isLoader = true;
                }, 1000);
            } else {
                this.isLoader = false;
            }
        },
    },
    data() {
        return {
            isLoader: false,
        };
    },
    methods: {
        send() {
        },
    },
};
</script>
