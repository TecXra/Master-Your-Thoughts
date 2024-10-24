<template>
	<div class="row">
		<!-- <div class="loading">Loading&#8230;</div> -->
		<!-- Big Chart -->
		<div class="col-12">
			<card type="chart">
				<template slot="header">
					<div class="row">
						<div class="col-sm-6" :class="isRTL ? 'text-right' : 'text-left'">
							<h5 class="card-category">Total shipments</h5>
							<h2 class="card-title">Performance</h2>
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
			<h5 class="card-category">Total Shipments</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-bell-55 text-primary "></i> 763,215
			</h3>
		</template>
		<div class="chart-area">
			<line-chart
			style="height: 100%"
			:chart-data="purpleLineChart.chartData"
			:gradient-colors="purpleLineChart.gradientColors"
			:gradient-stops="purpleLineChart.gradientStops"
			:extra-options="purpleLineChart.extraOptions"
			>
		</line-chart>
	</div>
</card>
</div>
<div class="col-lg-4" :class="{ 'text-right': isRTL }">
	<card type="chart">
		<template slot="header">
			<h5 class="card-category">Daily Sales</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-delivery-fast text-info "></i> 3,500€
			</h3>
		</template>
		<div class="chart-area">
			<bar-chart
			style="height: 100%"
			:chart-data="blueBarChart.chartData"
			:gradient-stops="blueBarChart.gradientStops"
			:extra-options="blueBarChart.extraOptions"
			>
		</bar-chart>
	</div>
</card>
</div>
<div class="col-lg-4" :class="{ 'text-right': isRTL }">
	<card type="chart">
		<template slot="header">
			<h5 class="card-category">Completed tasks</h5>
			<h3 class="card-title">
				<i class="tim-icons icon-send text-success "></i> 12,100K
			</h3>
		</template>
		<div class="chart-area">
			<line-chart
			style="height: 100%"
			:chart-data="greenLineChart.chartData"
			:gradient-stops="greenLineChart.gradientStops"
			:extra-options="greenLineChart.extraOptions"
			>
		</line-chart>
	</div>
</card>
</div>
<div class="col-lg-5">
	<card type="tasks" :header-classes="{ 'text-right': isRTL }">
		<template slot="header" class="d-inline">
			<h6 class="title d-inline">Tasks (5)</h6>
			<p class="card-category d-inline">Today</p>

			<base-dropdown
			menu-on-right=""
			tag="div"
			title-classes="btn btn-link btn-icon"
			class="float-right"
			>
			<i slot="title" class="tim-icons icon-settings-gear-63"></i>
			<a class="dropdown-item" href="#pablo"> Action </a>
			<a class="dropdown-item" href="#pablo"> Another action </a>
			<a class="dropdown-item" href="#pablo"> Something else </a>
		</base-dropdown>
	</template>
	<div class="table-full-width table-responsive">
		<task-list></task-list>
	</div>
</card>
</div>
<div class="col-lg-7">
	<card card-body-classes="table-full-width">
		<h4 slot="header" class="card-title">Striped table</h4>
		<el-table :data="tableData">
			<el-table-column
			min-width="150"
			sortable
			label="Name"
			property="name"
			></el-table-column>
			<el-table-column
			min-width="150"
			sortable
			label="Country"
			property="country"
			></el-table-column>
			<el-table-column
			min-width="150"
			sortable
			label="City"
			property="city"
			></el-table-column>
			<el-table-column
			min-width="150"
			sortable
			align="right"
			header-align="right"
			label="Salary"
			property="salary"
			></el-table-column>
		</el-table>
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
    	middleware: 'redirect',
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
				tableData: [
				{
					id: 1,
					name: 'Dakota Rice',
					salary: '$36.738',
					country: 'Niger',
					city: 'Oud-Turnhout'
				},
				{
					id: 2,
					name: 'Minerva Hooper',
					salary: '$23,789',
					country: 'Curaçao',
					city: 'Sinaai-Waas'
				},
				{
					id: 3,
					name: 'Sage Rodriguez',
					salary: '$56,142',
					country: 'Netherlands',
					city: 'Baileux'
				},
				{
					id: 4,
					name: 'Philip Chaney',
					salary: '$38,735',
					country: 'Korea, South',
					city: 'Overland Park'
				},
				{
					id: 5,
					name: 'Doris Greene',
					salary: '$63,542',
					country: 'Malawi',
					city: 'Feldkirchen in Kärnten'
				}
				],
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
			// ...mapGetters(['isAuthenticated', 'loggedInUser']),
			enableRTL () {
				return this.$route.query.enableRTL;
			},
			isRTL () {
				return this.$rtl.isRTL;
			},
			bigLineChartCategories () {
				return [{ name: 'Accounts', icon: 'tim-icons icon-single-02' }, {
					name: 'Purchases',
					icon: 'tim-icons icon-gift-2'
				}, { name: 'Sessions', icon: 'tim-icons icon-tap-02' }];
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
			},
			redirectToLogin()
			{
				this.$router.push('/login');
			}
		},
		mounted () {
			console.log('isAuthenticated');
			console.log(this.isAuthenticated);
			console.log('loggedInUser');
			console.log(this.loggedInUser);
			if (this.loggedInUser.user_type == 0)
			{
				// this.$router.push('/admin/dashboard');
			}
			else if (this.loggedInUser.user_type == 1)
			{
				// this.$router.push('/user/dashboard');
			}
			// setTimeout(this.redirectToLogin,1000);
			this.initBigChart(0);
		}
	}
</script>
<style>
	/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
