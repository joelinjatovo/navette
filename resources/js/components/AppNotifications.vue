<template>
<div class="dropdown">
	<div data-toggle="dropdown" data-offset="10px,0px" class="topbar-item">
		<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
			<span class="svg-icon svg-icon-xl svg-icon-primary">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"></rect> 
						<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"></path> <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"></path>
					</g>
				</svg>
			</span>
			<span class="pulse-ring"></span>
		</div>
	</div>
	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
		<form>
			<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top">
				<h4 class="d-flex flex-center rounded-top">
					<span>Notifications</span>
				</h4> 
			</div>
			<div>
				<!--begin::Nav-->
				<div class="navi navi-hover scroll my-4" data-scroll="true" data-height="300" data-mobile-height="200">
					<!--begin::Item-->
					<AppNotification :key="notification.id" v-for="notification in notifications" :notification="notification"></AppNotification>
					<!--end::Item-->
				</div>
				
			</div>
		</form>
	</div>
</div>
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
            .notification((res) => {
                console.log(res);
				$.notify({icon:"add_alert", message:this.formatMessage(res)}, {type:"danger"});
                this.$store.commit('ADD_NOTIFICATION', res)
            });
    },
    computed: {
      ...mapGetters([
        'notifications'
      ])
    },
    methods: {
      formatMessage(res) {
	  	switch(res.type){
			case 'App\\Notifications\\OrderStatus':
				switch(res.newStatus){
					case "ping":
						return "Votre commande a été créée ";
					break;
					case "on-hold":
						return "Votre commande est en cours de paiement ";
					break;
					case "processing":
						return "Votre commande est en cours de traitement ";
					break;
					case "ok":
						return "Votre commande est bien reçue ";
					break;
					case "active":
						return "Votre commande est active ";
					break;
					case "canceled":
						return "Votre commande a été annulée  ";
					break;
					case "completed":
						return "Votre commande a été términée ";
					break;
				}
			break;
			case 'App\\Notifications\\ItemStatus':
				switch(res.newStatus){
					case "ping":
						return "Un élément de votre commande créé ";
					break;
					case "active":
						return "Un élément de votre commande activé ";
					break;
					case "next":
						return "Vous etes le suivant ";
					break;
					case "arrived":
						return "Chauffeur arrivé ";
					break;
					case "online":
						return "Un élément de votre commande en route  ";
					break;
					case "canceled":
						return "Un élément de votre commande annulé ";
					break;
					case "completed":
						return "Un élément de votre commande términé ";
					break;
				}
			break;
			case 'App\\Notifications\\RideStatus':
				switch(res.newStatus){
					case "ping":
						return "Une course a été créée ";
					break;
					case "active":
						return "Une course a été activé ";
					break;
					case "cancelable":
						return "Une course peut etre annulée ";
					break;
					case "canceled":
						return "Une course a été annulée ";
					break;
					case "completable":
						return "Une course peut etre términée ";
					break;
					case "completed":
						return "Une course a été términée ";
					break;
				}
			break;
		}
		return 'Inconnu';
      }
    }
  }
</script>

<style>
</style>