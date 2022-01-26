<template>
  <md-avatar v-if="plugin.icon" class="checkbox-avatar" :class="size">
    <img :src="plugin.icon" :alt="plugin.Title" @error="replaceImage">
    <md-tooltip md-direction="top">{{plugin.Title}}</md-tooltip>
  </md-avatar>
  <md-avatar class="md-avatar-icon checkbox-avatar md-accent" :class="size" v-else>
    {{plugin.Title.charAt(0)}}
    <md-tooltip md-direction="top">{{plugin.Title}}</md-tooltip>
  </md-avatar>
</template>

<script>
import store from '@/store'
import { mapState, mapMutations } from 'vuex'

export default {
  name: 'plugin-avatar',
  store,
  props: {
    slug: {
      type: String
    },
    size: {
      default: 'md-small',
      type: String
    }
  },
  data () {
    return {}
  },
  computed: {
    plugin () {
      return this.activeCase.all_suspects[this.slug]
    },
    ...mapState([
      'activeCase'
    ])
  },
  methods: {
    replaceImage () {
      this.removeImage(this.plugin.plugin_file)
    },
    ...mapMutations([
      'removeImage'
    ])
  }
}
</script>