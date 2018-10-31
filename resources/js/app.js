
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Font Awesome Icons
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faBell } from '@fortawesome/free-solid-svg-icons';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { faBook } from '@fortawesome/free-solid-svg-icons';
import { faPlus } from '@fortawesome/free-solid-svg-icons';
import { faSignOutAlt } from '@fortawesome/free-solid-svg-icons';
import { faEdit } from '@fortawesome/free-solid-svg-icons';
import { faBackward } from '@fortawesome/free-solid-svg-icons';
import { faForward } from '@fortawesome/free-solid-svg-icons';
import { faArrowAltCircleRight } from '@fortawesome/free-solid-svg-icons';
import { faPencilAlt } from '@fortawesome/free-solid-svg-icons';
import { faBookReader } from '@fortawesome/free-solid-svg-icons';
import { faUserPlus } from '@fortawesome/free-solid-svg-icons';
import { faUserCircle } from '@fortawesome/free-solid-svg-icons';

import { faReadme } from '@fortawesome/free-brands-svg-icons';

window.Vue = require('vue');

library.add(
    faBell, faUser, faBook, faPlus, faSignOutAlt, faReadme, faEdit,
    faBackward, faForward, faArrowAltCircleRight, faPencilAlt, faBookReader,
    faUserPlus, faUserCircle
);

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('entry-card', require('./components/EntryCard.vue'));
Vue.component('entry-body', require('./components/EntryBody.vue'));
Vue.component('entry-comment', require('./components/EntryComment.vue'));
Vue.component('entry-header', require('./components/EntryHeader.vue'));

const app = new Vue({
    el: '#app'
});


