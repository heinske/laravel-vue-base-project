import Vue from 'vue'

const state = {
  generos: []
}

const getters = {
  getGeneros: state => {
    return state.generos
  }
}

const mutations = {
  setGeneros (state, data) {
    state.generos = data
  }
}

const actions = {
  getGeneros (context, id) {
    Vue.http.get('api/listagemRecolhimento/genero').then(response => {
      context.commit('setGeneros', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
