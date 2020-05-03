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
          <Notification :key="notification.id" v-for="notification in notifications" :notification="notification"></Notification>
        </div>
    </li>
</template>

<script>
  import {mapGetters} from 'vuex'
  import Notification from './Notification'

  export default {
    name: "Notifications",
    components: {Notification},
    props: ['user'],
    mounted() {
      this.$store.dispatch('GET_NOTIFICATIONS')
      
      window.Echo.private('App.User.' + this.user.id)
            .notification((data) => {
                console.log(data);
                this.$store.commit('ADD_NOTIFICATION', data.notification)
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