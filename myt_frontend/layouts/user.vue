<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <!-- <notifications></notifications> -->
    <side-bar
      :background-color="sidebarBackground"
      :short-title="$t('sidebar.shortTitle')"
      :title="$t('sidebar.title')"
    >
      <template slot="links">
        <sidebar-item
          :link="{
            name: $t('sidebar.dashboard'),
            icon: 'fa fa-home',
            path: '/user/dashboard',
            bg: 'dashboardBg',
            border: 'dashboardBorder',
          }"
        >
        </sidebar-item>
        <sidebar-item
          :link="{
            name: $t('sidebar.slideshow'),
            icon: 'fa fa-images',
            path: '/user/slideShow',
            bg: 'slideshowBg',
            border: 'slideshowBorder',
          }"
        >
        </sidebar-item>
        <sidebar-item
          :link="{
            name: $t('sidebar.wallpaper'),
            icon: 'fa fa-image',
            path: '/user/wallpaper',
            bg: 'wallpaperBg',
            border: 'wallpaperBorder',
          }"
        >
        </sidebar-item>
        <sidebar-item
          :link="{
            name: $t('sidebar.faithandfuel'),
            icon: 'fa fa-bullseye',
            path: '/user/faithandfuel',
            bg: 'faithandfuelBg',
            border: 'faithandfuelBorder',
          }"
        >
        </sidebar-item>
        <sidebar-item
          :link="{
            name: $t('sidebar.calendar'),
            icon: 'fa fa-calendar-alt',
            // path: '/user/calendar/detail',
            path: '/user/calendar',
            bg: 'calendarBg',
            border: 'calendarBorder',
          }"
        >
        </sidebar-item>

        <!-- <sidebar-item
					:link="{
						name: $t('sidebar.harmonizer'),
						icon: 'fa fa-user',
						path: '/user/harmonizer',
						bg: 'wallpaperBg',
						border: 'wallpaperBorder',
					}"
				>
				</sidebar-item> -->
        <sidebar-item
          :link="{
            name: $t('sidebar.banking'),
            icon: 'fa fa-university',
            path: '/user/banking',
            bg: 'wallpaperBg',
            border: 'wallpaperBorder',
          }"
        >
        </sidebar-item>
      </template>
      <!-- <template slot="links">
				<ul class="list-unstyled" v-if="isUnitInProgress">
					<li v-for="(unit, index) in userUnitsList" :key="index" class="nuxt-link-active" :class="{ active: active_unit == unit.id }" @click="selectUnit(unit)">
						<nuxt-link :event="unit.number > inProgressUnitDetail.number ? '' : 'click'" :to="'/user/unit/' + unit.id">
							{{ unit.title }}
						</nuxt-link>
					</li>
				</ul>
				<ul class="list-unstyled" v-else>
					<li class="nuxt-link-active">
						<nuxt-link :to="'/user/video-review-question/' + lastVideoQuestionId" class="">
							Play Last Video
						</nuxt-link>
					</li>
					<li class="nuxt-link-active">
						<nuxt-link :to="'/user/video-review-question/' + inProgressVideoQuestionId" class="">
							Play Next Video
						</nuxt-link>
					</li>
				</ul>
			</template> -->
    </side-bar>
    <!--Share plugin (for demo purposes). You can remove it if don't plan on using it-->
    <sidebar-share
      :background-color.sync="sidebarBackground"
      :nav-background-color.sync="navbarBackground"
      :navbar-style.sync="navbarStyle"
    >
    </sidebar-share>
    <div class="main-panel" :data="sidebarBackground">
      <dashboard-navbar
        :navbar-background="navbarBackground"
        :navbar-style="navbarStyle"
      ></dashboard-navbar>
      <router-view name="header"></router-view>

      <div :class="{ content: !isFullScreenRoute }" @click="toggleSidebar">
        <zoom-center-transition :duration="200" mode="out-in">
          <!-- your content here -->
          <nuxt></nuxt>
        </zoom-center-transition>
      </div>
      <content-footer v-if="!isFullScreenRoute"></content-footer>
    </div>
    <LogoutOnInactive />
  </div>
</template>
<script>
// import '@/mixins/helpers'
import { mapState } from "vuex";

/* eslint-disable no-new */
import LogoutOnInactive from "@/components/LogoutOnInactive.vue";
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";
import SidebarShare from "@/components/Layout/SidebarSharePlugin";
function hasElement(className) {
  return document.getElementsByClassName(className).length > 0;
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`);
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className);
    }, 100);
  }
}

import DashboardNavbar from "@/components/Layout/DashboardNavbar.vue";
import ContentFooter from "@/components/Layout/ContentFooter.vue";
import DashboardContent from "@/components/Layout/Content.vue";
import { SlideYDownTransition, ZoomCenterTransition } from "vue2-transitions";

export default {
  components: {
    DashboardNavbar,
    ContentFooter,
    DashboardContent,
    SlideYDownTransition,
    ZoomCenterTransition,
    SidebarShare,
    LogoutOnInactive,
  },
  data() {
    return {
      active_question: 0,
      active_unit: 0,
      sidebarBackground: "golden",
      navbarBackground: "golden",
      collapsed: true,
      navbarStyle: true,
      userUnitsList: [],
      isUnitInProgress: true,
      inProgressVideoQuestionId: null,
      lastVideoQuestionId: null,
      inProgressUnitDetail: null,
    };
  },
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
    isFullScreenRoute() {
      return this.$route.path === "/maps/full-screen";
    },
  },
  methods: {
    selectUnit(unit) {
      if (unit.number <= this.inProgressUnitDetail.number) {
        this.active_unit = unit.id;
      } else {
        this.$bvToast.toast("You haven't completed the previous unit yet.", {
          variant: "warning",
          solid: true,
        });
      }
    },

    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
    initScrollbar() {
      let docClasses = document.body.classList;
      let isWindows = navigator.platform.startsWith("Win");
      if (isWindows) {
        // if we are on windows OS we activate the perfectScrollbar function
        initScrollbar("sidebar");
        initScrollbar("main-panel");
        initScrollbar("sidebar-wrapper");

        docClasses.add("perfect-scrollbar-on");
      } else {
        docClasses.add("perfect-scrollbar-off");
      }
    },

    async getUserUnitsList() {
      var self = this;
      await this.$axios
        .get("/user/getUserUnitsList")
        .then(function(response) {
          self.userUnitsList = response.data;
          for (let index = 0; index < self.userUnitsList.length; index++) {
            if (self.userUnitsList[index].active) {
              self.active_unit = self.userUnitsList[index].id;
              self.inProgressUnitDetail = self.userUnitsList[index];
            }
          }
        })
        .catch(function(error) {
          console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getAvailableVideoQuestionId() {
      var self = this;
      await this.$axios
        .get("/user/getUserAvailableVideoQuestionId?user_id=" + this.user.id)
        .then(function(response) {
          console.log("getUserAvailableVideoQuestionId user layout");
          console.log(response);

          if (response.data.inProgress_video != null) {
            self.inProgressVideoQuestionId = response.data.inProgress_video.id;
          }
          // self.inProgressVideoQuestionId = response.data.inProgress_video.id;

          if (response.data.last_video != null) {
            self.lastVideoQuestionId = response.data.last_video.id;
          }
          // self.lastVideoQuestionId = response.data.last_video.id;

          self.isUnitInProgress = false;
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
  mounted() {
    this.initScrollbar();
    this.getUserUnitsList();
    this.active_unit = this.$route.params.unitId;
  },
  created() {
    this.$nuxt.$on("showVideoButtonsOnSideBar", () => {
      this.getAvailableVideoQuestionId();
    });

    this.$nuxt.$on("inProgressUnitData", (eventData) => {
      this.active_unit = eventData.id;
      this.inProgressUnitDetail = eventData;
    });
  },
};
</script>
<style lang="scss">
.sidebar .nav li.active > a:not([data-toggle="collapse"]):before {
  top: 19px;
}
.sidebar-mini-icon {
  opacity: 0;
}
$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}

.main-panel .zoomIn {
  animation-name: zoomIn95;
}

@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}

.main-panel .zoomOut {
  animation-name: zoomOut95;
}
.dashboardBorder {
  border-left: 10px solid #0e43a9;
}
.slideshowBorder {
  border-left: 10px solid #00a43b;
}
.wallpaperBorder {
  border-left: 10px solid #580095;
}
.faithandfuelBorder {
  border-left: 10px solid #86002a;
}
.calendarBorder {
  border-left: 10px solid #c26602;
}

.dashboardBg {
  background-color: #0e43a9;
}
.slideshowBg {
  background-color: #00a43b;
}
.wallpaperBg {
  background-color: #580095;
}
.faithandfuelBg {
  background-color: #86002a;
}
.calendarBg {
  background-color: #c26602;
}
</style>
