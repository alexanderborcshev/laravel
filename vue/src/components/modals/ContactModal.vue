<template>
    <div class="popup__header --contact"></div>
    <div class="popup__text">
        <h2>
            Контактная информация
        </h2>
        <div class="contact">
            <div class="contact__item">
                <svg-icon :name="'phone2'" :width="isDesktop ? 32 : 24" :height="isDesktop ? 32 : 24" class="svg-icon"></svg-icon>
                <div class="contact__info">
                    <a href="tel:+79296198199" class="ttl">+7(929)619-81-99</a>
                    <div class="desc">
                        Личный телефон руководителя проекта
                    </div>
                </div>
            </div>
            <div class="contact__item">
                <svg-icon :name="'envelope'" :width="isDesktop ? 32 : 24" :height="isDesktop ? 32 : 24" class="svg-icon"></svg-icon>
                <div class="contact__info">
                    <a href="tel:+79296198199" class="ttl">+7(929)619-81-99</a>
                    <div class="desc">
                        Личный телефон руководителя проекта
                    </div>
                </div>
            </div>
            <div class="contact__item">
                <svg-icon :name="'marker'" :width="isDesktop ? 32 : 24" :height="isDesktop ? 32 : 24" class="svg-icon"></svg-icon>
                <div class="contact__info">
                    <span class="ttl">г. Подольск, Комсомольская 1</span>
                    <div class="desc">
                        Основной офис
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'ContactModal',
    components: {
        SvgIcon,
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
        }),
    },
    watch: {

    },
    methods: {
    },
};
</script>

<style lang="sass">
</style>
