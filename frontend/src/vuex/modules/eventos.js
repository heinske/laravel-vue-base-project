import Vue from 'vue'

const state = {
  evento: [],
  eventos: []
}

const getters = {
  getEventos: state => {
    return state.evento
  },
  getEvento: state => {
    return state.eventos
  }
}

const mutations = {
  setEvento (state, data) {
    state.evento = data
  },
  setEventos (state, data) {
    state.eventos = data
  }
}

const actions = {
  getEventos (context, config) {
    Vue.http.get('api/evento').then(response => {
      context.commit('setEventos', response.body.data.data)
    })
  },
  getEvento (context, id) {
    Vue.http.get('api/evento/' + id).then(response => {
      context.commit('setEvento', response.data.data)
    })
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
