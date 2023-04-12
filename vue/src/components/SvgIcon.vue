<template>
    <svg :style="{width: `${width}px`, height: `${height}px`}" :viewBox="`0 0 ${width} ${height}`" class="svg-icon">
        <use v-bind="{ 'xlink:href': `${require('../assets/img/sprite.svg')}#${name}` }"></use>
    </svg>
</template>
<script>
export default {
    name: 'SvgIcon',
    components: {
    },
    props: {
        name: {
            default() {
                return '';
            },
        },
        width: {
            default() {
                return '';
            },
        },
        height: {
            default() {
                return '';
            },
        },
    },
    data() {
        return {
        };
    },
};
</script>

<style lang="sass">
.svg-icon
    display: flex
    align-items: center
    justify-content: center
</style>
