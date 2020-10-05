<template>
    <span>
      <b-card no-body>
        <b-card-header>
            <b-row>
                 <b-col md="10">
                    <h3>Perfis</h3>
                 </b-col>
                <b-col md="2">
                    <b-button v-if="can('perfil.store')" @click="navigate('/perfil/cadastrar')" block variant="primary">
                         <i class="fa fa-plus"></i>
                       <span>Novo Perfil</span>
                    </b-button>
                 </b-col>
            </b-row>
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col sm="12">
                    <b-form-group label="Nome:">
                        <b-form-input type="text" id="name" v-model="filtros.filter" placeholder="Nome"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="3">
                    <b-form-group>
                        <b-form-group label="Status:">
                            <b-form-checkbox-group v-model="filtros.status" id="checkbox-group-2" name="flavour-2">
                                <b-form-checkbox :value="1">Ativo</b-form-checkbox>
                                <b-form-checkbox :value="0">Inativo</b-form-checkbox>
                            </b-form-checkbox-group>
                        </b-form-group>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-card-body>
        <b-row>
            <b-col sm="12">
                <b-container fluid>
                       <span>
                          <table aria-rowcount="4" aria-busy="false" aria-colcount="7" class="table table-responsive-sm table-bordered table-striped table-sm">
                          <thead>
                            <tr>
                              <th scope="col">Perfil</th>
                              <th scope="col">Status</th>
                              <th scope="col">Ações</th>
                            </tr>
                          </thead>
                          <tbody v-if="perfis.data !== undefined">
                            <tr class="action" v-for="perfil in perfis.data" :key="perfil.id">
                              <td>{{perfil.nome}}</td>
                              <td v-if="perfil.ativo">
                                   <span class="badge badge-success">Ativo</span>
                              </td>
                              <td v-else>
                               <span class="badge badge-dark">Inativo</span>
                              </td>
                              <td style="width: 15%">
                                  <a v-if="can('perfil.update')" class="btn btn-sm btn-secondary action" title="Editar Perfil" @click="editarPerfil(perfil.id)">
                                     <i class="fa fa-pencil-square-o"></i>
                                  </a>
                                  <a v-if="can('perfil.destroy')" class="btn btn-sm btn-secondary action" title="Excluir Perfil" @click="excluirPerfil(perfil.id)">
                                     <i class="fa fa-times"></i>
                                  </a>
                                  <a v-if="can('perfil.show')" class="btn btn-sm btn-secondary action" title="Visualizar Perfil" @click="visualizarPerfil(perfil.id)">
                                     <i class="fa fa-search"></i>
                                  </a>
                              </td>
                            </tr>
                          </tbody>
                          <tbody v-else>
                           <tr class="action">
                             <td colspan="8">Nenhum registro de perfis...</td>
                           </tr>
                          </tbody>
                         </table>
                         <pagination v-show="perfis.data !== undefined" :totalPorPagina="totalPorPagina" :resource="resource"></pagination>
                       </span>
                </b-container>
            </b-col>
        </b-row>
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
import Pagination from '@/components/shared/Pagination'
import {eventType} from '@/components/shared/eventType'
import miniToastr from 'mini-toastr'

miniToastr.init()

export default {
  components: {
    Pagination
  },
  created () {
    if (!this.can('perfil.index')) {
      this.$router.push('/')
    }
  },
  data () {
    return {
      modalPreExcluir: false,
      totalPorPagina: 5,
      resource: 'perfil',
      password: null,
      filtros: {
        filter: '',
        sistema_id: null,
        status: null
      }
    }
  },
  computed: {
    perfil () {
      return this.$store.state.perfil.perfil
    },
    perfis () {
      if (this.$store.state.pagination.getList.data !== undefined) {
        if (this.$store.state.pagination.getList.data.length !== 0) {
          return this.$store.state.pagination.getList
        } else {
          return false
        }
      }
      return this.$store.state.pagination.getList
    }
  },
  watch: {
    'filtros.filter': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
    },
    'filtros.status': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
      this.setarFiltros(this.filtros)
    },
    'filtros.sistema_id': function () {
      this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
      this.setarFiltros(this.filtros)
    }
  },
  methods: {
    can (permissao) {
      return this.$store.getters.validaPermissao(permissao)
    },
    setarFiltros (filtros) {
      eventType.$emit('app', filtros)
    },
    navigate (route) {
      this.$router.push(route)
    },
    editarPerfil (id) {
      this.$router.push('/perfil/' + id + '/editar')
    },
    excluirPerfil (id) {
      this.$store.dispatch('getPerfil', id)
      this.modalPreExcluir = true
    },
    visualizarPerfil (id){
      this.$router.push('/perfil/' + id + '/visualizar')
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
              this.$store.dispatch('getRegistrosSearch', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
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

<style scoped>
    .action{
        cursor: pointer;
    }
</style>
