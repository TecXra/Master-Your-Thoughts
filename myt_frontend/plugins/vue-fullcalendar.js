import Vue from 'vue';
import Calendar from '~/components/BootCampCalendar'

Vue.component('full-calendar', Calendar);

// import Vue from 'vue'

// if (process.BROWSER_BUILD) {
//   window.onNuxtReady(() => {
//     const FullCalendar = require('@fullcalendar/vue');

// 	// const dayGridPlugin = require('@fullcalendar/daygrid');
// 	// const interactionPlugin = require('@fullcalendar/interaction');
// 	// const timeGridPlugin = require('@fullcalendar/timegrid');

//     Vue.use(FullCalendar);
// 	// Vue.use(dayGridPlugin);
// 	// Vue.use(interactionPlugin);
// 	// Vue.use(timeGridPlugin);

// 	window.dayGridPlugin = require('@fullcalendar/daygrid');
// 	window.interactionPlugin = require('@fullcalendar/interaction');
// 	window.timeGridPlugin = require('@fullcalendar/timegrid');
// 	// window.dayGridPlugin = require('@fullcalendar/daygrid');
// 	// window.timeGridPlugin = require('@fullcalendar/timegrid');
//   })
// }

// // Include no SSR
// // if (process.isClient) {
// // 	const FullCalendar = require("@fullcalendar/vue").default
// // 	Vue.component("full-calendar", FullCalendar)
// // }