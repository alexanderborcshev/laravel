<template>
    <tooltip-component
        :direction="'bottom-left-direction'"
        :add-style="{width: 'auto'}"
        :add-class-wrap="'city-changer__tooltip-wrap'"
        :add-class="'city-changer'"
        :is-btn-close="false">
        <template v-slot:tooltipBtn>
            <div class="city-changer__tooltip-btn">
                <svg-icon :name="'marker'" :width="isDesktop ? 16 : 24" :height="isDesktop ? 16 : 24" class="svg-icon"></svg-icon>
                <span class="ml4">Москва</span>
            </div>
        </template>
        <template v-slot:tooltipContent>
            <div class="txt">
                На данный момент мы работаем<br>только в Москве и области
            </div>
        </template>
    </tooltip-component>
</template>

<script>
import { mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import TooltipComponent from '@/components/TooltipComponent.vue';

export default {
    name: 'CityChanger',
    components: {
        SvgIcon,
        TooltipComponent,
    },
    props: {
    },
    data() {
        return {
        };
    },
    mounted() {
    },
    computed: {
        ...mapState({
            isDesktop: (state) => state.isDesktop,
        }),
    },
    watch: {

    },
    methods: {
    },
};
</script>

<style lang="sass">
.city-changer
    &__tooltip-wrap
        &.opened
            .city-changer__tooltip-btn
                color: $honey
    .tooltip__content
        padding: 12px
        color: $black3
        .txt
            width: 179px
            font-size: 12px
            line-height: 15px
            font-weight: 500
            +for-size(992)
                width: 239px
                font-size: 16px
                line-height: 24px
    &__tooltip-btn
        display: flex
        align-items: center
        color: $gray1
        font-weight: 700
        font-size: 14px
        line-height: 16px
        user-select: none
        span
            display: none
        +for-size(992)
            font-size: 14px
            line-height: 16px
            span
                display: inline
    &__btn
        display: flex
        align-items: center
        font-size: 12px
        line-height: 14px
        white-space: nowrap
        flex: 1
        color: $black
        font-weight: 500
        +for-size(992)
            font-size: 16px
            line-height: 24px
        .svg-icon
            color: $yellow
        &:hover
            color: $black

</style>
