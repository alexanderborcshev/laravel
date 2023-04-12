<template>
    <main-header v-if="!isOfferDetailPage"></main-header>
    <router-view/>

    <footer-block></footer-block>
    <popup-component
        :show="popups.contractOfferModal.show" :name="popups.contractOfferModal.name" :width="704">
        <contract-offer-modal></contract-offer-modal>
    </popup-component>
    <popup-component
        :show="popups.privacyPolicy.show" :name="popups.privacyPolicy.name" :width="704">
        <privacy-policy></privacy-policy>
    </popup-component>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import MainHeader from '@/components/MainHeader.vue';
import FooterBlock from '@/components/FooterBlock.vue';
import PopupComponent from '@/components/PopupComponent.vue';
import ContractOfferModal from './components/modals/ContractOfferModal.vue';
import PrivacyPolicy from './components/modals/PrivacyPolicy.vue';

export default {
    name: 'App',
    components: {
        MainHeader,
        FooterBlock,
        PopupComponent,
        ContractOfferModal,
        PrivacyPolicy,
    },
    props: {
    },
    data() {
        return {
            viewport: false,
        };
    },
    mounted() {
        this.getCsrf();
        this.viewport = document.querySelector('meta[name=viewport]');
        this.checkWindowSize(); // Проверка размера окна
        this.isMacOs(); // Проверка на мак ос
    },
    computed: {
        ...mapState({
            popups: (state) => state.popups.items,
            isDesktop: (state) => state.isDesktop,
        }),
        isOfferDetailPage() {
            return this.$route.name === 'offer-detail';
        },
    },
    watch: {

    },
    methods: {
        ...mapActions(['setIsDesktop']),
        ...mapActions('category', ['getCsrf']),
        setDesktopViewport() {
            document.querySelector('body').classList.remove('mobile-device');
            document.querySelector('body').classList.add('desktop-device');
            this.viewport.setAttribute('content', 'width=device-width, initial-scale=1');
            this.setIsDesktop(true);
        },
        setMobileViewport() {
            document.querySelector('body').classList.remove('desktop-device');
            document.querySelector('body').classList.add('mobile-device');
            this.viewport.setAttribute('content', 'width=320');
            this.setIsDesktop(false);
        },
        checkWindowSize() {
            if (window.screen.width > 991) {
                this.setDesktopViewport();
            }
            window.addEventListener('resize', () => {
                if (window.screen.width > 991) {
                    this.setDesktopViewport();
                } else {
                    this.setMobileViewport();
                }
            });
        },
        isMacOs() {
            const scrollWidth = window.innerWidth - document.documentElement.clientWidth;
            if (+scrollWidth === 0) {
                document.getElementsByTagName('body')[0].classList.add('scroll-mac-os');
            }
        },
    },
};
</script>

<style lang="sass">
@import "~@/assets/sass/style.sass"
#app
  font-family: $default-font
</style>
