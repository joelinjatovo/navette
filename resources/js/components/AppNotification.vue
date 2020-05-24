<template>
<a :href="link" class="navi-item">
	<div class="navi-link">
		<div class="navi-icon mr-2">
			<i class="flaticon2-line-chart text-success"></i>
		</div>
		<div class="navi-text">
			<div class="font-weight-bold">
				{{ text }}
			</div>
			<div class="text-muted">
				{{ datenow }}
			</div>
		</div>
	</div>
</a>
</template>

<script>
  export default {
    name: "AppNotification",
    props: ['notification'],
	data:function () {
		return {
		  datenow: ''
		}
  	},
	mounted: function() {
		this.updateDate()
	},
	methods: {
		updateDate: function () {
		  var self = this
		  this.datenow = moment(this.notification.created_at).fromNow()
		  setInterval(self.updateDate, 1000)
		}
	},
    computed: {
      link() {
        return "/notification/" + this.notification.id;
      },
      text() {
	  	var newStatus = this.notification.newStatus != undefined ? this.notification.newStatus : this.notification.data.newStatus;
	  	switch(this.notification.type){
			case 'App\\Notifications\\OrderStatus':
				switch(newStatus){
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
				switch(newStatus){
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
				switch(newStatus){
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