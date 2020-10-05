<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card v-if="tokenValido" no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form>
                <h1>Alterar senha</h1>
                <p class="text-muted">Preenchendo o formulário, clique em Alterar senha, assim concluirá a modificação.</p>
                <b-form-group label="Nova senha:">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="password" class="form-control" placeholder="Nova senha"
                                  v-model.trim="$v.form.senhaNova.$model" :state="chkState('senhaNova')"
                                  autocomplete="new-password"/>
                    <b-form-invalid-feedback id="input1LiveFeedback2">Este é um campo obrigatório, e precisa ter no
                      mínimo 6 dígitos.
                    </b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
                <b-form-group label="Confirmação de nova senha:">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="password" class="form-control" placeholder="Confirmação de nova senha"
                                  v-model.trim="$v.form.confirmaSenhaNova.$model" :state="chkState('confirmaSenhaNova')"
                                  autocomplete="new-password"/>
                    <b-form-invalid-feedback id="input1LiveFeedback20">Este é um campo obrigatório, e precisa ter no
                      mínimo 6 dígitos.
                    </b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-form>
            </b-card-body>
            <b-card-footer class="p-12">
              <b-row>
                <b-col md="6" offset-md="3">
                  <b-button block variant="primary" v-on:click="onSubmit">
                        <i class="fa fa-edit"></i>&nbsp;&nbsp;Alterar senha
                  </b-button>
                </b-col>
              </b-row>
            </b-card-footer>
          </b-card>
          <b-alert v-else show variant="danger">
            <h4 class="alert-heading"> <i class="fa fa-warning"></i>&nbsp;&nbsp;Link de alteração expirado!</h4>
            <p>
              Este link para recuperação de senha já foi utilizado em outra ação e encontra-se expirado. A ação já foi realizada em outro momento através deste mesmo link.
            </p>
            <hr>
            <p class="mb-0">
              Caso você identifique a necessidade de uma nova alteração, retorne ao sistema e faça o processo de recuperação de senha novamente.
            </p>
          </b-alert>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import AuthTemplate from '@/templates/auth/AuthTemplate'
import {validationMixin} from 'vuelidate'
import {required, minLength, sameAs} from 'vuelidate/lib/validators'
import miniToastr from 'mini-toastr'

miniToastr.init()

const formShape = {
  senhaNova: '',
  confirmaSenhaNova: ''
}

export default {
  name: 'RecuperarSenha',
  components: {
    AuthTemplate
  },
  mixins: [validationMixin],
  validations: {
    form: {
      senhaNova: {
        required,
        minLength: minLength(6)
      },
      confirmaSenhaNova: {
        required,
        sameAsSenhaNova: sameAs('senhaNova')
      }
    }
  },
  created () {
    this.$store.dispatch('buscarTokenEmail', {token: this.$route.params.token})
  },
  data () {
    return {
      form: Object.assign({}, formShape)
    }
  },
  computed: {
    tokenValido () {
      return this.$store.state.token.tokenEmailValido
    },
    isValid () {
      return !this.$v.form.$anyError
    }
  },
  methods: {
    alterar () {
      let form = this.$v.form
      let data = {
        token: this.$route.params.token,
        password: form.senhaNova.$model,
        confirm_password: form.confirmaSenhaNova.$model
      }

      Vue.http.post('api/auth/alterarSenha', data).then(response => {
        if (response.body.success) {
          miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
          miniToastr.success(response.body.msg, 'Alerta!', 10000)
        }

        setTimeout(() => this.$router.push({path: '/login'}), 5000)
      }).catch(e => {
        console.log('Servidor está fora! ' + e)
      })
    },
    confirmar () {
      this.$bvModal.msgBoxConfirm('Tem certeza que deseja continuar?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.alterar()
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
    }
  }
}
</script>
