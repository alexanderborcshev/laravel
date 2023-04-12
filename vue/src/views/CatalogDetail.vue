<template>
    <div class="wrapper">
        <section class="content">
            <div class="content__title">
                <svg-icon :name="currentCategory.code" :width="isDesktop ? 49 : 25" :height="isDesktop ? 49 : 25" class="svg-icon"></svg-icon>
                <h2 class="title">{{ currentCategory.name }}</h2>
            </div>
            <offers-items></offers-items>
        </section>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import OffersItems from '@/components/OffersItems.vue';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'MainHeader',
    components: {
        OffersItems,
        SvgIcon,
    },
    props: {
    },
    data() {
        return {
        };
    },
    mounted() {
        if (this.items.length === 0) {
            this.getItems();
        }
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
        ...mapActions('category', [
            'getItems',
        ]),
    },
};
</script>

<style lang="sass">
</style>
