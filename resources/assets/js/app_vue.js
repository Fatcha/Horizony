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


// Vue.component('slot-user', {
//
//     template: '<div v-on:click="selectSlot(date)" >{{date}}</div>',
//     props: ['date', 'slotNumb'],
//     created: function(){
//
//         console.log ("TEST"+this.$el.offsetHeight);
//     },
//     mounted: function(){
//         console.log('fdkkf');
//     },
//     methods: {
//         selectSlot: function (n,index) {
//             console.log("select slot"+n+' '+index);
//         },
//         mounted: function(){
//             console.log('fdkkf');
//         }
//     },
// });

Vue.component('slot-user', {

    template: '<div v-on:click="selectSlot(date)"   >{{date}}</div>',
    props: ['date', 'slotNumb'],
    mounted: function(){
        console.log(this.$el.offsetTop);
    },
    methods: {
        selectSlot: function (n,index) {
            console.log("select slot"+n+' '+index);
        }
    },
});

Vue.component('task-planned', {
    template: '<div   style="background-color: #2a88bd; position:relative; ">Task</div>',
    props: ['userId'],
    mounted: function(){

        /*
        this.$nextTick(function () {
            console.log("UUUU");

            var userRow = document.getElementById(idToFind);
            console.log("user row offset: " + userRow);
        });
*/
    },
});

var objectTaskTest = {
    userId : 1
};

const planning = new Vue({
    el: '#planning-view',

    data: {
        tasksServices: null,
        planningServices: null,
        message: 'Hello Vue !',
        path_to_planning: '',
        tasksPlanned: [objectTaskTest],
        departments: [],
        dayDates: [],
        projectIdSelected: null
    },
    beforeMount: function () {
        this.tasksServices = this.$el.attributes['data-tasks-services'].value;
        this.planningServices = this.$el.attributes['data-planning'].value;
    },
    ready: function () {

    },
    methods: {
        getPlanning: function () {
            //data: {start_date: start, end_date: end}
            var self = this;
            axios.get(this.planningServices, {})
                .then(function (response) {
                    self.departments = response.data.departments;
                    self.dayDates = response.data.dates;

                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getTasks: function () {

            axios.post(this.tasksServices, {
                start_date: '2017-10-02',
                end_date: '2017-12-02'
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });

        },


        // -- select active project
        chooseProject: function (id) {
            this.projectIdSelected = id;
        }
    },
    directives: {
        // services: function (el, binding) {
        //     path_to_planning = binding.value.planning;
        // }
    }


});

planning.getPlanning();
