import $ from 'jquery'
import _ from 'lodash'

export default {
  fetchApi ({commit}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: 'local-get-app.php',
        method: 'GET',
        dataType: 'json',
        contentType: 'application/json'
      })
      .done((data, status, xhr) => {
        commit('defineApi', data)
        resolve()
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  login ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'GET',
        dataType: 'json',
        contentType: 'application/json',
        data: {
          action: 'authenticate',
          username: state.username,
          password: state.password
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.errors)) {
          reject(data.errors)
          commit('defineNonce', '')
        } else {
          commit('defineNonce', data.data.nonce)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  getActiveCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'get_active',
          required_plugins: []
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.errors)) {
          if (data.errors.no_active_case) {
            commit('defineCase', {})
            resolve()
          } else {
            reject(data.errors)
          }
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  openCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'open',
          required_plugins: []
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.errors)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  updateCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          id: state.activeCase.id,
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'update',
          required_plugins: state.activeCase.required_plugins,
          url: getters.updatedActiveCase.url
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.errors)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  closeCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'close'
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  suspendCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'suspend'
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  resetCase ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'close',
          reset_active_plugins: true
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  interrogation ({commit, state, getters}) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'cases',
          action: 'review'
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  saveClue ({commit, state, getters}, status) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          outcome: status,
          nonce: state.api.nonce,
          controller: 'clues',
          action: 'create'
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          commit('defineCase', data.data)
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  },
  deactivatePlugins ({commit, state, getters}, plugins) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: getters.updatedApi.api_url,
        method: 'POST',
        dataType: 'json',
        data: {
          nonce: state.api.nonce,
          controller: 'plugins',
          action: 'deactivate',
          plugins
        }
      })
      .done((data, status, xhr) => {
        if (!_.isEmpty(data.error)) {
          reject(data.errors)
        } else {
          resolve()
        }
      })
      .fail((xhr, status, error) => {
        reject(error)
      })
    })
  }
}
