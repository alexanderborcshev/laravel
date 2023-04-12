<template>
    <div class="inp-s-wrap full"
        :class="{fill: filled, 'inp-disabled': disabled, '--error': isError, 'repeat-error':  repeatError, active: showLabel}">
        <span class="inp-s-label" :class="{ error: isError, 'repeat-error': repeatError }">{{ placeholderInput }}</span>
        <input :type="type"
            ref="field"
            :id="inputIdComputed"
            @keyup.enter="enter()"
            @focus="setFocus(true)"
            @blur="setFocus(false)"
            class="inp-s"
            :class="[{ error: isError, disabled:disabled, 'repeat-error': repeatError }, classBtn]"
            :disabled="disabled"
            :value="modelValue"
            v-mask="mask"
            :name="nameInput"
            @paste="paste($event)"
            @input="updateValue($event.target.value)"
            :maxlength="maxLengthNum"
            :autocomplete="fieldAutocomplete"
            :inputmode="inputmode"
        >

        <span class="field-clear__btn" v-if="isClearBtn" @click="clear">
            <span class="i i-close2"></span>
        </span>

        <span class="inp-s-error" v-if="isError && !(errorText === 'Обязательное поле' && modelValue.toString().length > 0)">{{ errorText }}</span>

        <span class="inp-s-icon">
            <svg-icon :name="'info'" :width="16" :height="16" v-if="isError && isErrorIcon" class="text-color-red"></svg-icon>
            <svg-icon :name="'pencil2'" :width="16" :height="16" v-if="isEdit" @click="edit"></svg-icon>
        </span>

        <span class="inp-s-counter" v-if="maxLengthNum">{{ maxLengthNum - modelValue.length }}</span>
    </div>
</template>

<script>
import { numberFormat } from '@/helpers/formatted';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    name: 'InputStyled',
    props: {
        modelValue: { default: '' },
        placeholder: { default: '' },
        placeholderInput: { default: '' },
        inputId: { default: '' },
        disabled: { default: false },
        classBtn: { default: '' },
        isError: { default: false },
        isErrorIcon: { default: false },
        isEdit: { default: false },
        isBlockArrowPhone: { default: false },
        isMoney: { default: false },
        maxMoney: { default: 9999999 },
        isValidate: { default: false },
        errorText: { default: '' },
        mask: { default: '' },
        name: { default: 'name' },
        isClearBtn: { default: false },
        maxLength: { default: false },
        maxLengthNum: { default: '' },
        fieldAutocomplete: { default: 'off' },
        type: { default: 'text' },
        autoFocus: { default: false },
        inputmode: { default: '' },
        isBold: { default: false },
    },
    components: {
        SvgIcon,
    },
    data() {
        return {
            focus: false,
            showPlaceholder: false,
            nameInput: '',
            repeatError: false,
            inputValue: '',
        };
    },
    mounted() {
        if (this.name !== 'name') {
            this.nameInput = this.name;
        } else {
            this.nameInput = Math.random().toString(36).substr(2, 5);
        }
        if (this.isBlockArrowPhone) {
            this.$refs.field.addEventListener('keydown', this.blockArrow, false);
        }
        if (this.autoFocus === true) {
            this.inputFocus('field');
        }
    },
    beforeUnmount() {
        this.$refs.field.removeEventListener('keydown', this.blockArrow);
    },
    emits: ['input', 'enter', 'check', 'focus', 'blur', 'edit', 'update:modelValue', 'paste'],
    computed: {
        showLabel() {
            return this.focus;
        },
        filled() {
            return this.modelValue.toString().length > 0;
        },
        inputIdComputed() {
            return this.inputId ? this.inputId : Math.random().toString(36).substr(2, 5);
        },
    },
    watch: {
        isError(val, oldVal) {
            if (oldVal) {
                this.repeatError = true;
            }
            // if (this.isError) {
            //     if (this.$el.closest('.popup-wrapper')) {
            //         let $top = 0;
            //         const pr = this.$el.closest('.popup-wrapper');
            //         $top += parseFloat(pr.offsetTop);
            //         pr.scrollTo({ top: $top, left: 0, behavior: 'smooth' });
            //     }
            // }
        },
    },
    methods: {
        blockArrow(e) {
            if ((e.keyCode >= 37 && e.keyCode <= 40)) {
                e.preventDefault();
                return false;
            }
            return false;
        },
        updateValue(value) {
            let v = value;
            if (this.isMoney) {
                v = v.replace(/[-;":'a-zA-Zа-яА-Я\\=`ё/*++!@#$%^&_№?><\s]/g, '');
                if (+v > this.maxMoney) {
                    v = this.maxMoney;
                    v = numberFormat(v, 0, '', ' ');
                } else if (v !== '') {
                    v = numberFormat(v, 0, '', ' ');
                }
                this.$refs.field.value = v;
            }
            if (this.mask && this.mask.mask === '9{1,2}%') {
                if (+v !== 0) {
                    v = +v;
                    this.$refs.field.value = v;
                }
            }
            this.$emit('update:modelValue', v);
            this.$emit('input');
        },
        paste(evt) {
            const e = evt;
            if (this.mask !== '') {
                const v = e.clipboardData.getData('text');
                e.target.value = v;
                this.$emit('update:modelValue', e.target.value);
                e.target.blur();
                e.target.focus();
            }
            this.$emit('paste');
        },
        enter() {
            this.$emit('enter');
        },
        check() {
            this.$emit('check');
        },
        clear() {
            this.$refs.field.focus();
            this.$emit('update:modelValue', '');
        },
        setFocus(value) {
            let val = value;
            const self = this;
            val = val || false;
            this.focus = val;
            this.repeatError = false;
            if (val) {
                this.$emit('focus');
                setTimeout(() => {
                    self.showPlaceholder = true;
                }, 50);
            } else {
                this.$emit('blur');
                this.showPlaceholder = false;
            }
        },
        edit() {
            this.$emit('edit');
        },
        inputFocus(ref) {
            if (this.$refs[ref]) {
                this.$nextTick(() => { this.$refs[ref].focus(); });
            }
        },

    },
};
</script>

<style lang="sass">
.inp-s
    width: 100%
    height: 56px
    background: none
    border: none
    border: 1px solid $black3
    font-size: 14px
    font-weight: normal
    border-radius: 8px
    padding-left: 8px
    padding-right: 8px
    background-color: $black3
    color: $black1
    z-index: 1
    transition: all 0.2s ease
    +for-size(992)
        height: 64px
        font-size: 16px
        line-height: 16px
    &::-webkit-input-placeholder
        color: $gray50
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1

    &:-moz-placeholder
        color: $gray50
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1

    &::-moz-placeholder
        color: $gray50
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1

    &:-ms-input-placeholder
        color: $gray50
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1
    &.disabled
        color: $gray50
        opacity: 1
        &:hover
            border-color: $gray20
    &-icon
        position: absolute
        top: calc(50% - 8px)
        right: 8px
        z-index: 1
    &.error
        border-color: $red !important
        color: $red
        background-color: #2E2626
        &::-webkit-input-placeholder
            color: $red

        &:-moz-placeholder
            color: $red

        &::-moz-placeholder
            color: $red

        &:-ms-input-placeholder
            color: $red
        & + .inp-s-error
            opacity: 1
            &.repeat-error
                animation: anim-inp-error 0.7s ease
        &:hover
            border-color: $red
    &-wrap
        position: relative
        &.--error
            .inp-s-label
                color: $red !important
        &.active, &.fill
            .inp-s
                background-color: $white
                border-color: rgba(#6F6F6F, 0.75)
            .inp-s-label
                position: absolute
                top: 6px
                font-size: 9px
                line-height: 12px
                white-space: nowrap
                font-weight: normal
                text-transform: uppercase
                padding: 0px
                left: 8px
                +for-size(992)
                    top: 8px
    &:hover
        border-color: #363535
        background-color: #363535
    &-counter
        position: absolute
        top: calc(50% - 6px)
        font-weight: normal !important
        z-index: 2
        right: 8px
        font-size: 10px
        line-height: 12px
        color: $gray50
        opacity: 0
        transition: opacity 0.2s ease
    &:focus
        border-color: $link-color
        & ~ .inp-s-counter
            opacity: 1
    &:active
        & ~ .inp-s-counter
            opacity: 1
    &-error
        font-size: 10px
        line-height: 16px
        color: $red
        position: absolute
        right: 0
        top: 100%
    &-label
        position: absolute
        top: calc(50% - 8px)
        white-space: nowrap
        left: 8px
        font-size: 14px
        line-height: 16px
        color: $gray-dark
        z-index: 2
        transition: all 0.1s ease
        pointer-events: none !important
        +for-size(992)
            font-size: 16px
            line-height: 16px
        &.error
            color: $red
        &.repeat-error
            &.error
                animation: anim-inp-txt 0.7s ease !important
</style>
