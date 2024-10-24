<template>
	<b-container fluid>
		<card>
			<b-row>
				<b-col lg="12">
					<kanban-view></kanban-view>
				</b-col>
			</b-row>
		</card>
	</b-container>
</template>
<script>

	import KanbanView from '@/components/LoopingQuestion/KanbanView'
	import { mapState } from 'vuex'

	export default {
		middleware: 'admin',
		layout: 'admin',
		components: {
			KanbanView,
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