<template>
  <b-tabs>
    <b-tab>
      <template slot="title">
        <i class='icon-list'></i>
      </template>
      <b-list-group class="list-group-accent">
        <b-list-group-item class="list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">
          Módulos
        </b-list-group-item>
        <b-list-group-item href="#" class="list-group-item-accent-warning list-group-item-divider">
          <div>Sistema
            <strong>SINDH Desaparecidos</strong>
          </div>
        </b-list-group-item>
        <hr class="transparent mx-3 my-0">
      </b-list-group>
    </b-tab>
  </b-tabs>
</template>

<script>
import { Switch as cSwitch } from '@coreui/vue'
export default {
  name: 'DefaultAside',
  components: {
    cSwitch
  }
}
</script>
