<template>
    <div class="offers" v-masonry transition-duration="0.3s" gutter="24"  item-selector=".offers__item" id="offers">
        <template v-if="load">
            <div class="offers__item --ghost" v-for="i in 10" :key="i">
                <div class="stat"></div>
                <div class="image-wrapper"></div>
                <div class="title"></div>
                <div class="price"></div>
            </div>
        </template>
        <template v-else>
            <article v-masonry-tile class="offers__item" v-for="item in items" :key="item.id">
                <router-link :to="'/catalog/'+item.category.code + '/' + item.id">
                    <div class="stat">
                        <svg-icon :name="'cart'" :width="16" :height="16" class="svg-icon mr4"></svg-icon>
                        <span class="value">{{ numberFormat(item.orders ) }}</span>
                    </div>
                    <div class="image-wrapper">
                        <img v-if="item.preview" :src="appPath + '/' +item.preview.path" :alt="item.name">
                    </div>
                    <h3 class="title">{{ item.name }}</h3>
                    <div class="price">
                        От <span class="text-semibold">{{ numberFormat(item.price_min) }} ₽</span>
                        до <span class="text-semibold">{{ numberFormat(item.price_max) }} ₽</span>
                    </div>
                </router-link>
            </article>
        </template>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import { numberFormat } from '@/helpers/formatted';
import { scrollTo } from '@/helpers/animate';

export default {
    name: 'OffersItems',
    components: {
        SvgIcon,
    },
    props: {
        popular: {
            default: false,
        },
    },
    data() {
        return {
            appPath: process.env.VUE_APP_PATH_BACK,
        };
    },
    mounted() {
        this.getItems({ code: this.$route.params.code, popular: false });
    },
    computed: {
        ...mapState({
            isDesktop: (state) => state.isDesktop,
        }),
        ...mapState('offer', {
            items: (state) => state.items,
            load: (state) => state.load,
        }),
    },
    watch: {
        $route() {
            this.getItems({ code: this.$route.params.code, popular: false }).then(() => {
                if (!this.isDesktop && this.$route.params?.code) {
                    scrollTo(`#${this.$route.params.code}`);
                }
            });
        },
    },
    methods: {
        ...mapActions('offer', [
            'getItems',
        ]),
        numberFormat(v) {
            return numberFormat(v, 0, '', ' ');
        },
    },
};
</script>

<style lang="sass">
.offers
    margin-left: -12px
    width: 320px
    display: flex
    flex-direction: column
    padding-top: 4px
    padding-bottom: 64px
    gap: 0 24px
    +for-size(992)
        display: flex
        flex-wrap: wrap
        margin: 0
        width: 448px
        padding-top: 4px
        padding-bottom: 0
        align-items: flex-start
        flex-direction: row
    +for-size(1440)
        width: 920px
    &__item
        display: block
        background-color: $black2
        text-align: center
        position: relative
        padding-bottom: 20px
        margin-bottom: 24px
        border-radius: 8px
        +for-size(992)
            width: 448px
            padding-bottom: 24px
            margin-bottom: 0
            border-radius: 12px
            margin-bottom: 40px
        &:last-child
            margin-bottom: 0
        .stat
            position: absolute
            width: auto
            height: auto
            display: flex
            align-items: center
            padding: 4px
            border-radius: 4px
            color: $gray-light
            background-color: rgba(#6F6F6F,0.75)
            top: 12px
            left: 12px
            font-size: 12px
            line-height: 16px
            backdrop-filter: blur(4px)
            +for-size(992)
                padding: 4px 8px
                font-size: 16px
                line-height: 24px
        .image-wrapper
            width: 320px
            height: 182px
            display: flex
            align-items: center
            justify-content: center
            overflow: hidden
            border-radius: 8px 8px 0 0
            +for-size(992)
                width: 448px
                height: 256px
                border-radius: 12px 12px 0 0
            img
                width: 100%
        .title
            margin: 20px 0 12px
            font-size: 16px
            line-height: 19px
            font-weight: bold
            letter-spacing: 0.025em
            color: $gray3
            +for-size(992)
                margin: 24px 0 16px
                font-size: 20px
                line-height: 24px
        .price
            font-size: 14px
            color: rgba($gray3, 0.5)
            line-height: 16px
            letter-spacing: 0.025em
            +for-size(992)
                font-size: 16px
                line-height: 19px
        &.--ghost
            div
                animation: 1.8s anim-ghost infinite
            .stat
                width: 64px !important
                height: 40px !important
                top: 12px
                left: 12px
                border-radius: 4px
                background-color: #302F2E
                +for-size(992)
                    width: 64px
                    height: 32px
            .image-wrapper
                background-color: transparent
            .title
                width: calc(100% - 32px)
                height: 24px
                border-radius: 4px
                width: 100%
                background-color: #302F2E
                +for-size(992)
                    width: calc(100% - 32px)
                    height: 30px
                    margin: 24px auto
                    margin-bottom: 16px
            .price
                width: calc(100% - 200px)
                height: 19px
                background-color: #302F2E
                border-radius: 4px
                margin: 0 auto
</style>
