// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import {sync} from 'vuex-router-sync'
import Vue from 'vue'
import Vuex from 'vuex'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import routes from '@/router/index'
import VuexStore from '@/vuex/store'
import VueTheMask from 'vue-the-mask'
import LoginInterceptors from '@/services/interceptors'
import '@/templates/utils/filters'
import '@/assets/global.css'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(Vuex)
Vue.use(VueResource)
Vue.use(VueRouter)
Vue.use(VueTheMask)

Vue.http.options.root = process.env.ROOT_API1

const store = new Vuex.Store(VuexStore)

const router = new VueRouter({
  mode: 'history',
  routes
})

LoginInterceptors.checkAuth()
LoginInterceptors.refreshAuth()
LoginInterceptors.refreshNotifications()

sync(store, router)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  watch: {
    '$route' (to, from) {
      this.$store.dispatch('clearRegistries')
    }
  },
  components: { App },
  template: '<App/>'
})
