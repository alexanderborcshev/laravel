import { parse, stringify } from 'qs';
import store from '@/store/index';
import { fileHeader, jsonHeader } from '@/helpers/axiosHeaders';
import axios from 'axios';
import router from '@/router';

export default {
    axios: axios.create({
        withCredentials: true,
        paramsSerializer: {
            encode: parse,
            serialize: stringify,
        },
    }),
    get(path, params) {
        return new Promise((resolve, reject) => {
            let pathToApi = process.env.VUE_APP_API_PATH;
            if (path === '/sanctum/csrf-cookie') {
                pathToApi = `${process.env.VUE_APP_PATH_BACK}/public`;
            }
            this.axios.get(`${pathToApi}${path}`, this.axiosConfig(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        reject(response.response.data.errorCode);
                    });
                });
        });
    },
    getBlob(path, params) {
        return new Promise((resolve, reject) => {
            this.axios.get(`${process.env.VUE_APP_API_PATH}${path}`, this.axiosConfigBlob(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        reject(response.response.data ? response.response.data.errorCode : '0');
                    });
                });
        });
    },
    post(path, params, data) {
        return new Promise((resolve, reject) => {
            this.axios.post(`${process.env.VUE_APP_API_PATH}${path}`, data, this.axiosConfig(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        if (response.response.status === 422) {
                            //  if validation form error
                            reject(response.response.data);
                        } else {
                            reject(response.response.data.errorCode);
                        }
                    });
                });
        });
    },
    postFile(path, params, data) {
        return new Promise((resolve, reject) => {
            this.axios.post(`${process.env.VUE_APP_API_PATH}${path}`, data, this.axiosConfigFile(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        reject(response.response.data.errorCode);
                    });
                });
        });
    },
    put(path, params, data) {
        return new Promise((resolve, reject) => {
            let form = data;
            if (data instanceof FormData) {
                data.append('_method', 'PUT');
            } else {
                form = new FormData();
                for (const key in data) {
                    form.append(key, data[key]);
                }
                form.append('_method', 'PUT');
            }
            this.axios.post(`${process.env.VUE_APP_API_PATH}${path}`, form, this.axiosConfig(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        reject(response.response.data.errorCode);
                    });
                });
        });
    },
    delete(path, params) {
        return new Promise((resolve, reject) => {
            this.axios.delete(`${process.env.VUE_APP_API_PATH}${path}`, this.axiosConfig(params))
                .then((response) => {
                    resolve(response.data.data ? response.data.data : response.data);
                })
                .catch((response) => {
                    this.errorHandler(response).then(() => {
                        reject(response.response.data.errorCode);
                    });
                });
        });
    },
    axiosConfig(params) {
        return {
            params: params || {},
            headers: jsonHeader,
        };
    },
    axiosConfigFile(params) {
        return {
            params: params || {},
            headers: fileHeader,
        };
    },
    axiosConfigBlob(params) {
        return {
            params: params || {},
            headers: fileHeader,
            responseType: 'blob',
        };
    },
    formData(data) {
        let form = data;
        if (!(form instanceof FormData)) {
            form = new FormData();
            for (const key in data) {
                form.append(key, data[key]);
            }
        }
        return form;
    },
    errorHandler(response) {
        let error = 0;
        if (response.data || response.response) {
            error = response.data && response.data.error ? response.data.error : 0;
            if (!response.data?.error) {
                switch (response.response.status) {
                case 401:
                    error = 405;
                    break;
                case 405:
                    error = 404;
                    break;
                default:
                    error = response.response.status;
                    break;
                }
            }
        }
        console.log(error);
        // const data = response.data.result;
        return new Promise((resolve) => {
            switch (+error) {
            case 404:// Ресурс не найден
                resolve(response);
                router.push('/404page');
                break;
            default:
                resolve(response);
                store.dispatch('popups/open', store.state.popups.somethingWentWrong, { root: true });
                break;
            }
        });
    },
};
