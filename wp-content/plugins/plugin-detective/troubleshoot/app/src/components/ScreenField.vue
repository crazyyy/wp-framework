<template>
  <div class="screen" :class="{loading}">
    <loading v-if="loading" :text="translations.case.loading"></loading>
    <div class="frame-wrap">
      <div class="frame-address">
        <div class="site-base">{{urlBase}}</div>
        <div class="site-path">
          <input type="text" :value="urlPath" @keydown="updateUrl"/>
        </div>
      </div>
      <iframe :src="value" frameborder="0" @load="loaded"></iframe>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Loading from './Loading'

export default {
  name: 'screen-field',
  props: [ 'value' ],
  components: { Loading },
  data () {
    return {
      loading: true,
      initialized: false,
      urlParser: document.createElement('a')
    }
  },
  watch: {
    value() {
      this.urlParser.href = this.value
    }
  },
  computed: {
    urlBase () {
      return this.urlParser.origin
    },
    urlPath () {
      // clone urlParser DOM element to prevent mutation.
      const parser = document.createElement('a')
      parser.href = this.value
      
      parser.protocol = 'ftp://'
      return parser.pathname + parser.search + parser.hash
    },
    ...mapState([
      'translations'
    ])
  },
  methods: {
    updateUrl (e) {
      if (e.keyCode === 13) {
        var completeUrl = this.urlBase + e.target.value
        this.$emit('input', completeUrl)
      }
    },
    loaded () {
      if (this.initialized) {
        let iframe = document.getElementsByTagName('iframe')[0]
        this.$emit('input', iframe.contentWindow.location.href)
      } else {
        this.initialized = true
        this.loading = false
        this.$emit('load')
      }
    }
  }
}
</script>