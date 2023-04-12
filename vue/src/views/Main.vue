<template>
    <div class="wrapper">
        <div class="main-bn">
            <div class="inner-wrapper">
                <div>
                    <h1>БАЗА ПРОВЕРЕННЫХ ПОДРЯДЧИКОВ</h1>
                    <div class="alexey">Алексея Земскова</div>
                </div>
                <div class="guarantee">
                    <div class="icon mr8">
                        <div class="icon-wrap">
                            <svg-icon :name="'hand'" :width="19" :height="18"></svg-icon>
                        </div>
                    </div>
                    <div class="text">
                        <span>гарантия 100% на все работы</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="content --scrolling-content">
            <div>
                <h2>каталог</h2>
                <aside-sticky :marginTop="32" :marginBottom="32">
                    <aside class="aside">
                        <div class="aside-catalog">
                            <catalog-items :class="'--main-catalog'"></catalog-items>
                        </div>
                    </aside>
                </aside-sticky>
            </div>
            <div class="container-scroll" v-if="isDesktop">
                <h2>{{currentCategory.name ? currentCategory.name : 'все офферы'}}</h2>
                <offers-items></offers-items>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import CatalogItems from '@/components/CatalogItems.vue';
import OffersItems from '@/components/OffersItems.vue';
import SvgIcon from '@/components/SvgIcon.vue';
import AsideSticky from '@/components/AsideSticky.vue';

export default {
    name: 'MainHeader',
    components: {
        CatalogItems,
        OffersItems,
        SvgIcon,
        AsideSticky,
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
            popups: (state) => state.popups.items,
            isDesktop: (state) => state.isDesktop,
        }),
        ...mapState('category', {
            items: (state) => state.items,
            load: (state) => state.load,
        }),
        currentCategory() {
            const item = this.items.find((i) => i.code === this.$route.params.code);
            return item || {};
        },
    },
    watch: {
    },
    methods: {
        ...mapActions('popups', [
            'open',
        ]),
    },
};
</script>

<style lang="sass">
.main-bn
    height: 394px
    width: 100%
    background-size: 320px
    background-position: 0px 127px
    background-image: url(../assets/img/main-bn-mob.webp)
    background-repeat: no-repeat
    background-color: $black1
    .inner-wrapper
        width: 100%
        height: inherit
        display: flex
        flex-direction: column
        align-items: center
        position: relative
        justify-content: space-between
        overflow: hidden
        padding: 24px 12px 16px 12px
        +for-size(992)
            align-items: flex-start
            width: 992px
            padding: 114px 48px 134px 48px
        +for-size(1440)
            width: 1440px
    +for-size(992)
        background-size: cover
        background-position: center
        height: 544px
        background-image: url(../assets/img/main-bn.webp)
        padding: 0
    h1
        font-family: 'BebasNeue', Arial, sans-serif
        text-align: center
        font-size: 32px
        line-height: 32px
        letter-spacing: 0.025em
        font-weight: bold
        color: $honey
        +for-size(992)
            font-size: 72px
            line-height: 72px
            width: 525px
            text-align: left
        +for-size(1440)
            width: 525px
    .alexey
        color: $gray1
        font-size: 24px
        line-height: 24px
        font-family: 'BebasNeue', Arial, sans-serif
        text-align: center
        margin-top: 4px
        font-weight: bold
        +for-size(992)
            font-size: 32px
            line-height: 32px
            text-align: left
            margin-top: 8px
    .guarantee
        width: 100%
        display: flex
        align-items: center
        +for-size(992)
            width: 315px
            height: 64px
            display: flex
            align-items: center
            justify-content: center
            font-size: 16px
            transition: all .15s ease
            +background-gradient
        .icon
            width: 45px
            height: 46px
            position: relative
            display: flex
            align-items: center
            justify-content: center
            +background-gradient
            +for-size(992)
                width: 48px
                height: 48px
                &:after
                    content: none
                &:before
                    content: none
            .svg-icon
                z-index: 1
                color: $black2
            .icon-wrap
                content: ''
                width: 32px
                height: 32px
                border-radius: 32px
                background-color: $honey
                display: block
                position: relative
                z-index: 2
                display: flex
                align-items: center
                justify-content: center
                filter: drop-shadow(0px 0px 10px rgba(231, 206, 39, 0.5))
        .text
            font-size: 12px
            text-transform: uppercase
            color: $honey
            font-weight: bold
            padding: 16px 8px
            width: 243px
            height: 46px
            +background-gradient
            +for-size(992)
                width: 235px
                font-size: 14px
                line-height: 16px
                padding: 0
                height: auto
                &:after
                    content: none
                &:before
                    content: none
            span
                position: relative
                z-index: 2
                display: block
                width: 227px
.catalog-section
    padding: 28px 12px 0
    +for-size(992)
        padding-top: 48px
    &__top
        display: flex
        align-items: center
        justify-content: space-between
        margin-bottom: 24px
        +for-size(992)
            margin-bottom: 32px
        h2
            font-size: 18px
            font-weight: 700
            +for-size(992)
                font-size: 40px
                line-height: 48px
                margin-right: 24px
                font-weight: 600
.most-popular
    h2
        font-size: 18px
        font-weight: 700
        text-align: center
        margin-bottom: 24px
        margin-top: 48px
        +for-size(992)
            font-size: 40px
            line-height: 48px
            font-weight: 600
            text-align: left
            margin-top: 80px
            margin-bottom: 32px
.--scrolling-content
    display: block
    padding: 41px 12px 0
    h2
        letter-spacing: 0.025em
        font-size: 32px
        line-height: 32px
        color: $gray1
        font-weight: bold
        text-align: center
        font-family: 'BebasNeue', Arial, sans-serif
        margin-bottom: 24px
        +for-size(992)
            text-align: left
    .container-scroll
        display: none
    +for-size(992)
        display: flex
        justify-content: space-between
        min-height: 1000px
        .container-scroll
            display: block
</style>
