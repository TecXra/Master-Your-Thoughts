<template>
	<div class="container bg-white border p-0">
		<div class="custom-top-border"></div>
		<div v-if="loadingExistingBankInformation">
			Loading
		</div>
		<div v-else>
			<div v-if="bankingInformationExist" class="container">
				<div class="row" v-if="bankAccountInformation">
					<div class=" col-lg-5">
						<div class="py-5">
							<table class="table table-borderless table-details">
								<tbody>
									<tr>
										<th>Name</th>
										<td
										class="d-flex align-items-center justify-content-between"
										>
										<span>{{
											bankAccountInformation.company_info.company_name
										}}</span>
										<i
										@click="openCompanyInformationEditModal"
										:class="
										bankAccountInformation.company_info.company_name != ''
										? 'fa fa-pen cursor-pointer'
										: 'fa fa-plus cursor-pointer'
										"
										class="fa fa-pen cursor-pointer"
										></i>
									</td>
								</tr>
								<tr>
									<th scope="row">Address:</th>
									<td>
										{{
											bankAccountInformation.company_info.address
											.address_line_1
										}}
									</td>
								</tr>
								<tr>
									<th></th>
									<td>
										{{
											bankAccountInformation.company_info.address
											.address_line_2
										}}
											<!-- {{ bankAccountInformation.company_info.address.city_name }}
											<span v-if="bankAccountInformation.company_info.address.city_name">,</span>
											{{ bankAccountInformation.company_info.address.state }}
											{{ bankAccountInformation.company_info.address.zip_code }} -->
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-5">
						<div class="py-5">
							<table class="table table-borderless table-details">
								<tbody>
									<tr>
										<th scope="row">Account:</th>
										<td
										class="d-flex align-items-center justify-content-between"
										>
										{{ bankAccountInformation.account_info.account_number }}
										<i
										@click="openBankAccountInfoEditModal"
										:class="
										bankAccountInformation.account_info.account_number !=
										''
										? 'fa fa-pen cursor-pointer'
										: 'fa fa-plus cursor-pointer'
										"
										></i>
									</td>
								</tr>
								<tr>
									<th scope="row">Bank Name:</th>
									<td>
										{{ bankAccountInformation.account_info.bank_name }}
									</td>
								</tr>
								<tr>
									<th scope="row">Address:</th>
									<td>
										{{
											bankAccountInformation.account_info.address
											.address_line_1
										}}
									</td>
								</tr>
								<tr>
									<th></th>
									<td>
										{{
											bankAccountInformation.account_info.address.city_name
										}}
										<span
										v-if="
										bankAccountInformation.account_info.address.city_name
										"
										>,</span
										>
										{{ bankAccountInformation.account_info.address.state }}
										{{ bankAccountInformation.account_info.address.zip_code }}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-2 p-0 d-flex align-items-center justify-content-center">
					<!-- <div class=""> -->
					<barcode v-bind:value="bankAccountInformation.account_info.account_number" class="barcode-align" width="1" height="40"></barcode>
					<!-- </div> -->
				</div>
				<transactions
				:accountId="bankAccountInformation.account_info.bank_account_id"
				:initialDeposit="
				bankAccountInformation.account_info.initial_deposit
				"
				></transactions>
			</div>
		</div>
		<banking-form @saved="onSaveCallback" v-else></banking-form>
	</div>
	<b-modal
	ref="account-edit-modal"
	title="Edit Info"
	centered
	header-class="p-0"
	hide-footer
	variant="primary"
	>
	<template #modal-header>
		<div class="w-100 bg-dark p-3">
			<h4 class="mb-0 text-white">
				Edit Information
			</h4>
		</div>
	</template>
	<div class="row">
		<div class="col-lg-12">
			<form class="px-3 h-100">
				<div class="form-group">
					<label for="bank-name">Name</label>
					<input
					type="text"
					class="form-control"
					v-model="editCompanyInfoForm.company_name"
					id="bank-name"
					placeholder="Name"
					/>
				</div>
			</form>
		</div>
		<div class="col-lg-12">
			<form class="px-3 h-100">
				<div class="form-group">
					<label for="inputAddress">Address</label>
					<input
					type="text"
					class="form-control"
					id="inputAddress"
					v-model="editCompanyInfoForm.address.address_line_1"
					placeholder="Address"
					/>
				</div>
				<div class="form-group">
					<label for="inputAddress">City / State / Zip</label>
					<input
					type="text"
					class="form-control"
					id="inputAddress"
					v-model="editCompanyInfoForm.address.address_line_2"
					placeholder="City / State / Zip"
					/>
				</div>
						<!-- <div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="inputCity">City</label>
									<input
										type="text"
										class="form-control"
										v-model="editCompanyInfoForm.address.city_name"
										id="inputCity"
										placeholder="City"
									/>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="inputState">State</label>
									<select
										id="inputState"
										v-model="editCompanyInfoForm.address.state"
										class="form-control"
									>
										<option value="">Select</option>
										<option
											:key="'company_account_option_index_' + index"
											v-for="(state, index) in statesList"
											:value="state.postal_code"
											>{{ state.postal_code }}</option
										>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="inputZip">Zip</label>
									<input
										type="text"
										v-model="editCompanyInfoForm.address.zip_code"
										class="form-control"
										id="inputZip"
										placeholder="ZipCode"
									/>
								</div>
							</div>
						</div> -->
					</form>
				</div>
				<div class="col-lg-12 w-100 text-right mt-3">
					<b-button variant="danger" @click="hideCompanyInformationEditModal()">
						Close
					</b-button>
					<b-button
					variant="primary"
					:disabled="!isValidCompanyInfoObj || updatingCompanyInfo"
					@click.prevent="updateCompanyInfo()"
					>
					<i v-if="updatingCompanyInfo" class="fa fa-spinner fa-pulse"></i>
					<span v-else> Save</span>
				</b-button>
			</div>
		</div>
	</b-modal>
	<b-modal
	ref="bank-edit-modal"
	title="Edit Bank Info"
	header-class="p-0"
	footer-bg-variant="secondary"
	scrollable
	>
	<template #modal-header>
		<div class="w-100 bg-dark p-3">
			<h4 class="mb-0 text-white">
				Edit Bank Information
			</h4>
		</div>
	</template>
      <template slot="default">

	<div class="row">
		<div class="col-lg-12">
			<form class="px-3 h-100">
				<div class="form-group">
					<label for="bank-name">Bank Name</label>
					<input
					type="text"
					class="form-control"
					id="bank-name"
					v-model="editBankAccountInfoForm.bank_name"
					placeholder="Name"
					/>
				</div>

				<div class="form-group">
					<label for="prim-account">Bank Account</label>
					<input
					type="email"
					class="form-control"
					id="prim-account"
					v-model="editBankAccountInfoForm.account_number"
					placeholder="Account"
					/>
				</div>

				<div class="form-group">
					<label for="initial-deposit">Initial Deposit</label>
					<input
					type="number"
					class="form-control"
					id="initial-deposit"
					v-model="editBankAccountInfoForm.initial_deposit"
					placeholder="$0.00"
					/>
				</div>
			</form>
		</div>
		<div class="col-lg-12">
			<form class="px-3 h-100">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="inputAddress">Address line 1</label>
							<input
							type="text"
							class="form-control"
							id="inputAddress"
							v-model="editBankAccountInfoForm.address.address_line_1"
							placeholder="Line 1"
							/>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="inputAddress">Address line 2</label>
							<input
							type="text"
							class="form-control"
							id="inputAddress"
							v-model="editBankAccountInfoForm.address.address_line_2"
							placeholder="line 2"
							/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="inputCity">City</label>
							<input
							type="text"
							v-model="editBankAccountInfoForm.address.city_name"
							class="form-control"
							id="inputCity"
							placeholder="City"
							/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="inputState">State</label>
							<select
							id="inputState"
							class="form-control"
							v-model="editBankAccountInfoForm.address.state"
							>
							<option value="">Select</option>
							<option
							:key="'bank_account_option_index_' + index"
							v-for="(state, index) in statesList"
							:value="state.postal_code"
							>{{ state.postal_code }}</option
							>
						</select>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label for="inputZip">Zip</label>
						<input
						type="text"
						class="form-control"
						id="inputZip"
						v-model="editBankAccountInfoForm.address.zip_code"
						placeholder="ZipCode"
						/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</template>

      <template #modal-footer>
	<div class="row w-100 text-right">
	<div class="col-lg-12 mt-3">
		<b-button variant="danger" @click="hideBankAccountInfoEditModal()">
			Close
		</b-button>
		<b-button
		variant="primary"
		:disabled="!isValidBankInfoObj || updatingBankInfo"
		@click.prevent="updateBankAccountInfo()"
		>
		<i v-if="updatingBankInfo" class="fa fa-spinner fa-pulse"></i>
		<span v-else> Save</span>
	</b-button>
</div>
</div>
</template>
</b-modal>
</div>
</template>
<script>
	import { mapState } from "vuex";
	import VueBarcode from "vue-barcode";
	import Transactions from "@/components/Banking/Transaction";
	import BankingForm from "@/components/Banking/BankingForm";
	export default {
		components: {
			barcode: VueBarcode,
			Transactions,
			BankingForm,
		},

		name: "banking",
		middleware: "user",
		layout: "user",

		computed: {
			...mapState("auth", ["user"]),
			isValidBankInfoObj() {
				let flag = true;
				if (this.editBankAccountInfoForm.bank_name == "") {
					flag = false;
				}
				if (
					this.editBankAccountInfoForm.account_number == "" ||
					this.editBankAccountInfoForm.account_number == 0
					) {
					flag = false;
			}
			if (
				this.editBankAccountInfoForm.initial_deposit == "" ||
				this.editBankAccountInfoForm.initial_deposit == 0
				) {
				flag = false;
		}

		if (this.editBankAccountInfoForm.address.address_line_1 == "") {
			flag = false;
		}
			// if (this.editBankAccountInfoForm.address.city_name == "") {
			//  flag = false;
			// }
			// if (this.editBankAccountInfoForm.address.state == "") {
			//  flag = false;
			// }

			// if (this.editBankAccountInfoForm.address.zip_code == "") {
			//  flag = false;
			// }

		return flag;
	},
	isValidCompanyInfoObj() {
		let flag = true;
		if (this.editCompanyInfoForm.company_name == "") {
			flag = false;
		}
		if (this.editCompanyInfoForm.address.address_line_1 == "") {
			flag = false;
		}
		if (this.editCompanyInfoForm.address.city_name == "") {
			flag = false;
		}
		if (this.editCompanyInfoForm.address.state == "") {
			flag = false;
		}
		if (this.editCompanyInfoForm.address.zip_code == "") {
			flag = false;
		}
		return flag;
	},
},
data() {
	return {
		bankingInformationExist: false,
		loadingExistingBankInformation: false,
		bankAccountInformation: {
			company_info: {
				company_name: "",
				company_id: 0,
				address: {
					address_line_1: "",
					address_line_2: "",
					city_name: "",
					state: "",
					zip_code: "",
				},
			},
			account_info: {
				bank_name: "",
				initial_deposit: 0,
				bank_account_id: 0,
				account_number: "",
				address: {
					address_line_1: "",
					address_line_2: "",
					city_name: "",
					state: "",
					zip_code: "",
				},
			},
		},
		editBankAccountInfoForm: {
			bank_name: "",
			bank_account_id: 0,
			account_number: "",
			address: {
				address_line_1: "",
				address_line_2: "",
				city_name: "",
				state: "",
				zip_code: "",
			},
		},
		updatingBankInfo: false,
		editCompanyInfoForm: {
			company_name: "",
			company_id: 0,
			address: {
				address_line_1: "",
				address_line_2: "",
					// city_name: "",
					// state: "",
					// zip_code: "",
			},
		},
		updatingCompanyInfo: false,
		statesList: [],
	};
},
mounted() {
	this.getBankInformation();
	this.getStatesList();
},
methods: {
	onSaveCallback() {
		this.getBankInformation();
	},

	async getStatesList() {
		var self = this;
		await this.$axios
		.get("/getStatesList")
		.then(function(response) {
			self.statesList = response.data;
		})
		.catch(function(error) {
			console.log("error: " + error);
			self.$bvToast.toast(error, {
				variant: "danger",
				solid: true,
			});
		});
	},

	async getBankInformation() {
		this.loadingExistingBankInformation = true;
		var self = this;
		await this.$axios
		.get("/user/getBankInformation/" + this.user.id)
		.then(function(response) {
			if (response.data.exist) {
				self.bankAccountInformation = response.data.data;
				self.bankingInformationExist = true;
			}
			self.loadingExistingBankInformation = false;
		})
		.catch(function(error) {
			console.log("error: " + error);
			self.$bvToast.toast(error, {
				variant: "danger",
				solid: true,
			});
		});
	},
	openCompanyInformationEditModal() {
		this.editCompanyInfoForm.company_name = this.bankAccountInformation.company_info.company_name;
		this.editCompanyInfoForm.company_id = this.bankAccountInformation.company_info.company_id;
		this.editCompanyInfoForm.address.address_line_1 = this.bankAccountInformation.company_info.address.address_line_1;
		this.editCompanyInfoForm.address.address_line_2 = this.bankAccountInformation.company_info.address.address_line_2;
			// this.editCompanyInfoForm.address.city_name = this.bankAccountInformation.company_info.address.city_name;
			// this.editCompanyInfoForm.address.state = this.bankAccountInformation.company_info.address.state;
			// this.editCompanyInfoForm.address.zip_code = this.bankAccountInformation.company_info.address.zip_code;
		this.$refs["account-edit-modal"].show();
	},

	async updateCompanyInfo() {
		this.updatingCompanyInfo = true;
		var self = this;
		await this.$axios
		.post("/user/updateCompanyInformation", this.editCompanyInfoForm)
		.then(function(response) {
			if (response.data == true) {
				self.bankAccountInformation.company_info.company_name =
				self.editCompanyInfoForm.company_name;
				self.bankAccountInformation.company_info.company_id =
				self.editCompanyInfoForm.company_id;
				self.bankAccountInformation.company_info.address.address_line_1 =
				self.editCompanyInfoForm.address.address_line_1;
				self.bankAccountInformation.company_info.address.address_line_2 =
				self.editCompanyInfoForm.address.address_line_2;
						// self.bankAccountInformation.company_info.address.city_name = self.editCompanyInfoForm.address.city_name;
						// self.bankAccountInformation.company_info.address.state = self.editCompanyInfoForm.address.state;
						// self.bankAccountInformation.company_info.address.zip_code = self.editCompanyInfoForm.address.zip_code;
				self.hideCompanyInformationEditModal();
			} else {
				self.$bvToast.toast("Invalid information provided.", {
					variant: "danger",
					solid: true,
				});
			}
			self.updatingCompanyInfo = false;
		})
		.catch(function(error) {
			console.log("error: " + error);
			self.$bvToast.toast(error, {
				variant: "danger",
				solid: true,
			});
		});
	},

	hideCompanyInformationEditModal() {
		this.$refs["account-edit-modal"].hide();
	},
	openBankAccountInfoEditModal() {
		this.editBankAccountInfoForm.bank_name = this.bankAccountInformation.account_info.bank_name;
		this.editBankAccountInfoForm.bank_account_id = this.bankAccountInformation.account_info.bank_account_id;
		this.editBankAccountInfoForm.account_number = this.bankAccountInformation.account_info.account_number;
		this.editBankAccountInfoForm.initial_deposit = this.bankAccountInformation.account_info.initial_deposit;
		this.editBankAccountInfoForm.address.address_line_1 = this.bankAccountInformation.account_info.address.address_line_1;
		this.editBankAccountInfoForm.address.address_line_2 = this.bankAccountInformation.account_info.address.address_line_2;
		this.editBankAccountInfoForm.address.city_name = this.bankAccountInformation.account_info.address.city_name;
		this.editBankAccountInfoForm.address.state = this.bankAccountInformation.account_info.address.state;
		this.editBankAccountInfoForm.address.zip_code = this.bankAccountInformation.account_info.address.zip_code;
		this.$refs["bank-edit-modal"].show();
	},

	async updateBankAccountInfo() {
		this.updatingBankInfo = true;
		var self = this;
		await this.$axios
		.post(
			"/user/updateBankAccountInformation",
			this.editBankAccountInfoForm
			)
		.then(function(response) {
			if (response.data == true) {
				self.bankAccountInformation.account_info.bank_name =
				self.editBankAccountInfoForm.bank_name;
				self.bankAccountInformation.account_info.bank_account_id =
				self.editBankAccountInfoForm.bank_account_id;
				self.bankAccountInformation.account_info.account_number =
				self.editBankAccountInfoForm.account_number;
				self.bankAccountInformation.account_info.initial_deposit =
				self.editBankAccountInfoForm.initial_deposit;

				self.bankAccountInformation.account_info.address.address_line_1 =
				self.editBankAccountInfoForm.address.address_line_1;
				self.bankAccountInformation.account_info.address.address_line_2 =
				self.editBankAccountInfoForm.address.address_line_2;
				self.bankAccountInformation.account_info.address.city_name =
				self.editBankAccountInfoForm.address.city_name;
				self.bankAccountInformation.account_info.address.state =
				self.editBankAccountInfoForm.address.state;
				self.bankAccountInformation.account_info.address.zip_code =
				self.editBankAccountInfoForm.address.zip_code;
				self.hideBankAccountInfoEditModal();
			} else {
				self.$bvToast.toast("Invalid information provided.", {
					variant: "danger",
					solid: true,
				});
			}
			self.updatingBankInfo = false;
		})
		.catch(function(error) {
			console.log("error: " + error);
			self.$bvToast.toast(error, {
				variant: "danger",
				solid: true,
			});
		});
	},
	hideBankAccountInfoEditModal() {
		this.$refs["bank-edit-modal"].hide();
	},
},
};
</script>
<style>
	.barcode-align {
		transform: rotate(90deg);
	}
	.info-heading {
		font-weight: bold;
	}
	@media only screen and (max-width: 991px) {
		.barcode-align {
			transform: inherit;
		}
	}
	.table-details tr {
		line-height: 9px;
	}
	.cursor-pointer {
		cursor: pointer;
	}
	.custom-top-border {
		height: 10px;
		background: rgb(2, 0, 36) !important;
		background: linear-gradient(
			90deg,
			rgba(2, 0, 36, 1) 0%,
			rgba(9, 9, 121, 1) 0%,
			rgba(0, 212, 255, 1) 100%
		) !important;
		color: white !important;
	}
	.blue-gradient-heading {
		background: rgb(2, 0, 36) !important;
		background: linear-gradient(
			90deg,
			rgba(2, 0, 36, 1) 0%,
			rgba(9, 9, 121, 1) 0%,
			rgba(0, 212, 255, 1) 100%
		) !important;
		color: white !important;
	}
	td
	{
		line-height: 1;
	}
</style>
