import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'

Vue.use(Vuex)

const state = {
  router,
  'api': undefined,
  'username': '',
  'password': '',
  'activeCase': undefined,
  'user_id': undefined,
  'requestProtocol': 'http:',
  'translations': {}
}

export default new Vuex.Store({
  state,
  actions,
  mutations,
  getters
})
