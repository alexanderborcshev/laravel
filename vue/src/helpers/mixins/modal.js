import validate from '@/helpers/validate';

export default {
    data() {
        return {
            status: 'normal',
            popup: '',
            dispatch: '',
            form: {
                phone: {
                    value: '',
                    require: true,
                    error: false,
                    type: 'phone',
                    errorType: 'require',
                },
                name: {
                    value: '',
                    require: true,
                    error: false,
                    type: 'text',
                    errorType: 'require',
                },
                email: {
                    value: '',
                    require: false,
                    error: false,
                    type: 'email',
                    errorType: 'require',
                },
                comment: {
                    value: '',
                    require: false,
                    error: false,
                    type: 'text',
                    errorType: 'require',
                },
                how_connect: {
                    value: 'phone',
                    require: false,
                },
                checkbox: {
                    value: false,
                    require: true,
                    error: false,
                    type: 'check',
                    errorType: 'require',
                },

            },
        };
    },
    methods: {
        send() {
            if (this.validate()) {
                this.status = 'load';
                this.$store.dispatch(this.dispatch, this.getData()).then((r) => {
                    this.status = 'normal';
                    this.close();
                    this.callback(r);
                });
            }
        },
        close() {
            this.$store.commit('popups/close', { name: this.popup });
        },
        getData() {
            const result = {};
            for (const f in this.form) {
                result[f] = this.form[f].value;
            }
            return result;
        },
        validate() {
            let result = true;
            for (const f in this.form) {
                let error = false;
                if (this.form[f].require) {
                    switch (this.form[f].type) {
                    case 'text':
                        if (!this.validateText(this.form[f].value, this.form[f].rule)) {
                            error = true;
                            result = false;
                        }
                        break;
                    case 'email':
                        if (((this.form[f].validateNotEmpty && this.form[f].value.length > 0)
                            || this.form[f].require) && !validate.isEmail(this.form[f].value)) {
                            error = true;
                            result = false;
                        }
                        break;
                    case 'phone':
                        if (((this.form[f].validateNotEmpty && this.form[f].value.length > 0)
                            || this.form[f].require) && !validate.isPhoneCity(this.form[f].value)) {
                            error = true;
                            result = false;
                        }
                        break;
                    case 'check':
                    case 'select':
                        if (!this.form[f].value) {
                            error = true;
                            result = false;
                        }
                        break;
                    default:
                        break;
                    }
                    if (error) {
                        this.setError(f);
                    }
                }
            }
            return result;
        },
        setError(f) {
            if (this.form[f].error) {
                this.form[f].error = false;
                setTimeout(() => {
                    this.form[f].error = true;
                }, 10);
            } else {
                this.form[f].error = true;
            }
        },
        validateText(value, rule) {
            let result = true;
            if (rule === {} || !rule) {
                result = (!(!value || value.toString().length === 0));
            }
            if (typeof rule === 'object' && rule !== {}) {
                if (rule.minLength && value.toString().length < rule.minLength) {
                    result = false;
                }
                if (rule.maxLength && value.toString().length > rule.maxLength) {
                    result = false;
                }
            }
            return result;
        },
        callback(r) { return r; },
    },

};
