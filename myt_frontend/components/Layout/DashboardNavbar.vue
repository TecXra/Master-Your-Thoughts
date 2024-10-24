<template>
	<base-nav v-model="showMenu" class="navbar-absolute top-navbar" :type="navbarBackground" :transparent="navbarStyle">
		<div slot="brand" class="navbar-wrapper ">
			<div class="navbar-toggle d-inline" :class="{ toggled: $sidebar.showSidebar }">
				<button type="button" class="navbar-toggler" @click="toggleSidebar">
					<span class="navbar-toggler-bar bar1"></span>
					<span class="navbar-toggler-bar bar2"></span>
					<span class="navbar-toggler-bar bar3"></span>
				</button>
			</div>
			<!-- <a href="https://masteryourthoughts.net" target="_blank" class=" navbar-brand ml-xl-0 font-weight-bold">
				Master Your Thoughts
			</a> -->
			<!-- <nuxt-link :to="dashboardUrl" class="navbar-brand ml-xl-3 ml-5">
				Dashboard
			</nuxt-link> -->

			<!-- <a class="navbar-brand ml-xl-3 ml-5" href="/user/dashboard"> Dashboard </a> -->
			<!-- <a class="navbar-brand ml-xl-3 ml-5" href="#pablo">{{ routeName }}</a> -->
		</div>

		<!-- <ul class="border border-success mr-auto d-flex justify-content-center align-items-center"> -->
		<!-- <ul class="navbar-nav" :class="$rtl.isRTL ? 'mr-auto' : 'ml-auto'" v-if="showUserNavBarOptions">
			<li class="nav-link cursor-pointer text-primary h4 my-2 mx-3">
				<nuxt-link to="/user/slideShow" class="btn btn-link btn-primary">
					SlideShow
				</nuxt-link>
			</li>
			<li class="nav-link cursor-pointer text-primary h4 my-2 mx-3">
				<nuxt-link to="/user/wallpaper" class="btn btn-link btn-primary">
					Wallpaper
				</nuxt-link>
			</li>
			<li class="nav-link cursor-pointer text-primary h4 my-2 mx-3">
				<nuxt-link to="/user/faithandfuel" class="btn btn-link btn-primary">
					Point of faith & fuel
				</nuxt-link>
			</li>
			<li class="nav-link cursor-pointer text-primary h4 my-2 mx-3">
				<nuxt-link to="/user/calendar" class="btn btn-link btn-primary">
					Calendar
				</nuxt-link>
			</li>
		</ul> -->
		<ul class="navbar-nav" :class="$rtl.isRTL ? 'mr-auto' : 'ml-auto'">
			<!-- <div class="search-bar input-group" @click="searchModalVisible = true">
				<button
					class="btn btn-link"
					id="search-button"
					data-toggle="modal"
					data-target="#searchModal"
				>
					<i class="tim-icons icon-zoom-split"></i>
				</button>
			</div>
			<modal :show.sync="searchModalVisible" class="modal-search" id="searchModal" :centered="false" :show-close="true">
				<input slot="header" v-model="searchQuery" type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH"/>
			</modal> -->
			<!-- <base-dropdown
				tag="li"
				:menu-on-right="!$rtl.isRTL"
				title-tag="a"
				title-classes="nav-link"
				class="nav-item"
			>
				<template slot="title">
					<div
						class="notification d-none d-lg-block d-xl-block"
					></div>
					<i class="tim-icons icon-bell-55"></i>
					<p class="d-lg-none">New Notifications</p>
				</template>
				<li class="nav-link">
					<a href="#" class="nav-item dropdown-item">
						Mike John responded to your email
					</a>
				</li>
				<li class="nav-link">
					<a href="#" class="nav-item dropdown-item">
						You have 5 more tasks
					</a>
				</li>
				<li class="nav-link">
					<a href="#" class="nav-item dropdown-item">
						Your friend Michael is in town
					</a>
				</li>
				<li class="nav-link">
					<a href="#" class="nav-item dropdown-item">
						Another notification
					</a>
				</li>
				<li class="nav-link">
					<a href="#" class="nav-item dropdown-item">
						Another one
					</a>
				</li>
			</base-dropdown> -->
			<base-dropdown
				tag="li"
				:menu-on-right="!$rtl.isRTL"
				title-tag="a"
				class="nav-item"
				title-classes="nav-link"
				menu-classes="dropdown-navbar"
			>
				<template slot="title">
					<div class="photo" v-if="user">
						<v-gravatar :email="user.email" :size="25" default-img="identicon" class="rounded-circle" />
					</div>
					<b class="caret d-none d-lg-block d-xl-block"></b>
					<p class="d-lg-none">Log out</p>
				</template>
				<li class="nav-link text-center" v-if="user">
					{{ user.name }}
				</li>

				<li class="nav-link" v-if="user">
					<a href="/admin/profile" v-if="user.user_type == 0" class="nav-item dropdown-item">Profile</a>
					<!-- <a href="/user/profile" v-if="user.user_type == 1" class="nav-item dropdown-item">Profile</a> -->
				</li>
				<li class="nav-link" v-if="user">
					<a href="/admin/settings" class="nav-item dropdown-item" v-if="user.user_type == 0">Settings</a>
					<!-- <a href="/user/settings" class="nav-item dropdown-item" v-if="user.user_type == 1">Settings</a> -->
				</li>
				<div class="dropdown-divider"></div>
				<li class="nav-link" v-if="loggedIn">
					<a href="#" class="nav-item dropdown-item" @click="logout">Log out</a>
				</li>
			</base-dropdown>
		</ul>
	</base-nav>
</template>
<script>
import { CollapseTransition } from "vue2-transitions";
import { BaseNav, Modal } from "@/components";

import { mapState } from "vuex";

export default {
	name: "dashboard-navbar",
	components: {
		CollapseTransition,
		BaseNav,
		Modal,
	},
	props: {
		navbarStyle: {
			type: Boolean,
			default: true,
			description: "Navbar style (true|false)",
		},
		navbarBackground: {
			type: String,
			default: "golden",
			validator: (value) => {
				let acceptedValues = [
					"",
					"blue",
					"golden",
					"purple",
					"yellow",
					"primary",
					"blue_shade_one",
					"blue_shade_two",
					"blue_shade_three",
					"blue_shade_four",
					"blue_shade_five",
				];
				return acceptedValues.indexOf(value) !== -1;
			},
			description: "Navbar background color (blue|golden|purple|yellow)",
		},
	},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),

		routeName() {
			const { path } = this.$route;
			let parts = path.split("/");
			if (parts == ",") {
				return "Dashboard";
			}
			return parts.map((p) => this.capitalizeFirstLetter(p)).join(" ");
		},
		isRTL() {
			return this.$rtl.isRTL;
		},
		showUserNavBarOptions() {
			if (this.$auth.user.user_type == 1) {
				return true;
			}
			return false;
		},
		dashboardUrl() {
			// console.log(this.$auth.user);
			if (this.$auth.user.user_type == 0) {
				return "/admin/dashboard";
			}
			if (this.$auth.user.user_type == 1) {
				return "/user/dashboard";
			}
			return "/";
		},
	},
	data() {
		return {
			activeNotifications: false,
			showMenu: false,
			searchModalVisible: false,
			searchQuery: "",
		};
	},
	mounted() {},
	methods: {
		capitalizeFirstLetter(string) {
			if (!string || typeof string !== "string") {
				return "";
			}
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		closeDropDown() {
			this.activeNotifications = false;
		},
		toggleSidebar() {
			this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
		},
		toggleMenu() {
			this.showMenu = !this.showMenu;
		},
		logout() {
			this.$auth
				.logout()
				.then(() => {
					return this.$router.push("/login");
				})
				.catch((e) => {
					// this.$auth.logout();
					return this.$router.push("/");
				});
		},
	},
};
</script>
<style scoped>
.top-navbar {
	top: 0px;
}
.btn:not(:disabled):not(.disabled).active:focus,
.btn:not(:disabled):not(.disabled):active:focus,
.show > .btn.dropdown-toggle:focus {
	box-shadow: 2px 2px 6px rgb(0 0 0 / 40%) !important;
	color: black !important;
}
</style>
