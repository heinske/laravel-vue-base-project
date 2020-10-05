import Vue from 'vue'

const state = {
  tokenEmailValido: true
}

const mutations = {
  setToken (state, data) {
    state.tokenEmailValido = data
  }
}

const actions = {
  buscarTokenEmail (context, data) {
    Vue.http.post('api/auth/validarTokenEmail', data).then(response => {
      context.commit('setToken', response.body.success)
    }).catch(response => {
      context.commit('setToken', response.body.success)
    })
  }
}

export default {
  state,
  mutations,
  actions
}
