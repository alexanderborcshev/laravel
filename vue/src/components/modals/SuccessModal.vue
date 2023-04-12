<template>
    <div class="popup__header --success">
        <h2>Заявка успешно отправлена</h2>
    </div>
    <div class="popup__text">
        <div class="image"></div>
        <div class="offer-detail__elem">
            <ul class="how-to-order">
                <li>
                    <svg-icon :name="'phone'" :width="32" :height="32" class="svg-icon"></svg-icon>
                    <span>Мы с вами свяжемся, проконсультируем и поможем оформить заказ.</span>
                </li>
                <li>
                    <svg-icon :name="'clock'" :width="32" :height="32" class="svg-icon"></svg-icon>
                    <span>Мы работаем {{ item.work_time }}</span>
                </li>
                <li>
                    <svg-icon :name="'heart'" :width="32" :height="32" class="svg-icon"></svg-icon>
                    <span v-if="item.provider">С уважением, {{ item.provider.name }}</span>
                </li>
            </ul>
        </div>
        <router-link @click="close(popups.successModal)" :to="'/'" class="btn go-main">ПЕРЕЙТИ НА ГЛАВНУЮ</router-link>
    </div>
</template>

<script>
import SvgIcon from '@/components/SvgIcon.vue';
import { mapActions, mapState } from 'vuex';

export default {
    name: 'SuccessModal',
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
            popups: (state) => state.popups.items,
            isDesktop: (state) => state.isDesktop,
        }),
    },
    watch: {

    },
    methods: {
        ...mapActions('popups', [
            'close',
        ]),
    },
};
</script>

<style lang="sass">
</style>
