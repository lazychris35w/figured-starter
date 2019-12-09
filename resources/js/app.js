require("./bootstrap");

import "es6-promise/auto";
import axios from "axios";
// import "./bootstrap";
import Vue from "vue";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import Index from "./Index";
import auth from "./auth";
import router from "./router";

import store from "./store/index";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";

// Set Vue globally
window.Vue = Vue;
// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
// Set Vue authentication
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAuth, auth);

Vue.use(ElementUI);

// import App from "./App.vue";
Vue.use(VueAxios, axios);

//  Vue.component("create-post", require("./pages/admin/CreatePost.vue").default);
// Vue.component("edit-post", require("./components/EditPost.vue").default);
// Vue.component("all-posts", require("./components/AllPosts.vue").default);
// Vue.component("list-posts", require("./components/ListPosts.vue").default);
 
// Load Index
Vue.component("index", Index);
const app = new Vue({
    el: "#app",
    router,
    store
});
