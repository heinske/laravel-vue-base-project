import Vue from 'vue'

const state = {
  participante: {
    evento: {
      data: null
    }
  },
  participantes: []
}

const getters = {
  getParticipantes: state => {
    return state.participantes
  },
  getParticipante: state => {
    return state.participante
  }
}

const mutations = {
  setParticipante (state, data) {
    state.participante = data
  },
  setParticipantes (state, data) {
    state.participantes = data
  }
}

const actions = {
  getParticipantes (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/participante?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setParticipantes', response.body.data.data)
    })
  },
  getParticipante (context, id) {
    Vue.http.get('api/participante/' + id).then(response => {
      context.commit('setParticipante', response.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
