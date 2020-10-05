<template>
  <auth-template>
    <b-col md="8">
      <b-card-group>
        <b-card no-body class="p-4">
          <b-card-body>
            <b-form>
              <h1>Login</h1>
              <b-input-group class="mb-3">
                <b-input-group-prepend>
                  <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input type="text" class="form-control" v-mask="'###.###.###-##'" v-model="usuario.cpf" placeholder="CPF" autocomplete="username email"/>
              </b-input-group>
              <b-input-group class="mb-4">
                <b-input-group-prepend>
                  <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input type="password" class="form-control" placeholder="Senha" v-model="usuario.senha" autocomplete="current-password"/>
              </b-input-group>
              <b-row>
                <b-col cols="4">
                  <b-button variant="primary" v-on:click="login" class="px-4">
                    <b-spinner small v-show="logando"></b-spinner><span v-show="!logando">Entrar</span></b-button><br><br>
                  <g-recaptcha :sitekey="chavaCaptcha"/>
                </b-col>
                <b-col cols="8" class="text-right">
                  <b-button variant="link" class="px-0" @click="navigate('/recuperar-senha')">Esqueci minha senha</b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-card-body>
        </b-card>
        <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:44%">
          <b-card-body class="text-center">
            <div>
              <h2>Projeto Base</h2>
            </div>
          </b-card-body>
        </b-card>
      </b-card-group>
    </b-col>
  </auth-template>
</template>


<script>
import AuthTemplate from '@/templates/auth/AuthTemplate'
import gRecaptcha from './recaptcha'
import miniToastr from 'mini-toastr'

export default {
  name: 'Login',
  components: {
    AuthTemplate,
    gRecaptcha
  },
  data () {
    return {
      usuario: {
        cpf: '',
        senha: ''
      },
      logando: false,
      titulo_toast: 'Alerta!',
      chavaCaptcha: process.env.KEY_RECAPTCHA
    }
  },
  methods: {
    navigate (route) {
      this.$router.push(route)
    },
    login () {
      this.logando = true
      let data = {
        cpf: this.usuario.cpf.replace(/[^\d]+/g, ''),
        password: this.usuario.senha,
        captcha: window.grecaptcha.getResponse()
      }

      this.$store.dispatch('login', data).then((response) => {
        this.$router.push('/')
      }).catch(e => {
        let response = e.body

        if (response.msg !== '') {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
          miniToastr.error(response.msg, this.titulo_toast, 5000)
        }

        if (response.data.erros) {
          let erros = Object.values(response.data)

          if (erros[0].captcha !== undefined) {
            for (let erro of erros[0].captcha) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
              miniToastr.error(erro, this.titulo_toast, 5000)
            }
          }

          if (erros[0].password !== undefined) {
            for (let erro of erros[0].password) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
              miniToastr.error(erro, this.titulo_toast, 5000)
            }
          }

          if (erros[0].cpf !== undefined) {
            for (let erro of erros[0].cpf) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
              miniToastr.error(erro, this.titulo_toast, 5000)
            }
          }
        }
        this.logando = false
        this.reloadRecapcha()
      })
    },
    reloadRecapcha () {
      window.grecaptcha.reset()
    }
  }
}
</script>
