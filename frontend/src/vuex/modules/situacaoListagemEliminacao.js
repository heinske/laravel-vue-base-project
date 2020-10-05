import Vue from 'vue'

const state = {
  situacoesListagemEliminacao: []
}

const getters = {
  getSituacoesListagemEliminacao: state => {
    return state.situacoesListagemEliminacao
  }
}

const mutations = {
  setSituacoesListagemEliminacao (state, data) {
    state.situacoesListagemEliminacao = data
  }
}

const actions = {
  getSituacoesListagemEliminacao (context, id) {
    Vue.http.get('api/listagemEliminacao/situacao').then(response => {
      context.commit('setSituacoesListagemEliminacao', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
