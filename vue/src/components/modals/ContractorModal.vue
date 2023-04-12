<template>
    <div class="popup__header --contractor-modal">
        <svg-icon :name="category.icon" :width="48" :height="48" class="svg-icon"></svg-icon>
        <h2>{{ item.name }}</h2>
    </div>
    <div class="popup__text">
        <p>
            <span v-html="item.description"></span><br><br>
            {{ item.legal_entity }}<br><br>
            ИНН  {{ item.inn }}<br><br>
            ОГРН {{ item.ogrn }}<br><br>
            Сайт: <a href="javascript:void(0);" @click="openAttentionModal()">{{ item.site }}</a>
        </p>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'ContractorModal',
    components: {
        SvgIcon,
    },
    props: {
        item: {
            default: {},
        },
        category: {
            default: {},
        },
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
        openAttentionModal() {
            this.close(this.popups.contractorModal);
            setTimeout(() => {
                this.open(this.popups.attentionModal);
            }, 50);
        },
    },
};
</script>

<style lang="sass">
</style>
