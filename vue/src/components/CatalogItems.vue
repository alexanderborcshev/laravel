<template>
    <div class="catalog">
        <!-- <router-link :to="'/catalog/'" class="catalog__item" v-for="i in 10" :key="i">
            <svg-icon :name="'window'" :width="isDesktop ? 32 : 25" :height="isDesktop ? 32 : 25" class="svg-icon"></svg-icon>
            <span class="name">Электрика и электромонтаж</span>
        </router-link> -->
        <template v-if="load">
            <div class="catalog__item --ghost" v-for="i in 16" :key="i">
                <div class="icon">
                    <span class="svg-icon"></span>
                </div>
                <div class="name-wrapper">
                    <span class="name"></span>
                    <span class="count"></span>
                </div>
            </div>
        </template>
        <template v-else>
            <div v-for="item in items" :key="item.icon">
                <router-link :to="'/catalog/'+item.code+'/'" class="catalog__item" :id="item.code" v-if="item.count">
                    <div class="icon">
                        <svg-icon :name="item.icon" :width="isDesktop ? 24 : 20" :height="isDesktop ? 24 : 20" class="svg-icon ico"></svg-icon>
                        <svg-icon :name="'arrow'" :width="24" :height="24" class="arrow"></svg-icon>
                    </div>
                    <div class="name-wrapper">
                        <span class="name">{{ item.name }}</span>
                        <span class="count">{{ item.count }}</span>
                    </div>
                </router-link>
                <offers-items v-if="$route.params?.code === item.code && !isDesktop"></offers-items>
            </div>
        </template>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import OffersItems from '@/components/OffersItems.vue';

export default {
    name: 'CatalogItems',
    components: {
        SvgIcon,
        OffersItems,
    },
    props: {
    },
    data() {
        return {};
    },
    mounted() {
        this.getItems();
    },
    computed: {
        ...mapState({
            isDesktop: (state) => state.isDesktop,
        }),
        ...mapState('category', {
            items: (state) => state.items,
            load: (state) => state.load,
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('category', [
            'getItems',
        ]),
    },
};
</script>

<style lang="sass">
.catalog
    width: 296px
    +for-size(992)
        width: 392px
    .catalog__item
        width: 100%
        height: 56px
        margin-bottom: 12px
        display: flex
        align-items: center
        cursor: pointer
        transition: all .15s ease
        +for-size(992)
            &:hover
                .icon
                    &:after
                        background-color: $black3
                .name-wrapper
                    &:after
                        background-color: $black3
        &.router-link-active
            .icon
                color: $black2
                .arrow
                    display: block
                    color: $black2
                .ico
                    display: none
                &:after
                    background-color: $honey
            .name-wrapper
                .name
                    color: $black2
                .count
                    color: rgba($black2, 0.5)
                &:after
                    background-color: $honey
        .icon
            width: 56px
            height: 56px
            display: flex
            align-items: center
            justify-content: center
            margin-right: 8px
            flex-shrink: 0
            +background-gradient
            .arrow
                display: none
            .svg-icon
                position: relative
                z-index: 2
                color: $honey
        .name-wrapper
            width: 100%
            height: 56px
            display: flex
            align-items: center
            padding: 0 8px
            +background-gradient
            +for-size(992)
                padding: 0 16px
            .count
                font-weight: 500
                color: rgba($honey, 0.5)
                position: relative
                z-index: 2
                font-size: 12px
                line-height: 16px
                letter-spacing: 0.025em
                width: 11px
                margin-left: 8px
            .name
                color: $black
                width: 100%
                white-space: nowrap
                text-overflow: ellipsis
                overflow: hidden
                font-size: 11px
                line-height: 16px
                font-weight: bold
                color: $honey
                position: relative
                letter-spacing: 0.025em
                z-index: 2
                text-transform: uppercase
                +for-size(992)
                    font-size: 14px
                    line-height: 16px
        &.--ghost
            span
                display: block
                background-color: #302F2E
                animation: 1.8s anim-ghost infinite
            .count
                width: 20px
                height: 20px
                border-radius: 2px
                +for-size(992)
                    width: 16px
                    height: 16px
                    border-radius: 4px
            .name
                width: 188px
                height: 20px
                border-radius: 2px
                +for-size(992)
                    width: 272px
                    height: 16px
                    border-radius: 4px
            .svg-icon
                width: 20px
                height: 20px
                border-radius: 2px
                +for-size(992)
                    width: 24px
                    height: 24px
                    border-radius: 4px
</style>
