/** determining the env file name to read from according to the environment */
const path = require('path');
const fs = require('fs');
const env = process.env.NODE_ENV;
const envFile = `.env.${env}`;
const envPath = path.resolve(process.cwd(), envFile);
const defaultEnvFile =  '.env';
const defaultEnvPath = path.resolve(process.cwd(), defaultEnvFile);
require('dotenv-expand')(require('dotenv').config({
		path: fs.existsSync(envPath) ? envPath : defaultEnvPath,
}));
const envFileUsable = fs.existsSync(envPath) ? envFile : defaultEnvFile;

export default {
  ssr: false ,
  target: 'static', //server
  /*
  ** Headers of the page
  */
  head: {
    title: 'Master Your Thoughts Boot Camp',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.png' },
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800'},
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css2?family=Varela+Round&display=swap'},
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap' },
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css2?family=Roboto&display=swap' },
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css2?family=Montserrat&display=swap' },
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://fonts.googleapis.com/css2?family=Raleway&display=swap' },

      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css'}
    ],
    bodyAttrs: {
      class: 'white-content font-family-one' // Add `white-content` class here to enable "white" mode.
    },
    
  },
  router: {
    linkExactActiveClass: 'active'
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#fff' },
  /*
   ** Global CSS
   */
  css: [
    'assets/fonts/LucidaHandwritingItalic.css',
    'assets/css/demo.css',
    'assets/css/nucleo-icons.css',
    'assets/sass/black-dashboard.scss',
  ],
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    `~/plugins/dashboard-plugin.js`,
    '~plugins/filters.js',
    { src: '~/plugins/client-only-plugin.js', mode: 'client', ssr: false },
    { src: '~/plugins/vue-fullcalendar.js', ssr: false }
  ],
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
    // With options
    ['@nuxtjs/moment', { /* module options */ }]
  ],
  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/auth',
    '@nuxtjs/axios',
    '@nuxtjs/pwa',
    'nuxt-i18n',
    'bootstrap-vue/nuxt'
  ],
  i18n: {
    locales: [
      {
        code: 'en',
        file: 'en.js'
      },
      {
        code: 'ar',
        file: 'ar.js'
      }
    ],
    lazy: true,
    langDir: 'lang/',
    defaultLocale: 'en',
  },
  /*
  ** Axios module configuration
  */
  axios: {
      // See https://github.com/nuxt-community/axios-module#options
      baseURL: process.env.BASE_URL
  },
  
    env: {
      baseUrl: process.env.BASE_URL,
      providerURL: process.env.WORDPRESS_BASE_URL
    },



  /*
  ** Auth module configuration
  */
  
  auth: {
		strategies: {
			local: {
				endpoints: {
          login: {url: 'auth/login', method: 'post', propertyName: 'access_token'},
					user: {url: 'user/authUserData', method: 'get', propertyName: false},
					logout: {url: 'auth/logout', method: 'get'}
				},
				tokenRequired: true,
    		tokenType: 'Bearer'
			}
		},
		rewriteRedirects: true,
		redirect: {
      login: '/login',
			logout: '/',
			home: '/',
		},

	},





  /*
  ** Build configuration
  */
  build: {
    transpile: [/^element-ui/, /@fullcalendar.*/],

    /*
    ** You can extend webpack config here
    */
    extend (config, ctx) {
      config.node = {
          fs: 'empty'
      }
    },
    babel: {
      compact: true,
      plugins: [
        [
          'component',
          {
            'libraryName': 'element-ui',
            'styleLibraryName': 'theme-chalk'
          }
        ]
      ]
    }
  }
}
