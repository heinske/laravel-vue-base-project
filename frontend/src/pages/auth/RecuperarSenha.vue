<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form>
                <h1>Recuperar Senha</h1>
                <p class="text-muted">Insira seu CPF para prosseguir sua recuperação de senha.</p>
                <b-alert v-if="alerta_sucesso" show variant="warning">{{mensagem_sucesso}}</b-alert>
                <b-alert v-if="alerta_erro" show variant="danger">{{mensagem_erro}}</b-alert>
                <b-form-group label="CPF:">
                  <b-input-group class="mb-6">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input v-mask="'###.###.###-##'"
                                  type="text"
                                  class="form-control"
                                  placeholder="CPF"
                                  v-model="$v.form.cpf.$model"
                                  :state="chkState('cpf')"
                                  autocomplete="cpf"
                                  autofocus/>
                    <b-form-invalid-feedback id="input1LiveFeedback1">CPF é obrigatório.</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-form>
            </b-card-body>
            <b-card-footer class="p-12">
              <b-row>
                <b-col md="6">
                  <b-button v-if="!envio" block variant="primary" v-on:click="onSubmit">
                    <i class="fa fa-send-o"></i>&nbsp;&nbsp;Disparar E-mail
                  </b-button>
                  <b-button v-else block variant="primary" disabled v-on:click="onSubmit">
                    <b-spinner small type="grow"></b-spinner>
                    Enviando e-mail...
                  </b-button>
                </b-col>
                <b-col md="6">
                  <b-button @click="navigate('/login')" block variant="secondary">
                    <i class="fa fa-mail-reply-all"></i>&nbsp;&nbsp;Voltar para o Login
                  </b-button>
                </b-col>
              </b-row>
            </b-card-footer>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import AuthTemplate from '@/templates/auth/AuthTemplate'
import {validationMixin} from 'vuelidate'
import {required, minLength} from 'vuelidate/lib/validators'

const formShape = {
  cpf: ''
}

export default {
  name: 'RecuperarSenha',
  components: {
    AuthTemplate
  },
  mixins: [validationMixin],
  validations: {
    form: {
      cpf: {
        required,
        minLength: minLength(14)
      }
    }
  },
  data () {
    return {
      form: Object.assign({}, formShape),
      alerta_sucesso: false,
      alerta_erro: false,
      mensagem_sucesso: '',
      mensagem_erro: '',
      envio: false
    }
  },
  computed: {
    isValid () {
      return !this.$v.form.$anyError
    }
  },
  methods: {
    enviarEmail () {
      this.envio = true
      let form = this.$v.form
      let data = {
        cpf: form.cpf.$model.replace(/[^\d]+/g, '')
      }

      Vue.http.post('api/auth/recuperarSenha', data).then(response => {
        let retorno = response.body

        if (retorno.success) {
          this.alerta_sucesso = true
          this.alerta_erro = false
          let email = retorno.data.email.split('@')
          this.mensagem_sucesso = 'Um e-mail foi enviado para ' + email[0].substring(0, 4) + '*******@' + email[1] + ' verifique sua caixa de mensagens.'
        }
        this.envio = false
      }).catch(e => {
        this.alerta_sucesso = false
        this.alerta_erro = true
        this.mensagem_erro = e.body.msg
        this.envio = false
      })
    },
    confirmar () {
      this.$bvModal.msgBoxConfirm('Tem certeza que deseja continuar?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.enviarEmail()
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    onSubmit () {
      if (this.validate()) {
        this.confirmar()
      }
    },
    chkState (val) {
      const field = this.$v.form[val]
      return !field.$dirty || !field.$invalid
    },
    findFirstError (component = this) {
      if (component.state === false) {
        if (component.$refs.input) {
          component.$refs.input.focus()
          return true
        }
        if (component.$refs.check) {
          component.$refs.check.focus()
          return true
        }
      }
      let focused = false
      component.$children.some((child) => {
        focused = this.findFirstError(child)
        return focused
      })

      return focused
    },
    validate () {
      this.$v.$touch()
      this.$nextTick(() => this.findFirstError())
      return this.isValid
    },
    navigate (route) {
      this.$router.push(route)
    }
  }
}
</script>
