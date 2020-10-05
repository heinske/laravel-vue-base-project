import Vue from 'vue'
import JwtToken from '@/services/jwt-token'
import miniToastr from 'mini-toastr'

miniToastr.init()

export default {

  checkAuth: function () {
    Vue.http.interceptors.push((request, next) => {
      request.headers.set('Authorization', JwtToken.getAuthorizationHeader())
        next(function(response){
          if (response.body.success === false && request.url != 'api/auth') {
            miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
            miniToastr.error(response.body.msg, 'Alerta!', 7000)           
          }
  });

//      next()
    })
  },
  refreshAuth: function () {
    Vue.http.interceptors.push((request, next) => {
      if (request.url !== 'api/auth' && request.url !== 'usuario/store/pub') {
        next(response => {
          if (response.status === 401) { // token expirado
            return JwtToken.refreshToken()
              .then(() => {
                return Vue.http(request)
              }).catch(() => {
                this.$router.push('/login')
              })
          }
        })
      }
    })
  },
  refreshNotifications: function () {
    Vue.http.interceptors.push((request, next) => {
      request.headers.set('Authorization', JwtToken.getAuthorizationHeader())
        next(function(response) {
      });
    })
  },
}
