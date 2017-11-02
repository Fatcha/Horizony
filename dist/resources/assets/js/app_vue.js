'use strict';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vue = Vue;
Vue.use(require('vue-resource'));
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example', require('./components/Example.vue'));
//


Vue.component('slot-user', {

    template: '<div  ></div>',
    methods: {
        selectSlot: function selectSlot() {
            console.log("select slot");
        }
    }
});

var planning = new Vue({
    el: '#planning-view',

    data: {
        message: 'Hello Vue !',
        path_to_planning: '',
        tasks_planned: [],
        departments: [],
        day_date: [],
        projectIdSelected: null
    },
    ready: function ready() {
        //
        console.log("ready vue");
        // getPlanning();
    },
    methods: {
        getPlanning: function getPlanning() {
            var _this = this;

            this.$http.get(path_to_planning).then(function (response) {
                var body = response.body;
                // get body data
                _this.someData = response.body;
                _this.day_date = body.dates;
                _this.tasks_planned = body.tasks_planned;
                _this.departments = body.departments;
            }, function (response) {
                // error callback
            });
        },
        selectSlot: function selectSlot() {
            console.log("clicked");
        },

        chooseProject: function chooseProject() {
            console.log("project");
        }
    },
    directives: {
        services: function services(el, binding) {
            path_to_planning = binding.value.planning;
        }
    }

});

planning.getPlanning();
//# sourceMappingURL=app_vue.js.map