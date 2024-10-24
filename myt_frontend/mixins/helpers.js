import Vue from "vue";

Vue.mixin({
	methods: {
		testFoo() {
			alert("testfoo");
		},
		testFoo2() {
			alert("testfoo2");
		},
	},
});
