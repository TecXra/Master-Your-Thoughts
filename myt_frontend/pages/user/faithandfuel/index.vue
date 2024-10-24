<template>
	<div class="row bg-image">
		<video id="videoBG" autoplay muted loop>
			<source src="~/assets/videos/waterfalls-at-plitvice-national-park-in-croatia.mp4" type="video/mp4">
		</video>
		<div class="col-lg-3"></div>
		<div class="col-lg-6 mt-5">
			<div class="card">
				<div class="header-container text-center">
					<h3 class="text-white mb-0 mt-3 mb-1">Points of Faith and Fuel</h3>
					<h5 class="text-white mb-0">Points of Faith & Fuel: {{totalFaithAndFuelPoints}} of 100</h5>
					<h5 class="text-white mb-3">{{date}}</h5>
				</div>

				<div class="faith_and_fuel p-3">
					<div class="text-center" v-if="totalFaithAndFuelPoints == 100">
						<button class="btn btn-primary" @click="openCongratulaionModal">
							Download Certificate
						</button>
					</div>
					<div class="mb-3" v-else>
						<b-form @submit.stop.prevent="onSubmit" class="form-row">
							<div class="col-6">

								<b-form-group id="example-input-group-1" >
									<b-form-input
									placeholder="Please tell us about earning your points"
									id="example-input-1"
									name="example-input-1"
									v-model="$v.newEntry.description.$model"
									:state="validateState('description')"
									aria-describedby="input-1-live-feedback"
									></b-form-input>

									<b-form-invalid-feedback
									id="input-1-live-feedback"
									>This is a required field.</b-form-invalid-feedback>
								</b-form-group>

							</div>
							<div class="col">
								<b-form-group id="example-input-group-2" >
									<b-form-input
									type="number"
									min="1"
									max="99"
									placeholder="Points"
									id="example-input-2"
									name="example-input-2"
									v-model="$v.newEntry.points.$model"
									:state="validateState('points')"
									aria-describedby="input-2-live-feedback"
									></b-form-input>

									<b-form-invalid-feedback
									id="input-2-live-feedback"
									>This is a required field and value should be (1-99).</b-form-invalid-feedback>
								</b-form-group>						      

							</div>
							<div class="col">
								<base-button  type="primary" class="btn-fill btn-block m-0" @click="addFaithAndFuelPoints()">Add</base-button>

							</div>
						</b-form>
					</div>
					<div class="row justify-content-center" v-if="faithAndFuelTable.length <= 0">
						<!-- <h3 class="text-center">You have ZERO Point in Faith and Fuel Table.</h3> -->
					</div>

					<div class="form-row faithAndFuelTable mt-2 rounded" v-for="(item, index) in faithAndFuelTable" :key="item.id" v-if="index < pointsLimit">
						<div class="col-10">
							<span class="date">{{item.time_zone_date | formatDate}}</span>
							<p>{{item.description}}</p>
							<ul class="m-0">
								<li class="mr-3" @click="showModal(item)">Edit</li>
								<li @click="deleteFaithAndFuelById(item.id)">Delete</li>
							</ul>
						</div>
						<div class="col d-flex justify-content-center align-items-center">
							<p>{{item.points}}</p>
						</div>
					</div>
					<div class="row" v-if="faithAndFuelTable.length > 1">
						<div class="col text-center mt-3" v-if="pointsLimit == 1">
							<a class="font-weight-bold" href="javascript:void(0)" @click="showAllFaithFuelPoints">View All Entries</a>
						</div>
						<div class="col text-center mt-3" v-else>
							<a class="font-weight-bold" href="javascript:void(0)" @click="showLatestFaithFuelPoint">Show Last Entry Only</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<b-modal ref="my-modal" title="Edit Your Points" hide-footer>
			<b-form @submit.stop.prevent="onSubmit" class="form-row">
				<div class="col-9">
					<b-form-group id="example-input-group-1" >
						<b-form-input
						placeholder="Please tell us about earning your points"
						id="example-input-1"
						name="example-input-1"
						v-model="editEntry.description"
						aria-describedby="input-1-live-feedback"
						></b-form-input>
						<b-form-invalid-feedback
						id="input-1-live-feedback"
						>This is a required field.</b-form-invalid-feedback>
					</b-form-group>
				</div>
				<div class="col">
					<b-form-group id="example-input-group-2" >
						<b-form-input
						type="number"
						min="1"
						max="99"
						placeholder="Points"
						id="example-input-2"
						name="example-input-2"
						v-model="editEntry.points"
						aria-describedby="input-2-live-feedback"
						></b-form-input>
						<b-form-invalid-feedback
						id="input-2-live-feedback"
						>This is a required field and value should be (1-99).</b-form-invalid-feedback>
					</b-form-group>
				</div>
				<div class="row m-0 p-0 w-100 justify-content-end mt-5">
					<base-button  type="danger" class="btn-fill m-0 mr-2" @click="cancelFaithAndFuelPoints()">Cancel</base-button>
					<base-button  type="primary" class="btn-fill m-0" @click="updateFaithAndFuelPoints()">Update</base-button>
				</div>
			</b-form>
		</b-modal>

		<!-- congratulation modal -->
		<b-modal ref="congratulation-modal" hide-header hide-footer centered>
			<div class="row">
				<div class="col-lg-12">
					<h3 class="text-center">
						Congratulations!
					</h3>
					<p class="text-center">
						You have reached 100 Points of Faith & Fuel.
					</p>
					<p class="text-center mb-4">
						Are you ready to complete the course?
					</p>
					<div>
						<vue-html2pdf
					        :show-layout="false"
					        :float-layout="true"
					        :enable-download="true"
					        :preview-modal="false"
					        :paginate-elements-by-height="900"
					        filename="MasterYourThoughts Certificate"
					        :pdf-quality="2"
					        :manual-pagination="false"
					        pdf-format="a4"
					        pdf-orientation="landscape"
					        pdf-content-width="1125px"
					        ref="html2Pdf"
					    >
					        <section slot="pdf-content">
					        	<CompletionCertificate :user="user"></CompletionCertificate>
					        </section>
					    </vue-html2pdf>
				   	</div>
				</div>
				<div class="col-lg-12 text-center">
					<nuxt-link to="/user/dashboard" class="btn btn-info">
						No
					</nuxt-link>

					<!-- <base-button  type="danger" class="btn-fill m-0 mr-2" @click="goToDashboard()">No</base-button> -->
					<base-button  type="primary" class="btn-fill m-0" @click="generateReport()">Yes</base-button>
				</div>
			</div>
		</b-modal>

	</div>
</template>
<script>
import moment from 'moment'
import { validationMixin } from "vuelidate";
import { required, minLength, between  } from "vuelidate/lib/validators";
import CompletionCertificate from "@/components/CompletionCertificate";
import { mapState } from "vuex";

export default {
	middleware: 'user',
	mixins: [validationMixin],
	layout: 'user',
	components: {
		CompletionCertificate
	},
	data() {
		return {
			totalFaithAndFuelPoints:'',
			date:'',
			point:0,
			newEntry:{
				description:'',
				points:0,
			},
			editEntry:{
				id:'',
				description:'',
				points:'',
			},
			faithAndFuelTable:'',
			pointsLimit: 1
		};
	},
	validations: {
		newEntry: {
			description: {
				required
			},
			points: {
				required,
				between: between(1, 100)


			}
		}
	},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),
		totalPoints(){
			var total_points = 0
			for (var i = 0; i < this.faithAndFuelTable.length; i++) {
				total_points += this.faithAndFuelTable[i].points;
			}
			return total_points;
		}
	},
	methods: {
		openCongratulaionModal()
		{
			this.$refs['congratulation-modal'].show();
		},
		generateReport ()
		{
            this.$refs.html2Pdf.generatePdf()
			this.$refs['congratulation-modal'].hide();
        },
		printCertificate() {
			var user_id = 2;
            window.open(
                '/user/certificate/' + user_id,
                '_blank'
            );
        },
		showAllFaithFuelPoints()
		{
			this.pointsLimit = this.faithAndFuelTable.length;
		},
		showLatestFaithFuelPoint()
		{
			this.pointsLimit = 1;
		},
		showModal(item){
			this.editEntry.id = item.id;
			this.editEntry.description = item.description;
			this.editEntry.points = item.points;
			this.$refs['my-modal'].show()
		},
		async updateFaithAndFuelPoints(){
			
			var self = this;
			if ( this.totalPoints + parseInt(this.editEntry.points) <= 100 ) {
				await this.$axios.post("user/updateFaithAndFuelPoints",
					this.editEntry)
				.then(function (response)
				{
					
					self.$bvToast.toast('Points Table Updated Successfuly.', {
						variant: 'success',
						solid: true,
					});
					self.getAllFaithAndFuelPoints();
					self.cancelFaithAndFuelPoints();

				})
				.catch(function (error)
				{
					console.log('error');
					console.log(error.response);
					self.$bvToast.toast(error.response, {
						variant: 'danger',
						solid: true,
					});

				});
			}else{
				this.$bvToast.toast('Your total points should be less than 100', {
					variant: 'warning',
					solid: true,
				});
			}

		},
		cancelFaithAndFuelPoints(){
			this.$refs['my-modal'].hide()
		},
		async getAllFaithAndFuelPoints()
		{
			var self = this;
			await this.$axios.$get('/user/getAllFaithAndFuelPoints')
			.then(function (response)
			{
				self.faithAndFuelTable =  response;
				console.log('self.faithAndFuelTable');
				console.log(self.faithAndFuelTable);
				// this.faithAndFuelTable.push( response );
				var total_points = 0
				for (var i = 0; i < self.faithAndFuelTable.length; i++) {
					total_points += self.faithAndFuelTable[i].points;
				}
				self.totalFaithAndFuelPoints = total_points;
				// if (self.totalFaithAndFuelPoints == 100)
				// {
				// 	self.$refs['congratulation-modal'].show();
				// }
			})
			.catch(function (error) {
				console.log('error: ' + error);
				self.$bvToast.toast(error, {
					variant: 'danger',
					solid: true,
				});
			});

		},
		async addFaithAndFuelPoints()
		{
			this.$v.newEntry.$touch();
			if (this.$v.newEntry.$anyError) {
				return;
			}
			console.log(this.totalPoints);
			// console.log(this.newEntry.points);
			// console.log(document.getElementById('example-input-2').value);
			// console.log(this.totalPoints + this.newEntry.points);
	  
			if ( this.totalPoints + parseInt(this.newEntry.points) <= 100 ) {
				var self = this;
				await this.$axios.$post('/user/addFaithAndFuelPoints',this.newEntry)
				.then(function (response)
				{
					self.getAllFaithAndFuelPoints();
					return;
				})
				.catch(function (error) {
					self.$bvToast.toast(error, {
						variant: 'danger',
						solid: true,
					});
				});
			}
			else
			{
				this.$bvToast.toast('Your total points should be less than 100', {
					variant: 'warning',
					solid: true,
				});
			}
			this.newEntry.description = '';
			this.newEntry.points = '';
			this.$v.newEntry.$reset();
		},
		async deleteFaithAndFuelById(id)
		{
			var self = this;
			await this.$axios.$get('/user/deleteFaithAndFuelById/'+id)
			.then(function (response)
			{
				self.getAllFaithAndFuelPoints();
			})
			.catch(function (error) {
				self.$bvToast.toast(error, {
					variant: 'danger',
					solid: true,
				});
			});
		},
		validateState(description) {
			const { $dirty, $error } = this.$v.newEntry[description];
			return $dirty ? !$error : null;
		}
	},
	mounted() {
		this.getAllFaithAndFuelPoints();
		this.date = moment().format('LL');
	}
};
</script>
<style>
.header-container {
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
}

.faithAndFuelTable{
	box-shadow: 0 1px 15px 0 rgb(123 123 123 / 5%);
	padding:10px;
	border:1px solid #c0c4cc;
}
.faithAndFuelTable .date{
	color: #c0c4cc;
}
.faithAndFuelTable ul{
	list-style: none;
	display: flex;
	padding-left: 0px;
}
.faithAndFuelTable ul li{
	color: #c0c4cc !important;
	cursor: pointer;
	border-bottom: 1px solid transparent;
}
.faithAndFuelTable ul li:hover{
	border-bottom: 1px solid #c0c4cc;
}
.bg-image{
	/*width:100vw;*/
	height: 100%;
	/*height: calc(100vh - 300px);*/
	margin: 0;
	/*background: url('~/assets/videos/waterfalls-at-plitvice-national-park-in-croatia.mp4');
	background-repeat: no-repeat;
	background-size: 100% 100%;
	background-attachment: fixed;*/
}
#videoBG {
	position:fixed;
	z-index: 0;
}
@media (min-aspect-ratio: 16/9) {
	#videoBG {
		width:100%;
		height: auto;
	}
}
@media (max-aspect-ratio: 16/9) {
	#videoBG { 
		width:auto;
		height: 100%;
	}
}
@media (max-width: 767px) {
	#videoBG {
		display: none;
	}
	.bg-image {
		background: url('~/assets/videos/waterfalls-at-plitvice-national-park-in-croatia-poster.png');
		background-size: cover;
		height: 100%;
	}
}
</style>