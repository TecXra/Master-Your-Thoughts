<template>
	<div class="certificate-wrapper">
		<div class="ribbon ribbon-top-left"><span></span></div>
    	<div class="certificate-container">
    		<div class="certificate-inner-container">
    			<img src="~/assets/images/logo.png" height="100" width="200" class="website-logo" />
    			<img src="~/assets/images/proof-of-authunticity.png" height="190" width="150" class="proof-of-authunticity-image" />
    			<div class="content-container">
					<h1 class="certificate-heading">
						Certificate of Completion
					</h1>
					<h3 class="certificate-paragraph">
						Proudly Awarded to
					</h3>
					<h2 class="student-name-heading">
						{{user.name}}
					</h2>
					<h3 class="certificate-paragraph">
						For Excellence, Commitment and dedication towards Successfully
						<br>
						Completing Master Your Thoughts Boot Camp,
						<br>
						this {{getCurrentDate}}
					</h3>
					<h2 class="stamp-bar">
						____________________
					</h2>
					<h3 class="certificate-website-name">
						Master Your Thoughts Boot Camp
					</h3>
    			</div>
			</div>
    	</div>
	</div>
</template>
<script>
import moment from 'moment'
	export default{
		props: ['user'],
		data() {
			return {
				currentDate: null
			}
		},
		computed: {
			getCurrentDate()
			{
				return moment().format("MMMM DD, YYYY");
			}
		}
	}
</script>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Italianno&display=swap');

.certificate-wrapper
{
	padding: 20px;
	background-color: #ffffff;
	position: relative;
}
.certificate-container
{
	clip-path: polygon(2% 0%, 98% 0%, 100% 5%, 100% 95%, 98% 100%, 4% 105%, 0px 95%, 0px 5%) !important;
	/*clip-path: polygon(10% 0, 90% 0, 100% 10%, 100% 90%, 90% 100%, 10% 100%, 0 90%, 0 10%);*/
	/*clip-path: polygon(1% 0, 99% 0, 100% 10%, 100% 90%, 99% 100%, 1% 100%, 0 90%, 0 10%);*/
	background: #b17a23;
	padding: 5px;
}
.certificate-inner-container
{
	padding: 20px 40px;
	clip-path: polygon(2% 0%, 98% 0%, 100% 5%, 100% 95%, 98% 100%, 4% 105%, 0px 95%, 0px 5%) !important;
	/*clip-path: polygon(10% 0, 90% 0, 100% 10%, 100% 90%, 90% 100%, 10% 100%, 0 90%, 0 10%);*/
	/*clip-path: polygon(1% 0, 99% 0, 100% 10%, 100% 90%, 99% 100%, 1% 100%, 0 90%, 0 10%);*/
	background: #fdffe6;
}
.website-logo
{
	position: absolute;
	top: 5%;
	right: 3%;
}
.proof-of-authunticity-image
{
	position: absolute;
	bottom: 5%;
	right: 3%;
}
.content-container
{
	text-align: center;
}
.certificate-heading
{
	font-size: 70px;
	font-weight: bold;
	margin-top: 10%;
}
.student-name-heading
{
	/*font-family: cursive;*/
	font-family: 'Italianno', cursive;
	font-size: 75px;
	margin: 0;
}
.certificate-paragraph
{
	color: #b17a23 !important;
	font-weight: bold;
	letter-spacing: 1px;
	margin: 0;
}
.stamp-bar
{
	margin-top: 5%;
}
.certificate-website-name
{
	color: #b17a23 !important;
	font-weight: bold;
	letter-spacing: 1px;
	margin-top: 8%;	
	margin-bottom: 7%;	
}
/* ------------- */
/* ribbon styles */
/* ------------- */
.certificate-inner-container {
  /*position: relative;*/
  /*max-width: 600px;*/
  /*width: 90%;*/
  /*height: 400px;*/
  /*background: #fff;*/
  /*box-shadow: 0 0 15px rgba(0,0,0,.1);*/
}

/* common */
.ribbon {
  width: 250px;
  height: 250px;
  overflow: hidden;
  position: absolute;
	z-index: 1;
	top: 0;
	left: 0;
}
/* .ribbon::before {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 0px solid #2980b9;
} */
/* .ribbon::after {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 5px solid #2980b9;
} */
.ribbon span {
  position: absolute;
  display: block;
  width: 275px;
  padding: 30px 0;
  background-color: #efde70;
  /*box-shadow: 0 5px 10px rgba(0,0,0,.1);*/
  color: #fff;
  font: 700 18px/1 'Lato', sans-serif;
  /*text-shadow: 0 1px 1px rgba(0,0,0,.2);*/
  /*text-transform: uppercase;*/
  text-align: center;
}

/* top left*/
/* .ribbon-top-left {
  top: 0px;
  left: 0px;
} */
.ribbon-top-left::before,
.ribbon-top-left::after {
  border-top-color: transparent;
  border-left-color: transparent;
}
/* .ribbon-top-left::before {
  top: 0;
  right: 0;
} */
/* .ribbon-top-left::after {
  bottom: 0px;
  left: 0px;
	z-index: 0;
	height: 20px
} */
.ribbon-top-left span {
  right: 36px;
  top: 46px;
  transform: rotate(-45deg);
}


</style>