export default {
    isPhone(value) {
        const re = /\8\(9\d{2}\)\d{3}-\d{2}-\d{2}/;
        return re.test(value);
    },
    isAnyPhone(value) {
        const phone = value.replace(/[^+0-9]/g, '');
        return phone.length >= 12;
    },
    isEmail(value) {
        // eslint-disable-next-line
        const r = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return r.test(value);
    },
    isFloat(value) {
        const r = /^[0-9]+[.,][0-9]+/i;
        return r.test(value);
    },
    isPhoneCity(value) {
        const re = /\8\(\d{3}\)\d{3}-\d{2}-\d{2}/;
        return re.test(value);
    },
};
