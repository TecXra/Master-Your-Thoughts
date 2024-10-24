<template>
	<div class="h-100 w-100">
		<div class="blue-gradient w-100 py-3">
		</div>
		<div v-if="responseDetail" class="card p-2 m-0 h-100 d-flex flex-column">
			<div style="overflow-y: auto;">
				<h3 class="response_text" v-html="responseDetail.message">
					<!-- {{ responseDetail.message }} -->
				</h3>
				<div class="text-center">
					<!-- <nuxt-link to="/user/unit/1" class="btn btn-success" v-if="unitId != 1">
						Review Previous Units
					</nuxt-link> -->
					<nuxt-link to="/user/dashboard" class="btn btn-info">
						Return to Dashboard
					</nuxt-link>
				</div>
			</div>
		</div>		
	</div>
</template>
<script>
// import Timer from '~/components/Timer';

export default {
	layout: "user",
	name: "question-detail-id",
	props: ["data"],

	components: {
		// Timer
	},
	data() {
		return {
			timerStartDateTime: null,
			responseDetail: null,
			unitId: null,
		};
	},
	methods: {
		// startTimer()
		// {
		// 	this.timerStartDateTime = new Date();
		// 	var offset = this.timerStartDateTime.getTimezoneOffset() * 60 * 1000;
		// 	this.timerStartDateTime = this.timerStartDateTime.getTime();
		// 	this.timerStartDateTime = this.timerStartDateTime - offset;
		// }
		async getUnitQuestionAnswerResponse() {
			var self = this;
			await this.$axios
				.get(
					"/user/getUnitQuestionAnswerResponse?question_id=" +
						this.data.id +
						"&phrase_id=" +
						this.data.phrase.id
				)
				.then(function(response) {
					self.responseDetail = response.data;
				})
				.catch(function(error) {
					console.log("error: " + error);
					self.$bvToast.toast(error, {
						variant: "danger",
						solid: true,
					});
				});
		},
	},
	computed: {},
	mounted() {
		this.unitId = this.$route.params.unitId;
		// this.startTimer();
		this.getUnitQuestionAnswerResponse();
	},
};
</script>
<style>
	.response_text
	{
		padding: 1rem 10rem 0 10rem;
	}
	@media only screen and (max-width: 768px) {
		.response_text
		{
			padding: 1rem;
		}
	}
</style>