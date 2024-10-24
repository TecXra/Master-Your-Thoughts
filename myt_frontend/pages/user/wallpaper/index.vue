<template>
	<div>
<!--        <style>
			:root {
				--device-height: "{{ deviceHeight }}px";
				--device-width: "{{ deviceWidth }}px";
			}
		</style> -->

		<div class="row" v-if="isWallpaperGridActive">
			<div class="col-lg-12">
				<div class="card px-5 py-5 mb-0 d-flex justify-content-center align-items-center">
					<h1 class="text-success font-weight-bold">
						Create your own wallpaper
					</h1>
					<p>
						You can create your own wallpaper by adding your own background image, foreground image or text
						with any color, size and font. You can also download your created image or save to the platform
						for further use. You can create for following three different resolutions.
					</p>
					<div class="mt-3 text-center">
						<button class="btn btn-primary" @click="showDesktopWallpaperGrid">
							Desktop
							<!-- (1920*1080) -->
						</button>
						<!-- <button class="btn btn-primary" @click="showiPadpWallpaperGrid">
							iPad
						</button> -->
							<!-- (2048*1536) -->
						<!-- <button class="btn btn-primary" @click="showiPadpWallpaperGrid">iPad (1024*768)</button> -->
						<button class="btn btn-primary" @click="showiPhoneWallpaperGrid">
							Cell Phone
							<!-- (1170*2532) -->
						</button>
					</div>
					<div class="mt-3 text-center">
						<button class="btn btn-warning px-3" @click="openInstructionVideoModal">
							Video Tutorial
						</button>

						<!-- <a href="#" class="text-info font-weight-bold" @click="openInstructionVideoModal">
							Click here to watch complete instructions in <strong>Video Tutorial</strong>
						</a> -->
					</div>
				</div>
			</div>
		</div>
		<div v-if="isDesktopWallpaperGridActive">
			<div v-if="showDraftedWallpaperLoader" class="bg-white d-flex justify-content-center align-items-center py-5">
				<i class="fa fa-spinner fa-pulse text-primary fa-5x"></i>
			</div>
			<DesktopGrid :drafted-wallpeper="draftData" v-on:showWallpaperGrid="showWallpaperGrid" v-on:updateWallpaperList="showDesktopWallpaper" v-else></DesktopGrid>
		</div>
		<!-- <div v-if="isiPadWallpaperGridActive">
			<div v-if="showDraftedWallpaperLoader" class="bg-white d-flex justify-content-center align-items-center py-5">
				<i class="fa fa-spinner fa-pulse text-primary fa-5x"></i>
			</div>
			<IpadGrid :drafted-wallpeper="draftData" v-on:showWallpaperGrid="showWallpaperGrid" v-on:updateWallpaperList="showiPadpWallpaper" v-else></IpadGrid>
		</div> -->
		<div v-if="isiPhoneWallpaperGridActive">
			<div v-if="showDraftedWallpaperLoader" class="bg-white d-flex justify-content-center align-items-center py-5">
				<i class="fa fa-spinner fa-pulse text-primary fa-5x"></i>
			</div>
			<IphoneGrid :drafted-wallpeper="draftData" v-on:showWallpaperGrid="showWallpaperGrid" v-on:updateWallpaperList="showiPhoneWallpaper" v-else></IphoneGrid>
			<!-- <IphoneGrid :drafted-wallpeper="draftData" v-on:showWallpaperGrid="showWallpaperGrid" v-on:updateWallpaperList="showiPhoneWallpaper" v-on:sendUpdatedDeviceResolution="getUpdatedDeviceResolution" v-else></IphoneGrid> -->
		</div>

		<div class="row" v-if="isWallpaperGridActive">
			<div class="col">
				<b-card no-body>
					<b-tabs fill class="tabs-wrapper" v-model="tabIndex" @input="tabClicked">
						<b-tab title="Desktop" active>
							<b-card class="mb-0">
								<b-card-text>
									<div class="row" v-if="showWallpaperListLoader">
										<div class="col text-center py-5">
											<i class="fa fa-spinner fa-pulse text-primary fa-3x"></i>
										</div>
									</div>
									<div class="row" v-else>
										<div class="col-lg-12" v-if="mediaList.length == 0">
											<p class="py-5 text-center">
												No Wallpaper downloaded yet.
											</p>
										</div>
										<div class="col-lg-4 mb-3 " v-for="(image, index) in mediaList" :key="index" v-else>
											<transition name="slide-fade" :duration="{ enter: 800, leave: 500 }" appear>
												<div class="show-image">
													<img :src="image.link_url" width="1024" height="180" />
													<div class="overlay">
														<a :href="image.link_url" target="_blank">
															<base-button native-type="submit" type="primary" class="btn-fill">
																<i class="tim-icons icon-zoom-split"></i>
															</base-button>
														</a>
														<base-button native-type="submit" type="danger" class="btn-fill" @click="showDeleteWallpaperConfirmationModal(image.id, index)">
															<i class="tim-icons icon-trash-simple"></i>
														</base-button>
														<a :href="image.base64" download="wallpaper.png" target="_blank">
															<base-button native-type="submit" type="success" class="btn-fill">
																<i class="tim-icons icon-cloud-download-93"></i>
															</base-button>
														</a>
													</div>
												</div>
											</transition>
										</div>
									</div>
								</b-card-text>
							</b-card>
						</b-tab>
						<!-- <b-tab title="iPad">
							<b-card class="mb-0">
								<b-card-text>
									<div class="row" v-if="showWallpaperListLoader">
										<div class="col text-center py-5">
											<i class="fa fa-spinner fa-pulse text-primary fa-3x"></i>
										</div>
									</div>
									<div class="row" v-else>
										<div class="col-lg-12" v-if="mediaList.length == 0">
											<p class="py-5 text-center">
												No Wallpaper downloaded yet.
											</p>
										</div>
										<div class="col-lg-4 mb-3 " v-for="(image, index) in mediaList" :key="index" v-else>
											<transition name="slide-fade" :duration="{ enter: 800, leave: 500 }" appear>
												<div class="show-image">
													<img :src="image.link_url" width="1024" height="180" />
													<div class="overlay">
														<a :href="image.link_url" target="_blank">
															<base-button native-type="submit" type="primary" class="btn-fill">
																<i class="tim-icons icon-zoom-split"></i>
															</base-button>
														</a>
														<base-button native-type="submit" type="danger" class="btn-fill" @click="showDeleteWallpaperConfirmationModal(image.id, index)">
															<i class="tim-icons icon-trash-simple"></i>
														</base-button>
														<a :href="image.base64" download="wallpaper.png" target="_blank">
															<base-button native-type="submit" type="success" class="btn-fill">
																<i class="tim-icons icon-cloud-download-93"></i>
															</base-button>
														</a>
													</div>
												</div>
											</transition>
										</div>
									</div>
								</b-card-text>
							</b-card>
						</b-tab> -->
						<b-tab title="Cell Phone">
							<b-card class="mb-0">
								<b-card-text>
									<div class="row" v-if="showWallpaperListLoader">
										<div class="col text-center py-5">
											<i class="fa fa-spinner fa-pulse text-primary fa-3x"></i>
										</div>
									</div>
									<div class="row" v-else>
										<div class="col-lg-12" v-if="mediaList.length == 0">
											<p class="py-5 text-center">
												No Wallpaper downloaded yet.
											</p>
										</div>
										<div class="col-lg-4 mb-3 " v-for="(image, index) in mediaList" :key="index" v-else>
											<transition name="slide-fade" :duration="{ enter: 800, leave: 500 }" appear>
												<div class="show-image">
													<img :src="image.link_url" width="1024" height="180" />
													<div class="overlay">
														<a :href="image.link_url" target="_blank">
															<base-button native-type="submit" type="primary" class="btn-fill">
																<i class="tim-icons icon-zoom-split"></i>
															</base-button>
														</a>
														<base-button native-type="submit" type="danger" class="btn-fill" @click="showDeleteWallpaperConfirmationModal(image.id, index)">
															<i class="tim-icons icon-trash-simple"></i>
														</base-button>
														<a :href="image.base64" download="wallpaper.png" target="_blank">
															<base-button native-type="submit" type="success" class="btn-fill">
																<i class="tim-icons icon-cloud-download-93"></i>
															</base-button>
														</a>
													</div>
												</div>
											</transition>
										</div>
									</div>
								</b-card-text>
							</b-card>
						</b-tab>
					</b-tabs>
				</b-card>
			</div>
		</div>
<!--        <div class="mt-3 text-center">
			<button class="btn btn-primary" @click="showDesktopWallpaper">Desktop</button>
			<button class="btn btn-primary" @click="showiPadpWallpaper">iPad</button>
			<button class="btn btn-primary" @click="showiPhoneWallpaper">iPhone 12</button>
		</div> -->

		<!-- <div class="row">
			<div class="col-lg-12">
				<div class="card px-5 py-5 my-lg-5 mb-0 ">
					<div class="row">
						<div class="col-lg-4 mb-3 " v-for="(image, index) in mediaList" :key="index">
							<transition name="slide-fade" :duration="{ enter: 800, leave: 500 }" appear>
								<div class="show-image">
									<img :src="image.link_url" width="1024" height="180" />
									<div class="overlay">
										<a :href="image.link_url" target="_blank">
											<base-button native-type="submit" type="primary" class="btn-fill">
												<i class="tim-icons icon-zoom-split"></i>
											</base-button>
										</a>
										<base-button native-type="submit" type="danger" class="btn-fill" @click="showDeleteWallpaperConfirmationModal(image.id, index)">
											<i class="tim-icons icon-trash-simple"></i>
										</base-button>
										<a :href="image.base64" download="wallpaper.png" target="_blank">
											<base-button native-type="submit" type="success" class="btn-fill">
												<i class="tim-icons icon-cloud-download-93"></i>
											</base-button>
										</a>
									</div>
								</div>
							</transition>
						</div>
					</div>
				</div>
			</div>
		</div> -->

		<!-- modal for instruction video -->
		<b-modal id="instruction-video-modal" hide-footer hide-header centered>
			<div v-if="videoData">
				<div v-if="videoData.videoType == 'upload'">
					<video width="100%" controls class="h-100">
						<source :src="videoData.link_url" type="video/mp4" />
						Your browser does not support the video tag.
					</video>
				</div>
				<div v-if="videoData.videoType == 'url'">
					<!-- <iframe class="embed-responsive-item" :src="videoData.file_path" id="video" allowscriptaccess="always" allow="autoplay"></iframe> -->
					<div v-if="videoLoading" class="text-center p-5">
						<i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
					</div>
					<div v-if="question_video_iframe != ''" class="embed-responsive embed-responsive-16by9">
						<div v-html="question_video_iframe"></div>
					</div>
				</div>

			</div>
			<div v-else>
				<p class="my-5 text-center font-weight-bold">
					Coming Soon
				</p>
			</div>
		</b-modal>

		<!-- delete wallpaper confirmation modal -->
		<b-modal id="delete-wallpaper-modal" hide-footer hide-header centered>
			<div class="row">
				<div class="col-lg-12 mb-4 text-center">
					<i class="fas fa-exclamation-circle fa-4x text-danger"></i>
					<h4 class="my-3">
						Are you sure to delete wallpaper? 
					</h4>
					<small class="my-3 text-danger">
						This action cann't be undo.
					</small>
				</div>
				<div class="col-lg-12 my-3 text-center">
					<button class="btn btn-info" @click="$bvModal.hide('delete-wallpaper-modal')">Cancel</button>
					<button class="btn btn-danger" :disabled="isDeleteActive" @click="deleteWallpaper(selectedWallpaperId, selectedWallpaperIndex)">
						<i v-if="isDeleteActive" class="fas fa-spinner fa-spin"></i>
						Delete
					</button>
				</div>
			</div>
		</b-modal>


	</div>
</template>
<script>
import IphoneGrid from "@/components/Wallpaper/IphoneGrid.vue";
import IpadGrid from "@/components/Wallpaper/IpadGrid.vue";
import DesktopGrid from "@/components/Wallpaper/DesktopGrid.vue";

export default {
	// props: {
	//          options: {type: Object, default: () => {}},
	//      },
	middleware: "user",
	layout: "user",
	name: "wallpaper",
	components: {
		IphoneGrid,
		IpadGrid,
		DesktopGrid,
	},
	data() {
		const tW = 400;
		const tH = 250;
		const textWidth = 210;
		const textHeight = 50;

		return {
			deviceHeight: "844px",
			deviceWidth: "390px",
			videoData: "",
			isWallpaperGridActive: true,
			isDesktopWallpaperGridActive: false,
			isiPadWallpaperGridActive: false,
			isiPhoneWallpaperGridActive: false,
			mediaList: [],
			selectedWallpaperId: null,
			selectedWallpaperIndex: null,
			tabIndex: 0,
			isDeleteActive: false,
			showWallpaperListLoader: false,
			draftData:{
				backgroundInfo: {
					image: '',
					color: '#a6a6a6'
				},
				foregroundInfo: {
					image: '',
					width: tW,
					height: tH,
					left: `calc( 50% - ${tW / 2}px)`,
					top: `calc(50% - ${tH / 2}px)`,
				},
				textInfo: {
					content: '',
					color: '#a6a6a6',
					fontFamily: 'Poppins',
					width: textWidth,
					height: textHeight,
					left: 0,
					top: 0,
				}
			},
			showDraftedWallpaperLoader: false,
			videoApiData: "",
			question_video_iframe: "",
			videoLoading: false
		};
	},
	computed: {},
	mounted() {
		this.getInstructionVideo();
		this.getVideoApiData();
		this.showDesktopWallpaper("desktop");
	},
	methods: {
		async getVideoApiData() {
		  let url = "admin/getVideoApiData";
		  var self = this;
		  await this.$axios
			.$get(url)
			.then(function(response) {
				self.videoApiData = response;
			})
			.catch(function(error) {
			  self.$bvToast.toast(error, {
				variant: "danger",
				solid: true,
			  });
			});
		},
		openInstructionVideoModal()
		{
			this.$root.$emit('bv::show::modal', 'instruction-video-modal');
			this.getVideoWithUrl();
		},
		getVideoWithUrl() {
			var video_id = this.videoData.file_path.split("/")[3];
			this.videoLoading = true;
			var self = this;

			let Vimeo = require("vimeo").Vimeo;

			let client = new Vimeo(
				this.videoApiData.client_id,
				this.videoApiData.client_secret,
				this.videoApiData.personal_access_token
				);
			client.request(
			{
				method: "GET",
				path: "/videos/" + video_id,
			},
			function(error, body, status_code, headers) {
				if (error) {
					console.log(error);
					self.videoLoading = true;
				} else {
					self.videoLoading = false;
					self.question_video_iframe = body.embed.html;
				}
			}
			);
		},

		showDeleteWallpaperConfirmationModal(wallpaperId, index)
		{
			this.selectedWallpaperId = wallpaperId;
			this.selectedWallpaperIndex = index;
			this.$root.$emit('bv::show::modal', 'delete-wallpaper-modal');
		},
		async getInstructionVideo() {
			let url = "user/getInstructionVideo?video_for=wallpaper";
			var self = this;
			await this.$axios.$get(url)
				.then(function(response) {
					console.log("getInstructionVideo response");
					console.log(response);
					self.videoData = response;
				})
				.catch(function(error) {
					// self.$bvToast.toast(error, {
					//  variant: "danger",
					//  solid: true,
					// });
				});
		},
		showDesktopWallpaperGrid() {
			this.isDesktopWallpaperGridActive = true;
			this.isiPadWallpaperGridActive = false;
			this.isiPhoneWallpaperGridActive = false;
			this.isWallpaperGridActive = false;
			this.getDraftWallpaper("desktop");
		},
		showiPadpWallpaperGrid() {
			this.isDesktopWallpaperGridActive = false;
			this.isiPadWallpaperGridActive = true;
			this.isiPhoneWallpaperGridActive = false;
			this.isWallpaperGridActive = false;
			this.getDraftWallpaper("ipad");
		},
		showiPhoneWallpaperGrid() {
			this.isDesktopWallpaperGridActive = false;
			this.isiPadWallpaperGridActive = false;
			this.isiPhoneWallpaperGridActive = true;
			this.isWallpaperGridActive = false;
			this.getDraftWallpaper("iphone");
		},
		showWallpaperGrid() {
			this.isDesktopWallpaperGridActive = false;
			this.isiPadWallpaperGridActive = false;
			this.isiPhoneWallpaperGridActive = false;
			this.isWallpaperGridActive = true;
		},
		getUpdatedDeviceResolution(height, width)
		{
			this.deviceHeight = height;
			this.deviceWidth = width;
			console.log(this.deviceHeight);
			console.log(this.deviceWidth);
			// resolution = resolution.split('x');
			// this.deviceHeight = resolution[0]; 
			// this.deviceWidth = resolution[1]; 
		},
		tabClicked(event)
		{
			if (this.tabIndex == 0)
			{
				this.showDesktopWallpaper();
			}
			// if (this.tabIndex == 1)
			// {
			// 	this.showiPadpWallpaper();
			// }
			if (this.tabIndex == 1)
			{
				this.showiPhoneWallpaper();
			}
		},
		async getDraftWallpaper(type = "desktop")
		{
			this.showDraftedWallpaperLoader = true;
			let url = "user/getDraftWallpaper?type=" + type;
			var self = this;
			await this.$axios.get(url)
				.then(function(response) {
					console.log('getDraftWallpaper response');
					console.log(response);
					self.draftData = response.data.draft_data;

					self.draftData.backgroundInfo.image = response.data.draft_data.backgroundInfo.image ;
					self.draftData.backgroundInfo.color = response.data.draft_data.backgroundInfo.color ;

					self.draftData.foregroundInfo.image = response.data.draft_data.foregroundInfo.image ;
					self.draftData.foregroundInfo.width = response.data.draft_data.foregroundInfo.width ;
					self.draftData.foregroundInfo.height = response.data.draft_data.foregroundInfo.height ;
					self.draftData.foregroundInfo.left = response.data.draft_data.foregroundInfo.left ;
					self.draftData.foregroundInfo.top = response.data.draft_data.foregroundInfo.top ;

					self.draftData.textInfo.content = response.data.draft_data.textInfo.content ;
					self.draftData.textInfo.color = response.data.draft_data.textInfo.color ;
					self.draftData.textInfo.fontFamily = response.data.draft_data.textInfo.fontFamily ;
					self.draftData.textInfo.width = response.data.draft_data.textInfo.width ;
					self.draftData.textInfo.height = response.data.draft_data.textInfo.height ;
					self.draftData.textInfo.left = response.data.draft_data.textInfo.left ;
					self.draftData.textInfo.top = response.data.draft_data.textInfo.top ;

					// self.mediaList = response.data;
					self.showDraftedWallpaperLoader = false;
					// self.isDesktopWallpaperGridActive = true;
					// self.isiPadWallpaperGridActive = false;
					// self.isiPhoneWallpaperGridActive = false;
					// self.isWallpaperGridActive = false;
				})
				.catch(function(error) {
					console.log(error + 'getDraftWallpaper');
					// self.$bvToast.toast(error, {
					//  variant: "danger",
					//  solid: true,
					// });
				});
		},

		showDesktopWallpaper() {
			this.getWallpapersList("desktop");
		},
		showiPadpWallpaper() {
			this.getWallpapersList("ipad");
		},
		showiPhoneWallpaper() {
			this.getWallpapersList("iphone");
		},

		async getWallpapersList(type = "desktop")
		{
			this.showWallpaperListLoader = true;
			let url = "user/getWallpapersList?type=" + type;
			var self = this;
			await this.$axios.get(url)
				.then(function(response) {
					self.mediaList = response.data;
					self.showWallpaperListLoader = false;
				})
				.catch(function(error) {
					// self.$bvToast.toast(error, {
					//  variant: "danger",
					//  solid: true,
					// });
				});
		},

		async deleteWallpaper(id, index) {
			this.isDeleteActive = true;
			let url = "user/deleteWallpaper/" + id;
			var self = this;
			await this.$axios.get(url)
			.then(function(response) {
				self.mediaList.splice(index, 1);
				self.$root.$emit('bv::hide::modal', 'delete-wallpaper-modal');
				self.isDeleteActive = false;
			})
			.catch(function(error) {
				self.$bvToast.toast(error, {
					variant: "danger",
					solid: true,
				});
			});
		},
	},
};
</script>
<style lang="scss">
@import "~@/assets/sass/dashboard/custom/variables";

.wallpaperGridBG {
	background-position: center !important;
	background-repeat: no-repeat !important;
	background-size: cover !important;
}
/* wallpaper grid */
// .wallpaper-grid {
	/*1170, 2532*/
	/*1280, 1024*/
	/*1600, 1200*/
	/*height: 2532px;*/
	/*width: 1170px;*/
	// height: 500px;
	/*width: 450px;*/
	// background-color: #ffffff;
// }
// .resize-container {
//  width: 100%;
//  height: 100%;
//  display: inline-block;
//  background: transparent;
// }

.wallpaper-grid {
  // padding: 10px;
  // background: white;
  // box-sizing: border-box;
  // resize: horizontal;
  // border: 1px dashed;
  // overflow: auto;
  // max-width: 100%;
  // height: calc(100vh - 100px);

	  // background: white;
	position: relative;
	width: 100%;
}

.resize-container {
	position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
				// text-align: center;
				// font-size: 25px;
				// color: white;
  // width: 100%;
  // padding-bottom: 75%;
}
.desktop-wallpaper-grid
{
	padding-top: 56.25%; /* 16:9 Aspect Ratio */
}
.ipad-wallpaper-grid
{
	padding-top: 75%; /* 4:3 Aspect Ratio */
}
.iphone-wallpaper-grid
{
	// height: var(--device-height);
	// width: var(--device-width);
	padding-top: 85%; /* 3:2 Aspect Ratio */
	// width: 100%;
	width: 375px;
	height: 812px;
	// background-size: auto 100%;
	// background-position: center;
	// background-position: center;    

	// iPhone 13 Pro Max
	// width: 428px;
	// height: 926px;

	// iPhone X
	// width: 375px;
	// height: 812px;
	// background-size: auto 100%;
}
// .wallpaper-grid {
//  background-color: #ffffff;
//  position: relative;
//  &:before {
//      display: block;
//      content: "";
//      width: 100%;
//      padding-top: (9 / 16) * 100%;
//  }
//  > .resize-container {
//      position: absolute;
//      top: 0;
//      right: 0;
//      bottom: 0;
//      left: 0;
//      width: 100%;
//      height: 100%;
//      display: inline-block;
//      background: transparent;
//  }
// }
.primary-bg-color {
	padding: 10px;
	border-radius: 3px;
	height: 10px;
	width: 10px;
	box-shadow: inset 1px 1px 4px rgba(0, 0, 0, 0.5);
	cursor: pointer;
}
.red-background {
	background-color: red !important;
}
.green-background {
	background-color: green !important;
}
.white-background {
	background-color: white !important;
}
.yellow-background {
	background-color: yellow !important;
}
.purple-background {
	background-color: purple !important;
}
.orange-background {
	background-color: orange !important;
}
.black-background {
	background-color: black !important;
}
.blue-background {
	background-color: #004aad !important;
}
.tabs-wrapper .nav-tabs .nav-link.active
{
	background-color: $default;
	color: $white;
	font-weight: bold;
	border-color: $default;
}
.custom-select {
	color: black !important;
}
</style>
