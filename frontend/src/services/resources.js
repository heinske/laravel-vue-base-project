import Vue from 'vue'

export class Jwt {
  static accessToken (data) {
    return Vue.http.post('api/auth', data)
  }
  static refreshToken () {
    return Vue.http.post('api/auth/refresh')
  }
}
