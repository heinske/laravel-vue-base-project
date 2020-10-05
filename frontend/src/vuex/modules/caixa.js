import Vue from 'vue'

const state = {
  caixa: {
    historicos: [  ]
  },
  caixas: [],
  listaCaixas: []
}

const getters = {
  getCaixas: state => {
    return state.caixas
  },
  getCaixa: state => {
    return state.caixa
  },
  getListaCaixas: state => {
    return state.listaCaixas
  }
}

const mutations = {
  setCaixa (state, data) {
    state.caixa = data
  },
  setCaixas (state, data) {
    state.caixas = data
  },
  setListaCaixas (state, data) {
    state.listaCaixas = data
  }
}

const actions = {
  getCaixas (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/caixa?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setCaixas', response.body.data.data)
    })
  },
  getCaixa (context, id) {
    Vue.http.get('api/caixa/' + id).then(response => {
      context.commit('setCaixa', response.data.data)
    })
  },
  getListaCaixas (context, id) {
    Vue.http.get('api/caixa/lista/combo').then(response => {
      context.commit('setListaCaixas', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
