<template>
    <footer class="footer">
        <div class="top">
            <img src="@/assets/img/footer-logo.svg" alt="">
        </div>
        <div class="bottom">
            <div class="l">
                <a href="javascript:void(0);" @click="open(this.popups.contractOfferModal)">
                    Договор оферты
                </a>
                <a href="javascript:void(0);" @click="open(this.popups.privacyPolicy)">
                    Политика обработки персональных данных
                </a>
            </div>
            <div class="r">
                <div class="copyright">
                    © 1980-2092 Алексей Земсков
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
    name: 'FooterBlock',
    components: {
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
.footer
    width: 100%
    height: 272px
    background-position: center
    background-repeat: no-repeat
    background-color: $black1
    background-size: contain
    display: flex
    flex-direction: column
    justify-content: space-between
    padding-bottom: 30px
    text-align: center
    padding-top: 112px
    +for-size(992)
        height: 344px
        padding-bottom: 46px
    .bottom
        display: flex
        flex-direction: column
        +for-size(992)
            flex-direction: row
            justify-content: space-between
            align-items: center
            width: 896px
            margin: 0 auto
        +for-size(1440)
            width: 1344px
        .l
            +for-size(992)
                text-align: left !important
            a
                display: block
                margin-bottom: 8px
                color: $gray1
                font-size: 10px
                line-height: 12px
                +for-size(992)
                    margin-bottom: 4px
                    font-size: 14px
                    line-height: 16px
                    transition: all .15s ease
                    &:hover
                        color: $gray3
        .copyright
            font-size: 10px
            line-height: 12px
            color: $gray1
            font-weight: 500
            +for-size(992)
                text-align: right !important
                font-size: 14px
                line-height: 16px
    .top
        width: 100%
        position: relative
        display: flex
        align-items: center
        justify-content: center
        &:before
            content: ''
            display: block
            width: calc(50% - 73px)
            height: 2px
            border-radius: 2px
            background-color: $honey
            position: absolute
            top: 23px
            left: 0
            box-shadow: 0px 0px 31px #FFC700
            +for-size(992)
                top: 43px
                width: calc(50% - 94px)
        &:after
            content: ''
            display: block
            width: calc(50% - 73px)
            height: 2px
            border-radius: 2px
            background-color: $honey
            position: absolute
            top: 23px
            right: 0
            box-shadow: 0px 0px 31px #FFC700
            +for-size(992)
                top: 43px
                width: calc(50% - 94px)
        img
            +for-size(992)
                width: 123px
                height: 119px
</style>
