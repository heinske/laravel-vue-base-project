import Vue from 'vue'

const state = {
  classificacoes: [],
  classificacao: [],
}

const getters = {
  getClassificacoes: state => {
    return state.classificacoes
  },
  getClassificacao: state => {
    return state.classificacao
  }
}

const mutations = {
  setClassificacoes (state, data) {
    state.classificacoes = data
  },
  setClassificacao (state, data) {
    state.classificacao = data
  },
}

const actions = {
  getClassificacoes (context) {
    Vue.http.get('api/documento/classificacao').then(response => {
      context.commit('setClassificacoes', response.body.data)
    })
  },
  getClassificacoesIndex (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/classificacao?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setClassificacoes', response.body.data.data)
    })
  },
  getClassificacao (context, id) {
    Vue.http.get('api/classificacao/' + id).then(response => {
      context.commit('setClassificacao', response.data.data)
    })
  },
}

export default {
  state,
  mutations,
  actions,
  getters
}
