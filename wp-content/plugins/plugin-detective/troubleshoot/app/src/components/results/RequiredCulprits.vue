<!-- No culprits found - suggest other options -->
<template>
  <div class="no-culprit finished">
  	<md-empty-state
  		md-icon="help_outline"
  		md-label="No Culprit Found">
			<p>{{translations.results.noCulprit}}</p>
			<ul>
				<li>{{translations.results.theme}}</li>
				<li v-if="activeCase.required_plugins.length">{{translations.results.requiredPlugins}}</li>
				<li>{{translations.results.muPlugins}}</li>
			</ul>
      <md-button to="/" class="md-primary">{{translations.results.startOverButton}}</md-button>
		</md-empty-state>
  	<div class="corner-otto">
  		<bubble>
  			<p>{{translations.results.noCulpritOtto}}</p>
        <md-button to="/" class="md-primary md-raised">{{translations.results.startOverButton}}</md-button>
  		</bubble>
  		<img :src="updatedApi.static_url + '/robot-corner.svg'" alt="Otto the Robot">
  	</div>
  </div>
</template>

<script>
import Bubble from '../Bubble'
import { mapState, mapGetters } from 'vuex'

export default {
  name: 'no-culprits-found',
  components: { Bubble },
  data () {
    return {}
  },
  computed: {
    ...mapState([
      'activeCase',
      'api',
      'translations'
    ]),
    ...mapGetters([
      'updatedApi'
    ])
  }
}
</script>