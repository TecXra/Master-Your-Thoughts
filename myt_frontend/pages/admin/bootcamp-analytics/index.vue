<template>
	<b-container fluid>
		<card>
			<b-row>
				<b-col lg="12">
					<b-tabs fill class="settings-tab" >
						<b-tab title="Activity" active>
							<activity-algo></activity-algo>
						</b-tab>
						<b-tab title="Chart Algo">
						<chart-algo></chart-algo>
						</b-tab>
					</b-tabs>
				</b-col>
			</b-row>
		</card>
	</b-container>
</template>
<script>
import ActivityAlgo from "~/components/Admin/ActivityAlgo.vue";
import ChartAlgo from "~/components/Admin/ChartAlgo.vue";

	import { mapState } from 'vuex'

	export default {
		middleware: 'admin',
		layout: 'admin',
		components: {
			ActivityAlgo,
			ChartAlgo
		},
		data() {
			return {
			}
		},
		computed: {
			...mapState('auth', ['loggedIn', 'user'])
		},
		methods: {	
		},
		mounted() {
		}
	};
</script>
<style>
</style>