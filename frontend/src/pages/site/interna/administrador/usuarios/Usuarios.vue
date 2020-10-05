<template>
    <span>
      <b-card no-body>
        <b-card-header>
            <b-row>
                 <b-col md="10">
                    <h3>Listar Usuários</h3>
                 </b-col>
                 <b-col md="2">
                    <b-button v-if="can('user.store')" @click="navigate('/usuario/cadastrar')" block variant="primary">
                         <i class="fa fa-plus"></i>
                       <span>Novo Usuário</span>
                    </b-button>
                 </b-col>
            </b-row>
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col sm="12">
                    <b-form-group label="Nome, E-mail, CPF:">
                        <b-form-input type="text" id="name" v-model="filtros.filter" placeholder="Nome, E-mail, CPF"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="2">
                    <b-form-group label="Perfil do Usuário:">
                        <b-form-select v-model="filtros.tipo" placeholder="Tipo de Usuário" class="mb-3">
                              <option selected :value="null">Selecione</option>
                              <option v-for="item in perfis" :key="item.id" :value="item.id"> {{item.nome}}</option>
                        </b-form-select>
                    </b-form-group>
                </b-col>
                <b-col sm="2">
                    <b-form-group label="Situação:">
                        <b-form-select v-model="filtros.status" placeholder="Situação" class="mb-3">
                              <option selected :value="null">Selecione</option>
                              <option v-for="item in situacoes" :key="item.id" :value="item.value"> {{item.text}}</option>
                        </b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="2">
                  <b-button @click="resetForm()" block>
                      <span>Limpar Filtros</span>
                  </b-button>
                </b-col>
            </b-row>
        </b-card-body>
        <b-row>
            <b-col sm="12">
                <b-container fluid>
                       <span>
                          <table aria-rowcount="4" id="my-table" aria-busy="false" aria-colcount="7" class="table table-responsive-sm table-bordered table-striped table-sm">
                          <thead>
                            <tr>
                              <th scope="col">CPF</th>
                              <th scope="col">Nome do Usuário</th>
                              <th scope="col">Perfil do Usuário</th>
                              <th scope="col">Situação</th>
                              <th scope="col">Data de Cadastro</th>
                              <th scope="col">Ações</th>
                            </tr>
                          </thead>

                          <tbody v-if="usuarios.data !== undefined">
                            <tr class="action" v-for="usuario in usuarios.data" :key="usuario.id_user">

                              <td>{{usuario.cpf}}</td>
                              <td>{{usuario.nome}}</td>
                              <td>{{usuario.perfil}}</td>
                              <td>
                                <span v-if="usuario.ativo" class="badge badge-success">Ativo</span>
                                <span v-else class="badge badge-dark">Inativo</span>
                              </td>
                              <td>{{usuario.created_at}}</td>                       
                              <td style="width: 15%">
                                  <a v-if="can('user.update')" class="btn btn-sm btn-secondary action" title="Editar" @click="editarUsuario(usuario.id_user)">
                                     <i class="fa fa-pencil-square-o"></i>
                                  </a>
 
                                  <span>
                                     <a v-if="can('user.destroy') && usuario.id_user !== usuarioCorrente" class="btn btn-sm btn-secondary action" title="Excluir" @click="excluirUsuario(usuario.id_user)">
                                      <i class="fa fa-times"></i>
                                     </a>
                                  </span>

                                  <span v-if="can('user.suspender') && usuario.ativo">
                                     <a class="btn btn-sm btn-secondary action" title="Inativar" @click="suspenderUsuario(usuario.id_user)">
                                      <i class="fa fa-toggle-on"></i>
                                     </a>
                                  </span>

                                  <span v-if="can('user.ativar') && !usuario.ativo">
                                     <a class="btn btn-sm btn-secondary action" title="Ativar" @click="ativarUsuario(usuario.id_user)">
                                      <i class="fa fa-toggle-off"></i>
                                     </a>
                                  </span>

                                  <span>
                                     <a v-if="can('user.show')" class="btn btn-sm btn-secondary action" title="Visualizar" @click="visualizarUsuario(usuario.id_user)">
                                      <i class="fa fa-search"></i>
                                     </a>
                                  </span>
                              </td>
                            </tr>
                          </tbody>
                          <tbody v-else>
                           <tr class="action">
                             <td colspan="9">Nenhum registro de usuários...</td>
                           </tr>
                          </tbody>
                         </table>
                          <pagination v-show="usuarios.data !== undefined" :totalPorPagina="totalPorPagina" :resource="resource"></pagination>
                       </span>
                </b-container>
            </b-col>
        </b-row>
      </b-card>
      <b-modal :title="titulo_descricao" size="lg" :ok-title="titulo_botao" cancel-title="Cancelar" v-model="modalPreExcluirRejeitar" @ok="modalConfirmaExclusaoRejeicao(tipo)">
         <b-card-body>
             <b-form>
            <b-row>
              <b-col cols="12">
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
              <b-col cols="12">
                <b-form-group label="Nome completo::">
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
            </b-row>
          </b-form>
        </b-card-body>
      </b-modal>
      <b-modal title="Aprovação de Usuário" size="lg" ok-title="Aprovar" cancel-title="Cancelar" v-model="modalPreAprovar" @ok="modalConfirmaAprovacao">
             <b-card-body>
             <b-form>
            <b-row>
                 <b-col cols="12">
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
                 <b-col cols="12">
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
             <b-col cols="12">
                <b-form-group label="Tipo de Usuário:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="usuario.perfil"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
         </b-modal>
      <b-modal title="Inativar Usuário" size="lg" ok-title="Inativar" cancel-title="Cancelar" v-model="modalSuspender" @ok="modalConfirmaSuspensao">
             <b-card-body>
             <b-form>
            <b-row>
                <b-col cols="12">
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
                <b-col cols="12">
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
              <b-col cols="12">
                <b-form-group label="Tipo de Usuário:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="usuario.perfil"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card-body>
         </b-modal>
      <b-modal title="Ativar Usuário" size="lg" ok-title="Ativar" cancel-title="Cancelar" v-model="modalAtivar" @ok="modalConfirmaAtivar">
             <b-card-body>
             <b-form>
            <b-row>
                 <b-col cols="12">
                <b-form-group label="Tipo de Usuário:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="usuario.perfil"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
                 <b-col cols="12">
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
              <b-col cols="12">
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
            </b-row>
          </b-form>
        </b-card-body>
         </b-modal>
      <b-modal title="Enviar Pendência" size="lg" ok-title="Enviar pendência" cancel-title="Cancelar" v-model="modalPendencia" @ok="modalConfirmaEnvioPendencia" @cancel="resetForm">
         <b-card-body>
             <b-form>
            <b-row>
                 <b-col cols="12">
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
                 <b-col cols="12">
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
              <b-col cols="12">
                <b-form-group label="Tipo de Usuário:">
                  <b-input-group class="mb-3">
                    <b-form-input type="text"
                                  class="form-control"
                                  v-model="usuario.perfil"
                                  :disabled="true"/>
                  </b-input-group>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
                <b-col cols="12">
                    <b-form-group label="Pendências:">
                        <b-input-group class="mb-12">
                            <b-form-textarea id="textarea" v-model="motivo" rows="5" max-rows="6"></b-form-textarea>
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
import Pagination from '@/components/shared/Pagination'
import {eventType} from '@/components/shared/eventType'
import {DatePicker, setupCalendar} from 'v-calendar'
import 'v-calendar/lib/v-calendar.min.css'
import miniToastr from 'mini-toastr'
import SessionStorage from '@/services/session-storage'
import Multiselect from 'vue-multiselect'

setupCalendar({
  firstDayOfWeek: 2 // Monday
})

miniToastr.init()

const today = new Date()

export default {
  components: {
    Pagination,
    'v-date-picker': DatePicker,
    Multiselect
  },
  created () {
    if (!this.can('user.index')) {
      this.$router.push('/')
    } else {
      this.$store.dispatch('buscarEstados')
      this.$store.dispatch('buscarCidades')
      this.$store.dispatch('getPerfis')
    }
  },
  data () {
    return {
      uf: false,
      uf_user: SessionStorage.get('uf'),
      usuarioCorrente: parseInt(SessionStorage.get('usuario')),
      motivo: null,
      label_data: '',
      disable_data: true,
      tipo: '',
      titulo_confirmacao: '',
      titulo_descricao: '',
      titulo_botao: '',
      totalPorPagina: 10,
      resource: 'usuario',
      modalPreExcluirRejeitar: false,
      modalSuspender: false,
      modalAtivar: false,
      modalPendencia: false,
      modalPreAprovar: false,
      situacoes: [
        { value: '1', text: 'Ativo' },
        { value: '0', text: 'Inativo' },
      ],
      filtros: {
        situacao: null,
        filter: '',
        tipo: null,
        uf: null,
        municipio: null,
        status: null,
        dataStart: null,
        dataEnd: null,
        consultarData: null,
        dataCadastro: {
          start: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
          end: new Date(today.getFullYear(), today.getMonth(), today.getDate())
        }
      }
    }
  },
  computed: {
    perfilAtual () {
      return this.$store.state.usuario.perfilAtual
    },
    usuarios () {
      if (this.$store.state.pagination.getList.data !== undefined) {
        if (this.$store.state.pagination.getList.data.length !== 0) {
          return this.$store.state.pagination.getList
        } else {
          return false
        }
      }
      return this.$store.state.pagination.getList
    },
    perfis () {
      return this.$store.state.perfil.lista
    },
    usuario () {
      return this.$store.state.usuario.usuarioEditar
    },
    inputState () {
      if (!this.selectedValue) {
        return {
          type: 'is-danger',
          message: 'Data do cadastro'
        }
      }
      return {
        type: 'is-primary',
        message: ''
      }
    }
  },
  watch: {
    'filtros.filter': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
    },
    'filtros.tipo': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
    },
    'filtros.status': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
    }
  },
  methods: {
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    setarFiltros (filtros) {
      eventType.$emit('app', filtros)
    },
    visualizarUsuario (id) {
      this.$router.push('/usuario/' + id + '/visualizar')
    },
    editarUsuario (id) {
      this.$router.push('/usuario/' + id + '/editar')
    },
    visualizarUsuario (id) {
      this.$router.push('/usuario/' + id + '/visualizar')
    },
    excluirUsuario (id) {
      this.titulo_descricao = 'Exclusão do Usuário'
      this.titulo_confirmacao = 'Confirma a exclusão do registro selecionado?'
      this.titulo_botao = 'Excluir'
      this.tipo = 'excluir'
      this.modalPreExcluirRejeitar = true
      this.$store.dispatch('getUsuario', id)
    },
    suspenderUsuario (id) {
      this.modalSuspender = true
      this.$store.dispatch('getUsuario', id)
    },
    ativarUsuario (id) {
      this.modalAtivar = true
      this.$store.dispatch('getUsuario', id)
    },
    enviarPendencia (id) {
      this.modalPendencia = true
      this.$store.dispatch('getUsuario', id)
    },
    modalConfirmaExclusaoRejeicao () {
      this.$bvModal.msgBoxConfirm(this.titulo_confirmacao, {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.get('api/usuario/' + this.tipo + '/' + this.usuario.id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          }).catch(erro => {
            if (!erro.body.success) {
              miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
              miniToastr.error(erro.body.msg, 'Alerta!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        console.log(erro)
      })
    },
    modalConfirmaAprovacao () {
      this.$bvModal.msgBoxConfirm('Confirma a aprovação do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.get('api/usuario/aprovar/' + this.usuario.id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
        }
      })
    },
    modalConfirmaSuspensao () {
      this.$bvModal.msgBoxConfirm('Confirma a suspensão do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.get('api/usuario/suspender/' + this.usuario.id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
        }
      })
    },
    modalConfirmaAtivar () {
      this.$bvModal.msgBoxConfirm('Confirma a ativação do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.get('api/usuario/ativar/' + this.usuario.id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
        }
      })
    },
    modalConfirmaEnvioPendencia () {
      this.$bvModal.msgBoxConfirm('Confirma o envio de pendência do registro selecionado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          let data = {
            mensagem: this.motivo,
            user_avaliador: SessionStorage.get('usuario', []),
            user_avaliado: this.usuario.id
          }

          Vue.http.post('api/usuario/enviar-pendencia', data).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.motivo = null
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
        }
      })
    },
    aprovarRejeitado (id) {
      this.$bvModal.msgBoxConfirm('Confirma a aprovação do usuário rejeitado?', {
        okTitle: 'Confirmar',
        cancelTitle: 'Cancelar'
      }).then(valor => {
        if (valor) {
          Vue.http.get('api/usuario/aprovar/' + id).then(response => {
            if (response.body.success) {
              miniToastr.setIcon('success', 'i', {'class': 'fa fa-check'})
              miniToastr.success(response.body.msg, 'Sucesso!', 7000)
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
            }
          })
        }
      }).catch(erro => {
        if (!erro.body.success) {
          miniToastr.setIcon('error', 'i', {'class': 'fa fa-check'})
          miniToastr.error(erro.body.msg, 'Alerta!', 7000)
          this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
        }
      })
    },
    navigate (route) {
      this.$router.push(route)
    },
    ativar () {
      this.disable_data = false
      this.filtros.consultarData = true
    },
    inativar () {
      this.disable_data = true
      this.filtros.consultarData = null
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
      this.setarFiltros(this.filtros)
    },
    resetForm () {
      this.filtros.status = null
      this.filtros.tipo = null
      this.filtros.filter = null
    },
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .multiselect.invalid .multiselect__tags,
    .multiselect.invalid .multiselect__tags span,
    .multiselect.invalid .multiselect__tags input {
        background:red;
    }
</style>
