import Vue from 'vue'
import JwtToken from '@/services/jwt-token'
import SessionStorage from '@/services/session-storage'

const state = {
  usuario: SessionStorage.get('usuario', []),
  usuarios: [],
  usuarioEditar: [],
  usuarioVisualizar: [],
  perfilAtual: '',
  permissoes: []
}

const getters = {
  getUsuario: state => {
    return state.usuario
  },
  getToken: state => {
    return state.usuario.token
  },
  validaPermissao: (state) => (permissao) => {
    if (state.permissoes.indexOf(permissao) > -1) {
      return true
    } else {
      return false
    }
  }
}

const mutations = {
  setUsuario (state, data) {
    state.usuario = data
  },
  setUsuarios (state, data) {
    state.usuarios = data
  },
  setUsuarioEditar (state, data) {
    state.usuarioEditar = data
  },
  setUsuarioVisualizar (state, data) {
    state.usuarioVisualizar = data
  },
  setPerfilAtual (state, data) {
    state.perfilAtual = data
  },
  atualizaPermissoes (state) {
    state.permissoes = SessionStorage.getObject('permissoes')
  }
}

const actions = {
  getUsuarios (context, config) {
    if (!config.page) {
      config.page = 1
    }

    if (!config.limit) {
      config.limit = 200
    }

    Vue.http.get('api/usuario?length=' + config.limit + '&page=' + config.page).then(response => {
      context.commit('setUsuarios', response.body.data.data)
    })
  },
  getUsuario (context, id) {
    Vue.http.get('api/usuario/' + id).then(response => {
      context.commit('setUsuarioEditar', response.data.data[0])
      context.commit('setPerfilAtual', response.data.data[0])
    })
  },
  login (context, data) {
    return JwtToken.accessToken(data)
  },
  atualizarPermissoes (context) {
    context.commit('atualizaPermissoes')
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
