<template>
	<div>
		<card v-if="!isTimeZoneLoaded">
			<FullCalendar :options="calendarOptions" />
		</card>
		<card class="text-center py-5" v-else>
			<i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
			<p class="text-primary font-weight-bold mt-3">
				Loading...Please Wait...
			</p>
		</card>
		<!-- <button class="btn btn-primary btn-sm btn-block" @click="onCLickCalendarDetail">
			Calendar Detail
		</button> -->
	</div>
</template>
<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import momentTimezonePlugin from '@fullcalendar/moment-timezone';
import moment from 'moment'
import { mapState } from "vuex";

export default {
	name: "calendar",
	props: {
		userId: {
			type: Number,
			default: null,
		},
		zone: {
			type: String,
			default: null
		},
		left: {
			type: String,
			default: "today",
		},
		center: {
			type: String,
			default: "title",
		},
		right: {
			type: String,
			// default: "Calendar Detail",
			// default: "custom2,dayGridMonth,timeGridWeek,timeGridDay",
			default: 'prev,next'
		},
	},
	components: {
		FullCalendar, // make the <FullCalendar> tag available
	},
	data() {
		return {
			calendarUser: null,
			userTimeZone: null,
			isTimeZoneLoaded: true,
			calendarOptions: {
				customButtons: {
					calendarDetailBtn: {
						text: 'Calendar Detail',
						click: function() {
							// this.$router.push("/user/calendar/detail");
							window.location.href = '/user/calendar/detail';
						}
					}
				},
				plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, momentTimezonePlugin],
				initialView: "dayGridMonth",
				eventContent:this.renderEventContent,
				dayCellDidMount: ({ date, el }) => {
					var calendarFullDate = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate();					
					var timeZoneYear = new Date(new Date().toLocaleString("en-US", {timeZone: this.zone})).getFullYear();
					var timeZoneMonth = new Date(new Date().toLocaleString("en-US", {timeZone: this.zone})).getMonth();
					var timeZoneDate = new Date(new Date().toLocaleString("en-US", {timeZone: this.zone})).getDate();
					var timeZoneFullDate = timeZoneYear + '-' + timeZoneMonth + '-' + timeZoneDate;
					if (timeZoneFullDate == calendarFullDate)
					{
						// el.style.borderColor = 'rgb(191, 166, 4)'
						// el.style.borderStyle = 'solid'
						// el.style.borderWidth = '2px'

						// el.style.borderTopStyle = 'solid'
						// el.style.borderLeftStyle = 'solid'
						// el.style.borderRightStyle = 'solid'
						// el.style.marginBottom = '0px'
						// el.style.paddingTop = '10px'
						// el.style.paddingRight = '10px'
						// el.style.paddingBottom = '10px'
						// el.style.paddingLeft = '10px'
						// el.style.borderTopLeftRadius = '5px'
						// el.style.borderTopRightRadius = '5px'
						// el.style.background= 'transparent'
					}
				},
				headerToolbar: {
					start: this.left,
					center: this.center,
					// end: 'calendarDetailBtn'
					end: this.right,
				},
				timeZone: this.zone,
				events: [],
				displayEventTime: false,
				eventBackgroundColor: "#ffffff",
				eventBorderColor: "#ffffff",
				eventTextColor: "#000000",
			},
		};
	},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),
	},
	mounted() {
		console.clear();
		this.getAllBootCampAnalyticsLog();
		this.getUserById();
		console.log(this.zone);
		console.log(this.calendarOptions.timeZone);
		console.log(this.calendarOptions);
		// this.zone = this.calendarOptions.timeZone;
	},
	watch: {
		zone(newVal, oldVal) {
			this.calendarOptions.timeZone = newVal;
		},
	},
	methods: {
		async getUserById()
		{
			this.isTimeZoneLoaded = true;
			var self = this;
			await this.$axios.$get('/admin/getUserById/'+this.userId)
			.then(function (response)
			{
				self.calendarUser = response;
				self.userTimeZone = response.time_zone_name
				self.calendarOptions.timeZone = response.time_zone_name;
				self.isTimeZoneLoaded = false;
			})
			.catch(function (error) {
				console.log('error: ' + error);
				self.$bvToast.toast(error, {
					variant: 'danger',
					solid: true,
				});
			});
		},
		renderEventContent(eventInfo, createElement) {    
			// var innerHtml = '<span>'+eventInfo.event._def.extendedProps.result.text+'</span>';
			var innerHtml = '<span></span>';
			// Check if event has image
			if (eventInfo.event._def.extendedProps.result.image_url)
			{
				// Store custom html code in variable
				// innerHtml = eventInfo.event._def.title+"<br/><img src='"+eventInfo.event._def.extendedProps.result.image_url+"'>";
				if (eventInfo.event._def.extendedProps.result.celebration)
				{
					innerHtml = innerHtml+"<br/><img class='celebration-image' src='/celebration.png'>";
				}
				else
				{
					innerHtml = innerHtml+"<br/><img src='"+eventInfo.event._def.extendedProps.result.image_url+"'>";
				}
				//Event with rendering html
				return createElement = { html: '<div class="custom-event">'+innerHtml+'</div>' }
			}

		},
		onCLickCalendarDetail() {
			this.$router.push("/user/calendar/detail");
		},
		async getAllBootCampAnalyticsLog() {
			if (this.userId != null) {
				var self = this;
				await this.$axios
					.$get("user/getAllBootCampAnalyticsLog?user_id=" + this.userId)
					.then(function(response) {
						for (var i = 0; i < response.length; i++) {
							// var tempObj = {};
							// tempObj["date"] = response[i].date;
							// tempObj["classNames"] = ["text-center"];
							self.calendarOptions.events.push(response[i]);
						}
					})
					.catch(function(error) {
						self.$bvToast.toast(error, {
							variant: "danger",
							solid: true,
						});
					});
			}
		},
	},
};
</script>
<style>
	.fc .fc-button-primary
	{
		text-transform: capitalize;
	}
	.fc-theme-standard td, .fc-theme-standard th
	{
		max-height: 20%;
		height: 20%;
	}
	.fc .fc-daygrid-day-frame
	{
		min-height: auto;
	}
	.custom-event
	{
		background-color: transparent;
		text-align: left;
	}
	.custom-event span
	{
		font-family: 'LucidaHandwriting', Fallback, sans-serif;
		color: #000000;
		font-weight: bold;
	}
	.custom-event img
	{
		width: 50%;
	}
	.custom-event .celebration-image
	{
		height: 40px;
		width: 30px;
		position: absolute;
		top: -10px;
		right: 0px;
	}
	.fc .fc-toolbar.fc-header-toolbar
	{
		margin-bottom: 0px;
		padding: 10px 10px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		background: rgb(191, 166, 4) !important;
		background: linear-gradient(
			90deg,
			rgba(224, 214, 150, 1) 0%,
			rgba(214, 189, 32, 1) 0%,
			rgba(191, 166, 4, 1) 100%
		) !important;
	}
	.fc .fc-daygrid-day.fc-day-today
	{
		background: transparent;
		border: none;
	}
	.fc .fc-daygrid-day.fc-day-today
	{
		border-radius: 0px;
		padding: 0px;
	}
	.fc-toolbar-title
	{
		color: #fff !important;
		font-weight: bold;
	}
	.fc-calendarDetailBtn-button,
	.fc .fc-button-primary,
	.fc-col-header
	{
		background: rgb(2, 0, 36) !important;
		background: linear-gradient(
			90deg,
			rgba(2, 0, 36, 1) 0%,
			rgba(9, 9, 121, 1) 0%,
			rgba(0, 212, 255, 1) 100%
		) !important;
		color: white !important;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		border: none !important;
	}
	.fc-daygrid-event.fc-daygrid-block-event.fc-h-event.fc-event.fc-event-start.fc-event-end.fc-event-today.text-center
	{
		background-color: transparent !important;
	}

	.fc-calendarDetailBtn-button:hover,
	.fc .fc-button-primary:hover
	{
		background-color: #3358f4 !important;
	    background-image: linear-gradient(to bottom left, #1d8cf8, #3358f4, #1d8cf8) !important;
	}
	.fc .fc-button-primary:focus
	{
		box-shadow: none;
	}
	.fc-theme-standard th a
	{
		color: #fff;
	}
	@media only screen and (max-width: 768px)
	{
		.custom-event span
		{
			font-size: 8px !important;
			font-weight: normal !important;
		}
	}
</style>
