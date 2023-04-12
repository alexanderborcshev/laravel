<template>
    <div class="wrapper --offer-detail">
        <div class="offer-detail__header --plug"></div>
        <div class="offer-detail__header" id="detailHeader">
            <div class="inner-wrapper">
                <div class="l">
                    <a href="javascript:void(0);" class="back" @click="goBack">
                        <svg-icon :name="'chevron'" :width="24" :height="24"></svg-icon>
                        <span v-if="isDesktop">ПЕРЕЙТИ В КАТАЛОГ</span>
                    </a>
                </div>
                <a href="javascript:void(0);" class="logo" @click="scrollUp"><img src="@/assets/img/logo.svg" alt="logo"></a>
                <div class="r">
                    <button type="button" name="button" class="btn" @click="open(this.popups.requestModal)" v-if="isDesktop">ОСТАВИТЬ ЗАЯВКУ</button>
                </div>
            </div>
        </div>
        <div class="offer-detail">
            <div class="offer-detail__top-bn">
                <div class="content">
                    <div class="info">
                        <div class="offer-detail__contractor" v-if="item.provider">
                            <span>Подрядчик: </span>
                            <a href="javascript:void(0);" @click="open(this.popups.contractorModal)">{{ item.provider.name }}</a>
                        </div>
                        <h1>{{ item.name }}</h1>
                        <div class="offer-detail__price">
                            От <span class="text-semibold">{{ numberFormat(item.price_min) }} ₽</span>
                            до <span class="text-semibold">{{ numberFormat(item.price_max) }} ₽</span>
                        </div>
                        <div class="offer-image" v-if="!isDesktop && item.main_photo">
                            <img :src="`${appPath}/${item.main_photo.path}`" alt="offer-image">
                        </div>
                        <div class="offer-detail__description">
                            <p v-html="item.description"></p>
                        </div>
                        <button type="button" name="button" class="btn"
                            ref="orderBtn"
                            @click="open(this.popups.requestModal)">ОСТАВИТЬ ЗАЯВКУ</button>
                    </div>
                    <div class="img" v-if="isDesktop && item.main_photo">
                        <img :src="`${appPath}/${item.main_photo.path}`" alt="offer-image">
                    </div>
                </div>
            </div>
            <div class="offer-detail__presents">
                <div class="content">
                    <h2>подарки при заказе на zemsbaza</h2>
                    <ul>
                        <li v-for="(gift, i) in item.gifts" :key="i" v-show="gift">
                            <svg-icon :name="'gift'" :width="21" :height="16" class="svg-icon"></svg-icon>
                            <span>{{ gift }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <transition name="show-btn">
                <div class="offer-detail__btn --fixed" v-if="!isDesktop && isBtnFixedShow" ref="orderBtnFixed">
                    <button type="button" name="button" class="btn" @click="open(this.popups.requestModal)">ОСТАВИТЬ ЗАЯВКУ</button>
                </div>
            </transition>
            <div class="offer-detail__elem" v-if="item.provider">
                <div class="inner-wrapper">
                    <h2>О компании</h2>
                    <p v-html="item.provider.description"></p>
                </div>
            </div>
            <div class="offer-detail__elem">
                <div class="inner-wrapper">
                    <h2>Портфолио</h2>
                    <div class="offer-detail__carousel">
                        <image-carousel v-if="item.images" :images="item.images"></image-carousel>
                    </div>
                </div>
            </div>
            <div class="offer-detail__elem">
                <div class="inner-wrapper">
                    <h2>Наши преимущества</h2>
                    <p v-html="item.advantages"></p>
                </div>
            </div>
            <div class="offer-detail__elem" v-if="item.prices && item.prices.length > 0">
                <div class="inner-wrapper">
                    <h2>Наши цены</h2>
                    <div class="price-list">
                        <div class="price-list__item"  v-for="(price, i) in item.prices" :key="i">
                            <div class="name">{{ price.description }}</div>
                            <div class="price">{{ price.price }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offer-detail__elem" v-for="(text_section, i) in item.text_sections" :key="i">
                <div class="inner-wrapper">
                    <h2>{{ text_section.title }}</h2>
                    <p  v-html="text_section.text"></p>
                </div>
            </div>
            <div class="offer-detail__elem --how-to-order">
                <div class="inner-wrapper">
                    <h2>Как оформить заказ?</h2>
                    <ul class="how-to-order">
                        <li>
                            <svg-icon :name="'clock'" :width="32" :height="32" class="svg-icon"></svg-icon>
                            <span>Мы работаем {{ item.work_time }}</span>
                        </li>
                        <li v-if="item.provider">
                            <svg-icon :name="'heart'" :width="32" :height="32" class="svg-icon"></svg-icon>
                            <span>С уважением,
                                <a href="javascript:void(0);" @click="open(this.popups.contractorModal)">{{ item.provider.name }}</a></span>
                        </li>
                        <li>
                            <svg-icon :name="'phone'" :width="32" :height="32" class="svg-icon"></svg-icon>
                            <span>Мы с вами свяжемся, проконсультируем и поможем оформить заказ.</span>
                        </li>
                        <li>
                            <svg-icon :name="'note-check'" :width="32" :height="32" class="svg-icon"></svg-icon>
                            <span>Нажмите на кнопку «Оставить заявку», а затем укажите имя и номер телефона</span>
                        </li>
                    </ul>
                    <button type="button" name="button" class="btn"
                        v-if="isDesktop"
                        @click="open(this.popups.requestModal)">ОСТАВИТЬ ЗАЯВКУ</button>
                </div>
            </div>
        </div>

        <popup-component
            :show="popups.contractorModal.show" :name="popups.contractorModal.name" :width="704">
            <contractor-modal :item="item.provider" :category="item.category"></contractor-modal>
        </popup-component>

        <popup-component
            :show="popups.attentionModal.show"
            :name="popups.attentionModal.name"
            :width="704"
            :show-footer="false">
            <attention-modal :item="item"></attention-modal>
        </popup-component>

        <popup-component
            :show="popups.requestModal.show"
            :name="popups.requestModal.name"
            :width="704"
            :show-footer="false"
            :is-btn-close-fixed="false">
            <request-modal  :item="item"></request-modal>
        </popup-component>
        <popup-component
            :show="popups.successModal.show"
            :name="popups.successModal.name"
            :width="704"
            :is-btn-close="false">
            <success-modal  :item="item"></success-modal>
        </popup-component>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import ImageCarousel from '@/components/ImageCarousel.vue';
import PopupComponent from '@/components/PopupComponent.vue';
import ContractorModal from '@/components/modals/ContractorModal.vue';
import AttentionModal from '@/components/modals/AttentionModal.vue';
import { numberFormat } from '@/helpers/formatted';
import RequestModal from '@/components/modals/RequestModal.vue';
import SuccessModal from '@/components/modals/SuccessModal.vue';
import { scrollTo } from '@/helpers/animate';

export default {
    name: 'MainHeader',
    components: {
        SvgIcon,
        ImageCarousel,
        PopupComponent,
        ContractorModal,
        AttentionModal,
        RequestModal,
        SuccessModal,
    },
    props: {
    },
    data() {
        return {
            images: [{ url: 'https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aHVtYW58ZW58MHx8MHx8&w=1000&q=80' },
                { url: 'https://thumbs.dreamstime.com/b/beautiful-rain-forest-ang-ka-nature-trail-doi-inthanon-national-park-thailand-36703721.jpg' },
                { url: 'https://images.ctfassets.net/hrltx12pl8hq/a2hkMAaruSQ8haQZ4rBL9/8ff4a6f289b9ca3f4e6474f29793a74a/nature-image-for-website.jpg?fit=fill&w=480&h=320' },
                { url: 'https://media.istockphoto.com/id/1322277517/photo/wild-grass-in-the-mountains-at-sunset.jpg?s=612x612&w=0&k=20&c=6mItwwFFGqKNKEAzv0mv6TaxhLN3zSE43bWmFN--J5w=' }],
            isBtnFixedShow: false,
            isTitleVisible: false,
            appPath: process.env.VUE_APP_PATH_BACK,
        };
    },
    mounted() {
        if (!this.isDesktop) {
            this.isVisible(this.$refs.orderBtn);
            window.addEventListener('scroll', () => { this.isVisible(this.$refs.orderBtn); });
            this.fixHeader();
        }
        this.getItem({ id: this.$route.params.id });
    },
    beforeUnmount() {
        if (!this.isDesktop) {
            window.removeEventListener('scroll', () => { this.isVisible(this.$refs.orderBtn); });
        }
    },
    computed: {
        ...mapState({
            popups: (state) => state.popups.items,
            isDesktop: (state) => state.isDesktop,
            item: (state) => state.offer.item,
        }),
    },
    watch: {

    },
    methods: {
        ...mapActions('popups', [
            'open',
        ]),
        ...mapActions('offer', [
            'getItem',
        ]),
        ...mapActions('category', [
            'getItems',
        ]),
        isVisible(target) {
            // Все позиции элемента
            if (target) {
                const targetPosition = {
                    top: window.pageYOffset + target.getBoundingClientRect().top,
                    left: window.pageXOffset + target.getBoundingClientRect().left,
                    right: window.pageXOffset + target.getBoundingClientRect().right,
                    bottom: window.pageYOffset + target.getBoundingClientRect().bottom,
                };
                // Получаем позиции окна
                const windowPosition = {
                    top: window.pageYOffset,
                    left: window.pageXOffset,
                    right: window.pageXOffset + document.documentElement.clientWidth,
                    bottom: window.pageYOffset + document.documentElement.clientHeight,
                };

                if (targetPosition.bottom > windowPosition.top
                    && targetPosition.top < windowPosition.bottom
                    && targetPosition.right > windowPosition.left
                    && targetPosition.left < windowPosition.right) { // Если позиция левой стороны элемента меньше позиции правой чайти окна, то элемент виден справа
                    // Если элемент полностью видно, то запускаем следующий код
                    this.isBtnFixedShow = false;
                    this.isTitleVisible = false;
                    return;
                }
                if (window.pageYOffset > 750 && !this.isDesktop) {
                    this.isBtnFixedShow = true;
                }
                if (window.pageYOffset > 200 && this.isDesktop) {
                    this.isTitleVisible = true;
                }
            }
        },
        numberFormat(v) {
            return numberFormat(v, 0, '', ' ');
        },
        goBack() {
            this.$router.go(-1);
        },
        fixHeader() {
            let prevScrollpos = window.pageYOffset;
            window.onscroll = () => {
                const currentScrollPos = window.pageYOffset;
                if (prevScrollpos > currentScrollPos || window.pageYOffset < 80) {
                    document.getElementById('detailHeader').style.top = '0';
                } else {
                    document.getElementById('detailHeader').style.top = '-64px';
                }
                prevScrollpos = currentScrollPos;
            };
        },
        scrollUp() {
            scrollTo('up', 500);
        },
    },
};
</script>

<style lang="sass">
.wrapper
    &.--offer-detail
        background-color: #fff
        padding-bottom: 0
.show-btn-enter-active, .show-btn-leave-active
    transition: opacity .15s ease
.show-btn-enter-from, .show-btn-leave-to
    opacity: 0
.show-btn-enter-to, .show-btn-leave-from
    opacity: 1
.offer-detail
    p
        color: $gray1
        font-size: 14px
        line-height: 18px
        +for-size(992)
            font-size: 18px
            line-height: 22px
        +for-size(1440)
            font-size: 20px
            line-height: 24px
    h2
        font-size: 32px
        line-height: 32px
        font-weight: bold
        margin: 64px 0 12px
        font-family: 'BebasNeue', sans-serif
        letter-spacing: 0.025em
        +for-size(992)
            font-size: 32px
            line-height: 32px
            margin: 80px 0 24px
        +for-size(1440)
            font-size: 48px
            line-height: 48px
            margin: 120px 0 32px
    &__header
        position: fixed
        top: 0
        left: 0
        right: 0
        z-index: 10
        background-color: $black3
        transition: top .35s ease
        .inner-wrapper
            height: 64px
            width: 320px
            padding: 0 12px
            display: flex
            align-items: center
            justify-content: space-between
            +for-size(992)
                height: 80px
                width: 992px
                padding: 0px 48px 0 40px
            +for-size(1440)
                width: 1440px
                padding: 0px 48px 0 40px
        .l,.r
            width: 24px
            display: flex
            align-items: center
            +for-size(992)
                width: 200px
        .l
            justify-content: flex-start
            .back
                display: flex
                align-items: center
                color: $gray1
                font-weight: bold
                transition: all .15s ease
                letter-spacing: 0.025em
                .svg-icon
                    transform: rotate(180deg)
                &:hover
                    color: $gray3
        .r
            justify-content: flex-end
            .btn
                height: 48px
                box-shadow: 0px 4px 20px rgba(240, 154, 22, 0.2)
        &.--plug
            position: static
            height: 64px
            background-color: $black1
            +for-size(992)
                height: 80px
    &__top-bn
        background-color: $black1
        .content
            padding: 40px 12px
            +for-size(992)
                padding: 64px 0
                display: flex
                align-items: center
                justify-content: space-between
            +for-size(1440)
                padding: 80px 0
            .info
                +for-size(992)
                    width: 397px
                +for-size(1440)
                    width: 764px
        h1
            font-size: 32px
            line-height: 32px
            font-weight: bold
            margin: 15px 0 12px
            text-align: center
            color: $honey
            letter-spacing: 0.025em
            font-family: 'BebasNeue', sans-serif
            +for-size(992)
                margin: 16px 0 4px
                font-size: 40px
                line-height: 40px
                text-align: left
            +for-size(1440)
                font-size: 56px
                line-height: 56px
        .offer-image
            width: 320px
            margin-left: -12px
            height: 183px
            overflow: hidden
            margin: 32px 0 40px
            margin-left: -12px
            img
                width: 100%
                height: 100%
                object-fit: cover
        .img
            +for-size(992)
                width: 451px
                height: 258px
                border-radius: 12px
                margin: 0
                position: relative
                img
                    width: 100%
                    height: 100%
                    object-fit: cover
                    border-radius: 12px
                    filter: drop-shadow(0px 24px 24px rgba(0, 0, 0, 0.45))
                &:before
                    content: ''
                    width: 369px
                    height: 302px
                    background-color: $black3
                    border-radius: 53px
                    display: block
                    position: absolute
                    right: 43px
                    top: -22px
                    transform: rotate(-12.91deg)
            +for-size(1440)
                width: 516px
                height: 295px
                &:before
                    width: 410px
                    height: 336px
                    right: 53px
                    top: -20px
        .btn
            width: 100%
            height: 48px
            box-shadow: 0px 4px 20px rgba(240, 154, 22, 0.2)
            letter-spacing: 0.025em
            +for-size(992)
                width: 186px
                font-size: 14px
            +for-size(1440)
                width: 216px
                height: 52px
                font-size: 16px
                letter-spacing: 0
    &__contractor
        text-align: center
        font-weight: bold
        font-size: 12px
        line-height: 14px
        letter-spacing: 0.025em
        color: $gray1
        a
            color: $honey
        +for-size(992)
            text-align: left
            font-size: 14px
            line-height: 16px
    &__price
        font-size: 12px
        line-height: 14px
        color: $gray1
        text-align: center
        letter-spacing: 0.025em
        font-weight: bold
        +for-size(992)
            font-size: 14px
            line-height: 16px
            text-align: left
    &__description
        margin-bottom: 48px
        word-break: break-word
        +for-size(992)
            margin: 32px 0
        +for-size(1440)
            margin: 40px 0 48px
        p
            font-size: 14px
            line-height: 16px
            letter-spacing: 0.025em
            color: $gray1
            font-weight: bold
            text-align: center
            +for-size(992)
                font-size: 16px
                line-height: 19px
                text-align: left
            +for-size(1440)
                font-size: 20px
                line-height: 24px
    &__carousel
        margin: 0
        position: relative
        width: 320px
        margin-left: -12px
        +for-size(992)
            width: 100%
            margin: 0
    &__presents
        padding: 64px 0 48px
        margin-bottom: 32px
        background-color: $black3
        +for-size(992)
            padding: 48px 0 72px
        +for-size(1440)
            padding: 64px 0 80px
        .content
            padding: 0 12px
        h2
            color: $gray1
            margin: 0 0 24px
            +for-size(992)
                margin-bottom: 32px
        ul
            display: flex
            flex-direction: column
            align-items: center
            +for-size(992)
                flex-direction: row
                gap: 16px
            li
                width: 100%
                height: auto
                padding: 24px 16px
                background-color: $black1
                border-radius: 8px
                display: flex
                align-items: center
                flex-direction: column
                font-size: 14px
                line-height: 17px
                color: $honey
                letter-spacing: 0.025em
                font-weight: 500
                +for-size(992)
                    font-size: 16px
                    line-height: 19px
                +for-size(1440)
                    font-size: 20px
                    line-height: 24px
                & + li
                    margin-top: 12px
                    +for-size(992)
                        margin-top: 0
                .svg-icon
                    color: $honey
                    margin-bottom: 12px
                    +for-size(992)
                        width: 31px !important
                        height: 24px !important
                    +for-size(1440)
                        width: 42px !important
                        height: 32px !important
    &__btn
        height: 80px
        border-radius: 0 0 12px 12px
        box-shadow: 0px -10px 32px rgba(162, 162, 162, 0.35)
        background-color: $black2
        margin-bottom: 32px
        .btn
            width: 296px
            height: 48px
            margin: 0 auto
            box-shadow: 0px 4px 20px rgba(240, 154, 22, 0.2)
        &.--fixed
            height: 80px
            box-shadow: none
            position: fixed
            bottom: 0
            left: 0
            right: 0
            z-index: 9
            margin: 0
            border-radius: 12px 12px 0 0
            display: flex
            align-items: center
            justify-content: center
    &__elem
        padding: 0
        .carousel__track,.carousel__pagination
            list-style: none !important
            padding-left: 0 !important
            li
                list-style: none !important
                & + li
                    margin-top: 0
        &.--how-to-order
            padding: 48px 0 80px
            margin-top: 48px
            background-color: $gray-light2
            +for-size(992)
                padding: 64px 0 80px
                margin-top: 80px
            +for-size(1440)
                padding: 80px 0 80px
                margin-top: 120px
            h2
                margin: 0 0 32px
            .btn
                height: 48px
                box-shadow: 0px 4px 20px rgba(240, 154, 22, 0.2)
                letter-spacing: 0.025em
                +for-size(992)
                    width: 186px
                    font-size: 14px
                    margin-top: 48px
                +for-size(1440)
                    width: 216px
                    height: 52px
                    font-size: 16px
                    letter-spacing: 0
                    margin-top: 64px
        .inner-wrapper
            width: 320px
            padding: 0 12px
            +for-size(992)
                width: 992px
                padding: 0 48px
        ul
            li
                padding-left: 9px
                position: relative
                +for-size(992)
                    padding-left: 14px
                &:before
                    content: "•"
                    position: absolute
                    left: 0
                & + li
                    margin-top: 20px
                    +for-size(992)
                        margin-top: 24px
        ol
            list-style: decimal !important
            padding-left: 18px
            +for-size(992)
                padding-left: 24px
            li
                list-style: decimal !important
                & + li
                    margin-top: 20px
                    +for-size(992)
                        margin-top: 24px
        .price-list
            &__item
                padding: 8px 0
                display: flex
                align-items: center
                color: $gray1
                border-bottom: 1px solid rgba($black1, 0.1)
                font-size: 12px
                line-height: 16px
                +for-size(992)
                    justify-content: space-between
                    font-size: 18px
                    line-height: 24px
                    padding: 16px 0
                .name
                    width: 154px
                    +for-size(992)
                        width: auto
                        flex: 1
                .price
                    width: 134px
                    text-align: right
                    font-weight: 700
                    +for-size(992)
                        width: 182px
                &:first-child
                    padding-top: 4px
        .how-to-order
            list-style: none !important
            padding: 0
            li
                list-style: none !important
                display: flex
                align-items: center
                font-size: 14px
                line-height: 16px
                padding: 0
                letter-spacing: 0.025em
                font-weight: bold
                color: $gray1
                &:before
                    content: none
                & + li
                    margin-top: 24px
                    +for-size(992)
                        margin-top: 16px
                    +for-size(1440)
                        margin-top: 24px
                    a
                        color: $honey
                +for-size(992)
                    font-size: 18px
                    line-height: 22px
                +for-size(1440)
                    font-size: 20px
                    line-height: 24px
                .svg-icon
                    margin-right: 16px
                    color: $honey
                span
                    flex: 1

</style>
