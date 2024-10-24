<template>
	<b-container fluid>
		<!-- User Interface controls -->
		<card card-body-classes="table-full-width">
			<b-row>
				<b-col lg="6" class="my-1">
					<base-input type="search" placeholder="Search" v-model="filter"> </base-input>
				</b-col>

				<!-- <b-col lg="6" class="my-1"> -->
				<div class="export-dropdown ml-auto">
					<base-dropdown
						:menu-on-right="!$rtl.isRTL"
						title-tag="a"
						title-classes="nav-link"
						class="nav-item p-0"
					>
						<template slot="title">
							<button class="btn btn-primary">Exports</button>
						</template>
						<li class="nav-link" @click="downloadFile(1)">
							<a href="#" class="nav-item dropdown-item">
								Date the User started the First Unit
							</a>
						</li>
						<li class="nav-link" @click="downloadFile(2)">
							<a href="#" class="nav-item dropdown-item">
								Number of Points of Faith & Fuel
							</a>
						</li>
						<li class="nav-link" @click="downloadFile(3)">
							<a href="#" class="nav-item dropdown-item">
								Unit that is currently being worked.
							</a>
						</li>
						<li class="nav-link" @click="downloadFile(4)">
							<a href="#" class="nav-item dropdown-item">
								Date the Unit that is currently being worked started
							</a>
						</li>
					</base-dropdown>
				</div>
			</b-row>

			<b-table
				:items="usersList"
				:fields="fields"
				:current-page="currentPage"
				:per-page="perPage"
				:filter="filter"
				:filter-included-fields="filterOn"
				:sort-by.sync="sortBy"
				:sort-desc.sync="sortDesc"
				:sort-direction="sortDirection"
				stacked="md"
				show-empty
				small
				@filtered="onFiltered"
			>
				<template #cell(avatar)="row">
					<div class="photo">
						<v-gravatar :email="row.item.email" :size="25" class="rounded-circle" />
					</div>
				</template>

				<template #cell(isActive)="row">
					<div v-if="row.item.is_active === true">Active</div>
					<div v-if="row.item.is_active === false">De-active</div>
				</template>

				<template #cell(actions)="row">
					<div class="d-flex">
						<b-form-checkbox
							v-model="row.item.is_active"
							name="check-button"
							switch
							@change="updateStatus(row.item.id, row.item.is_active)"
						>
						</b-form-checkbox>
						<nuxt-link
							v-if="row.item.user_type != 0"
							:to="'/admin/users/' + row.item.id"
							type="link"
							class="btn btn-primary btn-sm"
						>
							<span>info</span>
						</nuxt-link>
						<base-button
							class="ml-1 btn btn-danger btn-sm"
							@click="resetUserData(row.item)"
							v-if="row.item.user_type != 0"
						>
							<i class="tim-icons icon-refresh-02"></i>
							Reset
						</base-button>
					</div>
					<!-- 				<base-button type="link"  @click="openDeleteModal(row.item, row.index, $event.target)">
					<i class="far fa-trash-alt text-danger fa-lg"></i>
				</base-button> -->

					<!-- <i class="tim-icons icon-pencil text-primary"></i> -->

					<!-- <button class="btn btn-danger btn-sm pb-2" @click="openDeleteModal(row.item, row.index, $event.target)">
    	            <i class="tim-icons icon-trash-simple"></i>
				</button>
				<nuxt-link :to=" '/admin/users/' +row.item.id" type="link" class="btn btn-primary btn-sm pb-2">
	                <i class="tim-icons icon-pencil"></i>
	            </nuxt-link> -->
				</template>

				<template #row-details="row">
					<b-card>
						<ul>
							<li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
						</ul>
					</b-card>
				</template>
			</b-table>
			<b-row>
				<b-col sm="12" md="6" lg="5" offset="4" class="my-1">
					<b-pagination
						v-model="currentPage"
						:total-rows="totalRows"
						:per-page="perPage"
						size="sm"
						align="fill"
						class="my-0 py-1"
					></b-pagination>
				</b-col>

				<b-col sm="12" md="6" lg="3" class="my-1">
					<div class="row mb-3">
						<label for="perPage" class="col-sm-6 col-form-label">Per Page: </label>
						<div class="col-sm-6">
							<select class="form-control-sm w-100" id="perPage" v-model="perPage">
								<option :key="index" v-for="(option, index) in pageOptions">{{ option }}</option>
							</select>
						</div>
					</div>
				</b-col>
			</b-row>
		</card>

		<!-- Delete modal -->
		<b-modal :id="infoModal.id" hide-header hide-footer centered>
			<div class="container">
				<div class="row">
					<div class="col text-center">
						<i class="fas fa-times-circle fa-4x text-danger"></i>
						<h3>
							Are you sure?
						</h3>
						<p class="">
							Do you really want to delete the user
							<strong v-if="selectedUser"> {{ selectedUser.name }} </strong> ?
						</p>
						<div class="mt-4 mb-2">
							<button class="btn btn-secondary" @click="closeModal">Cancel</button>
							<button class="btn btn-info" @click="onDeleteUser">Confirm</button>
						</div>
					</div>
				</div>
			</div>
		</b-modal>

		<!-- Reset modal -->
		<b-modal id="reset-user_modal" hide-header hide-footer centered>
			<div class="container">
				<div class="row">
					<div class="col text-center">
						<i class="fas fa-times-circle fa-4x text-danger"></i>
						<h3>
							Are you sure?
						</h3>
						<p class="">
							Do you really want to reset the data of user
							<strong v-if="selectedUser"> {{ selectedUser.name }} </strong> ?
						</p>
						<div class="mt-4 mb-2">
							<button class="btn btn-secondary" @click="onClickCancelResetModal">Cancel</button>
							<button class="btn btn-info" @click="onClickConfirmResetModal" :disabled="reseting">
								<i v-if="reseting" class="fa fa-spinner fa-pulse"></i>Confirm
							</button>
						</div>
					</div>
				</div>
			</div>
		</b-modal>

		<!-- delete success modal -->

		<b-modal :id="deleteSuccessModal.id" hide-header hide-footer>
			<div class="container">
				<div class="row">
					<div class="col text-center">
						<i class="fas fa-check-circle fa-4x text-success"></i>
						<h3>
							Done
						</h3>
						<p class="">
							User has been deleted successfully.
						</p>
						<div class="mt-4 mb-2">
							<button class="btn btn-secondary" @click="closeDeleteSuccessModal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</b-modal>
	</b-container>
</template>
<script>
import { Table, TableColumn } from "element-ui";

export default {
	middleware: "admin",
	layout: "admin",
	components: {
		[Table.name]: Table,
		[TableColumn.name]: TableColumn,
	},
	data() {
		return {
			usersList: [
				{
					id: 1,
					avatar: "~/static/img/mike.jpg",
					name: "Dickerson Macdonald",
					email: "Dickerson@example.com",
					isActive: true,
				},
				{
					id: 2,
					avatar: "~/static/img/mike.jpg",
					name: "Mini Navarro",
					email: "Mini@example.com",
					isActive: true,
				},
				{
					id: 3,
					avatar: "~/static/img/mike.jpg",
					name: "Geneva Wilson",
					email: "Geneva@example.com",
					isActive: true,
				},
				{
					id: 4,
					avatar: "~/static/img/mike.jpg",
					name: "Essie Dunlap",
					email: "Essie@example.com",
					isActive: true,
				},
				{
					id: 5,
					avatar: "~/static/img/mike.jpg",
					name: "Jami Carney",
					email: "Jami@example.com",
					isActive: true,
				},
				{
					id: 6,
					avatar: "~/static/img/mike.jpg",
					name: "Thor Macdonald",
					email: "Thor@example.com",
					isActive: true,
				},
				{
					id: 7,
					avatar: "~/static/img/mike.jpg",
					name: "Larsen Shaw",
					email: "Larsen@example.com",
					isActive: true,
				},
				{
					id: 8,
					avatar: "~/static/img/mike.jpg",
					name: "Mitzi Navarro",
					email: "Mitzi@example.com",
					isActive: true,
				},
				{
					id: 9,
					avatar: "~/static/img/mike.jpg",
					name: "Genevieve Wilson",
					email: "Genevieve@example.com",
					isActive: true,
				},
				{
					id: 10,
					avatar: "~/static/img/mike.jpg",
					name: "John Carney",
					email: "John@example.com",
					isActive: true,
				},
				{
					id: 11,
					avatar: "~/static/img/mike.jpg",
					name: "Dick Dunlap",
					email: "Dick@example.com",
					isActive: true,
				},
			],
			fields: [
				{ key: "avatar", label: "", sortable: false, class: "text-left" },
				{ key: "name", label: "Full Name", sortable: true, sortDirection: "desc", class: "text-left" },
				{ key: "email", label: "Email", sortable: true, sortDirection: "desc", class: "text-left" },
				{
					key: "isActive",
					label: "Status",
					sortable: true,
					sortDirection: "desc",
					class: "text-center",
					formatter: (value, key, item) => {
						return value ? "Active" : "De-Active";
					},
				},
				{ key: "actions", label: "Actions", class: "text-center" },
			],
			totalRows: 1,
			currentPage: 1,
			perPage: 5,
			pageOptions: [5, 10, 15, 50, 100],
			sortBy: "",
			sortDesc: false,
			sortDirection: "asc",
			filter: null,
			filterOn: [],
			infoModal: {
				id: "info-modal",
				title: "",
			},
			deleteSuccessModal: {
				id: "delete-success-modal",
				title: "",
			},
			selectedUser: null,
			selectedUserIndex: null,
			updateStatusForm: {
				id: "",
				status: "",
			},
			reseting: false,
			exportsList: [
				{ id: 1, value: 'Stats For First Unit Started', text: 'Date the User started the First Unit'},
				{ id: 2, value: 'Stats For Points Of Faith Fuel', text: 'Number of Points of Faith & Fuel'},
				{ id: 3, value: 'Stats For Currently Working Unit', text: 'Unit that is currently being worked.'},
				{ id: 4, value: 'Stats For Current Unit Started Date', text: 'Date the Unit that is currently being worked started'}
			]
		};
	},
	computed: { },
	methods: {
		resetUserData(user) {
			this.selectedUser = user;
			this.$root.$emit("bv::show::modal", "reset-user_modal");
		},

		onClickCancelResetModal() {
			this.selectedUser = null;
			this.$root.$emit("bv::hide::modal", "reset-user_modal");
		},

		async onClickConfirmResetModal() {
			var self = this;
			this.reseting = true;
			await this.$axios
				.get("admin/resetUserData/" + this.selectedUser.id)
				.then(function(response) {
					self.selectedUser = null;
					self.reseting = false;
					self.$root.$emit("bv::hide::modal", "reset-user_modal");
				})
				.catch(function(error) {
					console.log("error");
					console.log(error.response);
					self.$bvToast.toast(error.response, {
						variant: "danger",
						solid: true,
					});
				});
		},

		async updateStatus(id, status) {
			if (this.usersList.is_active == true) {
				this.usersList.is_active = 1;
			}
			if (this.usersList.is_active == false) {
				this.usersList.is_active = 0;
			}

			this.updateStatusForm.id = id;
			this.updateStatusForm.status = status;

			var self = this;

			await this.$axios
				.post("admin/updateStatus", this.updateStatusForm)
				.then(function(response) {
					console.log(response);
					self.$bvToast.toast("Status Updated Successfuly.", {
						variant: "success",
						solid: true,
					});
				})
				.catch(function(error) {
					console.log("error");
					console.log(error.response);
					self.$bvToast.toast(error.response, {
						variant: "danger",
						solid: true,
					});
				});
		},
		async getAllUsers() {
			var self = this;
			await this.$axios
				.$get("/admin/getAllUsers")
				.then(function(response) {
					self.usersList = response;
					self.totalRows = self.usersList.length;
					for (var i = 0; i < self.usersList.length; i++) {
						if (self.usersList[i].is_active == 1) {
							self.usersList[i].is_active = true;
						}
						if (self.usersList[i].is_active == 0) {
							self.usersList[i].is_active = false;
						}
					}
				})
				.catch(function(error) {
					console.log("error: " + error);
					self.$bvToast.toast(error, {
						variant: "danger",
						solid: true,
					});
				});
		},
		goToUserDetailPage(user_id) {
			this.$router.push("/admin/users/" + user_id);
		},
		openDeleteModal(item, index, button) {
			this.selectedUser = item;
			this.selectedUserIndex = index;
			this.$root.$emit("bv::show::modal", this.infoModal.id);
		},
		closeModal() {
			this.$root.$emit("bv::hide::modal", this.infoModal.id);
		},

		async onDeleteUser() {
			this.$root.$emit("bv::hide::modal", this.infoModal.id);
			this.usersList.splice(this.usersList.indexOf(this.selectedUser), 1);
			var self = this;
			await this.$axios
				.$get("/admin/onDeleteUser/" + this.selectedUser.id)
				.then(function(response) {
					self.getAllUsers();
				})
				.catch(function(error) {
					self.$bvToast.toast(error, {
						variant: "danger",
						solid: true,
					});
				});
			this.showDeleteSuccessModal();
			this.onFiltered(this.usersList);
		},
		showDeleteSuccessModal() {
			this.$root.$emit("bv::show::modal", this.deleteSuccessModal.id);
		},
		closeDeleteSuccessModal() {
			this.$root.$emit("bv::hide::modal", this.deleteSuccessModal.id);
		},
		onFiltered(filteredItems) {
			this.totalRows = filteredItems.length;
			this.currentPage = 1;
		},
		async downloadFile(type) {
			await this.$axios.get("/admin/downloadFile?reportType=" + type, { responseType: "arraybuffer" })
			.then((response) => {
				console.log('admin downloadFile');
				console.log(response);
				console.log(response.data);
				var fileName = this.getNameForExportFile(type);
				var fileURL = window.URL.createObjectURL(
					new Blob([response.data], {
						type: "application/octet-stream",
					})
				);
				var fileLink = document.createElement("a");
				fileLink.href = fileURL;
				fileLink.setAttribute("download", fileName);
				document.body.appendChild(fileLink);
				fileLink.click();
			});
		},
		getNameForExportFile(type)
		{
			for (var i = 0; i < this.exportsList.length; i++)
			{
				if (this.exportsList[i].id == type) {
					return this.exportsList[i].value + '.csv';
				}
			}
		}		
	},
	mounted() {
		// this.totalRows = this.usersList.length
		this.getAllUsers();
	},
};
</script>
<style type="text/css">
.custom-switch .custom-control-input:checked ~ .custom-control-label::after {
	background-color: #f4f5f7 !important;
	transform: translateX(0.9375rem);
	z-index: 999;
}
.export-dropdown .nav-link {
	padding: 0px;
	padding-right: 15px;
}
</style>
