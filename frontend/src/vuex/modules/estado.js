import Vue from 'vue'

const state = {
  listaEstados: [],
  listaEstadosPorUsuario: []
}

const mutations = {
  setEstados (state, data) {
    state.listaEstados = data
  },
  setEstadosPorUsuario (state, data) {
    state.listaEstadosPorUsuario = data
  }
}

const getters = {
  getListaFiltroUf: state => {
    let valores = Object.entries(state.listaEstados)
    let valoresNovos = []
    let i
    for (i = 0; i < valores.length; i++) {
      valoresNovos.push(valores[i][1])
    }
    return valoresNovos
  }
}

const actions = {
  buscarEstados (context) {
    Vue.http.get('api/estado/buscarEstados').then(response => {
      context.commit('setEstados', response.data.data.estados)
    })
  },
  buscarEstadosPorRegiao (context) {
    Vue.http.get('api/estado/buscarEstadosPorRegiao').then(response => {
      context.commit('setEstados', response.data.data.estados)
    })
  },
  buscarEstadosPorUsuario (context, userId) {
    Vue.http.get('api/estado/buscarEstadosPorUsuario', {params: {user_id: userId}}).then(response => {
      context.commit('setEstadosPorUsuario', response.data.data.estados)
    })
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}
