<template>
	<div>
		<div v-if="isLoading" class="text-center p-5">
			<i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
		</div>
		<div v-if="!isLoading && questionDetail">
			<video-review-question-card v-on:submitAnswer="answerSubmitted" :question="questionDetail" v-if="!isAnswerSubmitted" :hide-question="'true'">
			</video-review-question-card>

			<!-- <div class="response-container">
				<response-card v-if="isAnswerSubmitted" :data="questionDetail"></response-card>
			</div> -->
		</div>
	</div>
</template>
<script>
import ResponseCard from "@/components/VideoReview/ResponseCard";
// import PracticeCheckQuestionCard from "@/components/VideoReview/PracticeCheckQuestionCard";
import VideoReviewQuestionCard from "@/components/VideoReview/VideoReviewQuestionCard";

export default {
	layout: "user",
	name: "unit-question-detail",
	components: {
		ResponseCard,
		// PracticeCheckQuestionCard,
		VideoReviewQuestionCard,
	},
	data() {
		return {
			timerStartDateTime: null,
			questionId: null,
			isAnswerSubmitted: false,
			questionDetail: null,
			isLoading: false
		};
	},
	methods: {
		answerSubmitted(data) {
			this.isAnswerSubmitted = true;
		},
		async getUserUnitQuestionDetailById()
		{
			this.isLoading = true;
			var self = this;
			await this.$axios
				.get("user/getSelectedVideoQuestionDetailById/" + this.questionId)
				.then(function(response) {
					self.questionDetail = response.data;
					self.isLoading = false;
				})
				.catch(function(error) {
					self.isLoading = true;
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
		this.questionId = this.$route.params.id;
		this.getUserUnitQuestionDetailById();
	},
};
</script>
<style>
.response-container {
	height: 85vh;
	display: flex;
	align-items: center;
}
.question-card {
	/*height: 50vh;*/
	margin-top: 15vh;
	/*display: flex;*/
	/*justify-content: center;*/
	/*align-items: center;*/
}
.answer-list-radio .custom-radio.b-custom-control-lg,
.input-group-lg .custom-radio {
	margin-top: 1rem !important;
}
.answer-list-radio
	.custom-radio.b-custom-control-lg
	.custom-control-label::before,
.input-group-lg .custom-radio .custom-control-label::before,
.custom-radio.b-custom-control-lg .custom-control-label::after,
.input-group-lg .custom-radio .custom-control-label::after {
	top: 0rem !important;
}
</style>

