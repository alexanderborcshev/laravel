<template>
    <textarea
        :style="computedStyles"
        v-model="val"
        ref="textField"
        maxlength="5000"
        @focus="focus()"
        @blur="blur()"
        cols="1"
        rows="1"
    ></textarea>
</template>
<script>
export default {
    name: 'TextareaAutosize',
    props: {
        autoResizeOnFocus: { default: true },
        autoFocus: { default: false },
        modelValue: {
            type: [String, Number],
            default: '',
        },
        autosize: {
            type: Boolean,
            default: true,
        },
        resizable: {
            default: false,
        },
        minHeight: {
            type: [Number],
            default: null,
        },
        maxHeight: {
            type: [Number],
            default: null,
        },
        addScrollHeight: {
            type: [Number],
            default: 1,
        },
        /*
             * Force !important for style properties
             */
        important: {
            type: [Boolean, Array],
            default: false,
        },
    },
    data() {
        return {
            // data property for v-model binding with real textarea tag
            val: null,
            // works when content height becomes more then value of the maxHeight property
            maxHeightScroll: false,
            height: 'auto',
        };
    },
    computed: {
        computedStyles() {
            if (!this.autosize) return {};
            return {
                resize: this.isResize,
                height: this.height,
                overflow: this.maxHeightScroll ? 'auto' : this.isHidden,
            };
        },
        isResize() {
            if (this.resizable) {
                return 'horizontal';
            } if (!this.isResizeImportant) {
                return 'none';
            }
            return 'none !important';
        },
        isResizeImportant() {
            const imp = this.important;
            return imp === true || (Array.isArray(imp) && imp.includes('resize'));
        },
        isOverflowImportant() {
            const imp = this.important;
            return imp === true || (Array.isArray(imp) && imp.includes('overflow'));
        },
        isHeightImportant() {
            const imp = this.important;
            return imp === true || (Array.isArray(imp) && imp.includes('height'));
        },
        isHidden() {
            return !this.isOverflowImportant ? 'hidden' : 'hidden !important';
        },
    },
    watch: {
        modelValue(val) {
            this.val = val;
        },
        val(val) {
            this.$nextTick(this.resize);
            this.$emit('input', val);
        },
        minHeight() {
            this.$nextTick(this.resize);
        },
        maxHeight() {
            this.$nextTick(this.resize);
        },
        autosize(val) {
            if (val) this.resize();
        },
    },
    emits: ['input', 'focus', 'blur'],
    methods: {
        focus() {
            this.$emit('focus');
        },
        blur() {
            this.$emit('blur');
        },
        resize() {
            const important = this.isHeightImportant ? 'important' : '';
            this.height = `auto${important ? ' !important' : ''}`;
            this.$nextTick(() => {
                let contentHeight = this.$el.scrollHeight + 1;
                if (this.minHeight) {
                    contentHeight = contentHeight < this.minHeight ? this.minHeight : contentHeight;
                }
                if (this.maxHeight) {
                    if (contentHeight > this.maxHeight) {
                        contentHeight = this.maxHeight;
                        this.maxHeightScroll = true;
                    } else {
                        this.maxHeightScroll = false;
                    }
                }
                let plusHeight = 40;
                if (contentHeight > this.minHeight) {
                    plusHeight = 0;
                }
                contentHeight += plusHeight;
                const heightVal = `${contentHeight}px`;
                this.height = `${heightVal}${important ? ' !important' : ''}`;
            });
            return this;
        },
        inputFocus(ref) {
            this.$nextTick(() => {
                if (this.$refs[ref]) {
                    this.$refs[ref].focus();
                }
            });
        },
    },
    created() {
        this.val = this.modelValue;
    },
    mounted() {
        this.resize();
        if (this.autoFocus === true) {
            this.inputFocus('textField');
        }
    },
};
</script>
