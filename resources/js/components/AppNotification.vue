<template>
<a href="#" class="navi-item">
	<div class="navi-link">
		<div class="navi-icon mr-2">
			<i class="flaticon2-line-chart text-success"></i>
		</div>
		<div class="navi-text">
			<div class="font-weight-bold">
				{{ text }}
			</div>
			<div class="text-muted">
				{{ created_at }}
			</div>
		</div>
	</div>
</a>
</template>

<script>
  export default {
    name: "AppNotification",
    props: ['notification'],
    computed: {
      created_at() {
        return moment(this.notification.created_at).format('MMMM Do YYYY')
      },
      text() {
	  	console.log(this.notification.type);
	  	switch(this.notification.type){
			case 'App\\Notifications\\OrderStatus':
	  			console.log(this.notification.data.newStatus);
				switch(this.notification.data.newStatus){
					case "ping":
						return "Votre commande a été créée " + this.notification.id;
					break;
					case "on-hold":
						return "Votre commande est en cours de paiement " + this.notification.id;
					break;
					case "processing":
						return "Votre commande est en cours de traitement " + this.notification.id;
					break;
					case "ok":
						return "Votre commande est bien reçue " + this.notification.id;
					break;
					case "active":
						return "Votre commande est active " + this.notification.id;
					break;
					case "canceled":
						return "Votre commande a été annulée  " + this.notification.id;
					break;
					case "completed":
						return "Votre commande a été términée " + this.notification.id;
					break;
				}
			break;
			case 'App\Notifications\ItemStatus':
				switch(this.notification.data.newStatus){
					case "ping":
						return "Un élément de votre commande créé " + this.notification.id;
					break;
					case "active":
						return "Un élément de votre commande activé " + this.notification.id;
					break;
					case "next":
						return "Vous etes le suivant " + this.notification.id;
					break;
					case "arrived":
						return "Chauffeur arrivé " + this.notification.id;
					break;
					case "online":
						return "Un élément de votre commande en route  " + this.notification.id;
					break;
					case "canceled":
						return "Un élément de votre commande annulé " + this.notification.id;
					break;
					case "completed":
						return "Un élément de votre commande términé " + this.notification.id;
					break;
				}
			break;
			case 'App\Notifications\RideStatus':
				switch(this.notification.data.newStatus){
					case "ping":
						return "Une course a été créée " + this.notification.id;
					break;
					case "active":
						return "Une course a été activé " + this.notification.id;
					break;
					case "cancelable":
						return "Une course peut etre annulée " + this.notification.id;
					break;
					case "canceled":
						return "Une course a été annulée " + this.notification.id;
					break;
					case "completable":
						return "Une course peut etre términée " + this.notification.id;
					break;
					case "completed":
						return "Une course a été términée " + this.notification.id;
					break;
				}
			break;
		}
		return 'Inconnu';
      }
    }
  }
</script>