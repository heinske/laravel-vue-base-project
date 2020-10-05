import Vue from 'vue'

const state = {
  palestrante: {
    evento: {
      data: null
    }
  },
  palestrantes: []
}

const getters = {
  getPalestrantes: state => {
    return state.palestrante
  },
  getPalestrante: state => {
    return state.palestrantes
  }
}

const mutations = {
  setPalestrante (state, data) {
    state.palestrante = data
  },
  setPalestrantes (state, data) {
    state.palestrantes = data
  }
}

const actions = {
  getPalestrantes (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/palestrante?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setPalestrantes', response.body.data.data)
    })
  },
  getPalestrante (context, id) {
    Vue.http.get('api/palestrante/' + id).then(response => {
      context.commit('setPalestrante', response.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
