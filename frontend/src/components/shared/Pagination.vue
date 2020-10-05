<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item" v-if="currentPage > 1">
            <a class="page-link" aria-label="Previous" v-on:click.prevent="navigate(currentPage - 1)">
              <span aria-hidden="true">«</span>
            </a>
          </li>
          <li class="page-link">
            {{ currentPage }} de {{ lastPage }}
          </li>
          <li v-if="currentPage < lastPage">
            <a class="page-link" aria-label="Next" v-on:click.prevent="navigate(currentPage + 1)">
              <span aria-hidden="true">»</span>
            </a>
          </li>
        </ul>
        <p>Exibindo página {{active}} de {{total}}, total de {{totalRegistros}} registros.</p>
    </nav>
</template>

<script>
import {eventType} from '@/components/shared/eventType'
export default {
  name: 'Pagination',
  props: [
    'resource',
    'totalPorPagina',
    'filtros'
  ],
  created () {
    this.$store.dispatch('getRegistros', {resource: this.resource, limit: this.totalPorPagina, filtros: this.filtros})
  },
  mounted () {
    eventType.$on('app', (result) => {
      this.filtros = result
    })
  },
  data: function () {
    return {
      active: 1
    }
  },
  computed: {
    registros () {
      if (this.filtros) {
        if (this.filtros.classificacao_ranking === 'T') {
          return this.$store.state.pagination.titulares
        }
        if (this.filtros.classificacao_ranking === 'S') {
          return this.$store.state.pagination.suplentes
        }
        if (this.filtros.classificacao_ranking === 'M') {
          return this.$store.state.pagination.menores
        }
      }
      return this.$store.state.pagination.getList
    },
    totalRegistros () {
      return this.registros.total || 0
    },
    total () {
      return this.registros.last_page || 0
    },
    currentPage () {
      return this.registros.current_page
    },
    lastPage () {
      return this.registros.last_page
    }
  },
  methods: {
    navigate (n) {
      this.active = n

      let config = {
        resource: this.resource,
        limit: this.totalPorPagina,
        page: n,
        filtros: this.filtros
      }

      this.$store.dispatch('getRegistrosSearch', config)
    }
  }
}
</script>
