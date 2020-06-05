import Vue from 'vue'
import store from '../store/index';
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import SingIn from "../pages/SingIn/index";
import Main from "../pages/Main/index";
import Edit from "../pages/CarParks/edit";

const isAuthenticated = (to, from, next) => {
    if (store.getters["user/isAuthenticated"]) {
        next();
        return;
    }
    next("/sing-in");
};

export default new VueRouter({
    routes: [
        {
            name: "sing-in",
            path: "/sing-in",
            component:  SingIn
        },
        {
            name: "main",
            path: "/",
            component:  Main,
            beforeEnter: isAuthenticated
        },
        {
            name: "add-car-park",
            path: "/add-car-park",
            component:  Edit,
            beforeEnter: isAuthenticated
        },
    ]
});



