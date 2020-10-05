<template>
    <b-col md="12" sm="8">
      <b-card no-body class="mx-4">
        <b-card-body class="p-4">
          <b-form v-on:submit.prevent="onSubmit">
            <h1>Cadastro de Usuário</h1>
            <b-row>
              <b-col cols="12">
                <b-form-group label="Nome Completo: *">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="Nome"
                                  autocomplete="nome"
                                  v-model.trim="$v.form.nome.$model"
                                  :state="chkState('nome')"/>
                    <b-form-invalid-feedback id="input1LiveFeedback3">Nome é obrigatório.</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="3">
                <b-form-group label="CPF: *">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input v-mask="'###.###.###-##'"
                                  type="text"
                                  class="form-control"
                                  placeholder="CPF"
                                  autocomplete="cpf"
                                  v-model="$v.form.cpf.$model"
                                  :state="chkState('cpf')"
                                  autofocus/>
                    <b-form-invalid-feedback id="input1LiveFeedback1">CPF é obrigatório.</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
   
              <b-col cols="4">
                <label>Foto:</label>
                <figure class="image__wrapper" v-if="$v.form.foto.$model">
                  <img
                    class="image__item preview"
                    :src="$v.form.foto.$model"
                    alt="random image"
                  >
                </figure>
                <span class="icon-info" v-b-popover.hover.top="'Arquivo de foto: tipo .jpg e no máximo 10mb'" title="Informação"></span>
                <b-form-group label-for="nome-input" invalid-feedback="Foto é obrigatório">
                  <b-form-file
                          v-on:change="uploadFoto"
                          v-model="$v.form.foto.$model"
                          browse-text="Selecione"
                          placeholder="Selecione a foto"
                          :state="chkState('foto')"
                  ></b-form-file>
                </b-form-group>
              </b-col>
            </b-row>        
            <b-row>
              <b-col cols="6">
                <b-form-group label="E-mail: *">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text>@</b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="E-mail"
                                  autocomplete="email"
                                  v-model.trim="$v.form.email.$model"
                                  :state="chkState('email')"/>
                    <b-form-invalid-feedback id="input1LiveFeedback7">Este é um campo obrigatório, e deve ser um
                      endereço de e-mail válido.
                    </b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="6">
                <b-form-group label="Confirme o e-mail: *">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text>@</b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  id="confirmar-email"
                                  placeholder="Confirme o e-mail"
                                  oncut="return false"
                                  onpaste="return false"
                                  autocomplete="confirme-email"
                                  v-model.trim="$v.form.confirmaEmail.$model"
                                  :state="chkState('confirmaEmail')"/>
                    <b-form-invalid-feedback id="input1LiveFeedback8">Este é um campo obrigatório, e deve ser correspondente ao campo e-mail.
                    </b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="4">
                <b-form-group label="Tipo de Usuário: *">
                  <b-form-select v-model.trim="$v.form.tipoUsuario.$model" :state="chkState('tipoUsuario')"
                                 placeholder="Tipo de Usuário" class="mb-3">
                    <option v-for="item in perfis" :key="item.id" :value="item.id"> {{item.nome}}</option>
                  </b-form-select>
                  <b-form-invalid-feedback id="input1LiveFeedback9">Este é um campo obrigatório.</b-form-invalid-feedback>
                </b-form-group>
              </b-col>
              <b-col cols="4">
                <b-form-group label="Cargo:">
                  <b-input-group class="mb-4">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="Cargo"
                                  autocomplete="cargo"
                                  v-model="$v.form.cargo.$model"
                                  autofocus/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <b-col cols="4">
                <b-form-group label="Setor de Lotação:">
                  <b-input-group class="mb-4">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="Setor"
                                  autocomplete="setor"
                                  v-model="$v.form.setor.$model"
                                  autofocus/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
        <b-card-footer class="p-12">
          <b-row>
            <b-col v-if="!loading" md="3">
              <b-button block variant="primary" :disabled="disable_buttons" v-on:click="onSubmit">
                <i class="fa fa-plus"></i>&nbsp;
                <span>Salvar</span>
              </b-button>
            </b-col>
            <b-col v-else md="3">
              <b-button block variant="primary" :disabled="true" v-on:click="onSubmit">
                <b-spinner small type="grow"></b-spinner>Salvando...
              </b-button>
            </b-col>
            <b-col md="3">
              <b-button block variant="secondary" :disabled="disable_buttons" @click="navigate('/usuarios')">
                <i class="fa fa-mail-reply-all"></i>&nbsp;&nbsp;<span>Voltar</span>
              </b-button>
            </b-col>
          </b-row>
        </b-card-footer>
      </b-card>
    </b-col>
</template>

<script>
import Vue from 'vue'
import VueSelect from 'vue-select'
import {validationMixin} from 'vuelidate'
import {required, minLength, maxLength, email, sameAs} from 'vuelidate/lib/validators'
import miniToastr from 'mini-toastr'
import Multiselect from 'vue-multiselect'

miniToastr.init()

export default {
  name: 'Cadastro',
  components: {
    VueSelect,
    Multiselect
  },
  mixins: [validationMixin],
  validations: {
    form: {
      cpf: {
        required,
        minLength: minLength(14)
      },
      foto: {},
      nome: {
        required
      },
      email: {
        required,
        email
      },
      confirmaEmail: {
        required,
        email,
        sameAsEmail: sameAs('email')
      },
      tipoUsuario: {
        required
      },
      setor: {},
      cargo: {}
    }
  },
  created () {
    if (!this.can('user.store')) {
      this.$router.push('/')
    }
    this.$store.dispatch('getPerfisListaCombo')
  },
  data () {
    return {
      loading: false,
      form: {
        cpf: '',
        date: '',
        tipoUsuario: null,
        nome: '',
        foto: null,
        email: '',
        cargo: null,
        setor: null
      },
      disable_buttons: false,
      titulo_toast: 'Alerta!',
      salvarForm: false
    }
  },
  computed: {
    perfis () {
      return this.$store.state.perfil.lista
    },
    isValid () {
      return !this.$v.form.$anyError
    },
    isValidSelection () {
      return this.selected !== '' && this.selected !== 'forbidden value'
    }
  },
  methods: {
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    uploadFoto (evento) {
      let arquivo = evento.target.files || evento.dataTransfer.files

      if (!arquivo.length) {
        return false
      }

      let reader = new FileReader()

      reader.onload = (evento) => {
        this.form.foto = evento.target.result
      }
      reader.readAsDataURL(arquivo[0])
    },
    salvar () {
      let form = this.$v.form
      let data = {
        cpf: form.cpf.$model.replace(/[^\d]+/g, ''),
        nome: form.nome.$model,
        foto: form.foto.$model,
        email: form.email.$model,
        email_confirmation: form.confirmaEmail.$model,
        cargo: form.cargo.$model,
        setor: form.setor.$model,
        ativo: true,
        perfis: JSON.stringify([{ id: form.tipoUsuario.$model }]),
        gerarToken: false,
      }

      this.loading = true

      Vue.http.post('api/usuario', data).then(response => {
        if (response.body.success) {
          miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
          miniToastr.success(response.body.msg, 'Sucesso!', 7000)
          this.$router.push({path: '/usuarios'})
        } else {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
          miniToastr.error(response.body.msg, 'Alerta', 5000)
        }
        this.loading = false
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
          this.salvar()
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    onSubmit () {
      this.salvarForm = true
      if (this.validate()) {
        this.confirmar()
      }
    },
    chkState (val) {
      const field = this.$v.form[val]
      if (!field.$model && !this.salvarForm) {
        return null
      }

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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
