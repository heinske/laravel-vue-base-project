<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <slot/>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AuthTemplate'
}
</script>
