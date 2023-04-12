<template>
    <transition name="fade-popup">
        <div class="popup-wrapper" v-if="show">
            <div class="overlay" @mousedown="close"></div>

            <div class="popup-scroll-block">
              <div class="popup"
                   ref="overlayPopup"
                   :class="[addClass]"
                   :style="{top: (top - 0) +'px', width: width+'px'}">
                  <div class="popup__wrap" v-clickoutside="close">
                      <div class="popup__close" @click="close" v-if="isBtnClose" :class="{'--fixed': isBtnCloseFixed}">
                      </div>

                      <slot></slot>

                      <footer-block v-if="showFooter"></footer-block>
                  </div>
              </div>
            </div>
        </div>
    </transition>
</template>

<script>
import FooterBlock from '@/components/FooterBlock.vue';

export default {
    name: 'PopupWindow',
    props: {
        width: {
            default() {
                return 720;
            },
        },
        addClass: { default: '' },
        show: {
            default() {
                return false;
            },
        },
        isSetTop: {
            default() {
                return true;
            },
        },
        isBtnClose: {
            default() {
                return true;
            },
        },
        isBtnCloseFixed: {
            default() {
                return true;
            },
        },
        isSetBlank: {
            default() {
                return false;
            },
        },
        isResize: {
            default() {
                return false;
            },
        },
        isCloseOutSize: {
            default() {
                return true;
            },
        },
        showFooter: {
            default() {
                return true;
            },
        },
        name: {
            default() {
                return '';
            },
        },
    },
    components: {
        FooterBlock,
    },
    watch: {
        show() {
            if (this.show) {
                if (this.isSetTop) {
                    this.updateViewportSize();
                }
            }
        },
        isResize(newV, oldQV) {
            if (this.isSetTop && (newV !== oldQV)) {
                this.updateViewportSize();
            }
        },
        top(newV) {
            if (newV < 1) {
                this.$refs.overlayPopup.style.marginTop = '32px';
            } else {
                this.$refs.overlayPopup.style.marginTop = '0px';
            }
        },
    },
    data() {
        return {
            top: 24,
        };
    },
    mounted() {
        if (this.isSetTop) {
            this.topListener();
        }
    },
    methods: {
        updateViewportSize() {
            this.$nextTick(() => {
                if (typeof (this.$refs.overlayPopup) !== 'undefined' && this.$refs.overlayPopup !== null) {
                    let top = this.getViewportSize().h - this.$refs.overlayPopup.clientHeight;
                    if (top < 1) {
                        top = 1;
                    }
                    if ((top / 2) < 33) {
                        this.top = 0;
                    } else {
                        this.top = (top / 2);
                    }
                }
            });
        },
        topListener() {
            const self = this;
            this.$nextTick(() => {
                self.updateViewportSize();
                window.addEventListener('resize', self.updateViewportSize);
            });
        },

        getViewportSize() {
            const d = window.document.querySelector('html');
            return { w: d.clientWidth, h: d.clientHeight };
        },
        closeOutSize() {
            if (this.isCloseOutSize) {
                this.close();
            }
        },
        close() {
            this.$nextTick(() => {
                if (this.show && this.name) {
                    this.$store.commit('popups/close', { name: this.name });
                    this.$emit('close');
                    document.getElementsByTagName('body')[0].classList.remove('noscroll');
                } else {
                    this.$emit('close');
                    document.getElementsByTagName('body')[0].classList.remove('noscroll');
                }
            });
        },
    },
    emits: ['close'],
    directives: {
        clickoutside: {
            mounted(el, binding) {
                const bubble = binding.modifiers.bubble;
                const handler = (e) => {
                    if (bubble
                        || ((!el.contains(e.target) && el !== e.target)
                        && (!e.target.classList.contains('click-outside-tooltip')))
                    ) {
                        binding.value(e);
                    }
                };
                /* eslint no-underscore-dangle: 0 */
                el.__vueClickOutside__ = handler;
                document.addEventListener('mousedown', handler);
            },

            unmounted(el) {
                document.removeEventListener('mousedown', el.__vueClickOutside__);
                el.__vueClickOutside__ = null;
            },
        },
    },
};
</script>

<style lang="sass">
.fade-popup-enter-active, .fade-popup-leave-active
    transition: opacity .15s
.fade-popup-enter, .fade-popup-leave-to
    opacity: 0
.popup-wrapper
    position: fixed
    bottom: 0
    right: 0
    top: 0
    left: 0
    z-index: 8010
    display: block
    width: auto
    height: auto

    .noscroll &
        overflow-y: scroll

.popup
    width: 100vw
    box-shadow: 0 10px 25px rgba(0,0,0,0.5)
    height: auto
    margin: 0 auto
    margin-bottom: 32px
    margin-top: 32px
    background: transparent
    color: $black
    position: relative
    text-shadow: none
    border-radius: 0
    +for-size(992)
        overflow: hidden
        border-radius: 12px
    &__footer
        display: flex
        justify-content: flex-end
        align-items: center
        height: 32px
        width: 100%
        position: absolute
        bottom: 16px
        right: 0
        padding: 0 16px
    &__close
        position: absolute
        top: 8px
        right: 8px
        cursor: pointer
        transition: $transition
        z-index: 1
        background-color: $white
        border-radius: 32px
        color: $gray50
        width: 32px
        height: 32px
        display: flex
        align-items: center
        justify-content: center
        &.--fixed
            position: fixed
        & + *
            margin-top: 0 !important
        &:after
            content: ''
            width: 24px
            height: 24px
            background-image: url(../assets/img/for-sprite/close.svg)
            background-size: contain
            display: block
            background-repeat: no-repeat
        +for-size(992)
            position: absolute
            top: 16px
            right: 16px
            width: 40px
            height: 40px
            transition: all .15s ease
            &:after
                width: 32px
                height: 32px
            &:hover
                background-color: #E4E4E4 !important
    &__content
        display: flex
        flex-direction: column
        align-items: center
    &__wrap
        position: relative
        padding: 0
        .footer
            margin-top: 0
            .bottom
                display: none
            +for-size(992)
                height: 248px
                padding-top: 80px
    &__text
        padding: 24px 12px 120px
        background-color: #fff
        +for-size(992)
            padding: 32px 64px 120px
        b
            font-weight: bold
        .contact
            margin-top: 0
            &__item
                display: flex
                align-items: center
                margin-bottom: 24px
                +for-size(992)
                    margin-bottom: 40px
                .svg-icon
                    margin-right: 8px
                    color: rgba($gray1, 0.5)
                    +for-size(992)
                        margin-right: 12px
                &:last-child
                    margin-bottom: 0
            &__info
                .ttl
                    color: $black
                    font-weight: 500
                    font-size: 16px
                    line-height: 24px
                    margin-bottom: 4px
                    display: block
                    +for-size(992)
                        font-size: 20px
                        line-height: 24px
                        margin-bottom: 4px
                .desc
                    color: rgba($gray1, 0.5)
                    font-size: 12px
                    line-height: 16px
                    white-space: nowrap
        .offer-detail__elem
            padding: 0
            .how-to-order
                padding: 0 12px
                margin-top: 30px
                +for-size(992)
                    padding: 0 48px
                    margin-top: 64px
                li
                    display: flex
                    align-items: center
                    font-size: 14px
                    line-height: 16px
                    letter-spacing: 0.025em
                    +for-size(992)
                        font-size: 20px
                        line-height: 24px
                    & + li
                        margin-top: 24px
                        +for-size(992)
                             margin-top: 24px
                    .svg-icon
                        margin-right: 16px
                        color: $honey
                    span
                        flex: 1
            h2
                margin-bottom: 16px
                font-size: 18px
                line-height: 24px
                font-weight: bold
                +for-size(992)
                    text-align: center
                    font-size: 24px
                    line-height: 32px
                    margin-bottom: 24px
        h2
            font-weight: bold
            font-size: 32px
            line-height: 32px
            margin: 0 0 12px
            font-family: 'BebasNeue', sans-serif
            +for-size(992)
                font-size: 48px
                line-height: 56px
                margin: 0 0 32px
        p
            font-size: 16px
            line-height: 18px
            color: $gray1
            +for-size(992)
                font-size: 20px
                line-height: 24px
            & + p
                margin-top: 56px
                +for-size(992)
                    margin-top: 72px
        .offer-detail__presents
            padding: 0
            margin-top: 24px
            +for-size(992)
                margin-top: 40px
                margin-bottom: 40px
            li
                color: $red
                .svg-icon
                    color: $red
        .btn
            width: 100%
            height: 48px
            border-radius: 4px
            &.go-main
                margin-top: 32px
                +for-size(992)
                    width: 296px
                    margin: 0 auto
                    display: flex
                    margin-top: 40px
            +for-size(992)
                display: inline-flex
                height: 56px
                width: 328px
                font-size: 16px
                line-height: 24px
                border-radius: 8px
    &__header
        height: 183px
        width: 100%
        background-size: cover
        background-repeat: no-repeat
        display: flex
        flex-direction: column
        justify-content: center
        align-items: center
        +for-size(992)
            height: 402px
            width: calc(100% + 1px)
        h2
            font-size: 32px
            line-height: 32px
            font-weight: 700
            color: #fff
            letter-spacing: 0.025em
            font-family: 'BebasNeue', sans-serif
            +for-size(992)
                font-size: 40px
                line-height: 40px
        &.--privacy
            background-image: url(../assets/img/policy.webp)
        &.--how-works
            background-image: url(../assets/img/howItWorksModal-mobile.webp)
            +for-size(992)
                background-image: url(../assets/img/howItWorksModal.webp)
        &.--contract-offer
            background-image: url(../assets/img/contractOffer-mobile.webp)
            +for-size(992)
                background-image: url(../assets/img/contractOffer.webp)
        &.--contact
            background-image: url(../assets/img/contact.jpg)
            +for-size(992)
                background-image: url(../assets/img/contact.jpg)
        &.--success
            text-align: center
            height: 160px
            background-color: $black1
            +for-size(992)
                height: 200px
            h2
                font-size: 32px
                letter-spacing: 0.025em
                line-height: 32px
                font-family: 'BebasNeue', sans-serif
                color: $honey
                +for-size(992)
                    font-size: 40px
                    line-height: 40px
            & + .popup__text
                background-color: $black1
                padding: 0
                padding-bottom: 80px
                .btn
                    width: 296px
                    margin: 0 auto
                    margin-top: 48px
                    height: 48px
                    font-size: 14px
                    line-height: 16px
                    +for-size(992)
                        margin-top: 64px
                        height: 52px
                        font-size: 16px
                        line-height: 19px
                        width: 247px
                .image
                    width: 100%
                    height: 183px
                    background-size: 322px
                    background-image: url(../assets/img/success-mobile.webp)
                    +for-size(992)
                        width: 100%
                        height: 402px
                        background-size: 708px
                        margin-left: 0
                        background-image: url(../assets/img/success.webp)
        &.--contractor-modal
            height: auto
            padding: 40px 0
            background: $black1
            +for-size(992)
                padding: 72px 0
            h2
                color: $honey
            .svg-icon
                margin-bottom: 24px
                color: $honey
        &.--attention-modal
            padding: 40px 0
            height: auto
            background-color: $red
            color: $white
            .svg-icon
                margin-bottom: 24px
                color: $white
            +for-size(992)
                padding: 72px 0
    .popup-info
        text-align: center
        .info-text
            font-size: 14px
            line-height: 17px
    .mobile-device &
        width: 320px !important
        margin: 0 !important
        margin-bottom: 0 !important
.noscroll:not(.scroll-mac-os) #app
    padding-right: 16px
.popup-scroll-block
    width: 100%
    position: absolute
    left: 0
    height: auto !important
    z-index: 1
.overlay
    position: fixed
    top: 0
    right: 0
    bottom: 0
    left: 0
    background: rgba(0,0,0,0.93)
</style>
