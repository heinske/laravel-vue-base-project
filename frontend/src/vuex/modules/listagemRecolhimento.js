import Vue from 'vue'

const state = {
  listagemRecolhimento: {
    historicos: []
  },
  listagensRecolhimento: [],
  listaListagensRecolhimento: []
}

const getters = {
  getListagensRecolhimento: state => {
    return state.listagensRecolhimento
  },
  getListagemRecolhimento: state => {
    return state.listagemRecolhimento
  },
  getListaListagensRecolhimento: state => {
    return state.listaListagensRecolhimento
  }
}

const mutations = {
  setListagemRecolhimento (state, data) {
    state.listagemRecolhimento = data
  },
  setListagensRecolhimento (state, data) {
    state.listagensRecolhimento = data
  },
  setListaListagensRecolhimento (state, data) {
    state.listaListagensRecolhimento = data
  }
}

const actions = {
  getListagensRecolhimento (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }
    
    Vue.http.get('api/listagemRecolhimento?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setListagensRecolhimento', response.body.data.data)
    })
  },
  getListagemRecolhimento (context, id) {
    Vue.http.get('api/listagemRecolhimento/' + id).then(response => {
      context.commit('setListagemRecolhimento', response.data.data)
    })
  },
  getListaListagensRecolhimento (context, id) {
    Vue.http.get('api/listagemRecolhimento').then(response => {
      context.commit('setListaListagensRecolhimento', response.body.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
