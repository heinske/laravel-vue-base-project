import Vue from 'vue'

const state = {
  situacoes: []
}

const getters = {
  getSituacoes: state => {
    return state.situacoes
  }
}

const mutations = {
  setSituacoes (state, data) {
    state.situacoes = data
  }
}

const actions = {
  getSituacoes (context, id) {
    Vue.http.get('api/documento/situacao').then(response => {
      context.commit('setSituacoes', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
