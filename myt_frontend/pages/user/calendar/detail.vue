<template>
	<div>
		<div>
			<b-form-datepicker
				id="datepicker-full-width"
				v-model="selectedDate"
				@input="onDateChange"
			></b-form-datepicker>
		</div>
		<table v-if="!isloading" class="table table-bordered" style="line-height: 1.0;">
			<thead class="golden-gradient">
				<tr class="text-center">
					<th scope="col" style="color: white !important;">
						Description
					</th>
					<th
						scope="col"
						class="text-white"
						v-for="(headCol, index) in weeklyLogsData.tableHeadCol"
						:key="'table_head_col_' + index"
					>
						{{ headCol.day }} <br />
						{{ headCol.date }}
					</th>
				</tr>
			</thead>
			<tbody class="font-weight-bold text-center">
				<tr
					style="line-height: 1.0;"
					v-for="(tableRow, index) in weeklyLogsData.tableRowsData"
					:key="'table_row_index_' + index"
				>
					<td class="text-left">{{ tableRow.discription }}</td>
					<td v-for="(day, index) in tableRow.days" :key="'table_row__day_index_' + index">
						<span v-if="day.celebration">
							<img src="~/assets/images/celebration.png" width="25px" height="30px"/>
							<!-- <img width="20px" height="30px" src="~/assets/images/celebration.jpg" /> -->
						</span>
						<span v-else>{{ day.value }}</span>
					</td>
				</tr>

				<tr class="blue-gradient" style="line-height: 1.0; border-top: solid 3px;">
					<td class="text-left" style="color: white !important;">Score</td>
					<td
						style="color: white !important;"
						v-for="(tableFoot, index) in weeklyLogsData.tableFooterCol"
						:key="'table_footer_index_' + index"
					>
						{{ tableFoot }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
<script>
import { mapState } from "vuex";
import moment from "moment";
export default {
	middleware: "user",
	layout: "user",
	name: "user-calendar-detail",
	components: {},
	computed: {
		...mapState("auth", ["loggedIn", "user"]),
	},

	data() {
		return {
			weeklyLogsData: {
				tableHeadCol: [],
				tableRowsData: [],
				tableFooterCol: [],
			},
			selectedDate: null,
			isloading: false,
		};
	},
	mounted() {
		this.selectedDate = moment().format("YYYY-MM-DD");
		this.getWeeklyBootCampAnalyticsLog(this.selectedDate);
	},
	methods: {
		onDateChange(date) {
			this.selectedDate = date;
			this.getWeeklyBootCampAnalyticsLog(this.selectedDate);
		},
		async getWeeklyBootCampAnalyticsLog(date) {
			var self = this;
			this.isloading = true;
			await this.$axios
				.get("/user/getWeeklyBootCampAnalyticsLog?user_id=" + this.user.id + "&date=" + date)
				.then(function(response) {
					self.weeklyLogsData = response.data;
					self.isloading = false;
				})
				.catch(function(error) {
					console.log("error: " + error);
					self.$bvToast.toast(error, {
						variant: "danger",
						solid: true,
					});
				});
		},
	},
};
</script>
