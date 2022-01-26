<template>
  <required-culprits v-if="activeCase.outcome === 'required_plugins_broken'"></required-culprits>
  <broken-loop v-else-if="activeCase.outcome === 'broken_loop'"></broken-loop>
  <culprits-found v-else-if="activeCase.culprits.length"></culprits-found>
  <no-culprit-found v-else></no-culprit-found>
</template>

<script>
import store from '@/store'
import { mapState } from 'vuex'
import NoCulpritFound from './results/NoCulpritFound'
import CulpritsFound from './results/CulpritsFound'
import RequiredCulprits from './results/RequiredCulprits'
import BrokenLoop from './results/BrokenLoop'

export default {
  name: 'complete',
  components: { NoCulpritFound, CulpritsFound, RequiredCulprits, BrokenLoop },
  store,
  data () {
    return {}
  },
  computed: {
    ...mapState([
      'activeCase'
    ])
  }
}
</script>