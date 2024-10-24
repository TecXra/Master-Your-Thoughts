<template>
	<card>
		<div class="embed-responsive embed-responsive-16by9">
			<!-- <iframe class="embed-responsive-item" src="~/assets/videos/waterfalls-at-plitvice-national-park-in-croatia.mp4" id="video"  allowscriptaccess="always" allow="autoplay"></iframe> -->
			<video width="320" height="240" controls @click="saveHarmonizerActivityLog">
				<source src="~/assets/videos/waterfalls-at-plitvice-national-park-in-croatia.mp4" type="video/mp4">
			</video>
		</div>

	</card>
</template>
<script>
import { mapState } from "vuex";

export default {
	middleware: "user",
	layout: "user",
	name: "user-harmonizer",
	components: {
	},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),
	},
	data() {
		return {
		};
	},
	methods: {
		async saveHarmonizerActivityLog()
		{
			var self = this;
			await this.$axios.$post("user/saveHarmonizerActivityLog")
			.then(function(response) {
				console.log('response');
				console.log(response);
			})
			.catch(function(error) {
				self.$bvToast.toast(error, {
					variant: "danger",
					solid: true,
				});
			});
		}
	}
};
</script>
