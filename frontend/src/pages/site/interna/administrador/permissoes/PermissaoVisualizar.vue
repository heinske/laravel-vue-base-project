<template>
    <span>
        <b-card no-body>
        <b-card-header>
            <b-row>
                 <b-col sm="10">
                    <h3>Visualizar Perfil</h3>
                 </b-col>
            </b-row>
        </b-card-header>
        <b-card-body>
           <b-form>
            <b-row>
               <b-col cols="12">
                <b-form-group label="Perfil:">
                  <b-input-group class="mb-3">
                         <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-user-secret"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  placeholder="Perfil"
                                  autocomplete="endereco"
                                  v-model="perfil.nome"
                                  :state="chkState('nome')"
                                  class="form-control" disabled
                    />
                      <b-form-invalid-feedback id="input1LiveFeedback1">Perfil é obrigatório.</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
               <b-col cols="12">
                <b-form-group label="Descrição:">
                  <b-input-group class="mb-3">
                         <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-user-secret"></i></b-input-group-text>
                    </b-input-group-prepend>
                   <b-form-textarea id="textarea" v-model="perfil.descricao" rows="3" max-rows="6" :state="true" disabled></b-form-textarea>
                      <b-form-invalid-feedback id="input1LiveFeedback2">Descrição é obrigatória</b-form-invalid-feedback>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
                 <b-col cols="12">
                    <b-form-group label="Status:">
                        <b-form-radio-group  v-model="perfil.ativo" :state="true" id="radio-slots" :options="options" name="radio-options-slots" disabled/>
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
                                       <input disabled type="checkbox" class="custom-control-input" :id="'defaultInline1' + i.id" :value="i.id" v-model="selected">
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
            <b-button v-if="can('perfil.update')" variant="primary" @click="editarPerfil()"><i class="fa fa-pencil"></i> Editar</b-button>
            <b-button v-if="can('perfil.destroy')" variant="primary" @click="excluirPerfil()"><i class="fa fa-times"></i> Excluir</b-button>
            <b-button variant="secondary" @click="$router.go(-1)"><i class="fa fa-mail-reply-all"></i> Voltar</b-button>
        </b-card-footer>
    </b-card>
    <b-modal title="Exclusão de Perfil" ok-title="Excluir" cancel-title="Cancelar" v-model="modalPreExcluir" @ok="modalConfirmaExclusao">
             <b-card-body>
             <b-form>
            <b-row>
              <b-col cols="12">
                <b-form-group label="Perfil:">
                   <b-form-input type="text" :disabled="true" v-model="perfil.nome" class="form-control"/>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
                <b-col cols="12">
                  <b-form-group label="Senha para confirmação: *">
                    <b-input-group class="mb-3">
                      <b-input-group-prepend>
                        <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                      </b-input-group-prepend>
                      <b-form-input type="password"
                                    class="form-control"
                                    placeholder=""
                                    autocomplete=""
                                    v-model.trim="password"
                                    />
                    </b-input-group>
                  </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
      </b-modal>
    </span>
</template>

<script>
import Vue from 'vue'
import miniToastr from 'mini-toastr'

miniToastr.init()

export default {
  created () {
    if (!this.can('perfil.show')) {
      this.$router.push('/')
    } else {
      this.$store.dispatch('getPermissoes')
      this.$store.dispatch('getPerfil', this.$route.params.id)
    }
  },
  data () {
    return {
      modalPreExcluir: false,
      password: null,
      novosPerfis: [],
      options: [
        { text: 'Ativo', value: true },
        { text: 'Inativo', value: false }
      ]
    }
  },
  computed: {
    permissoes () {
      return this.$store.state.permissao.permissoes
    },
    perfil () {
      return this.$store.state.perfil.perfil
    },
    selected: {
      get () {
        return this.$store.state.perfil.permissoesPorPerfil
      },
      set (value) {
        this.$store.commit('atualizaPermissoesPorPerfil', value)
      }
    }
  },
  methods: {
    save () {
      let data = {
        nome: this.perfil.nome,
        sistema_id: this.perfil.sistema_id,
        descricao: this.perfil.descricao,
        ativo: this.perfil.ativo,
        recursos: JSON.stringify(this.selected)
      }

      Vue.http.put('api/perfil/' + this.$route.params.id, data).then(response => {
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
    editarPerfil () {
      this.$router.push('/perfil/' + this.$route.params.id + '/editar')
    },
    confirmar () {
      this.$bvModal.msgBoxConfirm('Confirma a edição do Perfil?', {
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
    validate () {
      let result = true

      if (!this.perfil.nome) {
        result = false
      }

      return result
    },
    chkState (val) {
      switch (val) {
        case 'nome':
          return !!this.perfil.nome
        default:
          return false
      }
    },
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    validateRecursos () {
      if (!this.selected.length) {
        miniToastr.setIcon('error', 'i', {'class': 'fa fa-warning'})
        miniToastr.error('É necessário ter pelo menos uma permissão vinculada ao perfil!', 'Alerta', 5000)
        return false
      }
      return true
    },
    excluirPerfil () {
      this.modalPreExcluir = true
    },
    modalConfirmaExclusao () {
      this.$bvModal.msgBoxConfirm('Confirma a exclusão do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.post('api/perfil/delete/' + this.perfil.id, {'password': this.password}).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$router.push('/perfis')            
            }
          }).catch(erro => {
          })
        } else {
          this.modalPreExcluir = true
        }
      })
    }
  }
}
</script>
