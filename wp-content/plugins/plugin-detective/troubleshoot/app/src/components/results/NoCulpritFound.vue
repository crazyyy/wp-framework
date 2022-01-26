<!-- Bad clues - start again? -->
<template>
  <div class="no-culprit finished">
    <md-empty-state
      md-icon="help_outline"
      md-label="Case Unsolved">
      <p>{{translations.results.unsolved}}</p>
      <md-button class="md-primary" to="/">{{translations.results.startOverButton}}</md-button>
    </md-empty-state>
    <div class="corner-otto">
      <bubble>
        <p>{{translations.results.unsolvedOtto}}</p>
        <md-button class="md-primary md-raised" to="/">{{translations.results.startOverButton}}</md-button>
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