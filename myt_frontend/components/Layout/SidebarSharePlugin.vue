<template>
    <div class="fixed-plugin" v-click-outside="closeDropDown">
        <div v-if="themeSettingLoader">
                <i class="fa fa-spinner fa-pulse fa-2x text-white"></i>
        </div>

        <div class="dropdown show-dropdown" :class="{ show: isOpen }" v-else>
            <a data-toggle="dropdown" class="settings-icon">
                <i class="fa fa-cog fa-2x" @click="toggleDropDown"> </i>
            </a>

            <ul class="dropdown-menu py-3" :class="{ show: isOpen }">

                <!-- font family -->
                <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                    <label v-for="(option, index) in fontFamilyList" :key="option.name" class="btn btn-sm btn-primary btn-simple" :class="{ active: activeFontFamily.activeIndex === index }" :id="index">
                    	<input type="radio" @click="changeFontFamily(index, option.value)" name="options" autocomplete="off" :checked="activeFontFamily.activeIndex === index"/>
                    	<span class="d-none d-sm-block">{{ option.name }}</span>
                    </label>
                </div>

                <!-- navbar style -->
                <li class="header-title">Navbar Style</li>
                <li class="adjustments-line">
                    <div class="togglebutton switch-change-color mt-3">
                        <span class="label-switch">Colored</span>
                        <base-switch v-model="transparentNavbar" @input="toggleNavbarStyle"></base-switch>
                        <span class="label-switch label-right">Transparent</span>
                    </div>
                </li>

                <!-- navbar background color -->
                <li v-if="!transparentNavbar" class="header-title">Navbar Background</li>
                <li v-if="!transparentNavbar" class="adjustments-line">
                    <a class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span v-for="navColor in navBarColors" :key="navColor.color" class="badge filter" :class="[`badge-${navColor.color}`, { active: navColor.active }]" :data-color="navColor.color" @click="changeNavbarBackground(navColor);"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>

                <!-- sidebar background -->
                <li class="header-title">Sidebar Background</li>
                <li class="adjustments-line">
                    <a class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span v-for="item in sideBarColors" :key="item.color" class="badge filter" :class="[`badge-${item.color}`, { active: item.active }]" :data-color="item.color" @click="changeSidebarBackground(item);"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>

                <!-- light and dark mode -->
                <li class="header-title">Toggle Mode</li>
                <li class="adjustments-line mb-3">
                    <div class="togglebutton switch-change-color mt-3">
                        <span class="label-switch">LIGHT MODE</span>
                        <base-switch v-model="darkMode" @input="toggleMode"></base-switch>
                        <span class="label-switch label-right">DARK MODE</span>
                    </div>
                </li>

                <!-- <li class="button-container mt-4">
                    <a href="https://www.creative-tim.com/learning-lab/nuxt/overview/black-dashboard" target="_blank" rel="noopener" class="btn btn-default btn-block btn-round">
                        Documentation
                    </a>
                    <a href="https://creative-tim.com/product/nuxt-black-dashboard" target="_blank" rel="noopener" class="btn btn-primary btn-block btn-round">
                        Download Now
                    </a>
                    <a href="https://creative-tim.com/product/nuxt-black-dashboard-pro" target="_blank" rel="noopener" class="btn btn-info btn-block btn-round">
                        Upgrade to PRO
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</template>
<script>
    import { BaseSwitch } from '@/components';
    import { mapState } from "vuex";

    export default {
        name: 'sidebar-share',
        components: {
            BaseSwitch
        },
        props: {
            backgroundColor: String
        },
        data() {
            return {
                themeSettingLoader: true,
                sidebarMini: true,
                darkMode: false,
                transparentNavbar: true,
                isOpen: false,
                sideBarColors: [
                    { color: 'golden', active: true, value: 'golden' },
                    { color: 'blue', active: false, value: 'blue' },
                    { color: 'purple', active: false, value: 'purple' },
                    { color: 'yellow', active: false, value: 'yellow' },
                    { color: 'blue_shade_one', active: false, value: '#1f4e78' },
                    { color: 'blue_shade_two', active: false, value: '#2f75b5' },
                    { color: 'blue_shade_three', active: false, value: '#8ea9db' },
                    { color: 'blue_shade_four', active: false, value: '#bdd7ee' },
                    { color: 'blue_shade_five', active: false, value: '#d9e1f2' },
                ],
                navBarColors: [
                    { color: 'golden', active: true, value: 'golden' },
                    { color: 'blue', active: false, value: 'blue' },
                    { color: 'purple', active: false, value: 'purple' },
                    { color: 'yellow', active: false, value: 'yellow' },
                ],
                activeFontFamily: {
                    activeIndex: 0
                },
                fontFamilyList: [
                    { name: 'Poppins', value: 1, className: 'font-family-one' },
                    { name: 'Varela Round', value: 2, className: 'font-family-two' },
                    { name: 'Fredoka One', value: 3, className: 'font-family-three' },
                    { name: 'Roboto', value: 4, className: 'font-family-four' },
                    { name: 'Montserrat', value: 5, className: 'font-family-five' },
                    { name: 'Raleway', value: 6, className: 'font-family-six' }             
                ],
                themeSettingObj: {
					font_family: 1,
					navbar_style: 1,
					navbar_color: 'golden',
					sidebar_color: 'golden',
					default_theme: 0
                }
            };
        },
    computed: {
        // fontFamilyList () {
        //   return [{ name: 'Accounts', icon: 'tim-icons icon-single-02' }, {
        //     name: 'Purchases',
        //     icon: 'tim-icons icon-gift-2'
        //   }, { name: 'Sessions', icon: 'tim-icons icon-tap-02' }];
        // }
        ...mapState("auth", ["loggedIn", "user"]),
    },
    mounted () {
        this.getDefaultThemeSettings();
    },
    methods: {
        async getDefaultThemeSettings() {
            this.themeSettingLoader = true;
            let url = "getUserDefaultThemeSettings?user_id="+this.user.id;
            var self = this;
            await this.$axios.$get(url).then(function(response) {
                self.themeSettingLoader = false;

                // font family
                var selectedFontFamily = response.font_family;
                self.changeFontFamily(selectedFontFamily-1,selectedFontFamily);

                // light & dark mode
                self.darkMode = (response.default_theme == 0 ) ? false : true;
                self.toggleMode(self.darkMode);

                // navbar color
                self.transparentNavbar = (response.navbar_style == 0 ) ? false : true;
                self.toggleNavbarStyle(self.transparentNavbar)
                if (!self.transparentNavbar) {
                    var selectedNavbarColor = self.getActiveNavbarColorObject(response.navbar_color);
                    self.changeNavbarBackground(selectedNavbarColor)
                }

                // sidebar color
                var selectedSidebarColor = self.getActiveSidebarColorObject(response.sidebar_color);
                self.changeSidebarBackground(selectedSidebarColor);

				self.themeSettingObj.font_family = selectedFontFamily;
				self.themeSettingObj.navbar_style = self.transparentNavbar;
				self.themeSettingObj.navbar_color = response.navbar_color;
				self.themeSettingObj.sidebar_color = response.sidebar_color;
				self.themeSettingObj.default_theme = self.darkMode;
			})
            .catch(function(error) {
                self.themeSettingLoader = true;
                self.$bvToast.toast("getUserDefaultThemeSettings", {
                    variant: "danger",
                    solid: true,
                });
            });
        },
        getActiveNavbarColorObject(colorVal)
        {
            for (var i = 0; i < this.navBarColors.length; i++) {
                if (this.navBarColors[i].value == colorVal)
                {
                    return this.navBarColors[i];
                    break;
                }
            }
        },
        getActiveSidebarColorObject(colorVal)
        {
            for (var i = 0; i < this.sideBarColors.length; i++) {
                if (this.sideBarColors[i].value == colorVal)
                {
                    return this.sideBarColors[i];
                    break;
                }
            }
        },
        async updateThemeSetting()
        {
			var self = this;
	        await this.$axios.$post('updateUserThemeSetting',this.themeSettingObj)
	        .then(function(response)
	        {
	        	// console.log('updateUserThemeSetting');
	        	// console.log(response);
	        })
	        .catch(function(error){
	            self.$bvToast.toast(error, {
	                variant: 'danger',
	                solid: true,
	            });
	        });
        },
        changeFontFamily(index, value) {
            let docClasses = document.body.classList;
            // console.log(docClasses);
        
            for (var i = 0; i < this.fontFamilyList.length; i++) {
                docClasses.remove(this.fontFamilyList[i].className);
            }
            switch (value) {
                case 1:
                    docClasses.add('font-family-one');
                    break;
                case 2:
                     docClasses.add('font-family-two');
                    break;
                case 3:
                    docClasses.add('font-family-three');
                    break;
                case 4:
                    docClasses.add('font-family-four');
                    break;
                case 5:
                    docClasses.add('font-family-five');
                    break;
                case 6:
                    docClasses.add('font-family-six');
            }
            this.activeFontFamily.activeIndex = index;
            this.themeSettingObj.font_family = value;
            this.updateThemeSetting();
        },

        toggleDropDown() {
            this.isOpen = !this.isOpen;
        },
        closeDropDown() {
            this.isOpen = false;
        },
        toggleList(list, itemToActivate) {
            list.forEach(listItem => {
                listItem.active = false;
            });
            itemToActivate.active = true;
        },
        changeSidebarBackground(item) {
            this.$emit('update:backgroundColor', item.value);
            this.themeSettingObj.sidebar_color = item.value;
            this.updateThemeSetting();
            this.toggleList(this.sideBarColors, item);
        },
        changeNavbarBackground(item) {
            this.$emit('update:navBackgroundColor', item.value);
            this.themeSettingObj.navbar_color = item.value;
            this.updateThemeSetting();
            this.toggleNavList(this.navBarColors, item);
        },
        toggleNavList(list, itemToActivate) {
            list.forEach(listItem => {
                listItem.active = false;
            });
            itemToActivate.active = true;
        },
        toggleMode(type) {
            let docClasses = document.body.classList;

            this.themeSettingObj.default_theme = type;
            this.updateThemeSetting();
            if (type) {
                docClasses.remove('white-content');
            } else {
                docClasses.add('white-content');
            }
        },
        toggleNavbarStyle(style) {
            this.transparentNavbar = style;
            this.themeSettingObj.navbar_style = style;
            this.updateThemeSetting();
            this.$emit('update:navbarStyle', this.transparentNavbar);
        },
        minimizeSidebar() {
            this.$sidebar.toggleMinimize();
        }
    }
};
</script>
<style scoped lang="scss">
@import '~@/assets/sass/dashboard/custom/variables';

.settings-icon {
    cursor: pointer;
}

.badge-golden {
    background-color: $golden;
}
.badge-blue {
    background-color: $blue;
}
.badge-yellow {
    background-color: $yellow;
}
.badge-purple {
    background-color: $purple;
}
.badge-blue_shade_one {
    background-color: $blue_shade_one;
}
.badge-blue_shade_two {
    background-color: $blue_shade_two;
}
.badge-blue_shade_three {
    background-color: $blue_shade_three;
}
.badge-blue_shade_four {
    background-color: $blue_shade_four;
}
.badge-blue_shade_five {
    background-color: $blue_shade_five;
}
</style>
