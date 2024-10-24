<template>
	<div class="card p-2">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" :src="question.media.src" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
				</div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<h4 class="mb-2 font-weight-bold">
					Question: 
				</h4>
				<h4 class="mb-0">
					{{question.phrase.phrase}}
				</h4>
				<b-form-radio-group v-model="selectedAnswer" :options="question.answersList" class="d-flex flex-column answer-list-radio" size="lg" value-field="id" text-field="answer" disabled-field="notEnabled">
				</b-form-radio-group>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
				<button class="btn btn-info mt-5" @click="submitAnswer">
					Submit
				</button>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	layout: "user",
	name: "video-review-question-card",
	props: [ 'question' ],
	components: {
	},
	data() {
		return {
			selectedAnswer: 0
		}
	},
	methods:{
		submitAnswer()
		{
			this.$emit('submitAnswer', true);
		}
	},
	computed: {
    },
	mounted() {
	}
};
</script>
