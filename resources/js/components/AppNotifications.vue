<template>
    <li class="nav-item dropdown">
        <a class="nav-link" href="javascript:;#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">notifications</i>
          <span class="notification">5</span>
          <p class="d-lg-none d-md-block">
            Some Actions
          </p>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <AppNotification :key="notification.id" v-for="notification in notifications" :notification="notification"></AppNotification>
        </div>
    </li>
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