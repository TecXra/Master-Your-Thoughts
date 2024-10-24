<template>
	<div>
		<nav class="navbar">
			<div class="navbar p-2 d-flex justify-content-between">
				<a href="/">
					<img src="~/assets/images/logo/logo.png" class="nav-img" />
				</a>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row vh-100">
				<div class="col-lg-6 offset-lg-3 my-auto">
					<!-- <b-card title="Welcome!" img-src="~/assets/images/img-2.webp" class="shadow-lg" img-alt="Image" img-top> -->
					<b-card img-src="~/assets/images/img-2.webp" class="shadow-lg" body-class="p-0" img-alt="Image" img-top>
						<!-- <b-card-text> -->
							<!-- Please Click Login button to proceed. -->
							<!-- Provides all of the information that you need to level up your life, and unlock the key to a triumphant future. -->
						<!-- </b-card-text> -->
						<template #footer>
							<!-- <base-button native-type="submit" type="primary" class="login-btn" @click="wpSocialLogin('masteryourthoughts.net')"> -->
							<div class="row">
								<div class="col text-center">
									<base-button native-type="submit" type="primary" class="px-5" @click="wpSocialLogin(providerURL)">
										Login
									</base-button>
								</div>
							</div>
							<!-- <div class="row border-top mt-2">
								<div class="col text-center mt-2">
									<nuxt-link to="/admin/authenticate" class="font-weight-bold h4 text-primary">
										Admin Login
									</nuxt-link>
								</div>
							</div> -->
							<!-- <base-button native-type="submit" type="info" class="btn-block" @click="Adminlogin()">
								Admin Login
							</base-button> -->

							<!-- <base-button native-type="submit" type="primary" class="login-btn" @click="Adminlogin()">
								Admin Login
							</base-button>
							<base-button native-type="submit" type="success" class="login-btn" @click="wpSocialLogin('wordpress.local')">
								User Login
							</base-button> -->
						</template>
					</b-card>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	layout: "clean",
	middleware: "guest",

	components: {},
	data() {
		return {
			providerURL: process.env.providerURL,
		};
	},
	computed: {},
	methods: {
		wpSocialLogin(provider) {
			let url = `${process.env.baseUrl}auth/login/wp/${provider}`;
      // console.log(provider)
			window.location.href = url;
		},
		Adminlogin() {
			this.$router.push("/admin/authenticate");
			// window.location.href = 'http://mytbackend.local/login';
		},
		Userlogin() {
			this.$router.push("/user/dashboard");
		},
	},
	mounted() {},
};
</script>
<style lang="scss" scoped>
@import "~@/assets/sass/dashboard/custom/variables";

.navbar {
	background-color: white;
	top: 0px;
}
.nav-img {
	width: 150px;
	margin-left: 100px;
}

.bc-img {
	height: 300px;
	background-image: url("~/assets/images/img-1.jpg");
	background-repeat: no-repeat;
	background-origin: content-box;
	background-position: center;
	background-size: cover;
	border-radius: 5px;

	margin-top: 40px;
	background-color: $golden;
	background-blend-mode: multiply;
}

.login-btn {
	width: 200px;
	margin-left: auto;
	margin-right: auto;
}

</style>
