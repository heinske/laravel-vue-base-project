<template>
    <span>
        <b-card no-body>
        <b-card-header>
            <b-row>
                 <b-col sm="10">
                    <h3>Cadastro de Perfil</h3>
                 </b-col>
            </b-row>
        </b-card-header>
        <b-card-body>
           <b-form>
            <b-row>
               <b-col cols="12">
                <b-form-group label="Perfil: *">
                  <b-input-group class="mb-3">
                         <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-user-secret"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  placeholder="Perfil"
                                  autocomplete="endereco"
                                  v-model="$v.form.nome.$model"
                                  :state="chkState('nome')"
                                  class="form-control"
                    />
                      <b-form-invalid-feedback id="input1LiveFeedback1">Perfil é obrigatório.</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
               <b-col cols="12">
                <b-form-group label="Descrição: *">
                  <b-input-group class="mb-3">
                         <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-user-secret"></i></b-input-group-text>
                    </b-input-group-prepend>
                   <b-form-textarea id="textarea" rows="3" max-rows="6" v-model="descricao"></b-form-textarea>
                      <b-form-invalid-feedback id="input1LiveFeedback2">Descrição é obrigatória</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
               <b-row>
                 <b-col cols="12">
                    <b-form-group label="Status: *">
                        <b-form-radio-group v-model="$v.form.status.$model" :state="chkState('status')" id="radio-slots" :options="options" name="radio-options-slots"/>
                    </b-form-group>
                 </b-col>
             </b-row>
               <b-row>
                 <b-col cols="12">
                   <div id="app">
                       <table aria-rowcount="4" id="my-table" aria-busy="false" aria-colcount="7" class="table table-responsive-sm table-bordered table-striped table-sm">
                           <thead>
                            <tr>
                              <th scope="col">Selecionar</th>
                              <th scope="col">Funcionalidade</th>
                              <th scope="col">Nome da ação</th>
                            </tr>
                           </thead>
                           <tbody>
                            <tr v-for="i in permissoes" :key="i.id">
                             <td style="width: 10%">
                               <label class="form-checkbox">
                                   <div class="custom-control custom-checkbox custom-control-inline">
                                       <input type="checkbox" class="custom-control-input" :id="'defaultInline1' + i.id" :value="i.id" v-model="selected">
                                       <label class="custom-control-label" :for="'defaultInline1' + i.id"></label>
                                    </div>
                               </label>
                             </td>
                             <td>{{i.nome_recurso}}</td>
                             <td>{{i.nome_acao}}</td>
                            </tr>
                          </tbody>
                       </table>
                   </div>
                 </b-col>
             </b-row>
          </b-form>
        </b-card-body>
        <b-card-footer class="p-12">
            <b-button variant="primary" @click="onSubmit"><i class="fa fa-check"></i> Salvar</b-button>
            <b-button variant="secondary" @click="$router.go(-1)"><i class="fa fa-mail-reply-all"></i> Voltar</b-button>
        </b-card-footer>
    </b-card>
    </span>
</template>

<script>
import Vue from 'vue'
import miniToastr from 'mini-toastr'
import {validationMixin} from 'vuelidate'
import {required} from 'vuelidate/lib/validators'

miniToastr.init()

const formShape = {
  nome: '',
  status: null
}

export default {
  mixins: [validationMixin],
  validations: {
    form: {
      nome: {
        required
      },
      status: {
        required
      }
    }
  },
  created () {
    if (!this.can('perfil.store')) {
      this.$router.push('/')
    } else {
      this.$store.dispatch('getPermissoes')
    }
  },
  data () {
    return {
      selected: [],
      descricao: '',
      form: Object.assign({}, formShape),
      options: [
        { text: 'Ativo', value: true },
        { text: 'Inativo', value: false }
      ]
    }
  },
  computed: {
    isValid () {
      return !this.$v.form.$anyError
    },
    permissoes () {
      return this.$store.state.permissao.permissoes
    }
  },
  methods: {
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    save () {
      let form = this.$v.form
      let data = {
        nome: form.nome.$model,
        descricao: this.descricao,
        ativo: form.status.$model,
        publico: true,
        recursos: JSON.stringify(this.selected)
      }

      Vue.http.post('api/perfil', data).then(response => {
        if (response.body.success) {
          miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
          miniToastr.success(response.body.msg, 'Sucesso!', 7000)
          this.$router.push('/perfis')
        } else {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
          miniToastr.error(response.body.msg, 'Erro!', 7000)
        }
      }).catch(e => {
        console.log(e)
      })
    },
    confirmar () {
      this.$bvModal.msgBoxConfirm('Confirma o cadastro do Perfil?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.save()
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    onSubmit () {
      if (this.validate() && this.validateRecursos()) {
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
    validateRecursos () {
      if (!this.selected.length) {
        miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
        miniToastr.error('É necessário ter pelo menos uma permissão vinculada ao perfil!', 'Alerta', 5000)
        return false
      }
      return true
    }
  }
}
</script>
