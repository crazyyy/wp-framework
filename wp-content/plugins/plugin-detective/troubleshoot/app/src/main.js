import Vue from 'vue'
import App from './App'
import router from './router'
import VueMaterial from 'vue-material'

Vue.config.productionTip = false

Vue.use(VueMaterial)

/* eslint-disable no-new */
new Vue({
  render: h => h(App),
  router,
}).$mount('#app')
