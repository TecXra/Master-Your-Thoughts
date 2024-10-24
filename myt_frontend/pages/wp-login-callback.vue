<template>
	<!-- <div class="loader"></div> -->
	<!-- <p>Please wait while we're logging you in...</p> -->
	<!-- <div class="container"> -->
	<div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
		<div class="loader" v-if="loading"></div>
		<p v-if="loading">Please wait while we're logging you in...</p>
		<div class="row w-100">
			<div class="col-lg-6 offset-lg-3 w-100">
				<b-card v-if="!loading && !isExist">
					<h3 class="text-center">
						Add your region information
					</h3>
					<b-form>
						<!-- <b-form-group label-for="country">
							<b-form-input v-model="form.country" id="country" type="text" placeholder="Country" required></b-form-input>
						</b-form-group>
						<b-form-group label-for="state">
							<b-form-input v-model="form.state" id="state" type="text" placeholder="State" required></b-form-input>
						</b-form-group>
						<b-form-group label-for="city">
							<b-form-input v-model="form.city" id="city" type="text" placeholder="City" required></b-form-input>
						</b-form-group>
						<b-form-group label-for="time_zone">
							<b-form-input v-model="form.time_zone" id="time_zone" type="text" placeholder="Time-Zone" required></b-form-input>
						</b-form-group> -->

						<div class="form-group" v-if="timeZoneList.length > 0">
							<label class="typo__label">Select Time Zone</label>
							<multiselect v-model="form.time_zone" deselect-label="Can't remove this value" track-by="description" label="relative_to_GMT" :custom-label="utcOffsetTime" placeholder="Select one" :options="timeZoneList" :searchable="true" :allow-empty="false">
								<template slot="singleLabel" slot-scope="{ option }">
									<strong>{{ option.relative_to_GMT }}</strong> is <strong> {{ option.description }} - {{option.name}}</strong>
								</template>
							</multiselect>
							<!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
						</div>
						<div class="text-center my-3">
							<p>
								If you need to find your Time Zone
							</p>
							<p>
								The link below will open in a new window
							</p>
							<a href="https://www.timeanddate.com/time/zones/" target="_blank">https://www.timeanddate.com/time/zones/</a>
						</div>

						<b-button @click="saveUserInitialData" variant="primary" :disabled="isValid">
							<i class="fa fa-spinner fa-pulse" v-if="btnLoader"></i>
							<span v-else> Submit </span>
						</b-button>
					</b-form>
				</b-card>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	layout: "clean",

	data() {
		return {
			// value: null,
			timeZoneList: [],
			options: [
				// { name: 'ECT', description: 'European Central Time', relative_to_GMT: 'GMT+1:00' },
				// { name: 'EET', description: 'Eastern European Time', relative_to_GMT: 'GMT+2:00' },
				// { name: 'ART', description: '(Arabic) Egypt Standard Time', relative_to_GMT: 'GMT+2:00' },
				// { name: 'EAT', description: 'Eastern African Time', relative_to_GMT: 'GMT+3:00' },
				// { name: 'MET', description: 'Middle East Time', relative_to_GMT: 'GMT+3:30' },
				// { name: 'NET', description: 'Near East Time', relative_to_GMT: 'GMT+4:00' },
				// { name: 'PLT', description: 'Pakistan Lahore Time', relative_to_GMT: 'GMT+5:00' },
				// { name: 'IST', description: 'India Standard Time', relative_to_GMT: 'GMT+5:30' },
				// { name: 'BST', description: 'Bangladesh Standard Time', relative_to_GMT: 'GMT+6:00' },
				// { name: 'VST', description: 'Vietnam Standard Time', relative_to_GMT: 'GMT+7:00' },
				// { name: 'CTT', description: 'China Taiwan Time', relative_to_GMT: 'GMT+8:00' },
				// { name: 'JST', description: 'Japan Standard Time', relative_to_GMT: 'GMT+9:00' },
				// { name: 'ACT', description: 'Australia Central Time', relative_to_GMT: 'GMT+9:30' },
				// { name: 'AET', description: 'Australia Eastern Time', relative_to_GMT: 'GMT+10:00' },
				// { name: 'SST', description: 'Solomon Standard Time', relative_to_GMT: 'GMT+11:00' },
				// { name: 'NST', description: 'New Zealand Standard Time', relative_to_GMT: 'GMT+12:00' },
				// { name: 'MIT', description: 'Midway Islands Time', relative_to_GMT: 'GMT-11:00' },
				// { name: 'HST', description: 'Hawaii Standard Time', relative_to_GMT: 'GMT-10:00' },
				// { name: 'AST', description: 'Alaska Standard Time', relative_to_GMT: 'GMT-9:00' },
				// { name: 'PST', description: 'Pacific Standard Time', relative_to_GMT: 'GMT-8:00' },
				// { name: 'PNT', description: 'Phoenix Standard Time', relative_to_GMT: 'GMT-7:00' },
				// { name: 'MST', description: 'Mountain Standard Time', relative_to_GMT: 'GMT-7:00' },
				// { name: 'CST', description: 'Central Standard Time', relative_to_GMT: 'GMT-6:00' },
				// { name: 'EST', description: 'Eastern Standard Time', relative_to_GMT: 'GMT-5:00' },
				// { name: 'IET', description: 'Indiana Eastern Standard Time', relative_to_GMT: 'GMT-5:00' },
				// { name: 'PRT', description: 'Puerto Rico and US Virgin Islands Time', relative_to_GMT: 'GMT-4:00' },
				// { name: 'CNT', description: 'Canada Newfoundland Time', relative_to_GMT: 'GMT-3:30' },
				// { name: 'AGT', description: 'Argentina Standard Time', relative_to_GMT: 'GMT-3:00' },
				// { name: 'BET', description: 'Brazil Eastern Time', relative_to_GMT: 'GMT-3:00' },
				// { name: 'CAT', description: 'Central African Time', relative_to_GMT: 'GMT-1:00' }
				// { name: 'ART', Description: '(Arabic) Egypt Standard Time',	Relative_to_GMT: 'GMT+2:00' },
				// { name: 'AST', Description: 'Alaska Standard Time',	Relative_to_GMT: 'GMT-9:00' },
				// { name: 'AGT', Description: 'Argentina Standard Time', Relative_to_GMT: 'GMT-3:00' },
				// { name: 'ACT', Description: 'Australia Central Time', Relative_to_GMT: 'GMT+9:30' },
				// { name: 'AET', Description: 'Australia Eastern Time', Relative_to_GMT: 'GMT+10:00' },
				// { name: 'BST', Description: 'Bangladesh Standard Time', Relative_to_GMT: 'GMT+6:00' },
				// { name: 'BET', Description: 'Brazil Eastern Time', Relative_to_GMT: 'GMT-3:00' },
				// { name: 'CNT', Description: 'Canada Newfoundland Time', Relative_to_GMT: 'GMT-3:30' },
				// { name: 'CAT', Description: 'Central African Time', Relative_to_GMT: 'GMT-1:00' },
				// { name: 'CST', Description: 'Central Standard Time', Relative_to_GMT: 'GMT-6:00' },
				// { name: 'CTT', Description: 'China Taiwan Time', Relative_to_GMT: 'GMT+8:00' },
				// { name: 'EAT', Description: 'Eastern African Time', Relative_to_GMT: 'GMT+3:00' },
				// { name: 'EET', Description: 'Eastern European Time', Relative_to_GMT: 'GMT+2:00' },
				// { name: 'EST', Description: 'Eastern Standard Time', Relative_to_GMT: 'GMT-5:00' },
				// { name: 'ECT', Description: 'European Central Time', Relative_to_GMT: 'GMT+1:00' },
				// { name: 'GMT', Description: 'Greenwich Mean Time', Relative_to_GMT: 'GMT' },
				// { name: 'HST', Description: 'Hawaii Standard Time', Relative_to_GMT: 'GMT-10:00' },
				// { name: 'IST', Description: 'India Standard Time', Relative_to_GMT: 'GMT+5:30' },
				// { name: 'IET', Description: 'Indiana Eastern Standard Time', Relative_to_GMT: 'GMT-5:00' },
				// { name: 'JST', Description: 'Japan Standard Time', Relative_to_GMT: 'GMT+9:00' },
				// { name: 'MET', Description: 'Middle East Time', Relative_to_GMT: 'GMT+3:30' },
				// { name: 'MIT', Description: 'Midway Islands Time', Relative_to_GMT: 'GMT-11:00' },
				// { name: 'MST', Description: 'Mountain Standard Time', Relative_to_GMT: 'GMT-7:00' },
				// { name: 'NET', Description: 'Near East Time', Relative_to_GMT: 'GMT+4:00' },
				// { name: 'NST', Description: 'New Zealand Standard Time', Relative_to_GMT: 'GMT+12:00' },
				// { name: 'PST', Description: 'Pacific Standard Time', Relative_to_GMT: 'GMT-8:00' },
				// { name: 'PLT', Description: 'Pakistan Lahore Time', Relative_to_GMT: 'GMT+5:00' },
				// { name: 'PNT', Description: 'Phoenix Standard Time', Relative_to_GMT: 'GMT-7:00' },
				// { name: 'PRT', Description: 'Puerto Rico and US Virgin Islands Time', Relative_to_GMT: 'GMT-4:00' },
				// { name: 'SST', Description: 'Solomon Standard Time', Relative_to_GMT: 'GMT+11:00' },
				// { name: 'UTC', Description: 'Universal Coordinated Time', Relative_to_GMT: 'GMT' },
				// { name: 'VST', Description: 'Vietnam Standard Time', Relative_to_GMT: 'GMT+7:00' }
			],
			token: this.$route.query.token ? this.$route.query.token : null,
			form: {
				// country: null,
				// state: null,
				// city: null,
				time_zone: null,
			},
			isExist: false,
			loading: true,
			btnLoader: false,
		};
	},
	computed: {
		isValid() {
			if (
				// this.form.country == null ||
				// this.form.state == null ||
				// this.form.city == null ||
				this.form.time_zone == null ||
				this.btnLoader
			) {
				return true;
			}
			return false;
		},
	},
	mounted() {
		this.$auth.setToken("local", "Bearer " + this.token);
		this.$auth.setStrategy("local");
		this.$axios.setToken("Bearer " + this.token);
		this.checkAuthUserTimeZoneSetting();
		this.getAllTimeZonesList();
	},
	methods: {
		utcOffsetTime (timeZone) {
			// alert(JSON.stringify(timeZone.relative_to_GMT));
			return 'UTC ' + `${timeZone.relative_to_GMT}`
		},
		async getAllTimeZonesList()
		{
			let url = "/getAllTimeZonesList";
			var self = this;
			// this.loading = true;
			await this.$axios.$get(url).then(function(response) {
				console.log('response');
				console.log(response);
				self.timeZoneList = response;
				// self.loading = false;
			})
			.catch(function(error) {
				console.log("getAllTimeZonesList", error);
			});
		},
		async checkAuthUserTimeZoneSetting() {
			let url = "user/isAuthUserTimeZoneSettingExist";
			var self = this;
			this.loading = true;
			await this.$axios
				.$get(url)
				.then(function(response) {
					if (response == 1) {
						self.isExist = true;
						self.fetchUser();
						// self.$router.push('/');
					} else {
						self.isExist = false;
					}
					self.loading = false;
				})
				.catch(function(error) {
					console.log("checkAuthUserTimeZoneSetting", error);
				});
		},
		fetchUser() {
			this.$auth
				.fetchUser()
				.then(() => {
					return this.$router.push("/user/dashboard");
				})
				.catch((e) => {
					this.$auth.logout();
					return this.$router.push("/login");
				});
		},
		async saveUserInitialData() {
			// alert(JSON.stringify(this.form.time_zone));
			this.btnLoader = true;
			let url = "user/saveUserInitialData";
			var self = this;
			let payload = {
				// country: this.form.country,
				// state: this.form.state,
				// city: this.form.city,
				time_zone: this.form.time_zone,
			};
			await this.$axios.$post(url, payload).then(function(response) {
					self.btnLoader = false;
					self.fetchUser();
				})
				.catch(function(error) {
					// self.btnLoader = true;
					console.log("saveUserInitialData", error);
				});
		},
	},
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped>
.container {
	// height: calc(100vh - 50px);
}
.loader {
	margin: 20px auto;
	border: 8px solid #f3f3f3;
	border-radius: 50%;
	border-top: 8px solid #3b5998;
	border-bottom: 8px solid #3b5998;
	width: 60px;
	height: 60px;
	-webkit-animation: spin 1.2s linear infinite;
	animation: spin 1.2s linear infinite;
}
@-webkit-keyframes spin {
	0% {
		-webkit-transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(360deg);
	}
}
@keyframes spin {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
</style>
