<template>
	<b-row>
		<b-col lg="8" offset-lg="2">
			<!-- <card> -->
				<!-- <full-calendar :user-id="user.id"></full-calendar> -->
				<full-calendar :user-id="user.id" :zone="user.time_zone_name"></full-calendar>
				<!-- <boot-camp-calendar></boot-camp-calendar> -->
			<!-- </card> -->
		</b-col>
	</b-row>
</template>
<script>
// import BootCampCalendar from '@/components/BootCampCalendar'
import { mapState } from "vuex";

export default {
	middleware: "user",
	layout: "user",
	name: "user-calendar",
	components: {
		// BootCampCalendar,
	},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),
	},

	data() {
		return {
			headerLeft: "",
			headerCenter: "title",
			headerRight: "",
		};
	},
};
</script>
