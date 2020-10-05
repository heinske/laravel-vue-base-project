import Vue from 'vue'

const state = {
  documento: {
    historicos: []
  },
  documentos: [],
  listaDocumentos: []
}

const getters = {
  getDocumentos: state => {
    return state.documentos
  },
  getDocumento: state => {
    return state.documento
  },
  getListaDocumentos: state => {
    return state.listaDocumentos
  }
}

const mutations = {
  setDocumento (state, data) {
    state.documento = data
  },
  setDocumentos (state, data) {
    state.documentos = data
  },
  setListaDocumentos (state, data) {
    state.listaDocumentos = data
  }
}

const actions = {
  getDocumentos (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }
    
    Vue.http.get('api/documento?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setDocumentos', response.body.data.data)
    })
  },
  getDocumento (context, id) {
    Vue.http.get('api/documento/' + id).then(response => {
      context.commit('setDocumento', response.data.data)
    })
  },
  getListaDocumentos (context, id) {
    Vue.http.get('api/documento/lista/combo').then(response => {
      context.commit('setListaDocumentos', response.body.data)
    })
  },
  getListaDocumentosEliminacao (context, id) {
    Vue.http.get('api/documento/eliminacao').then(response => {
      context.commit('setListaDocumentos', response.body.data.data)
    })
  },
  getListaDocumentosRecolhimento (context, id) {
    Vue.http.get('api/documento/recolhimento').then(response => {
      context.commit('setListaDocumentos', response.body.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
