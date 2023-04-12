<template>
    <header class="header">
        <div class="l">
            <a href="/" class="logo"><img src="@/assets/img/logo.svg" alt="logo"></a>
            <city-changer></city-changer>
            <svg-icon :name="'humb'" :width="24" :height="24" class="humb" @click="open(this.popups.modalMenu)"></svg-icon>
        </div>
        <div class="center">
            <img src="@/assets/img/logo-mini.svg" alt="logo">
        </div>
        <div class="r">
            <div class="links">
                <a href="javascript:void(0);" @click="open(this.popups.howWorksModal)">о проекте</a>
                <a href="javascript:void(0);" @click="open(this.popups.contactModal)">контакты</a>
            </div>
        </div>
    </header>
    <popup-component
        :show="popups.modalMenu.show" :name="popups.modalMenu.name" :width="704" :add-class="'modal-menu'">
        <modal-menu></modal-menu>
    </popup-component>
    <popup-component
        :show="popups.contactModal.show" :name="popups.contactModal.name" :width="704">
        <contact-modal></contact-modal>
    </popup-component>
    <popup-component
        :show="popups.howWorksModal.show" :name="popups.howWorksModal.name" :width="704">
        <how-works-modal></how-works-modal>
    </popup-component>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import PopupComponent from '@/components/PopupComponent.vue';
import ContactModal from '@/components/modals/ContactModal.vue';
import CityChanger from '@/components/CityChanger.vue';
import SvgIcon from '@/components/SvgIcon.vue';
import HowWorksModal from '@/components/modals/HowWorksModal.vue';
import ModalMenu from '@/components/modals/ModalMenu.vue';

export default {
    name: 'MainHeader',
    components: {
        PopupComponent,
        CityChanger,
        SvgIcon,
        // MODALS
        ContactModal,
        HowWorksModal,
        ModalMenu,
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
    },
    watch: {
    },
    methods: {
        ...mapActions('popups', [
            'open', 'close',
        ]),
    },
};
</script>

<style lang="sass">
.fade-catalog-enter-active, .fade-catalog-leave-active
    transition: opacity .15s
.fade-catalog-enter, .fade-catalog-leave-to
    opacity: 0
.header
    height: 64px
    width: 100%
    position: relative
    top: 0
    left: 0
    right: 0
    background-color: $black1
    display: flex
    align-items: center
    justify-content: space-between
    padding: 0 12px
    color: #fff
    z-index: 10
    +for-size(992)
        height: 80px
    &:after
        content: ''
        width: 0
        height: 0
        right: calc(50% - 11px)
        position: absolute
        border-style: solid
        z-index: -1
        border-width: 64px 23px 0 0
        border-color: $black1 transparent transparent transparent
        +for-size(992)
            right: calc(50% - 16px)
            border-width: 80px 28px 0 0
    &:before
        content: ''
        width: calc(50% + 12px)
        right: 0
        z-index: -1
        position: absolute
        height: 64px
        background-color: $black3
        +for-size(992)
            height: 80px
    .humb
        display: block
        color: $gray1
        +for-size(992)
            display: none
    .links
        display: none
        +for-size(992)
            display: flex
            align-items: center
            a
                font-size: 14px
                line-height: 16px
                color: $gray3
                margin-right: 48px
                font-weight: bold
                text-transform: uppercase
                transition: all .15s ease
                &:last-child
                    margin-right: 0
                &:hover
                    color: $honey
    svg
        cursor: pointer
    &--plug
        position: static
    .center
        padding-top: 5px
        height: 32px
        display: none
        +for-size(992)
            display: block
    .l,.r
        display: flex
        align-items: center
        +for-size(992)
            width: 230px
    .l
        justify-content: space-between
        width: 100%
        .city-changer
            order: 0
        .logo
            order: 1
            margin-
        .humb
            order: 2
        +for-size(992)
            justify-content: flex-start
            width: 230px
            .city-changer
                order: 1
            .logo
                order: 0
                margin-right: 24px
    .r
        justify-content: flex-end
        display: none
        +for-size(992)
            display: flex
    .logo
        height: 16px
        img
            width: 128px
    .mobile-device &
        width: 320px
    .desktop-device &
        padding: 0 48px
</style>
