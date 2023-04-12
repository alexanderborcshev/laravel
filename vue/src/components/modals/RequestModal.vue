<template>
    <div class="popup__text --request-modal">
        <h2>Оставить заявку</h2>
        <h3>{{ item.name }}</h3>
        <div class="form">
            <input-styled
                    name="name"
                    :placeholderInput="'Как к вам обращаться'"
                    v-model="form.name.value"
                    :auto-focus="true"
                    @focus="form.name.error=false"
                    :is-error="form.name.error">
            </input-styled>
            <div class="flex-row">
                <div class="fixed-width">
                    <input-styled
                            name="phone"
                            :placeholderInput="'Телефон'"
                            :inputmode="'tel'"
                            :type="'tel'"
                            :mask="{mask:'8(999)999-99-99',showMaskOnHover: false}"
                            v-model="form.phone.value"
                            @focus="form.phone.error=false"
                            :is-error="form.phone.error">
                    </input-styled>
                </div>
                <div class="fixed-width" v-if="item.provider && item.provider.need_email">
                    <input-styled
                            name="email"
                            :placeholderInput="'E-mail'"
                            v-model="form.email.value"
                            @focus="form.email.error=false"
                            :is-error="form.email.error">
                    </input-styled>
                </div>
            </div>
            <textarea-field
                    v-model="form.comment.value"
                    :is-error="form.comment.error"
                    class="full"
                    :error-text="''"
                    :auto-focus="false"
                    placeholder="Комментарий (необязательно)"
                    :add-style="{minHeight: isDesktop ? 88 + 'px' : 96 + 'px'}">
            </textarea-field>
            <div class="how-connect__wrapper">
                <p>Как с вами связаться?</p>
                <div class="how-connect">
                    <check-item v-model="form.how_connect.value"
                        :inputId="`radio1`"
                        :type="'radio'"
                        :disabled="false"
                        :value="'telegram'"
                        :name="'how_connect'">
                        <slot name="labelSecond">
                            <svg-icon :name="'tg'" :width="isDesktop ? 16 : 12" :height="isDesktop ? 16 : 12"></svg-icon>
                            Телеграм
                        </slot>
                    </check-item>
                    <check-item v-model="form.how_connect.value"
                        :inputId="`radio2`"
                        :type="'radio'"
                        :disabled="false"
                        :value="'whatsapp'"
                        :name="'how_connect'">
                        <slot name="labelSecond">
                            <svg-icon :name="'wp'" :width="isDesktop ? 16 : 12" :height="isDesktop ? 16 : 12"></svg-icon>
                            WhatsApp
                        </slot>
                    </check-item>
                    <check-item v-model="form.how_connect.value"
                        :inputId="`radio3`"
                        :type="'radio'"
                        :disabled="false"
                        :value="'phone'"
                        :checked="true"
                        :name="'how_connect'">
                        <slot name="labelSecond">
                            <svg-icon :name="'phone'" :width="isDesktop ? 16 : 12" :height="isDesktop ? 16 : 12"></svg-icon>
                            По телефону
                        </slot>
                    </check-item>
                </div>
            </div>
            <div class="text-center">
                <check-item v-model="form.checkbox.value"
                    :inputId="`checkbox-agree`"
                    :type="'checkbox'"
                    :disabled="false"
                    :name="'checkbox-agree'"
                    :is-error="form.checkbox.error"
                    class="checkbox-agree">
                    <slot name="labelSecond">Я соглашаюсь с офертой и политикой обработки&nbsp;данных</slot>
                </check-item>
                <submit-btn @click="send()" :type="btnType" tag="button" class="btn">
                    ОТПРАВИТЬ ЗАЯВКУ
                </submit-btn>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Modal from '@/helpers/mixins/modal';
import SvgIcon from '@/components/SvgIcon.vue';
import InputStyled from '@/components/forms/InputStyled.vue';
import TextareaField from '@/components/forms/TextareaField.vue';
import SubmitBtn from '@/components/forms/SubmitBtn.vue';
import CheckItem from '@/components/forms/CheckItem.vue';

export default {
    name: 'RequestModal',
    mixins: [Modal],
    components: {
        SvgIcon,
        InputStyled,
        TextareaField,
        SubmitBtn,
        CheckItem,
    },
    props: {
        item: {
            default: {},
        },
    },
    data() {
        return {
            btnType: 'normal',
            dispatch: 'offer/sendOrder',
        };
    },
    mounted() {
        this.popup = this.popups.requestModal.name;
        if (this.item.provider.need_email) {
            this.form.email.require = true;
        }
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
            'open',
        ]),
        getData() {
            const result = {
                api_key: this.item.provider.api_key,
                offer_id: this.item.id,
            };
            for (const f in this.form) {
                result[f] = this.form[f].value;
            }
            return result;
        },
        callback() {
            this.open(this.popups.successModal);
        },
    },
};
</script>

<style lang="sass">
.--request-modal
    background-color: $black1
    padding: 48px 12px 260px
    +for-size(992)
        padding: 56px 64px 200px
    h2
        color: $gray-light2
        font-family: 'BebasNeue', sans-serif
        font-size: 32px
        line-height: 32px
        letter-spacing: 0.025em
        text-align: center
        +for-size(992)
            font-size: 48px
            line-height: 48px
            margin: 0
    h3
        color: $gray-light2
        font-size: 14px
        line-height: 16px
        letter-spacing: 0.025em
        text-align: center
        margin-top: 8px
        +for-size(992)
            font-size: 20px
            line-height: 24px
            margin-top: 12px
    .form
        display: flex
        flex-direction: column
        align-items: center
        margin-top: 24px
        +for-size(992)
            margin-top: 32px
            flex-direction: row
            flex-wrap: wrap
            justify-content: center
        .how-connect
            display: flex
            align-items: center
            margin-top: 16px
            +for-size(992)
                margin-top: 12px
            &__wrapper
                width: 100%
                margin-top: 24px
                p
                    font-size: 16px
                    line-height: 16px
                    color: $gray-light2
            .check-item
                width: 100%
                height: 40px
                [type="radio"]
                    & + label
                        height: 100%
                        padding: 0 !important
                        width: 100%
                        display: flex
                        align-items: center
                        justify-content: center
                        border: 1px solid $gray-light2
                        color: $white
                        font-size: 12px
                        line-height: 16px
                        transition: all .15s ease
                        +for-size(992)
                            font-size: 16px
                            line-height: 24px
                        .svg-icon
                            margin-right: 4px
                            +for-size(992)
                                margin-right: 8px
                        &:before
                            content: none
                        &:after
                            content: none
                    &:checked
                        & + label
                            background-color: rgba($honey, 0.1)
                            color: $honey
                            border-color: $honey
                            z-index: 1
                &:nth-child(1)
                    [type="radio"]
                        & + label
                            border-radius: 4px 0 0 4px
                            +for-size(992)
                                border-radius: 8px 0 0 8px
                &:nth-child(2)
                    margin-left: -1px
                    margin-right: -1px
                &:nth-child(3)
                    [type="radio"]
                        & + label
                            border-radius: 0 4px 4px 0
                            +for-size(992)
                                border-radius: 0 8px 8px 0
        .fixed-width
            width: 100%
        .flex-row
            display: flex
            align-items: center
            flex-direction: column
            gap: 16px
            width: 100%
            margin: 16px 0
            +for-size(992)
                flex-direction: row
                gap: 24px
                margin: 24px 0
        .checkbox-agree
            margin-top: 72px
            [type="checkbox"]
                & + label
                    font-size: 12px
                    line-height: 16px
                    color: $gray-light2
                    padding-left: 24px
                    position: relative
                    width: 296px
                    text-align: left
                    +for-size(992)
                        padding-left: 20px !important
                        width: 371px
                        font-size: 14px
                        line-height: 16px
                    &:before
                        top: 8px
                        border-color: $gray-light2
                        +for-size(992)
                            top: 0
                    .svg-icon
                        top: 10px
                        color: $black1
                        +for-size(992)
                            top: 2px
                &.error
                    & + label
                        color: $red !important
                        &:before
                            border-color: $red
                &:checked
                    & + label
                        &:before
                            background-color: $honey
                            border-color: $honey
            +for-size(992)
                margin-top: 64px
        .btn
            margin-top: 16px
            width: 296px
            height: 48px
            font-size: 14px
            line-height: 16px
            +for-size(992)
                margin-top: 24px
                width: 216px
                height: 52px
                font-size: 16px
                line-height: 19px
</style>
