import Vue from 'vue'
import moment from 'moment'

Vue.filter('formatDate', value => {
	if (!value) return ''
	return moment(value).format('LL');
})

Vue.filter('dateTime', value => {
	if (!value) return ''
	return moment(value).format('MMM D, YYYY hh:mm A')
})

Vue.filter('formatTime', value => {
	if (!value) return ''
	return moment(value,'HH:mm').format('hh:mm A');
})

Vue.filter('to2Decimal', value => {
    return value.toFixed(2);
})


Vue.filter('convertAmountToCommas', value => {
    // return value.toFixed(2);
	const numFor = Intl.NumberFormat('en-US');
	const new_for = numFor.format(value);
	return new_for;
})
