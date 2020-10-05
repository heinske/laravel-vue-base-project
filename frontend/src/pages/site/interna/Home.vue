<template>
<span>
    <h3>Seja bem-vindo(a) {{usuario.nome}}!</h3>
</span>
</template>
<script>
import Vue from 'vue'
import SessionStorage from '@/services/session-storage'
import miniToastr from 'mini-toastr'

miniToastr.init()

export default {
  name: 'HelloWorld',
  data () {
    return {
     
    }
  },
  computed: {
    usuario () {
      return this.$store.state.usuario.usuarioEditar
    }
  },
}
</script>
