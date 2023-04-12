<template>
    <transition name="fade-viewer">
        <div class="fullscreen-viewer" v-if="show.value && files != []" ref="viewer"
             @keyup.space="slideNext" @keyup.esc="closeViewer" @keyup.right="slideNext" @keyup.left="slidePrev">
            <div class="fullscreen-viewer__slider" tabindex="0"
                ref="viewerHooper" id="fullscreen-viewer">
                <div class="swiper-wrapper">
                    <div :key="index"
                        class="fullscreen-viewer__slide swiper-slide"
                        v-for="(item,index) in files">
                        <div class="item">
                            <img :src="`${appPath}/${item.path}`" alt="">
                            <div class="inner-nav" v-if="files.length > 1">
                                <div class="prev" @click="slidePrev"></div>
                                <div class="next" @click="slideNext"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fullscreen-viewer__prev fullscreen-viewer__arrow" @click="slidePrev">
                <svg-icon :name="'chevron'" :width="48" :height="48"></svg-icon>
            </div>
            <div class="fullscreen-viewer__next fullscreen-viewer__arrow" @click="slideNext">
                <svg-icon :name="'chevron'" :width="48" :height="48"></svg-icon>
            </div>
            <div role="button" class="fullscreen-viewer__close" @click="closeViewer" tabindex="0">
                <svg-icon :name="'close'" :width="48" :height="48"></svg-icon>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapState } from 'vuex';
import Swiper from 'swiper';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'FullscreenViewer',
    components: {
        SvgIcon,
    },
    props: {
        files: {
            default() {
                return [];
            },
        },
        show: {
            default() {
                return {
                    value: false,
                    index: 0,
                };
            },
        },
    },
    created() {},
    mounted() {
        this.swiper = new Swiper('#fullscreen-viewer', {
            sliderPerView: 1,
            observer: true,
            observeParents: true,
            loop: true,
        });
        document.querySelector('.fullscreen-viewer__slider').focus();
        console.log();
        this.swiper.slideTo(+this.show.index, 0, false);
        this.currentSlide = this.swiper.realIndex + 1;
        this.swiper.on('slideChange', () => {
            this.currentSlide = this.swiper.realIndex + 1;
        });
    },
    data() {
        return {
            currentSlide: 1,
            currentSlidePrev: 1,
            hoveredPrev: false,
            hoveredNext: false,
            isShowedViewer: false,
            swiper: false,
            appPath: process.env.VUE_APP_PATH_BACK,
        };
    },
    computed: {
        ...mapState({
            popups: (state) => state.popups.items,
            switches: (state) => state.switches.items,
        }),
    },
    methods: {
        slide(payload) {
            this.currentSlide = +payload.currentSlide === -1 ? this.files.length : +payload.currentSlide + 1;
            if (this.files && +this.currentSlide > this.files.length) {
                this.currentSlide = 1;
            }
            this.currentSlidePrev = +payload.slideFrom;
        },
        open(href) {
            const link = document.createElement('a');
            link.setAttribute('href', href);
            link.setAttribute('target', '_blank');
            link.click();
        },
        closeViewer() {
            this.$emit('close');
        },
        slideNext() {
            this.swiper.slideNext();
            document.querySelector('.fullscreen-viewer__slider').focus();
        },
        slidePrev() {
            this.swiper.slidePrev();
            document.querySelector('.fullscreen-viewer__slider').focus();
        },
    },
    watch: {

    },
};
</script>

<style lang="sass">
.fade-viewer-enter-active, .fade-viewer-leave-active
    transition: opacity .15s
.fade-viewer-enter, .fade-viewer-leave-to
    opacity: 0
.fullscreen-viewer
    z-index: 10000
    position: fixed
    width: 100%
    height: 100vh
    top: 0
    left: 0
    background-color: rgba(#000, 0.9)
    &__arrow
        width: 48px
        height: 48px
        position: absolute
        top: 50%
        transform: translateY(-24px)
        display: flex
        align-items: center
        justify-content: center
        transition: all .15s ease
        z-index: 10
        cursor: pointer
        color: $gray-light2
        &:hover
            color: $honey
    &__prev
        left: 24px
        .svg-icon
            transform: rotate(180deg)
    &__next
        right: 24px
        &:after
            margin-right: -3px
            transform: rotate(180deg)
    &__close
        position: absolute
        top: 0px
        width: 80px
        height: 80px
        right: 0px
        z-index: 10
        cursor: pointer
        display: flex
        align-items: center
        justify-content: center
        svg
            transition: all .15s ease
            color: $gray-light2
        &:hover
            svg
                color: $honey
    .inner-nav
        position: absolute
        width: 100%
        height: 100%
        left: 0
        top: 0
    .prev
        position: absolute
        width: 50%
        height: 100vh
        left: -80px
        top: -40px
        cursor: pointer
    .next
        position: absolute
        width: 50%
        height: 100vh
        right: -80px
        top: -40px
        cursor: pointer
    & > img
        max-height: 100%
        display: inline-block
        vertical-align: top
    &__slider
        height: 100%
    &__slide
        width: 100%
        height: 100%
        padding: 86px 96px
        &.swiper-slide-active
            z-index: 5
        .item
            display: flex
            justify-content: center
            position: relative
            height: 100%
            align-items: center
            &:before
                content: ''
                background-image: url(../assets/img/preloader.svg)
                width: 30px
                height: 30px
                background-size: contain
                background-repeat: no-repeat
                position: absolute
                display: block
                top: calc(50% - 20px)
                left: calc(50% - 15px)
                z-index: 1
                animation: preloader-rotate 2s linear infinite
            img
                max-width: calc(100vw - 192px)
                max-height: calc(100vh - 174px)
                width: auto !important
                height: auto !important
                border: none !important
                position: relative
                background-color: transparent
                z-index: 10
</style>
