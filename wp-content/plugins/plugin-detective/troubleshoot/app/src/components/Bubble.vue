<template>
  <div class="bubble-wrap">
    <div class="bubble" v-if="open">
      <div class="close" @click="toggleOpen">
        <md-icon>close</md-icon>
      </div>
      <slot></slot>
    </div>
    <div class="toggle" v-else>
      <div class="open" @click="toggleOpen">
        <md-icon class="md-accent">chat</md-icon>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'hello',
  data () {
    return {
      open: true
    }
  },
  methods: {
    toggleOpen () {
      this.open = !this.open
    }
  }
}
</script>