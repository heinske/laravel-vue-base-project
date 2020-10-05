import Vue from 'vue'

const state = {
  situacoesListagemRecolhimento: []
}

const getters = {
  getSituacoesListagemRecolhimento: state => {
    return state.situacoesListagemRecolhimento
  }
}

const mutations = {
  setSituacoesListagemRecolhimento (state, data) {
    state.situacoesListagemRecolhimento = data
  }
}

const actions = {
  getSituacoesListagemRecolhimento (context, id) {
    Vue.http.get('api/listagemRecolhimento/situacao').then(response => {
      context.commit('setSituacoesListagemRecolhimento', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
