import SessionStorage from '@/services/session-storage'
import {Jwt} from '@/services/resources'
export default {
  get token () {
    return SessionStorage.get('token')
  },
  set token (value) {
    SessionStorage.set('token', value)
  },
  get usuario () {
    return SessionStorage.get('usuario')
  },
  set usuario (value) {
    SessionStorage.set('usuario', value)
  },
  get avatar () {
    return SessionStorage.get('avatar')
  },
  set avatar (value) {
    SessionStorage.set('avatar', value)
  },
  get uf () {
    return SessionStorage.get('uf')
  },
  set uf (value) {
    SessionStorage.set('uf', value)
  },
  get permissoes () {
    return SessionStorage.get('permissoes')
  },
  set permissoes (value) {
    SessionStorage.setObject('permissoes', value)
  },
  get perfil_id () {
    return SessionStorage.get('perfil_id')
  },
  set perfil_id (value) {
    SessionStorage.set('perfil_id', value)
  },
  get situacao () {
    return SessionStorage.get('situacao')
  },
  set situacao (value) {
    SessionStorage.set('situacao', value)
  },
  accessToken (data) {
    return Jwt.accessToken(data).then((response) => {
      this.token = response.data.data.token
      this.usuario = response.data.data.user
      this.uf = response.data.data.estado_id
      this.avatar = response.data.data[1]
      this.permissoes = response.data.data.permissoes[0][0].permissoes
      this.perfil_id = response.data.data.perfil_id
      this.situacao = response.data.data.situacao
    })
  },
  refreshToken () {
    return Jwt.refreshToken().then(response => {
      this.token = response.data.token
      return response
    })
  },
  getAuthorizationHeader () {
    return `Bearer ${this.token}`
  }
}
