<template>
    <transition name="fade-catalog">
        <div class="header__catalog" v-if="show" v-clickoutside="closeCatalogNav">
            <div class="header__catalog-head">
                <div class="header__catalog-close"
                    @click="close(this.popups.catalogNav)">
                    <svg-icon :name="'close'" :width="24" :height="24"></svg-icon>
                    <span class="" v-if="isDesktop">
                        Каталог<br>подрядчиков
                    </span>
                </div>
                <city-changer></city-changer>
            </div>
            <catalog-items :class="'--header-catalog'"></catalog-items>
            <footer-block v-if="!isDesktop"></footer-block>
            <div class="links">
                <a href="javascript:void(0);" @click="open(this.popups.contactModal)">Контактная информация</a>
                <a href="javascript:void(0);" @click="open(this.popups.contractOfferModal)">Договор оферты</a>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import CatalogItems from '@/components/CatalogItems.vue';
import FooterBlock from '@/components/FooterBlock.vue';
import CityChanger from '@/components/CityChanger.vue';

export default {
    name: 'HeaderCatalog',
    components: {
        SvgIcon,
        CatalogItems,
        FooterBlock,
        CityChanger,
    },
    props: {
        show: {
            default() {
                return false;
            },
        },
    },
    data() {
        return {};
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
        closeCatalogNav() {
            this.$nextTick(() => {
                if (this.show) {
                    this.close(this.popups.catalogNav);
                }
            });
        },
    },
    directives: {
        clickoutside: {
            mounted(el, binding) {
                const bubble = binding.modifiers.bubble;
                const handler = (e) => {
                    if (bubble || ((!el.contains(e.target) && el !== e.target))) {
                        binding.value(e);
                    }
                };
                /* eslint no-underscore-dangle: 0 */
                el.__vueClickOutside__ = handler;
                document.addEventListener('click', handler);
            },

            unmounted(el) {
                document.removeEventListener('click', el.__vueClickOutside__);
                el.__vueClickOutside__ = null;
            },
        },
    },
};
</script>

<style lang="sass">

</style>
