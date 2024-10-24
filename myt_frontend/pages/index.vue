<template>
	<div>
		<nav class="navbar">
			<div class="navbar p-2 d-flex justify-content-between">
				<img src="~/assets/images/logo/logo.png" class="nav-img" />

				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link login-link text-primary" href="/login">Login</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="main-img">
			<div class="text text-center main-text rounded shadow-lg p-4">
				<h2>
					Master The Moment
				</h2>
				<br />
				<h4>
					<p>
						Your Step-by-Step Guide to Manifest:<br />
						*Abundance * Success * Freedom<br />
						All-inclusive Complete System!
					</p>
				</h4>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row my-5 px-3">
				<div class="col-lg-12">
					<h2 class="text-center main-heading">
						Master The Moment
					</h2>
					<p class="text-center my-2 mb-4">
						It doesn’t matter what attempts you tried previously to better your life that didn’t turn out
						the way you had hoped. This system is complete and will work for you. Master The Moment offers a 60 day money back guarantee so there is no risk in trying this program.
					</p>
				</div>

				<div class="col-lg-3 col-md-6 col-sm-6 mb-sm-4">
					<div class="boot-camp-points h-100">
						<img class=" rounded shadow" src="~/assets/images/Capture.jpg" />
						<p class="text-center boot-camp-para">
							Is a Uniquely Designed Self-paced Online Class that walks with you through the manifestation
							process..
						</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 mb-sm-4">
					<div class="boot-camp-points h-100">
						<img class=" rounded shadow" src="~/assets/images/Capture.jpg" />
						<p class="text-center boot-camp-para">
							Provides all of the information that you need to level up your life, and unlock the key to a
							triumphant future..
						</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 mb-sm-4">
					<div class="boot-camp-points h-100">
						<img class=" rounded shadow" src="~/assets/images/Capture.jpg" />
						<p class="text-center boot-camp-para">
							There is no guesswork, and you will not have to fill in the blanks.
						</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 mb-sm-4">
					<div class="boot-camp-points h-100">
						<img class=" rounded shadow" src="~/assets/images/Capture.jpg" />
						<p class="text-center boot-camp-para">Simply follow along to make this program work</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid philosophy-section py-5">
			<div class="container text-center">
				<div class="row">
					<div class="col-lg-12">
						<h2 class="main-heading mb-4">
							Our Philosophy
						</h2>
						<p class="text-white">
							Here at Master The Moment we believe that people are moving away from a place
							where they work for others to one of self-employment. We believe that if most people move
							towards Entrepreneurship whole systems will change and shift to accommodate this type of
							movement, and It will benefit people everywhere. Those who do not choose to move towards
							self-employment will also have much more than they have now because they will be in higher
							demand. That would allow for all to flourish, and change the situation of the majority of
							the wealth being in the hands of the top 1% of people.
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bar py-2">
			<div class="container d-flex justify-content-between">
				<p class="text-muted mb-0">
					masterthemoment.net
				</p>
				<div class="icons">
					<i class="fab fa-facebook text-muted fa-2x mx-2"></i>
					<i class="fab fa-twitter text-muted fa-2x mx-2"></i>
					<i class="fab fa-google-plus text-muted fa-2x mx-2"></i>
					<i class="fab fa-instagram text-muted fa-2x mx-2"></i>
					<i class="fas fa-rss text-muted fa-2x mx-2"></i>
				</div>

				<!-- <span><img class="icon-facebook" src="~/assets/images/social-icons/icon-facebook.svg"></span>
				<span><img class="icon" src="~/assets/images/social-icons/icon-twitter.svg"></span>
				<span><img class="icon" src="~/assets/images/social-icons/icon-instagram.svg"></span>
				<span><img class="icon" src="~/assets/images/social-icons/rss-solid.svg"></span> -->
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
	middleware: "guest",
	layout: "home",
	name: "homepage",
	components: {},
	data() {
		return {};
	},
	computed: {
		...mapGetters(["isAuthenticated", "loggedInUser"]),
	},
};
</script>
<style>
.navbar {
	background-color: white;
	top: 0px;
}
.nav-img {
	width: 150px;
	margin-left: 100px;
}
.login-link {
	color: black;
	margin-right: 100px;
	font-weight: 700;
}
.login-link:hover {
	color: black;
	opacity: 0.5;
}
.main-img {
	background-image: url(~/assets/images/Website-Image_New-1440-x-960.webp);
	height: 100vh;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center;
	display: flex;
	justify-content: center;
	align-items: center;
}
.main-text {
	background-color: #00003c;
}
.main-heading {
	color: #b79327 !important;
}
.philosophy-section {
	background-color: #00003c;
}
.footer-bar {
	background-color: #171717;
}
.boot-camp-points {
	display: flex;
	flex-direction: column;
	align-items: center;
	border: 1px solid;
	border-radius: 10px;
	padding: 40px;
}
.boot-camp-points img {
	margin-bottom: 10px;
}

.boot-camp-points p {
	color: #00003c;
	font-weight: 600;
	text-align: center;
}
.boot-camp-para {
	color: #00003c;
}
.main-text {
	background-color: #f9fafbe6;
}
</style>
