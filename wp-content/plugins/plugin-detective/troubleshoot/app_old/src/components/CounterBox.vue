<template>
  <md-card class="transparent text-centered" :class="display">
    <md-card-header>
      <md-card-header-text>
        <h2 class="md-title">{{title}}</h2>
      </md-card-header-text>
    </md-card-header>
    <md-card-content>
      <loading v-if="loading" :text="loadingmsg"></loading>
      <div class="suspects-box" v-else>
        <span class="number md-display-3">{{count}}</span>
        <span class="desc md-body-1">{{count === 1 ? 'suspect' : 'suspects'}}</span>
      </div>
      <div class="suspects-list" v-if="avatars.length && !loading">
        <plugin-avatar v-for="avatar in avatars" :key="avatar" :slug="avatar" :size="''"></plugin-avatar>
      </div>
    </md-card-content>
  </md-card>
</template>

<script>
import Loading from './Loading'
import PluginAvatar from './PluginAvatar'

export default {
  name: 'counter-box',
  components: { Loading, PluginAvatar },
  props: {
    'title': {
      type: String
    },
    'loading': {
      type: Boolean
    },
    'loadingmsg': {
      default: '',
      type: String
    },
    'count': {
      default: 0,
      type: Number
    },
    'avatars': {
      default: () => {
        return []
      },
      type: Array
    },
    'display': {
      default: '',
      type: String
    }
  },
  data () {
    return {}
  }
}
</script>