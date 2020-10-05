import Vue from 'vue'

const state = {
  lista: [],
  perfil: [],
  permissoesPorPerfil: []
}

const mutations = {
  setPerfis (state, data) {
    state.lista = data
  },
  setPerfil (state, data) {
    state.perfil = data

    let permissoes = []
    for (let i in state.perfil.recursos) {
      permissoes.push(state.perfil.recursos[i].id)
    }
    state.permissoesPorPerfil = permissoes
  },
  atualizaPermissoesPorPerfil (state, permissoes) {
    state.permissoesPorPerfil = permissoes
  }
}

const getters = {
  getNomePerfil: (state) => (id) => {
    let result = state.lista.find(item => item.id === id)
    return result.nome
  },
  getListaCombo: state => {
    return state.lista
  }
}

const actions = {
  getPerfis (context) {
    Vue.http.get('api/perfil').then(response => {
      context.commit('setPerfis', response.body.data.data)
    })
  },
  getPerfisListaCombo (context) {
    Vue.http.get('api/perfil?status=1').then(response => {
      context.commit('setPerfis', response.body.data.data)
    })
  },
  getPerfil (context, id) {
    Vue.http.get('api/perfil/' + id).then(response => {
      context.commit('setPerfil', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
