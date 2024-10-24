<template>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-lg-6 col-xl-6 offset-lg-3">
			<div class="card p-3">
				<h4 class="mb-2 p-2 rounded font-weight-bold blue-gradient text-white">
					Question: {{ question.number }}
				</h4>
				<h4 class="mb-0">
					{{ question.phrase.phrase }}
				</h4>
				<b-form-radio-group
					v-model="selectedAnswer"
					:options="question.answers_list"
					class="d-flex flex-column answer-list-radio"
					size="lg"
					value-field="id"
					text-field="answer"
					disabled-field="notEnabled"
				>
				</b-form-radio-group>
				<div class="text-right">

					<button class="btn btn-info mt-5" :disabled="!answerSelected || isQuestionAnwsered" @click="submitAnswer">
						<i class="fa fa-spinner fa-pulse text-white" v-if="isQuestionAnwsered"></i>

						Submit
					</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	layout: "user",
	name: "practice-check-question-card",
	props: ["question"],
	components: {},
	data() {
		return {
			selectedAnswer: null,
			isQuestionAnwsered: false
		};
	},
	methods: {
		async submitAnswer() {
			this.isQuestionAnwsered = true;
			var self = this;
			let payload = {
				question_id: this.question.id,
				phrase_id: this.question.phrase.id,
				answer_id: this.selectedAnswer,
			};
			await this.$axios
				.post("/user/submitUnitQuestionAnswer", payload)
				.then(function(response) {
					self.$emit("submitAnswer", true);
					self.isQuestionAnwsered = false;
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
	computed: {
		answerSelected() {
			return this.selectedAnswer != null;
		},
	},
	mounted() {},
};
</script>
