<template>
    
</template>

<script>
  import {mapGetters} from 'vuex'
  import AppNotification from './AppNotification'

  export default {
    name: "AppNotifications",
    components: {AppNotification},
    props: ['user_id'],
    mounted() {
      this.$store.dispatch('GET_NOTIFICATIONS')
      console.log("User Id  = " + this.user_id);
      window.Echo.private('App.User.' + this.user_id)
            .notification((response) => {
                console.log("window.Echo.private");
                console.log(response);
                this.$store.commit('ADD_NOTIFICATION', response.data)
            });
    },
    computed: {
      ...mapGetters([
        'notifications'
      ])
    }
  }
</script>

<style>
</style>