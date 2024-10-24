<template>
	<b-card class="mb-0">
		<b-card-text>
			<div class="row">
				<div class="col-lg-12 mb-2">
					<div class="form-group mb-0">
						<label for="client_id">
							Client identifier
						</label>
						<input type="text" v-model="videoApiData.client_id" id="client_id" class="form-control">
					</div>
				</div>
				<div class="col-lg-12 mb-2">
					<div class="form-group mb-0">
						<label for="client_secret">
							Client secrets
						</label>
						<input type="text" v-model="videoApiData.client_secret" id="client_secret" class="form-control">
					</div>
				</div>
				<div class="col-lg-12 mb-2">
					<div class="form-group mb-0">
						<label for="personal_access_token">
							Personal Access Token
						</label>
						<input type="text" v-model="videoApiData.personal_access_token" id="personal_access_token" class="form-control">
					</div>
				</div>
			</div>
		</b-card-text>
		<template #footer>
			<div class="text-right">
				<button class="btn btn-primary" :disabled="isValid">Update</button>
			</div>
		</template>
	</b-card>
</template>
<script>
	export default{
		data()
		{
			return {
				videoApiData: ''
			}
		},
		computed: {
			isValid()
			{
				if (this.videoApiData.client_id == '' || this.videoApiData.client_secret == '' || this.videoApiData.personal_access_token == '')
				{
					return true;
				}
				return false;
			}
		},
		mounted()
		{
			this.getVideoApiData();
		},
		methods: {
			async getVideoApiData()
			{
				let url = 'admin/getVideoApiData';
				var self = this;
				await this.$axios.$get(url)
				.then(function (response)
				{
					console.log('getVideoApiData response');
					console.log(response);
					self.videoApiData = response;
				})
				.catch(function (error) {
					self.$bvToast.toast(error, {
						variant: 'danger',
						solid: true,
					});
				});
			}
		}
	}
</script>