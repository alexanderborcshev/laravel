<template>
    <div class="error-page">
        <div class="content">
            <div class="title">
                404
            </div>
            <div class="subtitle">
                Страница не найдена
            </div>
            <p>
                Если страница не найдена, это не значит, что её нет. Просто она куда-то потерялась, наши специалисты уже её ищут.
            </p>
            <router-link :to="'/'" class="btn go-main">ПЕРЕЙТИ НА ГЛАВНУЮ</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ErrorPage',
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
    },
    methods: {
    },
};
</script>

<style lang="sass">
.error-page
    height: auto
    background-color: $black1
    color: #fff
    text-align: center
    .content
        padding: 40px 12px 200px
        +for-size(992)
            padding: 80px 0px 120px
    .title
        font-weight: bold
        font-size: 48px
        line-height: 48px
        font-family: 'BebasNeue', sans-serif
        letter-spacing: 0.025em
        color: $honey
        +for-size(992)
            font-size: 112px
            line-height: 112px
            letter-spacing: 0.025em
    .subtitle
        font-size: 32px
        line-height: 32px
        font-weight: bold
        margin-top: 4px
        font-family: 'BebasNeue', sans-serif
        letter-spacing: 0.025em
        color: $honey
        +for-size(992)
            font-size: 72px
            line-height: 72px
            margin-top: 8px
    p
        font-size: 14px
        line-height: 16px
        margin-top: 32px
        letter-spacing: 0.025em
        font-weight: bold
        color: $gray1
        +for-size(992)
            font-size: 20px
            line-height: 24px
            margin-top: 24px
    .btn
        margin-top: 48px
        letter-spacing: 0.025em
        font-size: 14px
        height: 48px
        box-shadow: 0px 4px 20px rgba(240, 154, 22, 0.2)
        border-radius: 4px !important
        +for-size(992)
            width: 247px
            height: 52px
            font-size: 16px
            line-height: 19px
            margin: 0 auto
            margin-top: 40px

</style>
