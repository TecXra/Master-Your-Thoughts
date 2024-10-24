import Vue from "vue";

import MyUpload from "vue-image-crop-upload";

import VueParticles from "vue-particles";
import InlineDatePicker from "vuejs-datepicker";

import Gravatar from "vue-gravatar";
Vue.component("v-gravatar", Gravatar);

Vue.component("MyUpload", MyUpload);
Vue.component("InlineDatePicker", InlineDatePicker);

Vue.use(VueParticles);

import TimeCountdown from "~/components/TimeCountdown";
Vue.component("time-countdown", TimeCountdown);

// import moment from 'moment';
// Vue.use(moment);
// Vue.component("moment", moment);

// import VueCropper from 'vue-cropper';
// Vue.use(VueCropper)


import VueRx from 'vue-rx'
import VuejsClipper from 'vuejs-clipper'
// install vue-rx
Vue.use(VueRx);
// install vuejs-clipper
Vue.use(VuejsClipper);

import VueHtml2pdf from 'vue-html2pdf'
Vue.use(VueHtml2pdf);

import Multiselect from "vue-multiselect";
Vue.component("multiselect", Multiselect);
