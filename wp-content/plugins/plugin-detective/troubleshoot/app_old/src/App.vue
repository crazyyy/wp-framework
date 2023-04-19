<template>
  <div id="app">
    <loading v-if="loading" :text="translations.loading.message"></loading>
    <template v-else-if="error">
      <md-empty-state
        md-icon="error_outline"
        :md-label="translations.error.errorHeadline"
        :md-description="translations.error.errorDescription"></md-empty-state>
    </template>
    <template v-else>
      <md-button class="md-fab md-accent md-fab-top-left md-dense" :href="updatedApi.site_url + '/wp-admin'" @click.native="resetCase">
        <md-icon>keyboard_backspace</md-icon>
        <md-tooltip md-direction="right">{{translations.general.backToWp}}</md-tooltip>
      </md-button>
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </template>

    <md-dialog :md-active.sync="showLogin" :md-close-on-esc="false" :md-click-outside-to-close="false">
      <md-dialog-title>{{translations.login.title}}</md-dialog-title>
      <md-dialog-content>
        <p v-if="loginError">{{loginErrorMessage}}</p>
        <p v-else>{{translations.login.instructions}}</p>
        <form novalidate @submit.prevent="authenticate">
          <md-field>
            <label>{{translations.login.username}}</label>
            <md-input v-model="lUsername"></md-input>
          </md-field>
          <md-field>
            <label>{{translations.login.password}}</label>
            <md-input v-model="lPassword" type="password"></md-input>
          </md-field>
        </form>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button class="md-primary" @click="authenticate">{{translations.login.title}}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
import store from '@/store'
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import _ from 'lodash'
import Loading from '@/components/Loading'

export default {
  name: 'app',
  store,
  components: { Loading },
  data () {
    return {
      'loading': true,
      'error': false,
      'localApi': window.app ? window.app : {},
      'getNonce': undefined,
      'showLogin': false,
      'loginError': false
    }
  },
  beforeCreate () {
    this.wpTranslations = window.pd_translations ? window.pd_translations : {}
    this.$store.commit('defineTranslations', this.wpTranslations)
  },
  beforeMount () {
    if (!this.activeCase) {
      this.router.push('/')
    }
    this.defineRequestProtocol(window.location.protocol)
    window.addEventListener('beforeunload', () => { this.resetCase() })
  },
  mounted () {
    let params = new URLSearchParams(window.location.search)
    this.defineUserId(params.get('session') ? params.get('session') : undefined)
    this.getNonce = params.get('nonce') ? params.get('nonce') : undefined
    this.init()
  },
  methods: {
    init () {
      if (typeof this.api === 'undefined' && !_.isEmpty(this.localApi)) {
        this.defineApi(this.localApi)
        this.init()
        return
      }

      if (typeof this.api === 'undefined') {
        this.loading = true
        this.fetchApi()
          .then(() => {
            if (this.api.nonce) {
              this.getActiveCase()
            }
            this.init()
          })
          .catch((xhr, error) => {
            this.loading = false
            this.error = true
            console.log('Error loading API')
          })
        return
      }

      if (!this.api.nonce && this.getNonce) {
        this.defineNonce(this.getNonce)
        this.getActiveCase()
          .then(() => {
            this.showLogin = false
          })
          .catch((error) => {
            this.showLogin = true
            console.log(error)
          })
        this.init()
        return
      }

      if (!this.api.nonce && !this.getNonce) {
        this.showLogin = true
        return
      }

      this.loading = false
    },
    authenticate () {
      this.login()
        .then(() => {
          this.loginError = false
          this.showLogin = false
          if (this.api.nonce) {
            this.getActiveCase()
              .then(() => {
                this.loading = false
              })
          }
        })
        .catch((error) => {
          this.loginError = error.authentication
        })
    },
    ...mapActions([
      'fetchApi',
      'login',
      'getActiveCase',
      'resetCase'
    ]),
    ...mapMutations([
      'defineApi',
      'defineNonce',
      'defineUsername',
      'definePassword',
      'defineUserId',
      'defineRequestProtocol'
    ])
  },
  computed: {
    loginErrorMessage () {
      switch (this.loginError) {
        case ('invalid_username'):
          return this.translations.login.invalid_username
        case ('incorrect_password'):
          return this.translations.login.incorrect_password
        case ('permission_denied'):
          return this.translations.login.permission_denied
        default:
          return this.translations.login.error
      }
    },
    lUsername: {
      get () {
        return this.username
      },
      set (value) {
        this.defineUsername(value)
      }
    },
    lPassword: {
      get () {
        return this.password
      },
      set (value) {
        this.definePassword(value)
      }
    },
    ...mapState([
      'api',
      'username',
      'password',
      'user_id',
      'activeCase',
      'router',
      'translations'
    ]),
    ...mapGetters([
      'updatedApi'
    ])
  }
}
</script>

<style lang="scss">
  @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
  @import '~vue-material/dist/vue-material.css';
  @import './assets/app.scss';
</style>
