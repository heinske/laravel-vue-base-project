import Vue from 'vue'
import moment from 'moment'

const prepararCpf = function (cpf) {
  if (cpf.length === 14) {
    cpf = cpf.charAt(0) + cpf.charAt(1) + cpf.charAt(2) +
      cpf.charAt(4) + cpf.charAt(5) + cpf.charAt(6) +
      cpf.charAt(8) + cpf.charAt(9) + cpf.charAt(10) +
      cpf.charAt(12) + cpf.charAt(13)
    return cpf
  }
}

Vue.filter('prepararCpf', prepararCpf)

Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('formatDateToBR', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
})

Vue.filter('formatDateTimeToBR', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY H:mm:ss')
  }
})