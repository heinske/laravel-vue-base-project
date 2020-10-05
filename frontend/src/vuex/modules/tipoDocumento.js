import Vue from 'vue'

const state = {
  tiposDocumento: [],
  tiposIndex: [],
  tipo: [],
}

const getters = {
  getTiposDocumento: state => {
    return state.tiposDocumento
  },
  getTipos: state => {
    return state.tiposIndex
  },
  getTipo: state => {
    return state.tipo
  }
}

const mutations = {
  setTiposDocumento (state, data) {
    state.tiposDocumento = data
  },
  setTipo (state, data) {
    state.tipo = data
  },
  setTipos (state, data) {
    state.tiposIndex = data
  },
}

const actions = {
  getTiposDocumento (context, id) {
    Vue.http.get('api/documento/tipo').then(response => {
      context.commit('setTiposDocumento', response.body.data)
    })
  },
  getTiposIndex (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/tipo?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setTipos', response.body.data.data)
    })
  },
  getTipo (context, id) {
    Vue.http.get('api/tipo/' + id).then(response => {
      context.commit('setTipo', response.data.data)
    })
  },
}

export default {
  state,
  mutations,
  actions,
  getters
}
