<template>
</template>

<script>
  import {mapGetters} from 'vuex'
  import AppRidePoint from './AppRidePoint'

  export default {
    name: "AppRidePoints",
    components: {AppRidePoint},
    props: ['user_id'],
    mounted() {
    },
    computed: {
    }
  }
</script>

<style>
</style>