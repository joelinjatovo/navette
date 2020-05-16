@extends('layouts.customer')

@section('style')
@endsection

@section('content')
<div class="col-xl-6">
	<form class="form" method="post">
        <!--begin::List Widget 13-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bolder text-dark">Choisissez votre methode de paiement</h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-2">
                <!--begin::Item-->
                <div class="d-flex flex-wrap align-items-center mb-10">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                        <div class="symbol-label" style="background-image: url('{{ asset('/img/gateways/cash.jpg') }}')"></div>
                    </div>
                    <!--end::Symbol-->

                    <!--begin::Title-->
                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 mr-2">
                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Espèce</a>
                        <span class="text-muted font-weight-bold">Payer la course directement dans la navette</span>
                    </div>
                    <!--end::Title-->

                    <!--begin::Section-->
                    <div class="d-flex align-items-center mt-lg-0 mt-3">
                        <!--begin::Btn-->
                        <a href="#" id="pay_per_cash" class="btn btn-icon btn-light btn-sm">
                            <span class="svg-icon svg-icon-success">
                                <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Navigation/Arrow-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"></rect>
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                        <!--end::Btn-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="d-flex flex-wrap align-items-center mb-10">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                        <div class="symbol-label" style="background-image: url('{{ asset('/img/gateways/stripe.jpg') }}')"></div>
                    </div>
                    <!--end::Symbol-->

                    <!--begin::Title-->
                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 mr-2">
                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Carte bancaire</a>
                        <span class="text-muted font-weight-bold">Utilisew une carte bancaire pour payer la course</span>
                    </div>
                    <!--end::Title-->

                    <!--begin::Section-->
                    <div class="d-flex align-items-center mt-lg-0 mt-3">

                        <!--begin::Btn-->
                        <a href="#" id="pay_per_stripe" class="btn btn-icon btn-light btn-sm">
                            <span class="svg-icon svg-icon-success">
                                <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Navigation/Arrow-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"></rect>
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "></path>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                        <!--end::Btn-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--end::Items-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List Widget 13-->
    </form>
</div>

<div class="modal fade" id="stripeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paiement par carte bancaire</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div id="card-element">
                        <!-- Elements will create input elements here -->
                    </div>
                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="payment-form" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://js.stripe.com/v3/"></script>
<script>
jQuery(document).ready(function(){
    $(document).on('click', '#pay_per_cash', function(e){
        e.preventDefault();
        var $this = $(this);
        KTApp.blockPage({overlayColor: '#000000',type: 'v2',state: 'success',size: 'xl'});
        $.post("/gateway/cash/pay", {})
        .done(function( data ) {
            KTApp.unblockPage();
            Swal.fire(data.title, data.message, data.status)
            .then(function(result) {
                if (data.redirect) {
                    window.location.href=data.redirect;
                }
            });
        })
        .fail(function() {
            KTApp.unblockPage();
            Swal.fire("Erreur", "Une erreur s'est produite.", "error")
        });
    });
    $(document).on('click', '#pay_per_stripe', function(e){
        e.preventDefault();
        var $this = $(this);
        KTApp.blockPage({overlayColor: '#000000',type: 'v2',state: 'success',size: 'xl'});
        $.post("/gateway/stripe/pay", {})
        .done(function( data ) {
            KTApp.unblockPage();
            $("#stripeModal").modal('show');
            var clientSecret = data.client_secret;
            var stripe = Stripe(data.publishable_key);
            var elements = stripe.elements();
            var style = {base: {color: "#32325d"}};
            
            var card = elements.create("card", { style: style });
            card.mount("#card-element");

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(ev) {
              ev.preventDefault();
              stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                  card: card,
                  //billing_details: {
                    //name: 'Jenny Rosen'
                  //}
                }
              }).then(function(result) {
                console.log(result);
                if (result.error) {
                    // Show error to your customer (e.g., insufficient funds)
                    Swal.fire("Erreur", result.error.message, "error")
                } else {
                    // The payment has been processed!
                    if (result.paymentIntent.status === 'succeeded') {
                        Swal.fire("Merci", "Votre paiement est bien effectué. Votre commande sera activée bientôt.", "success")
                            .then(function(swalResult) {
                                if (data.redirect) {
                                    window.location.href=data.redirect;
                                }
                            });
                    }else{
                        Swal.fire("Erreur", "Une erreur s'est produite.", "error")
                    }
                }
              });
            });
        })
        .fail(function() {
            KTApp.unblockPage();
            Swal.fire("Erreur", "Une erreur s'est produite.", "error")
        });
    });
});
</script>
@endsection
