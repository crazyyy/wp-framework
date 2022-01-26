<template>
  <div class="find-problem">
    <screen-field v-model="iframeUrl" @load="siteLoaded"></screen-field>
    <transition name="fade">
      <div class="corner-otto" v-show="!loading">
        <bubble>
          <p v-if="updatedApi.site_url !== updatedActiveCase.url">{{translations.case.problemUrl}}</p>
          <p v-else>{{translations.case.findProblem}}</p>
          <md-button class="md-raised md-primary" to="/key-witnesses" @click.native="updateCase">{{translations.case.problemButton}}</md-button>
        </bubble>
        <img :src="updatedApi.static_url + '/robot-corner.svg'" alt="Otto the Robot">
      </div>
    </transition>
  </div>
</template>

<script>
import store from '@/store'
import Bubble from './Bubble'
import ScreenField from './ScreenField'
import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'

export default {
  name: 'find-problem',
  components: { Bubble, ScreenField },
  store,
  data () {
    return {
      loading: true
    }
  },
  beforeMount () {
    this.defineCaseUrl(this.updatedActiveCase.url ? this.updatedActiveCase.url : this.updatedApi.site_url)
  },
  computed: {
    iframeUrl: {
      get () {
        return this.updatedActiveCase.url
      },
      set (value) {
        this.defineCaseUrl(value)
      }
    },
    ...mapState([
      'api',
      'activeCase',
      'translations'
    ]),
    ...mapGetters([
      'updatedActiveCase',
      'updatedApi'
    ])
  },
  methods: {
    siteLoaded () {
      this.loading = false
    },
    ...mapMutations([
      'defineCaseUrl'
    ]),
    ...mapActions([
      'updateCase'
    ])
  }
}
</script>