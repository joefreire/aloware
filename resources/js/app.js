require('./bootstrap');

import Vue from 'vue'
import moment from 'moment'

Vue.prototype.moment = moment

Vue.component('comments', require('./components/CommentsComponent.vue').default);

const app = new Vue({
    el: '#app',
});