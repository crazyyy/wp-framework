<template>
  <div class="loading">
    <div>
      <md-progress-spinner md-mode="indeterminate" class="md-accent"></md-progress-spinner>
      <p v-if="text">{{text}}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'loadingComponent',
  props: [ 'text' ],
  data () {
    return {}
  }
}
</script>