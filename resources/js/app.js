
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Font Awesome Icons
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faBell, faGripHorizontal, faUser, faBook, faPlus, faSignOutAlt,
    faEdit, faBackward, faForward, faArrowAltCircleRight, faPencilAlt,
    faBookReader, faUserPlus, faUserCircle, faTrashAlt, faArchive,
    faCogs, faEnvelope, faMailBulk, faSpinner
} from '@fortawesome/free-solid-svg-icons';

import { faReadme } from '@fortawesome/free-brands-svg-icons';

library.add(
    // fontawesome-svg-core
    faBell, faGripHorizontal, faUser, faBook, faPlus, faSignOutAlt,
    faEdit, faBackward, faForward, faArrowAltCircleRight, faPencilAlt,
    faBookReader, faUserPlus, faUserCircle, faTrashAlt, faArchive,
    faCogs, faEnvelope, faMailBulk, faSpinner,
    // free-brands-svg-icons
    faReadme
);

// JQuery UI widgets
import 'jquery-ui/ui/widgets/sortable.js';

// Moment
window.Moment = require('moment');

// Truncatise
window.Truncatise = require('truncatise');

// Vue
window.Vue = require('vue');

// Vue event bus
window.Event = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)

files.keys().map(key => {
    return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
})

// Other components
Vue.component('font-awesome-icon', FontAwesomeIcon);

// Register a global custom directive called `v-focus`
Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
});

const app = new Vue({
    el: '#app',

    data: {
        journal: {}
    },

    mounted() {
        // Activate all tooltips
        $('[data-toggle="tooltip"]').tooltip();
    }
});
