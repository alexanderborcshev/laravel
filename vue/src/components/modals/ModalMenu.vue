<template>
    <div class="popup__text">
        <div class="inner">
            <div class="logo">
                <img src="@/assets/img/logo.svg" alt="logo">
            </div>
            <div class="links">
                <a href="javascript:void(0);" @click="openModal(this.popups.howWorksModal)">о проекте</a>
                <a href="javascript:void(0);" @click="openModal(this.popups.contactModal)">контакты</a>
            </div>
        </div>
    </div>
    <div class="plug"></div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
// import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'ModalMenu',
    components: {
        // SvgIcon,
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
            popups: (state) => state.popups.items,
        }),
    },
    watch: {

    },
    methods: {
        ...mapActions({
            open: 'popups/open',
            close: 'popups/close',
        }),
        openModal(modal) {
            this.open(modal);
        },
    },
};
</script>

<style lang="sass">
.popup.modal-menu
    top: 0 !important
    .links
        width: 100%
        height: 194px
        display: flex
        flex-direction: column
        justify-content: space-between
        position: relative
        margin-top: 32px
        a
            height: 100%
            display: flex
            font-weight: bold
            font-size: 14px
            line-height: 16px
            letter-spacing: 0.025em
            align-items: center
            justify-content: center
            color: $gray3
            text-transform: uppercase
        &:after
            content: ''
            display: block
            width: 296px
            height: 2px
            border-radius: 2px
            background-color: $honey
            position: absolute
            top: 96px
            left: 12px
            box-shadow: 0px 0px 31px #FFC700
    .popup__close
        height: 64px
        top: 0
        width: 48px
        right: 0
        background-color: transparent
        position: absolute
        &:after
            background-image: url('../../assets/img/close.svg')
    .plug
        width: 100%
        height: 100%
        background-color: $black3
        margin-top: -1px
        position: relative
        z-index: 2
        flex: 1
    .popup__wrap
        min-height: 100vh
        display: flex
        flex-direction: column
        justify-content: space-between
        background-color: $black3
    .popup__text
        padding: 0
        .inner
            height: 385px
            padding: 24px 0 120px
            background-size: cover
            background-repeat: no-repeat
            background-image: url('../../assets/img/mobileMenuBg.svg')
        .logo
            width: 100%
            display: flex
            justify-content: center
    .footer
        background-color: $black3
</style>
