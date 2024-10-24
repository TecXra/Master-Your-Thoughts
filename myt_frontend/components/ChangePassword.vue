<template>
	<div class="card mb-4">
		<div class="card-header font-weight-bold">
			Change Password
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="form-group">
						<label for="name">Password:</label>
						<input type="text" placeholder="*********" id="name" class="form-control" v-model="form.old_password">
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="form-group">
						<label for="name">New Password:</label>
						<input type="text" id="name" placeholder="*********" class="form-control" v-model="form.password">
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="form-group">
						<label for="name">Confirm Password:</label>
						<input type="text" id="name" placeholder="*********" class="form-control" v-model="form.password_confirmation">
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-right">
					<b-button variant="primary" @click="updatePasswordInfoById()" >
					<i v-if="isLoading" class="fa fa-spinner fa-pulse" ></i>
					Update
				</b-button>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">

import { mapState } from 'vuex';
export default {
	props: ['userInfo'],
	data() {
		return {
			isLoading:false,
			form:{
				id:'',
				old_password:'',
				password:'',
				password_confirmation:'',
			}
		}
	},


	computed: {
		...mapState('auth', ['loggedIn', 'user']),
	},

	methods: {
		async updatePasswordInfoById(){
			event.preventDefault()
		this.isLoading = true;
			var self = this;

			await this.$axios.post("admin/updatePasswordInfoById",
				this.form)
			.then(function (response)
			{

				if (response.data == 1) {


					self.$bvToast.toast('Password Updated Successfuly.', {
						variant: 'success',
						solid: true,
					});


				}
				if (response.data == 0) {


					self.$bvToast.toast('Old Password is incorrect', {
						variant: 'danger',
						solid: true,
					});


				}


			})
			.catch(function (error)
			{
				console.log('error');
				console.log(error.response.data.errors);

				Object.entries(error.response.data.errors).map((key) => 
					(
						self.$bvToast.toast(key[1][0] , {
							variant: 'danger',
							solid: true,
						})
						)            			
					);	
			});
			this.isLoading = true;
		},

	},
	mounted(){
		this.form.id = this.user.id;
	},



};
</script>