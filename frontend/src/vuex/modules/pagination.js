import Vue from 'vue'

export default {
  state: {
    getList: []
  },
  mutations: {
    atualizarLista (state, data) {
      state.getList = data
    }
  },
  actions: {
    clearRegistries (context) {
      context.commit('atualizarLista', [])
    },
    getRegistros (context, config) {
      if (!config.page) {
        config.page = 1
      }
      if (!config.limit) {
        config.limit = 200
      }
      
      Vue.http.get('api/' + config.resource + '?length=' + config.limit + '&page=' + config.page).then(response => {
        context.commit('atualizarLista', response.data.data.data)
      })
    },
    getRegistrosSearch (context, config) {
      if (!config.page) {
        config.page = 1
      }
      if (!config.limit) {
        config.limit = 200
      }

      if (!config.filtros) {
        config.filtros = []
      }

      Vue.http.get('api/' + config.resource + '?length=' + config.limit + '&page=' + config.page, {params: config.filtros}).then(response => {
        context.commit('atualizarLista', response.data.data.data)
      })
    }
  }
}
