import * as type from './types.js'
import * as CryptoJS from "crypto-js";

export default {
    namespaced: true,
    state: {
        token: localStorage.getItem('user-token') || '',
        roles: localStorage.getItem('user-roles') || '',
        secretKey: "ENV.FILE.MySecretString", //need add env
    },
    getters: {
        isAuthenticated: state => {
            return state.token;
        },
        getToken: state => {
            return CryptoJS.AES
                .decrypt(state.token, state.secretKey)
                .toString(CryptoJS.enc.Utf8);
        },
        getRoles: state => {
            return CryptoJS.AES
                .decrypt(JSON.parse(state.roles), state.secretKey)
                .toString(CryptoJS.enc.Utf8);
        }
    },
    mutations: {
        [type.AUTHENTICATE]: (state, token) => {
            state.token = CryptoJS.AES.encrypt(token, state.secretKey).toString();
            localStorage.setItem('user-token', state.token);
        },

        [type.LOG_OUT]: (state, token) => {
            localStorage.removeItem("user-token");
            localStorage.removeItem("user-roles");
            state.token = '';
        },

        [type.SET_ROLES ]: (state, roles) => {
            state.roles  = CryptoJS.AES.encrypt(JSON.stringify(roles), state.secretKey).toString();
            localStorage.setItem('user-roles', state.roles);
        }
    },
}

