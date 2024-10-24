<template>
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
      <div class="row">
        <!-- point of faith and fuel card -->
        <div class="col-lg-12 text-left">
          <card class="blue-gradient">
            <template slot="header">
              <h4
                class="mb-0 cursor-pointer text-white"
                @click="goToPointsOfFaithAndFuel"
              >
                Points of Faith and Fuel
              </h4>
              <h3 class="card-title mt-2 d-flex justify-content-between">
                <span class="text-white">
                  Current Points:
                  <b>{{ totalFaithAndFuelPoints }}</b>
                </span>
                <span class="text-white"> Goal: 100 Points </span>
              </h3>
            </template>
          </card>
        </div>

        <!-- unit info cards -->
        <div class="col-lg-6 text-left">
          <card class="green-gradient mb-4">
            <template slot="header">
              <h4 class="mb-0 text-white">Completed</h4>
              <h3 class="card-title mt-2">
                <span class="text-white">
                  <i class="tim-icons icon-check-2 text-success"></i>
                  Unit {{ unitStats.completed }}
                </span>
              </h3>
            </template>
          </card>
        </div>
        <div class="col-lg-6 text-left">
          <card class="upcoming-card mb-4">
            <template slot="header">
              <h4 class="mb-0 text-white">Up-Coming</h4>
              <h3 class="card-title mt-2">
                <span class="text-white">
                  <i class="tim-icons icon-bullet-list-67 text-info"></i>
                  Unit {{ unitStats.upComing }}
                </span>
              </h3>
            </template>
          </card>
        </div>
        <div class="col-lg-6 text-left mb-4">
          <card
            class="blue-gradient h-100 d-flex justify-content-center"
            ref="inProgressUnitCard"
          >
            <template slot="header">
              <h4 class="mb-0 text-white">In-Progress Unit</h4>
              <h3 class="card-title mt-2">
                <span class="text-white">
                  <i class="tim-icons icon-app text-primary"></i>
                  Unit {{ unitStats.inProgress.unit.number }}
                </span>
              </h3>
            </template>
          </card>
        </div>

        <div class="col-lg-6 text-left mb-4">
          <div
            class="card py-4 d-flex justify-content-center align-items-center"
            v-if="showQuestionLoader"
          >
            <i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
            <div
              v-if="
                unitStats.inProgress.unit.number !== 'N/A' &&
                unitStats.inProgress.unit.number !== null
              "
            >
              <time-countdown
                type="PracticeCheck"
                :user-id="user.id"
                v-on:TimeElapsed="QuestionTimeElapsedHandler"
              ></time-countdown>
            </div>

            <time-countdown
              type="VideoReview"
              :user-id="user.id"
              v-on:TimeElapsed="VideoTimeElapsedHandler"
            ></time-countdown>
          </div>

          <div
            class="card golden-gradient h-100 p-2 d-flex justify-content-center"
            v-else
          >
            <div
              class="d-flex flex-column justify-content-center"
              ref="inProgressQuestionCard"
              id="inProgressQuestionCard"
              v-if="!isQuestionTimerActive && !showQuestionLoader"
            >
              <h4 class="mb-3 px-1 unit-text-heading text-center">
                <span
                  v-if="
                    !showQuestionLoader &&
                    unitStats.inProgress.unit.number == 'N/A'
                  "
                >
                  <img :src="unitCompletedImage" height="25" width="25" />
                  <!-- <i class="tim-icons icon-button-power text-info"></i> -->
                  <!-- All Units Completed from 7.1 to 4.2 -->
                  All Units Completed
                </span>

                <span v-else>
                  {{ unitStats.inProgress.unit.text }}
                </span>
                <!-- In-Progress Question -->
              </h4>
              <nuxt-link
                :to="'/user/unit/' + userUnitInitialDetail.unit.number"
                class="btn btn-info w-75 blue-gradient px-0 mx-auto"
                v-if="userUnitInitialDetail.status == 'pending'"
              >
                Start Practice
              </nuxt-link>

              <nuxt-link
                :to="'/user/unit/' + userUnitInitialDetail.unit.number"
                v-if="userUnitInitialDetail.status == 'working'"
                class="btn btn-info w-75 blue-gradient px-0 mx-auto"
              >
                Continue Practice
              </nuxt-link>
            </div>
            <div v-else>
              <h4
                class="text-center text-white mb-2 unit-text-heading card-headerg"
              >
                <span> Practice Questions - Currently Working </span>
              </h4>
              <p class="card-title mt-2 text-center">
                <span style="color: #2b97f9">
                  <i class="fas fa-hourglass-half fa-lg text-info"></i>
                  Will be available shortly
                </span>
              </p>
              <time-countdown
                type="PracticeCheck"
                :user-id="user.id"
                v-on:TimeElapsed="QuestionTimeElapsedHandler"
              ></time-countdown>
            </div>
            <!--            <div class="card golden-gradient h-100 mb-0 py-2"-->
            <!--                 v-else>-->
            <!--              <time-countdown-->
            <!--                  type="PracticeCheck"-->
            <!--                  :user-id="user.id"-->
            <!--                  v-on:TimeElapsed="QuestionTimeElapsedHandler"-->
            <!--              ></time-countdown>-->
            <!--            </div>-->
          </div>
        </div>

        <!-- <div class="col-lg-6 text-left">
          <card class="question-card-left py-1">
            <template slot="header">
              <h4 class="mb-0 text-white">Next Practice Question</h4>
              <h3 class="card-title mt-2 w-100 d-flex justify-content-between align-items-center">
                <small class="text-white font-weight-light">
                  Next Question {{ unitStats.inProgress.unit.number }}.{{
                    unitStats.inProgress.question.number
                  }}
                </small>
                <i class="tim-icons icon-minimal-right text-white"></i>
              </h3>
            </template>
          </card>
        </div> -->

        <!-- video review cards -->
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12 text-center" v-if="showVideoLoader">
              <div
                class="card py-4 d-flex justify-content-center align-items-center"
              >
                <i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
              </div>
            </div>
            <div class="col-lg-12" v-else>
              <div class="row">
                <div
                  class="col-lg-12"
                  v-if="unitStats.inProgress.unit.number < 7"
                >
                  <div
                    class="card p-4 d-flex justify-content-center align-items-center text-center"
                  >
                    <p
                      class="mb-0 py-1 font-weight-bold"
                      style="color: #2b97f9"
                    >
                      The Daily Video Review will start after the Unit 6
                      Practice Check Questions close.
                      <!-- Video Questions will be available after Unit 4. -->
                    </p>
                  </div>
                </div>
                <div class="col-lg-12" v-else>
                  <div class="row">
                    <div
                      class="col-lg-6 mb-4"
                      v-if="lastVideoQuestionId != null"
                    >
                      <div
                        class="card golden-gradient h-100 text-center p-2 d-flex justify-content-center align-items-center"
                      >
                        <h4 class="mb-3 text-white">
                          Daily Video Review - Previous
                        </h4>
                        <nuxt-link
                          :to="
                            '/user/last-video-review-question/' +
                            lastVideoQuestionId
                          "
                          class="btn btn-info w-75 blue-gradient px-0"
                        >
                          Play Previous Video
                        </nuxt-link>
                      </div>
                    </div>
                    <div
                      :class="
                        lastVideoQuestionId != null
                          ? 'col-lg-6 mb-4'
                          : 'col-lg-12 mb-4'
                      "
                    >
                      <div
                        class="card blue-gradient h-100 text-center p-2 d-flex justify-content-center align-items-center"
                        v-if="
                          !isVideoTimerActive &&
                          inProgressVideoQuestionId != null
                        "
                      >
                        <h4 class="mb-3 text-white">
                          Daily Video Review - Current
                        </h4>
                        <nuxt-link
                          :to="
                            '/user/video-review-question/' +
                            inProgressVideoQuestionId
                          "
                          class="btn btn-primary w-75 golden-gradient"
                        >
                          Play Video
                        </nuxt-link>
                      </div>
                      <div
                        class="card blue-gradient h-100 text-center d-flex justify-content-center align-items-center"
                        v-else
                      >
                        <h4 class="text-white text-center px-1">
                          Daily Video Review - Current
                        </h4>
                        <p class="card-title mt-2">
                          <span class="text-white">
                            <i
                              class="fas fa-hourglass-half fa-lg text-primary"
                            ></i>
                            Will be available shortly
                          </span>
                        </p>
                        <time-countdown
                          type="VideoReview"
                          :user-id="user.id"
                          v-on:TimeElapsed="VideoTimeElapsedHandler"
                        ></time-countdown>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-lg-6">
          <div class="card py-4 d-flex justify-content-center align-items-center" v-if="showVideoLoader">
            <i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
          </div>
          <div v-else>
            <div class="card p-4 d-flex justify-content-center align-items-center text-center"v-if="unitStats.inProgress.unit.number < 4">
              <p class="mb-0 py-1">
                Video Questions will be available after Unit 3.
              </p>
            </div>
            <div v-else>
              <div class="card d-flex flex-column justify-content-around align-items-center" v-if="!isVideoTimerActive || inProgressVideoQuestionId != null">
                <div v-if="showLastVideoButton">
                  <nuxt-link :to="'/user/video-review-question/' + lastVideoQuestionId" class="btn btn-info btn-block">
                    Play Last Video
                  </nuxt-link>
                </div>
                <div>
                  <nuxt-link :to="'/user/video-review-question/' + inProgressVideoQuestionId" class="btn btn-success btn-block">
                    <span v-if="showLastVideoButton"> Play Next Video </span>
                    <span v-else> Play Video </span>
                  </nuxt-link>
                </div>
              </div>
              <div class="card" v-else>
                <p class="text-center mb-2">
                  Next Video available after:
                </p>
                <time-countdown type="VideoReview" :user-id="user.id" v-on:TimeElapsed="VideoTimeElapsedHandler"></time-countdown>
              </div>
            </div>
          </div>
        </div> -->

        <!-- <div class="col-lg-6 text-left">
          <card class="question-card-left py-1">
            <template slot="header">
              <h4 class="mb-0 text-white text-right">Next Video Question</h4>
              <h3 class="card-title mt-2 w-100 d-flex justify-content-between align-items-center">
                <i class="tim-icons icon-minimal-left text-white"></i>
                <small class="text-white text-right font-weight-light">
                  Next Question {{ unitStats.inProgress.unit.number }}.{{
                    unitStats.inProgress.question.number
                  }}
                </small>
              </h3>
            </template>
          </card>
        </div> -->

        <div class="col-lg-12">
          <div class="card p-2 dashboard-calendar">
            <h4 class="mb-0 progess-question-card text-white p-2">
              Boot Camp Calendar
            </h4>
            <!-- <full-calendar :user-id="user.id" :auth-user-time-zone="authUserTimeZone"></full-calendar> -->
            <full-calendar
              :user-id="user.id"
              :zone="user.time_zone_name"
            ></full-calendar>
            <!-- <boot-camp-calendar left="title" center="" right="today prev,next"></boot-camp-calendar> -->
            <!-- <boot-camp-calendar left="" center="" right=""></boot-camp-calendar> -->

            <!-- <b-calendar hide-header block class="border rounded p-2" :date-info-fn="dateClass" :highlighted="highlightedDates" locale="en-US"></b-calendar> -->
            <!-- <button class="btn btn-primary btn-sm" @click="goToBootCampCalendar">
              Calendar Detail
            </button> -->
          </div>
        </div>

        <!-- continue button -->
        <!-- <div class="col-lg-12">
          <div class="card p-2">
            <nuxt-link
              :to="'/user/unit/' + userUnitInitialDetail.unit.number"
              class="btn btn-info btn-block"
              v-if="userUnitInitialDetail.status == 'pending'">
              Start Practice
            </nuxt-link>

            <nuxt-link
              :to="'/user/unit/' + userUnitInitialDetail.unit.number"
              v-if="userUnitInitialDetail.status == 'working'"
              class="btn btn-success btn-block">
              Continue Practice
            </nuxt-link>

            <nuxt-link to="/user/unit/1" v-if="userUnitInitialDetail.status == 'completed'" class="btn btn-default btn-block">
              Review
            </nuxt-link>

            <div class="d-flex justify-content-around align-items-center" v-if="showVideoButtons">
              <div v-if="showLastVideoButton">
                <nuxt-link :to="'/user/video-review-question/' + lastVideoQuestionId" class="btn btn-info btn-block">
                  Play Last Video
                </nuxt-link>
              </div>
              <div v-if="inProgressVideoQuestionId == null">
                <span>
                  No Next Video Available Yet.
                </span>
              </div>
              <div v-else>
                <nuxt-link :to="'/user/video-review-question/' + inProgressVideoQuestionId" class="btn btn-success btn-block">
                  <span v-if="showLastVideoButton"> Play Next Video </span>
                  <span v-else> Play Video </span>
                </nuxt-link>
              </div>
            </div>
            <div v-if="unitStats.inProgress.unit.number == 'N/A'">
              <nuxt-link to='/user/video-review-question/' class="btn btn-golden btn-block">
                Play All Videos
              </nuxt-link>
            </div>
          </div>
        </div> -->
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <!-- <div class="unsuplash-img rounded">
        <div class="card quote">
          <div v-if="quote">
            <q><p>{{ quote }}</p></q>
            <p class="author_name">~{{ author }}</p>
          </div>
          <div v-else>
            <p>
              Coming Soon
            </p>
          </div>
        </div>
      </div> -->

      <card class="quote-card">
        <div
          class="d-flex justify-content-center align-items-center"
          v-if="showQuestionLoader"
        >
          <i class="fa fa-spinner fa-pulse fa-3x text-white"></i>
        </div>
        <div v-else>
          <div v-if="quote">
            <p class="mb-0">{{ quote }}</p>
            <p class="author_name text-right">~ {{ author }}</p>
            <!-- <h3 class="card-title mt-2 d-flex justify-content-between"> -->

            <!-- <span class="text-white">
                Current Points:
                <b>{{ totalFaithAndFuelPoints }}</b>
              </span> -->
            <!-- <span class="text-white">
                Goal: 100 Points
              </span> -->
            <!-- </h3> -->
          </div>
          <div v-else>
            <h3 class="text-center mb-0 mt-3">Coming Soon</h3>
          </div>
        </div>
      </card>

      <div class="card p-2">
        <h4 class="mb-2">
          The Visualizer
          <i
            class="tim-icons icon-settings text-primary cursor-pointer"
            @click="goToSlideShowSettings"
          ></i>
        </h4>
        <div
          v-if="mediaList.length == 0"
          class="p-5 d-flex justify-content-center align-items-center"
        >
          <p class="mb-0">No Image added yet.</p>
        </div>
        <carousel-view
          :interval="slideShowInterval"
          :media-list="mediaList"
          v-else
        ></carousel-view>
      </div>

      <div class="card">
        <a
          href="https://mytbootcamp.com/student-dashboard/"
          target="_blank"
          class="btn blue-gradient btn-info btn-block"
        >
          Main Site Dashboard
        </a>
      </div>
    </div>
  </div>
</template>
<script>
import unitCompletedImage from "@/static/img/Icon-For-All-Units-Completed.png";

import CarouselView from "@/components/SlideShow/CarouselView";

import { mapState } from "vuex";
import QuestionDetailId from "~/components/VideoReview/ResponseCard.vue";

export default {
  middleware: "user",
  layout: "user",
  components: {
    QuestionDetailId,
    CarouselView,
  },
  data() {
    return {
      quotesLoopingDuration: 60000,
      quotesLoopingInterval: null,
      unitCompletedImage: unitCompletedImage,
      leftColStyles: {
        height: "0px",
      },
      totalFaithAndFuelPoints: 0,
      response: "",
      showQuoteLoader: true,
      quote: "",
      author: "",
      slideShowInterval: 0,
      mediaList: [],
      unitStats: {
        completed: null,
        upComing: null,
        inProgress: {
          unit: {
            id: null,
            number: null,
          },
          question: {
            id: null,
            number: null,
          },
        },
      },
      userUnitInitialDetail: {
        inProgress: false,
        unit: {
          id: null,
          name: null,
          number: null,
        },
      },
      showVideoButtons: false,
      showLastVideoButton: false,
      lastVideoQuestionId: null,
      inProgressVideoQuestionId: null,
      isQuestionTimerActive: false,
      showQuestionLoader: false,
      apiWaitLoader: false,
      isVideoTimerActive: false,
      showVideoLoader: false,
      authUserTimeZone: "UTC",
    };
  },
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },
  methods: {
    matchHeight() {
      // let height = this.$refs.inProgressQuestionCard.clientHeight;
      console.log("height");
      console.log(this.$refs.inProgressQuestionCard);
      // console.log(height);
      // this.$refs.inProgressUnitCard.clientHeight = height + 'px';

      var heightString =
        document.getElementById("inProgressQuestionCard").clientHeight + "px";

      console.log("heightString");
      console.log(heightString);
      this.leftColStyles.height = heightString;
    },
    QuestionTimeElapsedHandler(val) {
      this.isQuestionTimerActive = val;
      console.log(this.isQuestionTimerActive + " Practice timer");
      // alert('QuestionTimeElapsedHandler');
    },

    VideoTimeElapsedHandler(val) {
      this.isVideoTimerActive = val;
      console.log("this.isVideoTimerActive");
      console.log(this.isVideoTimerActive);
      if (!this.isVideoTimerActive) {
        this.getAvailableVideoQuestionId();
      }
    },
    async getUserPracticeStatus() {
      this.showQuestionLoader = true;
      var self = this;
      await this.$axios
        .get("/user/getUserPracticeStatus?user_id=" + this.user.id)
        .then(function (response) {
          // console.log("user/getUserPracticeStatus");
          // console.log(response.data);
          if (response.data == 1) {
            // self.isQuestionTimerActive = true;
            setTimeout(() => {
              self.showQuestionLoader = false;
            }, 2000);

            // console.log("Timer ends here");
          }
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getUserUnitStats() {
      this.showVideoLoader = true;
      var self = this;
      await this.$axios
        .get("/user/getUserUnitStats?user_id=" + this.user.id)
        .then(function (response) {
          self.unitStats = response.data;
          self.showVideoLoader = false;
          if (
            self.unitStats.inProgress.unit.number > 3 ||
            self.unitStats.inProgress.unit.number == "N/A"
          ) {
            self.showVideoButtons = true;
            self.getAvailableVideoQuestionId();
          }
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },

    async getUserUnitInitialDetail() {
      this.showQuestionLoader = true;
      var self = this;
      await this.$axios
        .get("/user/getUserUnitInitialDetail?user_id=" + this.user.id)
        .then(function (response) {
          self.userUnitInitialDetail = response.data;
          setTimeout(() => {
            self.showQuestionLoader = false;
          }, 2000);
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },

    async getAvailableVideoQuestionId() {
      this.showVideoLoader = true;
      var self = this;
      await this.$axios
        .get("/user/getUserAvailableVideoQuestionId?user_id=" + this.user.id)
        .then(function (response) {
          if (response.data.inProgress_video != null) {
            self.inProgressVideoQuestionId = response.data.inProgress_video.id;
            // console.log( "In Progress question id: " + self.inProgressVideoQuestionId);
          }

          if (response.data.last_video == null) {
            self.showLastVideoButton = false;
          } else {
            self.showLastVideoButton = true;
            self.lastVideoQuestionId = response.data.last_video.id;
          }
          self.showVideoLoader = false;
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getInProgressUnitByUserId() {
      var self = this;
      await this.$axios
        .get("/user/getInProgressUnitByUserId?user_id=" + this.user.id)
        .then(function (response) {
          // console.log("getInProgressUnitByUserId");
          // console.log(response.data);
          self.$nuxt.$emit("inProgressUnitData", response.data);
          if (response.data == "") {
            // console.log("showVideoButtonsOnSideBar");
            self.$nuxt.$emit("showVideoButtonsOnSideBar");
          }
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    goToBootCampCalendar() {
      this.$router.push("/user/calendar");
    },
    goToSlideShowSettings() {
      this.$router.push("/user/slideshow");
    },
    goToPointsOfFaithAndFuel() {
      this.$router.push("/user/faithandfuel");
    },
    async getAllFaithAndFuelPoints() {
      var self = this;
      await this.$axios
        .$get("/user/getAllFaithAndFuelPoints")
        .then(function (response) {
          for (var i = 0; i < response.length; i++) {
            self.totalFaithAndFuelPoints += response[i].points;
          }
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getAuthUserSlideShowImages() {
      this.mediaList = [];
      var self = this;
      await this.$axios
        .$get("user/getAuthUserSlideShowImages?user_id=" + this.user.id)
        .then(function (response) {
          self.mediaList = response;
        })
        .catch(function (error) {
          // console.log("error: " + error);
          self.$bvToast.toast("getAuthUserSlideShowImages", {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getAuthUserSlideShowSettings() {
      let url = "user/getAuthUserSlideShowSettings?user_id=" + this.user.id;
      var self = this;
      await this.$axios
        .$get(url)
        .then(function (response) {
          // console.log("getAuthUserSlideShowSettings");
          // console.log(response);
          self.slideShowInterval = response.slide_show_interval * 1000;
        })
        .catch(function (error) {
          // console.log(error);
          self.$bvToast.toast("getAuthUserSlideShowSettings", {
            variant: "danger",
            solid: true,
          });
        });
    },
    
    async getUserQuotesLog() {
      let url = "user/getQuotesLog";
      this.showQuoteLoader = true;
      var self = this;
      await this.$axios
      .get(url)
      .then(function(response) {
        console.log('response');
        console.log(response.data);
        // if (response.data == true || response.data == 'true')
        // {
          // self.getRandomQuote(); 
        // }
        // else
        // {
          self.quote = response.data.quote;
          self.author = response.data.author;
          self.showQuoteLoader = false;
        // }
      })
      .catch(function(error) {
        self.$bvToast.toast(error, {
          variant: "danger",
          solid: true,
        });
      });
    },

    async getQuotesLoopingDuration() {
      let url = "admin/getQuotesLoopingDuration";
      var self = this;
      await this.$axios
      .get(url)
      .then(function(response) {
        self.loopingDuration = response.data;
        self.quotesLoopingDuration = self.loopingDuration.duration * 60000;
        self.quotesLoopingInterval = setInterval(self.getRandomQuote, self.quotesLoopingDuration);
      })
      .catch(function(error) {
        self.$bvToast.toast(error, {
          variant: "danger",
          solid: true,
        });
      });
    },

    async getRandomQuote() {
      this.showQuoteLoader = true;
      let url = "user/getRandomQuote";
      var self = this;
      await this.$axios
        .$get(url)
        .then(function (response) {
          if (response) {
            self.response = response;
            self.quote = response.quote;
            self.author = response.author;
            self.showQuoteLoader = false;
          }
        })
        .catch(function (error) {
          self.showQuoteLoader = true;
          // console.log(error);
          self.$bvToast.toast("getRandomQuote", {
            variant: "danger",
            solid: true,
          });
        });
    },
    async getUserTimeZone() {
      alert("adsfasd");
      var self = this;
      await this.$axios
        .$get("user/getUserTimeZone")
        .then(function (response) {
          self.authUserTimeZone = response.time_zone;
          // console.log("self.authUserTimeZone");
          // console.log(self.authUserTimeZone);
        })
        .catch(function (error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
  },
  mounted() {
    this.getUserQuotesLog();
    // this.getQuotesLoopingDuration();
    this.getUserPracticeStatus();
    this.getAllFaithAndFuelPoints();
    // this.getRandomQuote();
    this.getAuthUserSlideShowImages();
    this.getAuthUserSlideShowSettings();
    this.getUserUnitStats();
    this.getUserUnitInitialDetail();
    this.getInProgressUnitByUserId();
  },
  destroyed: function() {
    clearInterval(this.quotesLoopingInterval);
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

.question-card-left {
  background: rgb(191, 166, 4) !important;
  background: linear-gradient(
    90deg,
    rgba(191, 166, 4, 1) 0%,
    rgba(214, 189, 32, 1) 0%,
    rgba(224, 214, 150, 1) 100%
  ) !important;
}

.dashboard-calendar .card {
  margin-bottom: 0px;
}

.dashboard-calendar .card .card-body {
  padding: 0px;
}

.quote-card {
  background: rgb(191, 166, 4) !important;
  background: linear-gradient(
    90deg,
    rgba(191, 166, 4, 1) 0%,
    rgba(214, 189, 32, 1) 0%,
    rgba(224, 214, 150, 1) 100%
  ) !important;
  height: 91px;
}

.quote-card p {
  color: #ffffff;
}

.unit-text-heading span {
  color: #2b97f9;
}

/*.active-days::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-size: small;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f118";
    color: #F8CA27;
}*/
.dashboard-calendar {
  .fc .fc-toolbar.fc-header-toolbar {
    // margin-bottom: 0.5em;
    border-radius: 0px;
  }

  .fc .fc-event-title::after,
  .fc .fc-daygrid-day-top,
  .fc .fc-button .fc-icon {
    font-size: small;
  }

  .fc .fc-toolbar-title {
    font-size: medium;
  }

  .fc .fc-button {
    padding: 0.2em 0.5em;
  }

  .fc .fc-daygrid-body-unbalanced .fc-daygrid-day-events {
    min-height: 1em;
  }

  .fc .fc-daygrid-day-top {
    display: block;
    text-align: right;
  }

  .fc .fc-daygrid-body,
  .fc .fc-scrollgrid-section table {
    width: 100% !important;
  }
}

/* width */
.dashboard-calendar .fc .fc-scroller::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.dashboard-calendar .fc .fc-scroller::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.dashboard-calendar .fc .fc-scroller::-webkit-scrollbar-thumb {
  background: $golden;
}

/* Handle on hover */
.dashboard-calendar .fc .fc-scroller::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.active-days::after {
  display: inline-block;
  font-style: normal;
  font-variant: normal;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  font-size: small;
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  content: "\f058";
  color: #15b161;
}

.b-calendar-nav {
  display: none !important;
}

/*.unsuplash-img{
  background-image: url("https://source.unsplash.com/350x350/?quotes");
  height: 300px;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;

  display: flex;
    justify-content: center;
    align-items: center;
}*/
.quote {
  /*width: 80%;*/
  padding: 30px;
  border-left: 15px solid goldenrod;
}

q {
  quotes: "“" "”" "‘" "’";
}

q::before {
  content: open-quote;
  height: 0px;
  font-size: 110px;
  position: absolute;
  top: -51px;
  color: #cccc;
}

q::after {
  content: close-quote;
  height: 0px;
  color: transparent;
  position: absolute;
  right: 40px;
  font-size: 110px;
  top: 15px;
}

.author_name {
  font-style: italic;
  margin-left: auto;
  font-weight: bold;
  // color: #000000 !important;
  // color: #cccc !important;
}
</style>
