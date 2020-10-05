import Vue from 'vue'

const state = {
  tiposObjeto: []
}

const getters = {
  getTiposObjeto: state => {
    return state.tiposObjeto
  }
}

const mutations = {
  setTiposObjeto (state, data) {
    state.tiposObjeto = data
  }
}

const actions = {
  getTiposObjeto (context, id) {
    Vue.http.get('api/documento/tipoObjeto').then(response => {
      context.commit('setTiposObjeto', response.body.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
