<template>
	<div class="row">
		<!-- Big Chart -->
		<div class="col-12">
			<card type="chart">
				<template slot="header">
					<div class="row">
						<div class="col-sm-6" :class="isRTL ? 'text-right' : 'text-left'">
							<!-- <h5 class="card-category">Total shipments</h5> -->
							<h2 class="card-title">Users</h2>
						</div>
						<div class="col-sm-6 d-flex d-sm-block">
							<div
							class="btn-group btn-group-toggle"
							:class="isRTL ? 'float-left' : 'float-right'"
							data-toggle="buttons"
							>
							<label
							v-for="(option, index) in bigLineChartCategories"
							:key="option.name"
							class="btn btn-sm btn-primary btn-simple"
							:class="{ active: bigLineChart.activeIndex === index }"
							:id="index"
							>
							<input
							type="radio"
							@click="initBigChart(index)"
							name="options"
							autocomplete="off"
							:checked="bigLineChart.activeIndex === index"
							/>
							<span class="d-none d-sm-block">{{ option.name }}</span>
							<span class="d-block d-sm-none">
								<i :class="option.icon"></i>
							</span>
						</label>
					</div>
				</div>
			</div>
		</template>
		<div class="chart-area">
			<line-chart
			style="height: 100%"
			ref="bigChart"
			:chart-data="bigLineChart.chartData"
			:gradient-colors="bigLineChart.gradientColors"
			:gradient-stops="bigLineChart.gradientStops"
			:extra-options="bigLineChart.extraOptions"
			>
		</line-chart>
	</div>
</card>
</div>


<!-- Small charts -->
<div class="col-lg-4" :class="{ 'text-right': isRTL }">
	<card type="chart">
		<template slot="header">
			<h5 class="card-category">Total Users</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-send text-primary "></i> 1000
			</h3>
		</template>
	</card>
</div>
<div class="col-lg-4" :class="{ 'text-right': isRTL }">
	<card type="chart">
		<template slot="header">
			<h5 class="card-category">Active User</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-single-02 text-success "></i> 500
			</h3>
		</template>
	</card>
</div>
<div class="col-lg-4" :class="{ 'text-right': isRTL }">
	<card type="chart">
		<template slot="header">
			<h5 class="card-category">De-active User</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-single-02 text-danger "></i> 500
			</h3>
		</template>
	</card>
</div>
</div>
</template>
<script>
	import LineChart from '@/components/Charts/LineChart';
	import BarChart from '@/components/Charts/BarChart';
	import * as chartConfigs from '@/components/Charts/config';
	import TaskList from '@/components/Dashboard/TaskList';
	import config from '@/config';
	import { Table, TableColumn } from 'element-ui';

	import { mapGetters } from 'vuex'

	let bigChartData = [
	[100, 70, 90, 70, 85, 60, 75, 60, 90, 80, 110, 100],
	[80, 120, 105, 110, 95, 105, 90, 100, 80, 95, 70, 120],
	[60, 80, 65, 130, 80, 105, 90, 130, 70, 115, 60, 130]
	]
	let bigChartLabels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
	let bigChartDatasetOptions = {
		fill: true,
		borderColor: config.colors.primary,
		borderWidth: 2,
		borderDash: [],
		borderDashOffset: 0.0,
		pointBackgroundColor: config.colors.primary,
		pointBorderColor: 'rgba(255,255,255,0)',
		pointHoverBackgroundColor: config.colors.primary,
		pointBorderWidth: 20,
		pointHoverRadius: 4,
		pointHoverBorderWidth: 15,
		pointRadius: 4,
	}

	export default {
		middleware: 'admin',
		layout: 'admin',
		name: 'dashboard',
		components: {
			LineChart,
			BarChart,
			TaskList,
			[Table.name]: Table,
			[TableColumn.name]: TableColumn
		},
		data () {
			return {
				bigLineChart: {
					activeIndex: 0,
					chartData: {
						datasets: [{
							...bigChartDatasetOptions,
							data: bigChartData[0]
						}],
						labels: bigChartLabels
					},
					extraOptions: chartConfigs.purpleChartOptions,
					gradientColors: config.colors.primaryGradient,
					gradientStops: [1, 0.4, 0],
					categories: []
				},
				purpleLineChart: {
					extraOptions: chartConfigs.purpleChartOptions,
					chartData: {
						labels: ['JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
						datasets: [
						{
							label: 'Data',
							fill: true,
							borderColor: config.colors.primary,
							borderWidth: 2,
							borderDash: [],
							borderDashOffset: 0.0,
							pointBackgroundColor: config.colors.primary,
							pointBorderColor: 'rgba(255,255,255,0)',
							pointHoverBackgroundColor: config.colors.primary,
							pointBorderWidth: 20,
							pointHoverRadius: 4,
							pointHoverBorderWidth: 15,
							pointRadius: 4,
							data: [80, 100, 70, 80, 120, 80]
						}
						]
					},
					gradientColors: config.colors.primaryGradient,
					gradientStops: [1, 0.2, 0]
				},
				greenLineChart: {
					extraOptions: chartConfigs.greenChartOptions,
					chartData: {
						labels: ['JUL', 'AUG', 'SEP', 'OCT', 'NOV'],
						datasets: [
						{
							label: 'My First dataset',
							fill: true,
							borderColor: config.colors.danger,
							borderWidth: 2,
							borderDash: [],
							borderDashOffset: 0.0,
							pointBackgroundColor: config.colors.danger,
							pointBorderColor: 'rgba(255,255,255,0)',
							pointHoverBackgroundColor: config.colors.danger,
							pointBorderWidth: 20,
							pointHoverRadius: 4,
							pointHoverBorderWidth: 15,
							pointRadius: 4,
							data: [90, 27, 60, 12, 80]
						}
						]
					},
					gradientColors: [
					'rgba(66,134,121,0.15)',
					'rgba(66,134,121,0.0)',
					'rgba(66,134,121,0)'
					],
					gradientStops: [1, 0.4, 0]
				},
				blueBarChart: {
					extraOptions: chartConfigs.barChartOptions,
					chartData: {
						labels: ['USA', 'GER', 'AUS', 'UK', 'RO', 'BR'],
						datasets: [
						{
							label: 'Countries',
							fill: true,
							borderColor: config.colors.info,
							borderWidth: 2,
							borderDash: [],
							borderDashOffset: 0.0,
							data: [53, 20, 10, 80, 100, 45]
						}
						]
					},
					gradientColors: config.colors.primaryGradient,
					gradientStops: [1, 0.4, 0]
				}
			};
		},
		computed: {
			enableRTL () {
				return this.$route.query.enableRTL;
			},
			isRTL () {
				return this.$rtl.isRTL;
			},
			bigLineChartCategories () {
				return [
				{ name: 'Current Year', icon: 'tim-icons icon-single-02' },
				{
					name: 'Last Year',
					icon: 'tim-icons icon-gift-2'
				}
      // { name: 'Sessions', icon: 'tim-icons icon-tap-02' }
      ];
  }
},
methods: {
	initBigChart (index) {
		let chartData = {
			datasets: [{
				...bigChartDatasetOptions,
				data: bigChartData[index]
			}],
			labels: bigChartLabels
		};
		this.$refs.bigChart.updateGradients(chartData);
		this.bigLineChart.chartData = chartData;
		this.bigLineChart.activeIndex = index;
	}
},
mounted () {
	this.initBigChart(0);
}
}
</script>
<style></style>
