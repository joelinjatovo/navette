<template>
</template>

<script>
  import {mapGetters} from 'vuex'

  export default {
    name: "AppRidePoint",
    props: ['point'],
    computed: {
      created_at() {
        return moment(this.point.created_at).format('MMMM Do YYYY')
      },
    }
  }
</script>

<style>
</style>