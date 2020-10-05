import Vue from 'vue'

const state = {
  listaCidades: [],
  listaCidadesPorEstado: [],
  listaCidadesPorConferencia: [],
  listaCidadesPorUsuario: []
}

const mutations = {
  setCidades (state, data) {
    state.listaCidades = data
  },
  setCidadesPorEstado (state, data) {
    state.listaCidadesPorEstado = data
  },
  setCidadesPorConferencia (state, data) {
    state.listaCidadesPorConferencia = data
  },
  setCidadesPorUsuario (state, data) {
    state.listaCidadesPorUsuario = data
  }
}

const getters = {
  getListaFiltroCidade: state => {
    let valores = Object.entries(state.listaCidades)
    let valoresNovos = []
    let i
    for (i = 0; i < valores.length; i++) {
      valoresNovos.push(valores[i][1])
    }
    return valoresNovos
  }
}

const actions = {
  buscarCidades (context, id) {
    Vue.http.get('api/cidade/buscarCidades').then(response => {
      context.commit('setCidades', response.data.data.cidades)
    })
  },
  buscarCidadesPorEstado (context, id) {
    Vue.http.get('api/cidade/buscarCidades/' + id).then(response => {
      context.commit('setCidadesPorEstado', response.data.data.cidades)
    })
  },
  buscarCidadesPorConferencia (context, id) {
    Vue.http.get('api/cidade/buscarCidadesPorConferencia/' + id).then(response => {
      context.commit('setCidadesPorConferencia', response.data.data.cidades)
    })
  },
  buscarCidadesPorUsuario (context, user_id) {
    Vue.http.get('api/cidade/buscarCidadesPorUsuario', {params: {user_id: user_id}} ).then(response => {
      context.commit('setCidadesPorUsuario', response.data.data.cidades)
    })
  },
  buscarCidadesPorUf (context, id) {
    Vue.http.get('api/cidade/buscarCidades/' + id).then(response => {
      context.commit('setCidadesPorUsuario', response.data.data.cidades)
    })
  }
}

export default {
  state,
  mutations,
  getters,
  actions
}
