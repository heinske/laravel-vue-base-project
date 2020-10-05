import Vue from 'vue'

const state = {
  permissoes: []
}

const mutations = {
  setPermissoes (state, data) {
    state.permissoes = data
  }
}

const actions = {
  getPermissoes (context) {
    Vue.http.get('api/recurso').then(response => {
      context.commit('setPermissoes', response.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions
}
