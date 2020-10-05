<template>
    <span>
        <b-card no-body>
        <b-card-header>
            <b-row>
                 <b-col sm="10">
                    <h3>Validar Usuário</h3>
                 </b-col>
            </b-row>
        </b-card-header>
        <b-card-body>
             <b-form>
             <b-row>

              <b-col cols="4">
                <b-form-group label="Solicitação:">
                  <b-input-group class="mb-4">
                    <b-form-input id="cpf"
                                  type="text"
                                  :disabled="true"
                                  class="form-control"
                                  v-model="this.getStatus()"
                                  autofocus/>
                    </b-input-group>
                  </b-form-group>

                 </b-col>

                 <b-col col-md-3 offset-md-2>
                    <b-form-group>
                        <img class="preview" :src="usuario.foto">
                    </b-form-group>
                 </b-col>
             </b-row>
             <b-row>
              <b-col cols="4">
                <b-form-group label="CPF:">
                  <b-input-group class="mb-6">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input v-mask="'###.###.###-##'"
                                  id="cpf"
                                  type="text"
                                  :disabled="true"
                                  class="form-control"
                                  placeholder="CPF"
                                  autocomplete="cpf"
                                  v-model="usuario.cpf"
                                  autofocus/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <b-col cols="4">
                <b-form-group label="Data de Nascimento:">
                  <b-input-group>
                    <div class="input-group-prepend">
                             <span class="input-group-text">
                               <i class='fa fa-calendar'></i>
                             </span>
                    </div>
                    <b-form-input id="type-date"
                                  type="text"
                                  :disabled="true"
                                  v-model="usuario.data_nascimento"></b-form-input>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <b-col cols="4">
                  <b-form-group label="Sexo:">
                     <b-form-radio-group v-model="usuario.sexo" :disabled="true" :options="options"
                                         name="radio-inline"></b-form-radio-group>
                  </b-form-group>
              </b-col>
            </b-row>
             <b-row>
              <b-col cols="12">
                <b-form-group label="Tipo de Usuário:">
                   <b-form-input type="text"
                                 class="form-control"
                                 v-model="usuario.perfil"
                                 :disabled="true"/>
                </b-form-group>
              </b-col>
            </b-row>
             <b-row>
              <b-col cols="8">
                <b-form-group label="Nome:">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="Nome"
                                  autocomplete="nome"
                                  v-model="usuario.nome"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <b-col cols="4">
                <b-form-group label="DDD + Telefone">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-phone"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  v-mask='["+55 (##) ####-####", "+55 (##) #####-####"]'
                                  class="form-control"
                                  placeholder="Telefone"
                                  autocomplete="telefone"
                                  v-model="usuario.telefone"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12">
                <b-form-group >
                  <b-button variant="primary" v-b-modal.modal-1><i class="fa fa-search"></i> Visualizar UF / Município(s)</b-button>
                </b-form-group>
              </b-col>
            </b-row>

            <b-modal id="modal-1" title="Listagem de Municípios" ok-title="Fechar" ok-only>
              <b-container fluid>
                     <span>
                        <table aria-rowcount="4" id="my-table" aria-busy="false" aria-colcount="7" class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                          <tr>
                            <th scope="col">UF</th>
                            <th scope="col">Município</th>
                          </tr>
                        </thead>
                        <tbody v-if="usuario.cidades !== undefined">
                          <tr class="action" v-for="item in usuario.cidades" :key="usuario.id_user">
                            <td>{{ item.cidade.estado.sigla }}</td>
                            <td>{{ item.cidade.cidade }}</td>
                          </tr>
                        </tbody>
                        <tbody v-else>
                         <tr class="action">
                           <td colspan="9">Nenhum registro de usuários...</td>
                         </tr>
                        </tbody>
                       </table>
                     </span>
              </b-container>
            </b-modal>
<!--              <b-row v-for="(item, index) in usuario.cidades" v-bind:key="index">
              <b-col cols="6">
                   <b-form-group label="Município:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="Nome"
                                  autocomplete="nome"
                                  v-model="item.cidade.cidade"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row> -->
             <b-row>
              <b-col cols="12">
                <b-form-group label="E-mail:">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text>@</b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  class="form-control"
                                  placeholder="E-mail"
                                  autocomplete="email"
                                  v-model="usuario.email"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
             <b-row>
                  <b-col cols="12">
                <b-form-group label="Órgão/Entidade:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="orgao"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              </b-row>
             <b-row>
                  <b-col cols="12">
                <b-form-group label="Cargo exercício no Órgão:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="cargo"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              </b-row>
             <b-row>
                  <b-col cols="12">
                <b-form-group label="Endereço do Órgão:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="endereco"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              </b-row>
             <b-row>
                  <b-col cols="5">
                <b-form-group label="DDD + Telefone do Órgão:">
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><i class="fa fa-phone"></i></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input type="text"
                                  v-mask='["+55 (##) ####-####", "+55 (##) #####-####"]'
                                  class="form-control"
                                  placeholder="Telefone"
                                  autocomplete="telefone"
                                  v-model="telefone"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
                  <b-col cols="7">
                <b-form-group label="Responsável pelo Órgão:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="responsavel"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
              </b-row>
             <b-row v-if="rg">
               <b-col cols="5">
                 <b-button variant="primary" @click="abrirDocumento(rg)"><i class="fa fa-download"></i> Visualizar Identidade (RG)</b-button>
               </b-col>
             </b-row>
             <br>
             <b-row v-if="cpf">
               <b-col cols="5">
                 <b-button variant="primary" @click="abrirDocumento(cpf)"><i class="fa fa-download"></i> Visualizar CPF</b-button>
               </b-col>
             </b-row>
             <br>
             <b-row v-if="cv">
               <b-col cols="5">
                 <b-button variant="primary" @click="abrirDocumento(cv)"><i class="fa fa-download"></i> Visualizar Mini Currículo</b-button>
               </b-col>
             </b-row>
             <br>
             <b-row v-if="ato">
               <b-col cols="5">
                 <b-button variant="primary" @click="abrirDocumento(ato)"><i class="fa fa-download"></i> Visualizar Ato de Nomeação</b-button>
               </b-col>
             </b-row>
             <br>
             <b-row v-for="(rede,index) in usuario.redes" v-bind:key="index">
                <b-col cols="12">
                <b-form-group label="Redes Sociais Pessoais e do Órgão:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="rede.link"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
             </b-row>
             <br>
             <b-row>
                <b-col cols="12">
                <b-form-group label="Aceite para o termo de uso de dados para o SINAJUVE">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="usuario.termo_sinajuve"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
             </b-row>
          </b-form>
        </b-card-body>
        <b-modal title="Rejeitar Usuário" size="lg" ok-title="Rejeitar Usuário" cancel-title="Cancelar" v-model="modalPreExcluirRejeitar" @ok="modalConfirmaRejeicao()" @cancel="resetForm()">
         <b-card-body>
             <b-form>
             <b-row>
              <b-col cols="12">
                <b-form-group label="Motivo da Rejeição:">
                  <b-input-group class="mb-12">
                     <b-form-textarea id="textarea" v-model="motivo" rows="5" max-rows="6"></b-form-textarea>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
      </b-modal>
        <b-modal title="Solicitar Correção" size="lg" ok-title="Solicitar Correção" cancel-title="Cancelar" v-model="modalPreAjuste" @ok="modalConfirmaAjuste()" @cancel="resetForm">
         <b-card-body>
             <b-form>
             <b-row>
              <b-col cols="12">
                <b-form-group label="Ajustes a serem realizados:">
                  <b-input-group class="mb-12">
                     <b-form-textarea id="textarea" v-model="motivo" rows="5" max-rows="6"></b-form-textarea>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
      </b-modal>
        <b-card-footer class="p-12">
            <b-button v-if="!loadingAprovar && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.aprovar')" @click="modalConfirmaAprovacao" variant="primary"><i class="fa fa-check"></i> Aprovar</b-button>
            <b-button v-if="loadingAprovar && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.aprovar')" variant="primary" disabled>
                <b-spinner small type="grow"></b-spinner>Aprovando...
            </b-button>
            <b-button v-if="!loadingRejeitar && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.rejeitar')" @click="modalConfirmaExclusaoRejeicao('rejeitar')" variant="primary"><i class="fa fa-ban"></i> Rejeitar</b-button>
            <b-button v-if="loadingRejeitar && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.rejeitar')" variant="primary" disabled>
                <b-spinner small type="grow"></b-spinner>Rejeitando...
            </b-button>
            <b-button v-if="!loadingSolicitarCorrecao && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.solicitarAjuste')" @click="modalAjuste()" variant="primary"><i class="fa fa-external-link-square"></i> Solicitar Correção</b-button>
            <b-button v-if="loadingSolicitarCorrecao && (usuario.situacao === 0 || usuario.situacao === 4) && can('user.solicitarAjuste')" variant="primary" disabled>
                <b-spinner small type="grow"></b-spinner>Solicitando...
            </b-button>
             <b-button variant="secondary" @click="$router.go(-1)"><i class="fa fa-mail-reply-all"></i> Voltar</b-button>
        </b-card-footer>
    </b-card>
    </span>
</template>

<script>
import Vue from 'vue'
import miniToastr from 'mini-toastr'
import SessionStorage from '@/services/session-storage'

miniToastr.init()
export default {
  created () {
    this.$store.dispatch('buscarEstados')
    this.$store.dispatch('buscarTipoUsuarios')
    this.$store.dispatch('buscarCidades')
    this.$store.dispatch('getUsuario', this.$route.params.id)
  },
  data () {
    return {
      uf: SessionStorage.get('uf'),
      modalPreExcluirRejeitar: false,
      modalPreAjuste: false,
      loadingAprovar: false,
      loadingRejeitar: false,
      loadingSolicitarCorrecao: false,
      motivo: '',
      orgao: '',
      cargo: '',
      endereco: '',
      estado_id: null,
      telefone: '',
      responsavel: '',
      ato: '',
      cpf: '',
      cv: '',
      rg: '',
      options: [
        {text: 'Feminino', value: 'F'},
        {text: 'Masculino', value: 'M'}
      ],
      titulo_confirmacao: ''
    }
  },
  watch: {
    'usuario.entidade': function () {
      if (this.usuario.entidade) {
        this.orgao = this.usuario.entidade.orgao
        this.cargo = this.usuario.entidade.cargo
        this.endereco = this.usuario.entidade.endereco
        this.telefone = this.usuario.entidade.telefone_orgao
        this.responsavel = this.usuario.entidade.responsavel

        for (let i = 0; i < this.usuario.documentos.length; i++) {
          if (this.usuario.documentos[i].tipo === '0') {
            this.ato = this.usuario.documentos[i].documento
          }

          if (this.usuario.documentos[i].tipo === '1') {
            this.cpf = this.usuario.documentos[i].documento
          }

          if (this.usuario.documentos[i].tipo === '2') {
            this.cv = this.usuario.documentos[i].documento
          }

          if (this.usuario.documentos[i].tipo === '3') {
            this.rg = this.usuario.documentos[i].documento
          }
        }
      }
    }
  },
  computed: {
    estados () {
      return this.$store.state.estado.listaEstados
    },
    cidades () {
      return this.$store.state.cidade.listaCidades
    },
    usuario () {
      return this.$store.state.usuario.usuarioEditar
    }
  },
  methods: {
    getStatus() {
      if (this.usuario.situacao === 0) { return 'Pendente' }
      if (this.usuario.situacao === 1) { return 'Aprovado' }
      if (this.usuario.situacao === 2) { return 'Rejeitado' }
      if (this.usuario.situacao === 3) { return 'Aguardando Correção' }
      if (this.usuario.situacao === 4) { return 'Corrigido' }
    },
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    modalConfirmaExclusaoRejeicao (tipo) {
      if (tipo === 'excluir') {
        this.titulo_confirmacao = 'Confirma a exclusão do registro selecionado?'
      } else {
        this.titulo_confirmacao = 'Confirma a rejeição do registro selecionado?'
      }

      this.modalPreExcluirRejeitar = true
    },
    modalAjuste () {
      this.modalPreAjuste = true
    },
    modalConfirmaAprovacao () {
      this.$bvModal.msgBoxConfirm('Confirma a aprovação do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.loadingAprovar = true
          Vue.http.get('api/usuario/aprovar/' + this.usuario.id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getUsuario', this.usuario.id)
              this.motivo = null
              this.loadingAprovar = false
              this.$router.push('/usuarios')
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {
            resource: this.resource,
            limit: this.totalPorPagina,
            filtros: this.filtros
          })
        }
      })
    },
    modalConfirmaRejeicao () {
      this.$bvModal.msgBoxConfirm('Você confirma a rejeição do usuário?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.loadingRejeitar = true

          let data = {
            mensagem: this.motivo,
            user_avaliador: SessionStorage.get('usuario', []),
            user_avaliado: this.usuario.id
          }

          Vue.http.post('api/usuario/rejeitar', data).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.loadingRejeitar = false
              this.motivo = null
              this.$store.dispatch('getUsuario', this.$route.params.id)
              this.$router.push('/usuarios')
            }
          }).catch(erro => {
            if (!erro.body.success) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
              miniToastr.error(erro.body.msg, 'Alerta!', 7000)
              this.$store.dispatch('getUsuario', this.$route.params.id)
            }
          })
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    resetForm() {
      this.motivo = '';
    },    
    modalConfirmaAjuste () {
      this.$bvModal.msgBoxConfirm('Você confirma o pedido de ajuste?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          this.loadingSolicitarCorrecao = true

          let data = {
            mensagem: this.motivo,
            user_avaliador: SessionStorage.get('usuario', []),
            user_avaliado: this.usuario.id
          }

          Vue.http.post('api/usuario/solicitar-ajuste', data).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.loadingSolicitarCorrecao = false
              this.motivo = null
              this.$store.dispatch('getUsuario', this.$route.params.id)
              this.$router.push('/usuarios')
            }
          }).catch(erro => {
            if (!erro.body.success) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
              miniToastr.error(erro.body.msg, 'Alerta!', 7000)
              this.$store.dispatch('getUsuario', this.$route.params.id)
            }
          })
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    navigate () {
      let id = this.$route.params.id
      this.$router.push('/usuario/' + id + '/editar')
    },
    abrirDocumento (item) {
      window.open(item, '_blank')
    }
  }
}
</script>

<style scoped>
    img.preview {
        width: 100px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }
</style>
