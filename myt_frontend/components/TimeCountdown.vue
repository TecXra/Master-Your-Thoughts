<template>
	<div>
		<flip-countdown v-if="showTimer && deadLine" :deadline="deadLine" :showDays="false" :showHours="false" :showMinutes="false" :showSeconds="false" @timeElapsed="TimeElapsedHandler"></flip-countdown>
	</div>
</template>

<script>
import moment from 'moment';
import FlipCountdown from "vue2-flip-countdown";

export default {
	components: { FlipCountdown },
	name: "time-countdown",
	props: {
		type: {
			type: String,
			default: "PracticeCheck",
		},
		userId: {
			type: Number,
			default: null,
		},
    waitType: {
      type: String,
      default: "non-loader",
    }
	},
	data() {
		return {
			showTimer: false,
			deadLine: null,
		};
	},
	methods: {
    TimeElapsedHandler(val) {
      this.$emit("TimeElapsed", val);
      // if (type == 'PracticeCheck') {
      //   this.$emit("QuestionTimeElapsed", true);
      // }
      // if (type == 'VideoReview') {
      //   this.$emit("VideoTimeElapsed", true);
      // }
    },
		async getTimerDeadLine() {
			this.showTimer = false;

        // this.deadLine = null;
        if (this.userId != null) {
          var self = this;
          await this.$axios
              .get("/user/getTimerDeadLine?user_id=" + this.userId + "&type=" + this.type)
              .then(function(response) {
                if (response.data) {
                  console.log('Response: '+ response.data);
                  self.deadLine = moment.utc(response.data).local().format('YYYY-MM-DD HH:mm:ss');
                  console.log('current timer');
                  console.log(moment().format('YYYY-MM-DD HH:mm:ss'));
                  console.log('self.deadLine');
                  console.log(self.deadLine);
                  if (moment().format('YYYY-MM-DD HH:mm:ss') < self.deadLine) {
                    self.showTimer = true;
                    self.TimeElapsedHandler(true);
                  } else {
                    self.TimeElapsedHandler(false);
                  }
                }
              })
              .catch(function(error) {
                console.log("getTimerDeadLine");
                self.$bvToast.toast(error, {
                  variant: "danger",
                  solid: true,
                });
              });


        }

		},
	},

	mounted() {
    // console.clear();
		this.getTimerDeadLine();

	},
	watch: {
		userId(val) {
			this.getTimerDeadLine();
		},
	},
};
</script>
<style>
.flip-clock {
	padding: 0px !important;
  text-align: center;
  perspective: 600px;
  margin: 0 auto;
}
.flip-clock *,
.flip-clock *:before,
.flip-clock *:after {
  box-sizing: border-box;
}
.flip-clock__piece {
  display: inline-block;
  margin: 0 0.2vw;
}
@media (min-width: 1000px) {
  .flip-clock__piece {
    margin: 0 2px !important;
  }
}
.flip-clock__slot {
  font-size: 0.8rem !important;
  line-height: 2 !important;
  display: block !important;
  font-weight: bold !important;
  color: #FFF !important;
  /*
  //position: relative;
  //top: -1.6em;
  z-index: 10;
*/
}
.flip-card {
  display: block;
  position: relative;
  padding-bottom: 0.72em;
  font-size: 2.25rem;
  line-height: 0.95;
}
@media (min-width: 1000px) {
  .flip-clock__slot {
    font-size: 1.2rem;
  }
  .flip-card {
    font-size: 2rem !important;
  }
}
/*////////////////////////////////////////*/
.flip-card__top,
.flip-card__bottom,
.flip-card__back-bottom,
.flip-card__back::before,
.flip-card__back::after {
  display: block;
  height: 0.72em;
  color: #ffffff;
  /*color: #ccc;*/
  /*background: #222;*/
  background: #fff !important;
  padding: 0.23em 0.25em 0.4em;
  border-radius: 0.15em 0.15em 0 0;
  backface-visiblity: hidden;
  transform-style: preserve-3d;
  width: 1.8em;
}
.flip-card__bottom,
.flip-card__back-bottom {
  color: #FFF;
  position: absolute;
  top: 50%;
  left: 0;
  border-top: solid 1px #000;
  /*background: #393939;*/
  background: #ffffff !important;
  border-radius: 0 0 0.15em 0.15em;
  pointer-events: none;
  overflow: hidden;
  z-index: 2;
}
.flip-card__back-bottom {
  z-index: 1;
}
.flip-card__bottom::after,
.flip-card__back-bottom::after {
  display: block;
  margin-top: -0.72em;
}
.flip-card__back::before,
.flip-card__bottom::after,
.flip-card__back-bottom::after {
  content: attr(data-value);
}
.flip-card__back {
  position: absolute;
  top: 0;
  height: 100%;
  left: 0%;
  pointer-events: none;
}
.flip-card__back::before {
  position: relative;
  overflow: hidden;
  z-index: -1;
}
.flip .flip-card__back::before {
  z-index: 1;
  -webkit-animation: flipTop 0.3s cubic-bezier(0.37, 0.01, 0.94, 0.35);
          animation: flipTop 0.3s cubic-bezier(0.37, 0.01, 0.94, 0.35);
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  transform-origin: center bottom;
}
.flip .flip-card__bottom {
  transform-origin: center top;
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  -webkit-animation: flipBottom 0.6s cubic-bezier(0.15, 0.45, 0.28, 1);
          animation: flipBottom 0.6s cubic-bezier(0.15, 0.45, 0.28, 1);
}
@-webkit-keyframes flipTop {
  0% {
    transform: rotateX(0deg);
    z-index: 2;
  }
  0%,
  99% {
    opacity: 1;
  }
  100% {
    transform: rotateX(-90deg);
    opacity: 0;
  }
}
@keyframes flipTop {
  0% {
    transform: rotateX(0deg);
    z-index: 2;
  }
  0%,
  99% {
    opacity: 1;
  }
  100% {
    transform: rotateX(-90deg);
    opacity: 0;
  }
}
@-webkit-keyframes flipBottom {
  0%,
  50% {
    z-index: -1;
    transform: rotateX(90deg);
    opacity: 0;
  }
  51% {
    opacity: 1;
  }
  100% {
    opacity: 1;
    transform: rotateX(0deg);
    z-index: 5;
  }
}
@keyframes flipBottom {
  0%,
  50% {
    z-index: -1;
    transform: rotateX(90deg);
    opacity: 0;
  }
  51% {
    opacity: 1;
  }
  100% {
    opacity: 1;
    transform: rotateX(0deg);
    z-index: 5;
  }
}
</style>
