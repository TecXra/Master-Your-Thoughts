<template>
	<div>
		<b-tabs content-class="mt-3" fill>
			<b-tab active @click="updateSearchText('iphone-12-pro-cool-wallpaper')">
				<template #title>
					<p class="text-primary mb-0 font-weight-bold">
						Cool
					</p>
				</template>
				<div class="row" v-if="isLoading">
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
				</div>
				<div class="row" v-else>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center" v-for="photo in photos" :key="photo.id">
						<img class="image-list cursor-pointer" height="300" width="200" :src="photo.urls.thumb" alt="img" @click="applyPhoto(photo)" />
					</div>
				</div>
			</b-tab>

			<b-tab @click="updateSearchText('iphone-12-pro-nature-wallpaper')">
				<template #title>
					<p class="text-primary mb-0 font-weight-bold">
						Nature
					</p>
				</template>
				<div class="row" v-if="isLoading">
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center mt-2"> <b-skeleton-img height="200px" width="200px"></b-skeleton-img> </div>
				</div>
				<div class="row" v-else>
					<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center" v-for="photo in photos" :key="photo.id">
						<img class="image-list cursor-pointer" height="300" width="200" :src="photo.urls.thumb" alt="img" @click="applyPhoto(photo)" />
					</div>
				</div>
			</b-tab>
		</b-tabs>
		<div class="row mt-3">
			<div class="col-lg-12">
				<b-pagination
				v-model="currentPage"
				:total-rows="rows"
				:per-page="perPage"
				@change="searchPhoto"
				align="fill"
				>
				<template #first-text>
					<span class="text-info">First</span>
				</template>
				<template #prev-text>
					<span class="text-info">Prev</span>
				</template>
				<template #next-text>
					<span class="text-info">Next</span>
				</template>
				<template #last-text>
					<span class="text-info">Last</span>
				</template>
				<template #page="{ page, active }">
					<b v-if="active">{{ page }}</b>
					<i v-else class="text-dark">{{ page }}</i>
				</template>
			</b-pagination>
		</div>
	</div>
</div>
</template>

<script>

	export default {

		name: 'iphone-image-library',
		data () {
			return {
				isLoading: true,
				photos: [],
				search: 'explore iphone nature hd wallpapers cool hd wallpapers',
				photo_url: null,
				download_url: null,
				rows: 100,
				perPage: 1,
				currentPage: 1,
			}
		},

		mounted()
		{
			this.searchPhoto(this.currentPage);
		},
		computed: { },
		methods: {
			updateSearchText(searchText)
			{
				this.search = searchText;
				this.searchPhoto(this.currentPage);
			},
			async searchPhoto(page)
			{
				this.currentPage = page;
				var self = this;
				this.isLoading = true;
				let appid = "wx3y2JRWA1vYrHEVbo_x0wgPS8k2jk2xNwkeJwxJiL0";

			// await this.$axios.$get(`https://api.unsplash.com/search/collections?page=${this.currentPage}&per_page=12&query=${this.search}&client_id=${appid}`)
				await this.$axios.$get(`https://api.unsplash.com/search/photos?page=${this.currentPage}&per_page=12&order_by=relevant&orientation=portrait&query=${this.search}&client_id=${appid}`)
				.then(response => {
					self.photos = response.results
					self.isLoading = false;
				})
				.catch(e => {
					self.isLoading = true;
					console.log(e)
				})
			},
			applyPhoto(photo)
			{
				console.log(photo);

				this.photo_url = photo.urls.regular
				this.download_url = photo.links.download + '?force=true'
				this.$emit('showPhotoUrl', this.photo_url);
			},
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
	.image-list
	{
		margin-top: 12px;
	}
	.page-link
	{
		padding: 0.7rem !important;
	}
</style>
