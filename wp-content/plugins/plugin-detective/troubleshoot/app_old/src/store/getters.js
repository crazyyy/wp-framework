export default {
  interrogatingCount (state) {
    if (!state.activeCase) {
      return 0
    }
    if (!state.activeCase.suspects_under_interrogation) {
      return 0
    }
    return state.activeCase.suspects_under_interrogation.length
  },
  clearedCount (state) {
    if (!state.activeCase) {
      return 0
    }
    if (!state.activeCase.cleared_suspects) {
      return 0
    }
    return state.activeCase.cleared_suspects.length
  },
  remainingCount (state, getters) {
    return getters.holdingCell.length
  },
  notHolding (state) {
    if (!state.activeCase) {
      return []
    }
    if (!state.activeCase.cleared_suspects) {
      return []
    }
    if (!state.activeCase.suspects_under_interrogation) {
      return []
    }
    return [...state.activeCase.cleared_suspects, ...state.activeCase.suspects_under_interrogation]
  },
  holdingCell (state, getters) {
    if (!state.activeCase) {
      return []
    }
    if (!state.activeCase.all_suspects) {
      return []
    }
    return Object.keys(state.activeCase.all_suspects).filter((el) => {
      return getters.notHolding.indexOf(el) < 0
    })
  },
  updatedApi (state) {
    if (typeof state.api === 'undefined') {
      return
    }

    let api = {}
    for (var prop in state.api) {
      if (state.api[prop] && typeof state.api[prop] === 'string' && state.api[prop].indexOf('http') > -1) {
        let url = document.createElement('a')
        url.setAttribute('href', state.api[prop])
        api[prop] = state.api[prop].replace(url.protocol, state.requestProtocol)
      } else {
        api[prop] = state.api[prop]
      }
    }
    return api
  },
  updatedActiveCase (state) {
    if (typeof state.activeCase === 'undefined') {
      return
    }

    let activeCase = {}
    for (var prop in state.activeCase) {
      if (state.activeCase[prop] && typeof state.activeCase[prop] === 'string' && state.activeCase[prop].indexOf('http') > -1) {
        let url = document.createElement('a')
        url.setAttribute('href', state.activeCase[prop])
        activeCase[prop] = state.activeCase[prop].replace(url.protocol, state.requestProtocol)
      } else {
        activeCase[prop] = state.activeCase[prop]
      }
    }

    return activeCase
  }
}
