import Vue from 'vue'

const state = {
  lista: []
}

const mutations = {
  setModulos (state, data) {
    state.lista = data
  }
}

const getters = {
  listaModulos: (state) => {
    let options = [{'value': null, 'text': 'Selecione'}]
    for (let i in state.lista) {
      options.push({'value': state.lista[i].id, 'text': state.lista[i].nome})
    }
    return options
  }
}

const actions = {
  buscarModulos (context) {
    Vue.http.get('api/sistema').then(response => {
      context.commit('setModulos', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
