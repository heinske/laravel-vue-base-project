import Vue from 'vue'

const state = {
  listaNacionalidades: []
}

const mutations = {
  setNacionalidade (state, data) {
    state.listaNacionalidades = data
  }
}

const actions = {
  buscarNacionalidades (context) {
    Vue.http.get('api/nacionalidade').then(response => {
      context.commit('setNacionalidade', response.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions
}
