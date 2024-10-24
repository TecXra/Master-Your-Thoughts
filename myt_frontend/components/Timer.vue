<template>
	<span id="time" v-html="time">TIME</span>
</template>
<script>
	export default {
		name: 'timer',  
		props: {
			startTimer: null,
		},
		data(){
			return{
				state: "started",
				currentTime: Date.now(),
				interval: null
			}
		},
		watch:{
		},
		mounted: function() {
			console.log('mounted this.startTimer');
			console.log(this.startTimer);
			console.log(this.currentTime);
			this.interval = setInterval(this.updateCurrentTime, 1000);
		},
		destroyed: function() {
			clearInterval(this.interval)
		},
		computed: {
			time: function() {
				return this.hours + ':' + this.minutes + ':' + this.seconds;
			},
			milliseconds: function() {
				return this.currentTime - this.startTimer;
			},
			hours: function() {
				var lapsed = this.milliseconds;
				var hrs = Math.floor((lapsed / 1000 / 60 / 60));
				return hrs >= 10 ? hrs : '0' + hrs;
			},
			minutes: function() {
				var lapsed = this.milliseconds;
				var min = Math.floor((lapsed / 1000 / 60) % 60);
				return min >= 10 ? min : '0' + min;
			},
			seconds: function() {
				var lapsed = this.milliseconds;
				var sec = Math.ceil((lapsed / 1000) % 60);
				return sec >= 10 ? sec : '0' + sec;
			}
		},
		methods: {
			start: function ()
			{
				this.interval = setInterval(this.updateCurrentTime, 1000);
			},
			reset: function() {
				this.state = "started";
				this.currentTime = Date.now();
			},
			pause: function() {
				this.state = "paused";
			},
			resume: function() {
				this.state = "started";
			},
			updateCurrentTime: function() {
				console.log('this.startTimer updateCurrentTime');
				console.log(this.startTimer);
				console.log(this.currentTime);
				if (this.state == "started")
				{
					this.currentTime = Date.now();
				}
			}
		}
	};

</script>