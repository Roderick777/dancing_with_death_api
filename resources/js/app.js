
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let events = {
    "2017-10-30":[
        {"id":26,"name":"Icie Williamson","starts_at":"2017-10-30 15:21:28"}
    ],
    "2017-10-27":[
        {"id":1,"name":"Olaf Hintz","starts_at":"2017-10-27 15:21:28"},
        {"id":10,"name":"Mr. Sanford Kassulke","starts_at":"2017-10-27 15:21:28"}
    ],
    "2017-10-14":[
        {"id":2,"name":"Juana Schmitt","starts_at":"2017-10-14 15:21:28"},
        {"id":6,"name":"Vito Simonis","starts_at":"2017-10-14 15:21:28"},
        {"id":14,"name":"Lisette McLaughlin","starts_at":"2017-10-14 15:21:28"},
    ]
 };
 

import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vuejs-timepicker';
import Vuex from 'vuex'; 
export default {
    components: {
        Datepicker,
        VueTimepicker
    }
}

Vue.use(Vuex);

const store = new Vuex.Store({
    state:{
        
    },
    mutations:{

    }

});

const app = new Vue({
    el: '#app',
    store: store,
    components: {
        Datepicker,
        VueTimepicker
    },
    created: function(){
        var c = this;
        c.getCitas(c);
        c.paginaActiva = paginas[0];
    },
    data() {
        return {
            form:{
                fecha: moment().format('YY-MM-DD'),
                hora: { 
                    HH: moment().format('HH:mm:ss').split(':')[0],
                    mm: moment().format('HH:mm:ss').split(':')[1],
                    ss: moment().format('HH:mm:ss').split(':')[2]
                }
            },
            citas: null,
            paginas: [
                { menu: 'principal'},
                { menu: 'ingresar'},
            ],
            paginaActiva: null,
            horaSize: 45,
            diasHabiles: [0,1,2,3,4],
            diaElegido: null,
            detalleGrafico: null,
            horas: [
                {hora: '9 AM', numero: 9},
                {hora: '10 AM', numero: 10},
                {hora: '11 AM', numero: 11},
                {hora: '12 PM', numero: 12},
                {hora: '1 PM', numero: 13},
                {hora: '2 PM', numero: 14},
                {hora: '3 PM', numero: 15},
                {hora: '4 PM', numero: 16},
                {hora: '5 PM', numero: 17},
            ],
            events: {
                "2019-03-04":[
                    {"id":26,"name":"Icie Williamson","starts_at":"2019-03-04 11:30:28"}
                ],
                "2019-03-07":[
                    {"id":1,"name":"Olaf Hintz","starts_at":"2019-03-07 10:01:28"},
                    {"id":10,"name":"Mr. Sanford Kassulke","starts_at":"2019-03-07 16:58:00"}
                ],
                "2019-03-21":[
                    {"id":2,"name":"Juana Schmitt","starts_at":"2019-03-21 13:25:28"},
                    {"id":6,"name":"Vito Simonis","starts_at":"2019-03-21 15:21:28"},
                    {"id":14,"name":"Lisette McLaughlin","starts_at":"2019-03-21 12:41:28"},
                    {"id":15,"name":"Vito Simonis","starts_at":"2019-03-21 9:40:28"},
                    {"id":16,"name":"Lisette McLaughlin","starts_at":"2019-03-21 10:41:28"},
                    {"id":18,"name":"Vito Simonis","starts_at":"2019-03-21 15:21:28"},
                    {"id":119,"name":"Lisette McLaughlin","starts_at":"2019-03-21 16:41:28"},
                ],
                "2019-03-27":[
                    {"id":2,"name":"Juana Schmitt","starts_at":"2019-03-27 13:25:28"},
                    {"id":6,"name":"Vito Simonis","starts_at":"2019-03-27 15:27:28"},
                    {"id":14,"name":"Lisette McLaughlin","starts_at":"2019-03-27 12:41:28"},
                    {"id":15,"name":"Vito Simonis","starts_at":"2019-03-27 9:40:28"},
                    {"id":16,"name":"Lisette McLaughlin","starts_at":"2019-03-27 10:41:28"},
                    {"id":18,"name":"Vito Simonis","starts_at":"2019-03-27 15:27:28"},
                    {"id":119,"name":"Lisette McLaughlin","starts_at":"2019-03-27 16:41:28"},
                ]
            },
            date: moment()
        };
    },
    computed: {
        startWeek() {
            return this.date.month() === 0 ? 0 : this.date.clone().startOf('month').week();
        },
        endWeek() {
            return this.date.clone().endOf('month').week();
        },
        month() {
            const month = [];
            for (let week = this.startWeek; week <= this.endWeek; week++) {
                month.push({
                    week: week,
                    days: [,,,,,,,].fill(0).map((n, i) => {
                        return this.date
                            .clone()
                            .week(week)
                            .startOf('week')
                            .add(i, 'day');
                    })
                });
            }
            return month;
        }
    },
  
    methods: {
        getCitas: function(c){
            axios.get('/cita')
            .then(function (response) {
                c.citas = response;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        eventsOf(day) {
            return this.events[day.format('YYYY-MM-DD')];
        },

        isToday(day) {
            return moment().format('YYYY-MM-DD') === day.format('YYYY-MM-DD');
        },

        isChoosen(day) {
            try{
                return  this.diaElegido.format('YYYY-MM-DD') === day.format('YYYY-MM-DD');
            } catch(e){ return ''}
        },

        calcularPosicion(event, indexEvent){
            var fecha = moment(event.starts_at);
            var posicion = this.horaToPosicion(fecha.format('HH:mm:ss'));
            return posicion;
        },

        horaToPosicion(hora){
            var time = hora.split(':');
            var posicion = parseInt(time[0]) - this.horas[0].numero;
            var posicion2 = ( time[1] == 0 )? 0 : parseInt(time[1]) / 60;
            posicion2 = (posicion2 == 0)? 0 : posicion2 * this.horaSize;

            if(posicion == 0){
                return 0 + posicion2;            
            } else {
                return (posicion * this.horaSize) + posicion2;
            }
        },

        setDetalleGrafico(event){
            console.log('funciona')
            this.detalleGrafico = event;
        },

        salirDetalleGrafico(){
            this.detalleGrafico = null;
        },

        elegirDia: function(dia, indice){
            console.log(dia, indice);
            this.diaElegido = dia;
        }
    }
});