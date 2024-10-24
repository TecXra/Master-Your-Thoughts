<template>
	<div>
		<div class="row">
			<div class="col-md-6">
				<div class="bg-white rounded shadow-md p-4">
					<h3>Personal Information</h3>
					<div class="d-flex align-items-center" v-if="loading">
						<b-spinner variant="primary" label="Spinning"></b-spinner>
					</div>
					<div class="p-info d-flex align-items-center" v-else>
						<div class="gravatar">
							<div>
								<v-gravatar class="rounded-circle" :email="userDetail.personalInfo.email" :size="50" />
							</div>
						</div>
						<div class="n_e mt-2 ml-3 mb-2">
							<h6>{{ userDetail.personalInfo.name }}</h6>
							<h6>{{ userDetail.personalInfo.email }}</h6>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="bg-white rounded shadow-md p-4">
					<h3>Faith and Fuel Points</h3>
					<div class="d-flex">
						<div v-if="loading">
							<b-spinner variant="primary" label="Spinning"></b-spinner>
						</div>
						<div v-else>
							<h6>Earned Points</h6>
							<h4>
								<b>{{ userDetail.faithAndFuelPoints }}</b>
							</h4>
						</div>
						<div class="ml-auto">
							<h6>Total Goal</h6>
							<h4><b>100</b></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- unit info cards -->
		<div class="row mt-4">
			<div class="col-md-4 ">
				<div class="video-review bg-white rounded shadow-md p-4">
					<h3>Practice check questions</h3>
					<div class="row  mt-4 p-0  ">
						<div class="col-lg-12 text-left">
							<card class="completed-card">
								<template slot="header">
									<h4 class="mb-0 text-white">Completed</h4>
									<h3 class="card-title mt-2">
										<b-spinner v-if="loading" variant="primary" label="Spinning"></b-spinner>
										<span v-else class="text-white">
											<i class="tim-icons icon-check-2 text-success"></i>
											Unit {{ userDetail.practiceCheckQuestions.completed }}
										</span>
									</h3>
								</template>
							</card>
						</div>
						<div class="col-lg-12 text-left">
							<card class="upcoming-card">
								<template slot="header">
									<h4 class="mb-0 text-white">Up-Coming</h4>
									<h3 class="card-title mt-2">
										<b-spinner v-if="loading" variant="primary" label="Spinning"></b-spinner>
										<span v-else class="text-white">
											<i class="tim-icons icon-bullet-list-67 text-info"></i>
											Unit {{ userDetail.practiceCheckQuestions.upComing }}
										</span>
									</h3>
								</template>
							</card>
						</div>
						<div class="col-lg-12 text-left">
							<card class="progess-unit-card">
								<template slot="header">
									<h4 class="mb-0 text-white">In-Progress Unit</h4>
									<h3 class="card-title mt-2">
										<b-spinner v-if="loading" variant="primary" label="Spinning"></b-spinner>
										<span v-else class="text-white">
											<i class="tim-icons icon-app text-primary"></i>
											Unit {{ userDetail.practiceCheckQuestions.inProgress.unit.number }}
										</span>
									</h3>
								</template>
							</card>
						</div>
						<div class="col-lg-12 text-left">
							<card class="progess-question-card">
								<template slot="header">
									<h4 class="mb-0 text-white">
										In-Progress Question
									</h4>
									<h3 class="card-title mt-2">
										<b-spinner v-if="loading" variant="primary" label="Spinning"></b-spinner>
										<span v-else class="text-white">
											<i class="tim-icons icon-app text-primary"></i>
											Question {{ userDetail.practiceCheckQuestions.inProgress.question.number }}
										</span>
									</h3>
								</template>
							</card>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="bg-white rounded shadow-md p-4" v-if="!loading">
					<h4 class="mb-2">
						Boot Camp Calendar
					</h4>
					<full-calendar :user-id="userId" :zone="timeZone" ></full-calendar>
				</div>
			</div>
			<div class="col-md-12 mt-4">
				<div class="video-review bg-white rounded shadow-md p-4">
					<div class="row" v-if="loading">
						<b-spinner variant="primary" label="Spinning"></b-spinner>
					</div>
					<h3 class="mb-1">Completed Videos</h3>
					<div class="row" v-if="userDetail.videoReviews">
						<div class="video-list col-md-12" v-if="userDetail.videoReviews.completed.length == 0">
							<div class="bg-light p-2 mb-2  rounded  d-flex align-items-center">
								<h6>No record Found</h6>
							</div>
						</div>
						<div v-else :key="index" class="video-list col-md-4" v-for="(vQuestion, index) in userDetail.videoReviews.completed">
							<div class="bg-light p-2 mb-2  rounded  d-flex align-items-center">
								<img :src="vQuestion.video_thumbnail_url" class="mr-3" style="height:80px; width:80px;"/>
								<div class="">
									<h6>Video # {{ vQuestion.video_number }}</h6>
									<p>Unit # {{ vQuestion.unit_number }}</p>
									<p>Question # {{ vQuestion.number }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row" v-else>
						<div class="col-lg-12">
							<p class="mb-0 py-5 text-center">
								No Video answered yet.
							</p>
						</div>
					</div>

					<h3 class="mt-4 mb-1">Next Video</h3>
					<div class="row" v-if="userDetail.videoReviews">
						<div class="video-list col-md-12" v-if="!userDetail.videoReviews.next">
							<div class="bg-light p-2 mb-2 rounded  d-flex align-items-center">
								<h6>No record Found</h6>
							</div>
						</div>
						<div v-else class="video-list col-md-4">
							<div class="bg-light p-2 mb-2  rounded  d-flex align-items-center">
								<img
									:src="userDetail.videoReviews.next.video_thumbnail_url"
									class="mr-3"
									style="height:80px; width:80px;"
								/>

								<div class="">
									<h6>Video # {{ userDetail.videoReviews.next.video_number }}</h6>
									<p>Unit # {{ userDetail.videoReviews.next.unit_number }}</p>
									<p>Question # {{ userDetail.videoReviews.next.number }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row" v-else>
						<div class="col-lg-12">
							<p class="mb-0 py-5 text-center">
								No Video answered yet.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	middleware: "admin",
	layout: "admin",
	name: "edit-user",
	components: {},
	data() {
		return {
			loading: true,
			userId: null,
			timeZone: null,
			userDetail: {
				personalInfo: null,
				faithAndFuelPoints: null,
				practiceCheckQuestions: null,
				videoReviews: null,
			},
		};
	},
	methods: {
		async getUserDetailForAdminView() {
			this.loading = true;
			var self = this;
			await this.$axios
				.get("/admin/getUserDetails/" + this.userId)
				.then(function(response) {
					self.userDetail = response.data;
					self.timeZone = response.data.personalInfo.time_zone;
					self.loading = false;
					console.log('self.userDetail');
					console.log(self.userDetail);
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
	watch: {
		timeZone: function(newVal, oldVal) {
			this.timeZone = newVal;
			console.log('newVal');
			console.log(newVal);
		},
	},
	mounted() {
		this.userId = parseInt(this.$route.params.userId);
		this.getUserDetailForAdminView();
	},
};
</script>
<style lang="scss">
@import "~@/assets/sass/dashboard/custom/variables";

.completed-card {
	background: rgb(2, 0, 36) !important;
	background: linear-gradient(
		90deg,
		rgba(2, 0, 36, 1) 0%,
		rgba(9, 9, 121, 1) 0%,
		rgba(0, 212, 255, 1) 100%
	) !important;
	color: white !important;
}
.upcoming-card {
	background: rgb(2, 0, 36) !important;
	background: linear-gradient(
		90deg,
		rgba(2, 0, 36, 1) 0%,
		rgba(121, 9, 85, 1) 0%,
		rgba(210, 142, 246, 1) 100%
	) !important;
}
.progess-unit-card {
	background: rgb(2, 0, 36) !important;
	background: linear-gradient(
		90deg,
		rgba(2, 0, 36, 1) 0%,
		rgba(93, 4, 10, 1) 0%,
		rgba(228, 122, 133, 1) 100%
	) !important;
}
.progess-question-card {
	background: rgb(2, 0, 36) !important;
	background: linear-gradient(
		90deg,
		rgba(2, 0, 36, 1) 0%,
		rgba(4, 93, 56, 1) 0%,
		rgba(122, 228, 175, 1) 100%
	) !important;
}
</style>
