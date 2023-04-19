<template>
  <div class="witnesses">
    <loading :text="translations.witnesses.loading" v-if="loading"></loading>
    <template v-else>
      <md-toolbar md-elevation="0" class="md-primary">
        <h1 class="md-title">{{translations.witnesses.title}}</h1>
      </md-toolbar>
      <md-content>
        <p class="md-body-2">{{translations.witnesses.description}}</p>
      </md-content>
      <md-list>
        <md-list-item v-for="plugin in activeCase.all_suspects" :key="plugin.slug">
          <md-checkbox v-model="required" :value="plugin.plugin_file"/>
          <plugin-avatar :slug="plugin.plugin_file"></plugin-avatar>
          <span class="md-list-item-text">
            {{plugin.Title}}
          </span>
        </md-list-item>
      </md-list>
      <div class="corner-otto">
        <bubble>
          <p>{{translations.witnesses.ottoQuestion}}</p>
          <md-button class="md-raised md-primary" @click.native="sendRequired">I'm done</md-button>
        </bubble>
        <img :src="updatedApi.static_url + '/robot-corner.svg'" alt="Otto the Robot">
      </div>
    </template>
  </div>
</template>

<script>
import store from '@/store'
import Bubble from './Bubble'
import PluginAvatar from './PluginAvatar'
import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
import Loading from './Loading'

export default {
  name: 'witnesses',
  components: { Bubble, Loading, PluginAvatar },
  store,
  data () {
    return {
      loading: false
    }
  },
  computed: {
    required: {
      get () {
        return this.activeCase.required_plugins
      },
      set (value) {
        this.defineRequired(value)
      }
    },
    ...mapState([
      'router',
      'api',
      'activeCase',
      'translations'
    ]),
    ...mapGetters([
      'updatedApi'
    ])
  },
  methods: {
    sendRequired () {
      this.loading = true
      this.updateCase()
        .then(() => {
          this.router.push('/interrogating')
        })
        .catch((error) => {
          console.log(error)
        })
    },
    ...mapMutations([
      'defineRequired'
    ]),
    ...mapActions([
      'updateCase'
    ])
  }
}
</script>