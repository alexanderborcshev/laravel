<template>
    <div class="popup__header --attention-modal">
        <svg-icon :name="'info2'" :width="48" :height="48" class="svg-icon"></svg-icon>
        <h2>Внимание!</h2>
    </div>
    <div class="popup__text">
        <p>
            Мы не несем ответственность за подрядчика,
            если вы обращаетесь к нему напрямую, минуя сайт ZEMSBAZA.RU.
            Кроме этого, при обращении напрямую, вы не получите следующие подарки:
        </p>
        <div class="attention__presents">
            <ul>
                <li v-for="(gift, i) in item.gifts" :key="i">
                    <svg-icon :name="'gift'" :width="isDesktop ? 42 : 21" :height="isDesktop ? 32 : 16" class="svg-icon"></svg-icon>
                    <span>{{ gift }}</span>
                </li>
            </ul>
        </div>
        <a v-if="item.provider" :href="'https://'+item.provider.site" target="_blank" class="btn btn--red">Перейти на сайт подрядчика</a>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'AttentionModal',
    components: {
        SvgIcon,
    },
    props: {
        item: {
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
            isDesktop: (state) => state.isDesktop,
        }),
    },
    watch: {

    },
    methods: {
    },
};
</script>

<style lang="sass">
.attention__presents
    margin-top: 40px
    margin-bottom: 48px
    +for-size(992)
        margin-bottom: 56px
    ul
        li
            color: $red
            display: flex
            align-items: center
            font-size: 16px
            line-height: 18px
            +for-size(992)
                font-size: 20px
                line-height: 24px
            & + li
                margin-top: 24px
            .svg-icon
                margin-right: 8px
                +for-size(992)
                    margin-right: 12px
</style>
