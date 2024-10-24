<template>
	<div class="container-fluid admin-login-container">
		<div class="container">
			<div class="row vh-100 d-flex justify-content-center align-items-center">
				<div class="col-lg-4 d-flex justify-content-center align-items-center flex-column">
					<div class="row">
						<div class="col-lg-12 d-flex justify-content-center align-items-center">
							<h3 class="login-main-icon">
								<i class="fas fa-lock fa-2x"></i>
							</h3>
						</div>
					</div>
					<div class="login-form">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="amdin_email">
										Username or Email Address
									</label>
									<input type="email" class="form-control" id="amdin_email" v-model="adminForm.email" required>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="amdin_password">
										Password
									</label>
									<input type="password" class="form-control" id="amdin_password" v-model="adminForm.password" required>
								</div>
							</div>
							<div class="col-lg-12 d-flex justify-content-between align-items-center">
								<p class="forgetmenot">
									<input name="rememberme" type="checkbox" id="rememberme" value="forever">
									<label for="rememberme">Remember Me</label>
								</p>
								<button class="btn" :disabled="isLoading" @click="login">
		                            <i v-if="isLoading" class="fa fa-spinner fa-pulse"></i>
									Login
								</button>
							</div>
						</div>
					</div>
					<!-- <div class="card py-2 px-3">
						<div class="row">
							<div class="col-lg-12 d-flex justify-content-center align-items-center">
								<h3 class="mt-n5 py-3 w-25 rounded text-center bg-success">
									<i class="fas fa-lock text-white fa-2x"></i>
								</h3>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="amdin_email">
										Email
									</label>
									<input type="email" placeholder="Enter your Email" class="form-control" id="amdin_email" v-model="adminForm.email" required>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label for="amdin_password">
										Password
									</label>
									<input type="password" placeholder="Enter your Password" class="form-control" id="amdin_password" v-model="adminForm.password" required>
								</div>
							</div>
							<div class="col-lg-12 my-2">
								<button class="btn btn-primary btn-block" :disabled="isLoading" @click="login">
		                            <i v-if="isLoading" class="fa fa-spinner fa-pulse"></i>
									Login
								</button>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		layout: 'login',
		data() {
			return {
				adminForm: {
					email: '',
					password: ''
				},
            	isLoading:false,
			}
		},
		methods: {
	        async login() {
	            this.isLoading = true;
	            try {
	                await this.$auth.loginWith('local', {
	                    data: {
	                        email: this.adminForm.email,
	                        password: this.adminForm.password,
	                    }
	                })
	                if(this.$store.state.auth.user.user_type == 0){
	                    return this.$router.push(this.localePath('/admin/dashboard'));
	                }
	                this.isLoading = false;
	            } catch (e) {
	                console.log(e)
	                this.isLoading = false;
	            }
	        }
		}
	}
</script>
<style>
	.admin-login-container
	{
		background-color: blue !important;
	}
	.login-main-icon
	{
		background: white;
		padding: 15px 20px;
		border-radius: 50px;
		margin-bottom: 0px;
	}
	.login-main-icon .fa-lock:before
	{
		color: blue !important;
	}
	.login-form
	{
		margin-top: 25px;
		margin-left: 0;
		padding: 26px 24px 34px;
		font-weight: 400;
		overflow: hidden;
		background: #fff;
		border: 1px solid #c3c4c7;
		box-shadow: 0 1px 3px rgb(0 0 0 / 4%);
		width: 320px;
	}
	.login-form label
	{
		font-size: 14px;
		line-height: 1.5;
		display: inline-block;
		margin-bottom: 3px;
	}
	.login-form input[type=password],
	.login-form input[type=email]
	{
		background: #fff;
		font-size: 24px;
		line-height: 1.33333333;
		width: 100%;
		border-width: .0625rem;
		padding: .1875rem .3125rem !important;
		margin: 0 6px 16px 0;
		min-height: 40px;
		max-height: none;
	}
	.login-form input[type=checkbox]
	{
		font-size: 14px;
		border: 1px solid #8c8f94 !important;
		border-radius: 4px;
		background: #fff;
		color: #50575e;
		clear: none;
		cursor: pointer;
		display: inline-block;
		line-height: 0;
		height: 1rem;
		margin: -.25rem .25rem 0 0;
		outline: 0;
		padding: 0!important;
		text-align: center;
		vertical-align: middle;
		width: 1rem;
		min-width: 1rem;
		-webkit-appearance: none;
		box-shadow: inset 0 1px 2px rgb(0 0 0 / 10%);
		transition: .05s border-color ease-in-out;
	}
input[type=checkbox]:checked::before {
    content: url(data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2020%2020%27%3E%3Cpath%20d%3D%27M14.83%204.89l1.34.94-5.81%208.38H9.02L5.78%209.67l1.34-1.25%202.57%202.4z%27%20fill%3D%27%233582c4%27%2F%3E%3C%2Fsvg%3E);
    margin: -.1875rem 0 0 -.25rem;
    height: 1.3125rem !important;
    width: 1.3125rem !important;
}
input[type=checkbox]:checked::before, input[type=radio]:checked::before {
    float: left;
    display: inline-block;
    vertical-align: middle;
    width: 1rem;
    speak: never;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
	.login-form button
	{
		background: #135e96;
		border-color: #135e96;
		box-shadow: none;
		color: #fff !important;
		min-height: 32px;
		line-height: 2.30769231;
		padding: 0 12px;
		font-size: 13px;
		cursor: pointer;
		border-width: 1px;
		border-style: solid;
		-webkit-appearance: none;
		border-radius: 3px;
		white-space: nowrap;
		box-sizing: border-box;
	}
</style>