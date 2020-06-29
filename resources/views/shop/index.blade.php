@extends('layouts.customer')

@section('title')
Résérvation
@endsection

@section('content')
<div class="card card-custom gutter-b">
	<div class="card-header">
		<h3 class="card-title">
			Votre commande
		</h3>
	</div>
	<!--begin::Form-->
	<form class="form" method="post">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <select id="list-club" class="d-none">
                            @foreach($clubs as $club)
                              <option value="{{ $club->getKey() }}" @if($club->getKey() == old('order.club'))selected="selected"@endif >{{ $club->name }}</option>
                            @endforeach
                        </select>
                        <select id="type-parcours" class="d-none">
                              <option value="go">go</option>
                              <option value="back">back</option>
                              <option value="go-back">go-back</option>
                        </select>
                    <div class="pac-card" id="pac-card">
                      <div>
                        <div id="title">&nbsp;</div>
                      </div>
                      <div id="pac-container">
                        <input id="pac-input-2" type="text" placeholder="Enter your club">

                        <input id="input-info-go" type="hidden" value=''>
                        <input id="input-info-back" type="hidden" value=''>
                      </div>
                    </div>
                    <div id="map"></div>
                    <div id="infowindow-content">
                      <img src="" width="16" height="16" id="place-icon">
                      <span id="place-name"  class="title"></span><br>
                      <span id="place-address"></span>
                      <span id="coords" style="display: block;"></span>
                    </div>
                    <div id="infowindow-content-1">
                      <img src="" width="16" height="16" id="place-icon-1">
                      <span id="place-name-1"  class="title"></span><br>
                      <span id="place-address-1"></span>
                      <span id="coords-1" style="display: block;"></span>
                    </div>
                    <div id="infowindow-content-2">
                      <img src="" width="16" height="16" id="place-icon-2">
                      <span id="place-name-2"  class="title"></span><br>
                      <span id="place-address-2"></span>
                      <span id="coords-2" style="display: block;"></span>
                    </div> 
                </div>
		    </div>
            <div class="form-group pt-5">
                <div class="row border shadow pt-5">
                    <div class="col-lg-4 mt-3">
                        <label class="option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" class="order-type" name="order[type]" value="go" checked="checked">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Allez Simple
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <label class="option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" class="order-type" name="order[type]" value="back">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Retours Simple
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <label class="option option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" class="order-type" name="order[type]" value="go-back">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Allez et Retours
                                    </span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row" id="display-origine">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Point d'origine</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-success" type="button">
                                <i class="fas fa-map-marked-alt"></i>
                                </button>
							</div>
                            <input type="text" name="order[items][0][point][name]" id="order_items_0_point_name" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
                            <input type="hidden" name="order[items][0][point][lat]" id="order_items_0_point_lat" >
                            <input type="hidden" name="order[items][0][point][lng]" id="order_items_0_point_lng">
                            <input type="hidden" name="order[items][0][point][alt]" id="order_items_0_point_alt">
                            <input type="hidden" name="order[items][0][item][type]" id="order_items_0_item_type" value="go">
                            <input type="hidden" name="order[items][0][item][distance]" id="order_items_0_item_distance">
                            <input type="hidden" name="order[items][0][item][distance_value]" id="order_items_0_item_distance_value">
                            <input type="hidden" name="order[items][0][item][duration]" id="order_items_0_item_duration">
                            <input type="hidden" name="order[items][0][item][duration_value]" id="order_items_0_item_duration_value">
                            <input type="hidden" name="order[items][0][item][direction]" id="order_items_0_item_direction">
                        </div>
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Date et heure</label>
                        <input type="text" class="form-control" name="order[items][0][item][ride_at]" id="kt_datepicker_1" readonly="" placeholder="Select date">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
            </div>
            <div class="row"  style="display:none;"  id="display-back">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Point de retours</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-success" type="button">
                                <i class="fas fa-map-marked-alt"></i>
                                </button>
							</div>
                            <input type="text" name="order[items][1][point][name]" id="order_items_1_point_name" class="form-control" placeholder="Point de retours" aria-describedby="basic-addon2">
                            <input type="hidden" name="order[items][1][point][lat]" id="order_items_1_point_lat" >
                            <input type="hidden" name="order[items][1][point][lng]" id="order_items_1_point_lng">
                            <input type="hidden" name="order[items][1][point][alt]" id="order_items_1_point_alt">
                            <input type="hidden" name="order[items][1][item][type]" id="order_items_1_item_type" value="back">
                            <input type="hidden" name="order[items][1][item][distance]" id="order_items_1_item_distance">
                            <input type="hidden" name="order[items][1][item][distance_value]" id="order_items_1_item_distance_value">
                            <input type="hidden" name="order[items][1][item][duration]" id="order_items_1_item_duration">
                            <input type="hidden" name="order[items][1][item][duration_value]" id="order_items_1_item_duration_value">
                            <input type="hidden" name="order[items][1][item][direction]" id="order_items_1_item_direction">
                        </div>
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Date et heure</label>
                        <input type="text" class="form-control"  name="order[items][1][item][ride_at]" id="kt_datepicker_2" readonly="" placeholder="Select date">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Club (destination)</label>
                        <input type="hidden" name="order[car]" id="order_car" value="1">
                        <select class="form-control select2" id="kt_select2" name="order[club]">
                            @foreach($clubs as $club)
                              <option value="{{ $club->getKey() }}" @if($club->getKey() == old('order.club'))selected="selected"@endif >{{ $club->name }}</option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Forms Widget 1-->
                    <div class="card card-custom card-shadowless card-stretch gutter-b card-spacer" id="display-cars">

                        <!--begin::Nav Content-->
                        <div class="tab-content m-0 p-0">
                            <div class="tab-pane active" id="forms_widget_tab_1" role="tabpanel">

                            </div>
                            <div class="tab-pane" id="forms_widget_tab_2" role="tabpanel">

                            </div>
                            <div class="tab-pane" id="forms_widget_tab_3" role="tabpanel">

                            </div>
                            <div class="tab-pane" id="forms_widget_tab_4" role="tabpanel">

                            </div>
                            <div class="tab-pane" id="forms_widget_tab_6" role="tabpanel">

                            </div>
                        </div>
                        <!--end::Nav Content-->
                    </div>
                    <!--end::Forms Widget 1-->
                </div>
            </div>
            <div class="row" id="display-placenumber" style="display: none;">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nombre de place <small>(max : <span id="max-place">0</span>)</small></label>             
                        <input type="number" id="order_place_number" class="form-control" name="order[place]" min="1" max="1">
                        
                    </div>
                </div>
            </div>
            <div class="row" id="display-privatecar" style="display: none;">
                <div class="col-md-4">
                    <label class="option option option-plain">
                            <span class="option-control">
                                <span class="checkbox mb-4">
                                    <input type="checkbox" id="order-private-car" name="order[privatized]">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title font-weight-normal">
                                        Voulez-vous privatiser le véhicule ?
                                    </span>
                                </span>
                            </span>
                        </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Résérver</button>
        </div>
    </form>
</div>

@endsection

@section('javascript')
<script>
var clubs = @json($clubs);
var club = {lat: {{ $clubs[0]->point->lat }}, lng: {{ $clubs[0]->point->lng }}};
var zoom = {{env('MAP_ZOOM', 15)}};
var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.9065462) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.5269284) }}};
var go = null;
var back = null;

jQuery(document).ready(function($){
    $("#kt_select2").select2({placeholder:"Select a state"});
    var t;t=KTUtil.isRTL()?{leftArrow:'<i class="la la-angle-right"></i>',rightArrow:'<i class="la la-angle-left"></i>'}:{leftArrow:'<i class="la la-angle-left"></i>',rightArrow:'<i class="la la-angle-right"></i>'};

});
</script>
<script>
    var hotlist=["2020-06-09", "2020-06-10"];
    $('#kt_datepicker_1').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY  HH:mm', shortTime : true, lang : 'fr', cancelText : 'ANNULER', minDate : new Date(), disabledDates:hotlist});
    $('#kt_datepicker_2').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY  HH:mm', shortTime : true, lang : 'fr', cancelText : 'ANNULER' });
    
    //choose parcours
    $(document).on('change', '.order-type', function(){
        var type = $(this).val();
        if(type == 'go'){
            $('#display-back').hide();
            $('#display-origine').show();
        }
        if(type == 'back'){
            $('#display-back').show();
            $('#display-origine').hide();
        }
        if(type == 'go-back'){
            $('#display-back').show();
            $('#display-origine').show();   
        }
        document.getElementById('type-parcours').value = $(this).val();
        document.getElementById('type-parcours').dispatchEvent(new Event('change'));
    });

    //select club and cars
    $(document).on('change', '#kt_select2', function(){

        document.getElementById('list-club').value = $(this).val();
        document.getElementById('list-club').dispatchEvent(new Event('change'));
        $('#display-placenumber').hide();
        $('#display-privatecar').hide();

        $('#display-cars').html('<img src="/img/loader.gif" style="width: 200px;margin: auto;">');
         $.ajax({
              data: { 
                        _id : $(this).val(), 
                        _token : $('meta[name="csrf-token"]').attr('content') 
                    },
              url: "{{ route('shop.order.cars') }}",
              type: "POST",
              success: function (data) {
                $('#display-cars').html(data);
              },
              error: function (data) {
                //console.log('Error:', data);
              }
          });
    });
    $(document).on('click' , '#custom-list-cars li:not(.invalid)', function(){
        
        document.getElementById('order_car').value = $(this).attr('data-id');

        $('#display-placenumber').show();
        $('#display-privatecar').show();

        $('#order_place_number').val(1);
        $('#order_place_number').attr("max", $(this).attr('data-place'));
        $('#max-place').text($(this).attr('data-place'));
    });

    $(document).on('change' , '#order-private-car', function(){
        if($(this).is(':checked')){
            $('#display-placenumber').hide();
        }else{
            $('#display-placenumber').show();
        }
    });

    window.addEventListener('load', function () {
      $('#kt_select2').trigger('change');
    });
</script>
 <script>

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -18.9065462, lng: 47.5269284},
          zoom: 15
        });

        var directionsDisplay_go = new google.maps.DirectionsRenderer({map: map,suppressMarkers: true,polylineOptions: {strokeColor: 'green'}});
        var directionsService_go = new google.maps.DirectionsService();
        var directionsDisplay_back = new google.maps.DirectionsRenderer({map: map,suppressMarkers: true,polylineOptions: {strokeColor: 'blue'}});
        var directionsService_back = new google.maps.DirectionsService();

        var geocoder_1 = new google.maps.Geocoder;
        var geocoder_2 = new google.maps.Geocoder;
        
        var icons = {
          go: { icon: '/img/go.png'},
          back: { icon: '/img/back.png' },
          club: { icon: '/img/club.png'}
        };
        var marker_1 = new google.maps.Marker({
          map: map,
          draggable: true,
          animation: google.maps.Animation.DROP,
          icon: icons.go.icon,
          position: {lat: -18.9065462, lng: 47.5269284}
        });

        marker_1.setVisible(false);
        marker_1.addListener('click', toggleBounce);
        var marker_2 = new google.maps.Marker({
          map: map,
          animation: google.maps.Animation.DROP,
          icon: icons.club.icon,
          position: {lat: -18.9065462, lng: 47.5269284}
        });
        marker_2.setVisible(false);
        marker_2.addListener('click', toggleBounce);
        var marker_3 = new google.maps.Marker({
          map: map,
          draggable: true,
          animation: google.maps.Animation.DROP,
          icon: icons.back.icon,
          position: {lat: club.lat, lng: club.lng}
        });

        marker_3.setVisible(false);
        marker_3.addListener('click', toggleBounce);

        var card = document.getElementById('pac-card');
        var input1 = document.getElementById('order_items_0_point_name');
        var input2 = document.getElementById('pac-input-2');
        var input3 = document.getElementById('order_items_1_point_name');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var infowindow_1 = {
          item : new google.maps.InfoWindow({ pixelOffset: new google.maps.Size(0, -20) }),
          content : document.getElementById('infowindow-content') 
        }
        var infowindow_2 = {
          item : new google.maps.InfoWindow({ pixelOffset: new google.maps.Size(0, -20) }),
          content : document.getElementById('infowindow-content-1') 
        }

        var infowindow_3 = {
          item : new google.maps.InfoWindow({ pixelOffset: new google.maps.Size(0, -20) }),
          content : document.getElementById('infowindow-content-2') 
        }
        
        var routes = [{

          start :  { marker : marker_1, infowindow : infowindow_1 },
          end : { marker : marker_2, infowindow : infowindow_2 },
          service : directionsService_go,
          display : directionsDisplay_go,
          type : 0,

        },{

          start :  { marker : marker_2, infowindow : infowindow_2 },
          end : { marker : marker_3, infowindow : infowindow_3 },
          service : directionsService_back,
          display : directionsDisplay_back,
          type : 1,

        }];

        //autocomplete
        var autocomplete_1 = new google.maps.places.Autocomplete(input1);
        set_autocomplete_input(map, autocomplete_1, infowindow_1, marker_1, routes, 0);


        var autocomplete_2 = new google.maps.places.Autocomplete(input2);
        set_autocomplete_input(map, autocomplete_2, infowindow_2, marker_2, routes, 1);

        var autocomplete_3 = new google.maps.places.Autocomplete(input3);
        set_autocomplete_input(map, autocomplete_3, infowindow_3, marker_3, routes, -1);

        //geolocation
        set_geolocation(map, marker_1, marker_2, marker_3, infowindow_1, infowindow_2, infowindow_3, geocoder_1, directionsService_go, directionsDisplay_go);

        google.maps.event.addListener(marker_1, 'dragend', function(e){
            
            infowindow_1.item.setPosition({ lat :e.latLng.lat(), lng : e.latLng.lng() });
            geocoder_1.geocode({'location': { lat :e.latLng.lat(), lng : e.latLng.lng()}}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_0_point_name").value = current_pos.formatted_address;
                infowindow_1.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
            infowindow_1.item.setContent(infowindow_1.content);
            infowindow_1.item.open(map);
            var my_pos = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
            Route(my_pos, club_pos, directionsService_go, directionsDisplay_go, 0 );

        });
        google.maps.event.addListener(marker_3, 'dragend', function(e){
            
            infowindow_3.item.setPosition({ lat :e.latLng.lat(), lng : e.latLng.lng() });
            geocoder_2.geocode({'location': { lat :e.latLng.lat(), lng : e.latLng.lng()}}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_1_point_name").value = current_pos.formatted_address;
                infowindow_3.content.children[1].textContent = "votre point de retour";
                infowindow_3.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
            infowindow_3.item.setContent(infowindow_3.content);
            infowindow_3.item.open(map);

            var my_pos = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
            Route(club_pos, my_pos, directionsService_back, directionsDisplay_back, 1 );
        });

        document.getElementById("list-club").addEventListener('change', function () {
          //init map
          directionsDisplay_go.setMap(null);
          directionsDisplay_back.setMap(null);
          marker_1.setVisible(false);
          marker_2.setVisible(false);
          marker_3.setVisible(false);

          //check type parcours
          var type_parcours = $('input.order-type:checked').val();
          var clb = clubs[document.getElementById("list-club").value - 1];
          var clublatlng = new google.maps.LatLng( parseFloat(clb.point.lat),parseFloat(clb.point.lng));
          marker_2.setPosition(clublatlng);
          infowindow_2.item.setPosition({ lat :parseFloat(clb.point.lat), lng : parseFloat(clb.point.lng) });
          infowindow_2.content.children[1].textContent = "club";
          infowindow_2.content.children[3].textContent = clb.name;
          infowindow_2.item.open(map);

          infowindow_1.item.setPosition({ lat : marker_1.getPosition().lat(), lng : marker_1.getPosition().lng() });
            geocoder_1.geocode({'location': { lat : marker_1.getPosition().lat(), lng : marker_1.getPosition().lng() }}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_0_point_name").value = current_pos.formatted_address;
                infowindow_1.content.children[1].textContent = "votre position";
                infowindow_1.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
          infowindow_3.item.setPosition({ lat : marker_3.getPosition().lat(), lng : marker_3.getPosition().lng() });
            geocoder_2.geocode({'location': { lat : marker_3.getPosition().lat(), lng : marker_3.getPosition().lng() }}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_1_point_name").value = current_pos.formatted_address;
                infowindow_3.content.children[1].textContent = "votre point de retour";
                infowindow_3.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
            infowindow_3.item.setContent(infowindow_3.content);
            infowindow_1.item.setContent(infowindow_1.content);
            infowindow_3.item.open(null);
            infowindow_1.item.open(null);

          
          if(type_parcours == 'go'){

            directionsDisplay_go.setMap(map);
            infowindow_1.item.open(map);
            marker_1.setVisible(true);
            marker_2.setVisible(true);
            var go_pos = new google.maps.LatLng(marker_1.getPosition().lat(), marker_1.getPosition().lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
            Route(go_pos, club_pos, directionsService_go, directionsDisplay_go, 0 );
          }
          if(type_parcours == 'back'){

            directionsDisplay_back.setMap(map);
            marker_3.setVisible(true);
            marker_2.setVisible(true);
            infowindow_3.item.open(map);
            var back_pos = new google.maps.LatLng(marker_3.getPosition().lat(), marker_3.getPosition().lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng()); 
            Route(club_pos, back_pos, directionsService_back, directionsDisplay_back, 1 );
          }
          if(type_parcours == 'go-back'){
            directionsDisplay_go.setMap(map);
            directionsDisplay_back.setMap(map);
            marker_3.setVisible(true);
            marker_2.setVisible(true);
            marker_1.setVisible(true);
            infowindow_3.item.open(map);
            var go_pos = new google.maps.LatLng(marker_1.getPosition().lat(), marker_1.getPosition().lng());
          var back_pos = new google.maps.LatLng(marker_3.getPosition().lat(), marker_3.getPosition().lng());
          var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
          Route(go_pos, club_pos, directionsService_go, directionsDisplay_go, 0 );
          Route(club_pos, back_pos, directionsService_back, directionsDisplay_back, 1 );
          }
          
        });

        document.getElementById("type-parcours").addEventListener('change', function () {
          //init map
          directionsDisplay_go.setMap(null);
          directionsDisplay_back.setMap(null);
          marker_1.setVisible(false);
          marker_2.setVisible(false);
          marker_3.setVisible(false);
          //check type parcours
          var type_parcours = document.getElementById("type-parcours").value;
          var clb = clubs[document.getElementById("list-club").value - 1];
          var clublatlng = new google.maps.LatLng( parseFloat(clb.point.lat),parseFloat(clb.point.lng));
          marker_2.setPosition(clublatlng);
          infowindow_2.item.setPosition({ lat :parseFloat(clb.point.lat), lng : parseFloat(clb.point.lng) });
          infowindow_2.content.children[1].textContent = "club";
          infowindow_2.content.children[3].textContent = clb.name;
          infowindow_2.item.open(map);

          infowindow_1.item.setPosition({ lat : marker_1.getPosition().lat(), lng : marker_1.getPosition().lng() });
            geocoder_1.geocode({'location': { lat : marker_1.getPosition().lat(), lng : marker_1.getPosition().lng() }}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_0_point_name").value = current_pos.formatted_address;
                infowindow_1.content.children[1].textContent = "votre position";
                infowindow_1.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
          infowindow_3.item.setPosition({ lat : marker_3.getPosition().lat(), lng : marker_3.getPosition().lng() });
            geocoder_2.geocode({'location': { lat : marker_3.getPosition().lat(), lng : marker_3.getPosition().lng() }}, function(results, status) {
              if (status === 'OK') {
                var current_pos = results[0];
                document.getElementById("order_items_1_point_name").value = current_pos.formatted_address;
                infowindow_3.content.children[1].textContent = "votre point de retour";
                infowindow_3.content.children[3].textContent = current_pos.formatted_address;
              } 
            });
            infowindow_3.item.setContent(infowindow_3.content);
            infowindow_1.item.setContent(infowindow_1.content);
            infowindow_3.item.open(null);
            infowindow_1.item.open(null);

          if(type_parcours == 'go'){

            directionsDisplay_go.setMap(map);
            marker_1.setVisible(true);
            marker_2.setVisible(true);
            infowindow_1.item.open(map);
            var go_pos = new google.maps.LatLng(marker_1.getPosition().lat(), marker_1.getPosition().lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
            Route(go_pos, club_pos, directionsService_go, directionsDisplay_go, 0 );
          }
          if(type_parcours == 'back'){

            directionsDisplay_back.setMap(map);
            marker_3.setVisible(true);
            marker_2.setVisible(true);
            infowindow_3.item.open(map);
            var back_pos = new google.maps.LatLng(marker_3.getPosition().lat(), marker_3.getPosition().lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng()); 
            Route(club_pos, back_pos, directionsService_back, directionsDisplay_back, 1 );
          }
          if(type_parcours == 'go-back'){
            directionsDisplay_go.setMap(map);
            directionsDisplay_back.setMap(map);
            marker_3.setVisible(true);
            marker_2.setVisible(true);
            marker_1.setVisible(true);
            infowindow_3.item.open(map);
            infowindow_1.item.open(map);
            var go_pos = new google.maps.LatLng(marker_1.getPosition().lat(), marker_1.getPosition().lng());
            var back_pos = new google.maps.LatLng(marker_3.getPosition().lat(), marker_3.getPosition().lng());
            var club_pos = new google.maps.LatLng(marker_2.getPosition().lat(), marker_2.getPosition().lng());
            Route(go_pos, club_pos, directionsService_go, directionsDisplay_go, 0 );
            Route(club_pos, back_pos, directionsService_back, directionsDisplay_back, 1 );
          }
          
        });
            
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

      function toggleBounce(marker) {

        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }

      }

      function Route(start, end, directionsService, directionsDisplay, type ) {

        var request = {
          origin: start,
          destination: end,
          optimizeWaypoints : true,
          travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(result, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
            if(type == 0){
                 
                document.getElementById("order_items_0_point_name").value = result.routes[0]["legs"][0].start_address;
                document.getElementById("order_items_0_point_lat").value = result.routes[0]["legs"][0].start_location.lat();
                document.getElementById("order_items_0_point_lng").value = result.routes[0]["legs"][0].start_location.lng();
                document.getElementById("order_items_0_point_alt").value = 0;
                document.getElementById("order_items_0_item_distance").value = result.routes[0]["legs"][0].distance.text;
                document.getElementById("order_items_0_item_distance_value").value = result.routes[0]["legs"][0].distance.value;
                document.getElementById("order_items_0_item_duration").value = result.routes[0]["legs"][0].duration.text;
                document.getElementById("order_items_0_item_duration_value").value = result.routes[0]["legs"][0].duration.value;
                document.getElementById("order_items_0_item_direction").value = result.routes[0].overview_polyline;
            }
            if(type == 1){
                document.getElementById("order_items_1_point_name").value = result.routes[0]["legs"][0].start_address;
                document.getElementById("order_items_1_point_lat").value = result.routes[0]["legs"][0].start_location.lat();
                document.getElementById("order_items_1_point_lng").value = result.routes[0]["legs"][0].start_location.lng();
                document.getElementById("order_items_1_point_alt").value = 0;
                document.getElementById("order_items_1_item_distance").value = result.routes[0]["legs"][0].distance.text;
                document.getElementById("order_items_1_item_distance_value").value = result.routes[0]["legs"][0].distance.value;
                document.getElementById("order_items_1_item_duration").value = result.routes[0]["legs"][0].duration.text;
                document.getElementById("order_items_1_item_duration_value").value = result.routes[0]["legs"][0].duration.value;
                document.getElementById("order_items_1_item_direction").value = result.routes[0].overview_polyline;
            }
          } else {
            alert("couldn't get directions:" + status);
          }
        });

      }

      function set_autocomplete_input(map, autocomplete, infowindow, marker, routes, type ) {

        autocomplete.bindTo('bounds', map);
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        infowindow.item.setContent(infowindow.content);
        
        autocomplete.addListener('place_changed', function() {
          infowindow.item.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(15);
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindow.content.children[0].src = place.icon;
          infowindow.content.children[1].textContent = place.name;
          infowindow.content.children[3].textContent = address;//2-br


          infowindow.item.open(map, marker);
          autocomplete.setTypes([]);
          autocomplete.setOptions({strictBounds: true});

            

          
          if(type == 0){

            routes[0].end.marker.setVisible(true);
            var go_pos = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
            var club_pos = new google.maps.LatLng(routes[0].end.marker.getPosition().lat(), routes[0].end.marker.getPosition().lng());
            Route(go_pos, club_pos, routes[0].service, routes[0].display, 0 );

          }
          if(type == -1){
            var back_pos = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
            var club_pos = new google.maps.LatLng(routes[0].start.marker.getPosition().lat(), routes[0].start.marker.getPosition().lng());
            Route(club_pos, back_pos, routes[1].service, routes[1].display, 1 );
          }


        });

      }
      function set_geolocation(map, marker, club_marker, back_marker, infowindow, club_infowindow, back_infowindow, geocoder, service, display){

          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              marker.setVisible(true);
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              var marker_pos = new google.maps.LatLng(pos.lat,pos.lng);
              marker.setPosition(marker_pos);
              back_marker.setPosition(marker_pos);
              infowindow.item.setPosition(pos);
              back_infowindow.item.setPosition(pos);
              geocoder.geocode({'location': pos}, function(results, status) {
                if (status === 'OK') {
                  var current_pos = results[0];
                  document.getElementById("order_items_0_point_name").value = current_pos.formatted_address;
                  infowindow.content.children[1].textContent = "votre position";
                  infowindow.content.children[3].textContent = current_pos.formatted_address;
                  document.getElementById("order_items_1_point_name").value = current_pos.formatted_address;
                  back_infowindow.content.children[1].textContent = "votre point de retour";
                  back_infowindow.content.children[3].textContent = current_pos.formatted_address;
                } 
              });
              infowindow.item.setContent(infowindow.content);
              back_infowindow.item.setContent(back_infowindow.content);
              infowindow.item.open(map, marker);
              map.setCenter(pos);

              club_infowindow.item.setPosition({ lat : club_marker.getPosition().lat(), lng : club_marker.getPosition().lng() });
              var geoclub = new google.maps.Geocoder;
              geoclub.geocode({'location': { lat : club_marker.getPosition().lat(), lng : club_marker.getPosition().lng() }}, function(results, status) {
                if (status === 'OK') {
                  var current_pos = results[0];
                  document.getElementById("pac-input-2").value = current_pos.formatted_address;
                  club_infowindow.content.children[1].textContent = "club";
                  club_infowindow.content.children[3].textContent = current_pos.formatted_address;
                } 
              });

              club_infowindow.item.setContent(club_infowindow.content);
              club_infowindow.item.open(map);

            club_marker.setVisible(true);
            var club_pos = new google.maps.LatLng(club_marker.getPosition().lat(), club_marker.getPosition().lng());
            Route(marker_pos, club_pos, service, display, 0 );

            }, function() {
              handleLocationError(true, infowindow.item, map.getCenter());
            });
          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infowindow.item, map.getCenter());
          }
      
      }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('google.apikey') }}&libraries=places&callback=initMap" async defer></script>
@endsection
