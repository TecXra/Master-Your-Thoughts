// import axios from 'axios';
import Unsplash from 'unsplash-js';

export default function ({$unsplash, redirect}) {

	const unsplash = new Unsplash({
	  applicationId: "wx3y2JRWA1vYrHEVbo_x0wgPS8k2jk2xNwkeJwxJiL0",
	  secret: "tjnhl0pQIpofCGSmEfAQbcYtdVjn7iU6jhGvTdq1bnw",
	  callbackUrl: "{CALLBACK_URL}"
	});

	Vue.prototype.$unsplash = unsplash;
}

