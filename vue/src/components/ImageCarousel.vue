<template>
    <div class="thumbnails" v-if="isDesktop">
        <div class="thumb" v-for="(image, index) in images.slice(0, 4)" :key="index" @click="showImage(index)">
            <div class="image" :style="{'background-image': `url(${appPath}/${image.path})`}"></div>
            <div class="thumb__overlay" v-if="index == 3 && images.length > 4">Ещё {{ images.length - 4 }} фото</div>
        </div>
    </div>
    <carousel :items-to-show="1" :wrap-around="true" v-else>
        <slide v-for="(image, index) in images" :key="index">
            <div class="image" :style="{'background-image': `url(${appPath}/${image.path})`}"></div>
        </slide>

        <template #addons>
            <pagination />
        </template>
    </carousel>

    <fullscreen-viewer :files="images" :show="showViewer" v-if="showViewer.value && isDesktop" @close="closeViewer"></fullscreen-viewer>
</template>

<script>
import { mapState } from 'vuex';
import 'vue3-carousel/dist/carousel.css';
import {
    Carousel, Slide, Pagination,
} from 'vue3-carousel';
import FullscreenViewer from '@/components/FullscreenViewer.vue';
// import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'ImageCarousel',
    components: {
        // SvgIcon,
        Carousel,
        Slide,
        Pagination,
        FullscreenViewer,
    },
    props: {
        images: { default: [] },
    },
    data() {
        return {
            appPath: process.env.VUE_APP_PATH_BACK,
            showViewer: {
                value: false,
                index: 0,
            },
        };
    },
    mounted() {
        this.initSliderStyles();
    },
    computed: {
        ...mapState({
            isDesktop: (state) => state.isDesktop,
        }),
    },
    watch: {

    },
    methods: {
        initSliderStyles() {
            const link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/swiper@8.3.1/swiper-bundle.min.css';
            document.head.appendChild(link);
        },
        closeViewer() {
            document.getElementsByTagName('body')[0].classList.remove('noscroll');
            this.showViewer = { value: false, index: 0 };
        },
        showImage(i) {
            document.getElementsByTagName('body')[0].classList.add('noscroll');
            if (i === 3 && this.images.length > 4) {
                this.showViewer = { value: true, index: i + 1 };
            } else {
                this.showViewer = { value: true, index: i };
            }
        },
    },
};
</script>

<style lang="sass">
.thumbnails
    display: flex
    flex-wrap: wrap
    width: 100%
    gap: 32px 24px
    .thumb
        width: 432px
        position: relative
        height: 243px
        cursor: pointer
        .image
            width: 100%
            height: 100%
            background-size: cover
            background-position: center
            border-radius: 8px
        &__overlay
            width: 100%
            height: 100%
            background-color: rgba(#0F0F0F, 0.8)
            border-radius: 8px
            display: flex
            align-items: center
            justify-content: center
            color: #FFFFFF
            font-size: 20px
            line-height: 24px
            position: absolute
            top: 0
            left: 0
            z-index: 1
            transition: all .15s ease
            border: 1px solid transparent
        &:hover
            .thumb__overlay
                background-color: rgba(#0F0F0F, 0.9)
                border-color: $gray-light2
.carousel
    &__track
        list-style: none !important
        padding-left: 0
    &__slide
        .image
            width: 320px
            height: 230px
            overflow: hidden
            display: flex
            align-items: center
            justify-content: center
            background-size: cover
            background-position: center
            +for-size(992)
                width: 896px
                height: 690px
            +for-size(992)
                width: 1152px
                height: 886px
            img
                width: auto
                height: 100%
    &__viewport
        +for-size(992)
            border-radius: 8px
    .carousel__prev, .carousel__next
        width: 80px
        height: 80px
        border-radius: 80px
        background-color: $gray-light
        transition: all .15s ease
        margin: 0
        svg
            display: none
        &:after
            width: 48px
            height: 48px
            content: ''
            background-image: url(../assets/img/for-sprite/chevron.svg)
        &:hover
            background-color: #E8E8ED
    &__prev
        left: -40px
        +for-size(992)
            left: -112px
        &:after
            transform: rotate(180deg)
    &__next
        right: -40px
        +for-size(992)
            right: -112px
    &__pagination
        position: absolute
        width: 100%
        bottom: 12px
        margin: 0
        gap: 4px
        +for-size(992)
            gap: 8px
            bottom: 24px
        li
            button
                padding: 0
                width: 6px
                height: 6px
                border-radius: 6px
                background-color: #DDDDDD
                +for-size(992)
                    width: 8px
                    height: 8px
                    border-radius: 8px
                &.carousel__pagination-button--active
                    background-color: $yellow
                &:after
                    content: none
</style>
