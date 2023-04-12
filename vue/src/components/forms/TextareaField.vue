<template>
    <div class="textarea-field" :class="{'error': isError, 'focused': this.focus, fill: filled}">
        <textarea-autosize :class="classTextareaField"
            :id="inputId"
            ref="textField"
            :auto-focus="autoFocus"
            @keyup.enter="enter()"
            @focus="setFocus(true)"
            @blur="setFocus(false)"
            :disabled="disabled"
            :min-height="minHeight"
            v-model="inputVal"
            :add-scroll-height="addScrollHeight"
            :style="addStyle"
            @input="updateValue"
            :important="important"
            :placeholder="placeholder"
            :autoResizeOnFocus="autoResizeOnFocus"
            :resizable="resize"></textarea-autosize>
        <div v-if="isError && errorText" class="textarea-error" :class="{'repeat-error': repeatError}">{{ errorText }}</div>
        <div class="textarea-counter" v-if="hasCounter">
            {{symbolsCount}}
        </div>
        <div class="icon" v-if="isError && isErrorIcon">
            <svg-icon :name="'info'" :width="16" :height="16" class="text-color-red"></svg-icon>
        </div>
    </div>
</template>

<script>
import TextareaAutosize from '@/components/forms/TextareaAutosize.vue';
import SvgIcon from '@/components/SvgIcon.vue';

export default {
    components: {
        TextareaAutosize,
        SvgIcon,
    },
    name: 'TextareaField',
    props: {
        autoResizeOnFocus: { default: true },
        addScrollHeight: { default: 1 },
        modelValue: { default: '' },
        placeholder: { default: '' },
        label: { default: '' },
        inputId: { default: '' },
        important: { default: false },
        disabled: { default: false },
        isError: { default: false },
        isErrorIcon: { default: false },
        isEdit: { default: false },
        addStyle: { default: '' },
        autoFocus: { default: false },
        isValidate: { default: false },
        errorText: { default: 'Не менее 10-ти символов' },
        resize: { default: false },
        minHeight: {
            type: [Number],
            default: null,
        },
        classTextarea: {
            default() {
                return [];
            },
            type: Array,
        },
        hasCounter: { default: false },
        hasCounterSMS: { default: false },
    },
    data() {
        return {
            focus: false,
            counterSMS: 0,
            counterSimbols: 0,
            counterSmsLength: 70,
            repeatError: false,
        };
    },
    watch: {
        isError(val, oldVal) {
            if (this.isError) {
                if (this.$el.closest('.popup-wrapper')) {
                    let $top = 0;
                    const pr = this.$el.closest('.popup-wrapper');
                    $top += parseFloat(pr.offsetTop);
                    pr.scrollTo({ top: $top, left: 0, behavior: 'smooth' });
                }
            }
            if (oldVal) {
                this.repeatError = true;
            }
        },
    },
    computed: {
        filled() {
            return this.modelValue !== null ? this.modelValue.toString().length > 0 : 0;
        },
        showLabel() {
            return this.focus || this.inputVal.toString().length > 0;
        },
        classTextareaField() {
            return { error: this.isError, 'repeat-error': this.repeatError, ...this.classTextarea };
        },
        inputVal: {
            get() { return this.modelValue; },
            set(value) { this.$emit('update:modelValue', value); },
        },
        symbolsCount() {
            return this.inputVal.length;
        },
    },
    mounted() {

    },
    emits: ['input', 'enter', 'check', 'focus', 'blur', 'edit', 'update:modelValue'],
    methods: {
        updateValue(value) {
            this.$emit('update:modelValue', value);
        },
        enter() {
            this.$emit('enter');
        },
        check() {
            this.$emit('check');
        },
        setFocus(val) {
            const value = val || false;
            this.repeatError = false;
            this.focus = value;
            if (value) {
                this.$emit('focus');
            } else {
                this.$emit('blur');
            }
        },
        edit() {
            this.$emit('edit');
        },
    },
};
</script>

<style lang="sass">
.textarea-field
    position: relative
    .icon
        position: absolute
        right: 8px
        top: 8px
    &.fill
        textarea
            border-color: rgba(#6F6F6F, 0.75)
            background-color: $white
textarea
    width: 100%
    min-height: 64px
    background-color: $black3
    height: auto
    display: block
    resize: none
    font-size: 14px
    padding: 20px 8px
    line-height: 22px
    border-radius: 8px
    border: 1px solid $black3
    transition: all .15s ease
    +for-size(992)
        font-size: 16px
        line-height: 19px
        padding: 24px 8
    &::-webkit-input-placeholder
        color: $gray3
        font-weight: normal
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1

    &:-moz-placeholder
        color: $gray3
        font-weight: normal
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1
    &::-moz-placeholder
        color: $gray3
        font-weight: normal
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1
    &:-ms-input-placeholder
        color: $gray3
        font-weight: normal
        text-overflow: ellipsis
        transition: color ease 0.3s
        opacity: 1
    &:hover
        border-color: #363535
        background-color: #363535
    &:focus
        border-color: rgba(#6F6F6F, 0.75)
        background-color: $white
    &.error
        border-color: $red
        color: $red
        &::-webkit-input-placeholder
            color: $red
        &:-moz-placeholder
            color: $red
        &::-moz-placeholder
            color: $red
        &:-ms-input-placeholder
            color: $red
</style>
