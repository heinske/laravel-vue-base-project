<template>
  <AppHeaderDropdown right no-caret>
    <template slot="header" v-if="avatar != null">
      <img v-if="avatar != null" :src="avatar"
        width="35"
        height="35"
        class="img-avatar"
        alt="" />
    </template>\
    <template slot="dropdown">
      <b-dropdown-header tag="div" class="text-center"><strong>Conta</strong></b-dropdown-header>
      <b-dropdown-item v-on:click="meuPerfil"><i class="fa fa-user" /> Meu Perfil</b-dropdown-item>
      <b-dropdown-divider />
      <b-dropdown-item v-on:click="logout"><i class="fa fa-lock" /> Sair</b-dropdown-item>
    </template>
  </AppHeaderDropdown>
</template>

<script>
import { HeaderDropdown as AppHeaderDropdown } from '@coreui/vue'
import SessionStorage from '@/services/session-storage'
export default {
  name: 'DefaultHeaderDropdownAccnt',
  components: {
    AppHeaderDropdown
  },
  created () {
    this.$store.dispatch('getUsuario', SessionStorage.get('usuario'))
  },
  data: () => {
    return {
      itemsCount: 42,
      avatar: SessionStorage.get('avatar')
    }
  },
  computed: {
    usuario () {
      return this.$store.state.usuario.usuarioEditar
    }
  },
  methods: {
    logout () {
      sessionStorage.clear()
      this.$router.push('/login')
    },
    meuPerfil () {
      this.$router.push('/perfil')
    }
  }
}
</script>
