import Vue from 'vue'

const state = {
  listagemEliminacao: {
    historicos: []
  },
  listagensEliminacao: [],
  listaListagensEliminacao: []
}

const getters = {
  getListagensEliminacao: state => {
    return state.listagensEliminacao
  },
  getListagemEliminacao: state => {
    return state.listagemEliminacao
  },
  getListaListagensEliminacao: state => {
    return state.listaListagensEliminacao
  }
}

const mutations = {
  setListagemEliminacao (state, data) {
    state.listagemEliminacao = data
  },
  setListagensEliminacao (state, data) {
    state.listagensEliminacao = data
  },
  setListaListagensEliminacao (state, data) {
    state.listaListagensEliminacao = data
  }
}

const actions = {
  getListagensEliminacao (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }
    
    Vue.http.get('api/listagemEliminacao?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setListagensEliminacao', response.body.data.data)
    })
  },
  getListagemEliminacao (context, id) {
    Vue.http.get('api/listagemEliminacao/' + id).then(response => {
      context.commit('setListagemEliminacao', response.data.data)
    })
  },
  getListaListagensEliminacao (context, id) {
    Vue.http.get('api/listagemEliminacao').then(response => {
      context.commit('setListaListagensEliminacao', response.body.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
