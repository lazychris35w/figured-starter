import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const debug = process.env.NODE_ENV != 'production';

export default new Vuex.Store({
    state: {
        posts: [],
    },

    actions: {
        async getAllPosts({ commit }) {
            return commit('setPosts', await axios.get('/posts'))
        },
    },

    mutations: {
        setPosts(state, response) {
            state.posts = response.data.data;
        },
    },
    strict: debug
});