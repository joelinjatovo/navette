@extends('layouts.customer')

@section('style')
@endsection

@section('content')
<div class="card card-custom gutter-b">
	<div class="card-header">
		<h3 class="card-title">
			Select2 Examples
		</h3>
	</div>
	<!--begin::Form-->
	<form class="form" method="post">
        @csrf
		<div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" name="order[type]" value="go" checked="checked">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Allez Simple
                                    </span>
                                </span>
                                <span class="option-body">
                                    30 days free trial and lifetime free updates
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-4">
                        <label class="option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" name="order[type]" value="back">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Retours Simple
                                    </span>
                                </span>
                                <span class="option-body">
                                    30 days free trial and lifetime free updates
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-lg-4">
                        <label class="option option option-plain">
                            <span class="option-control">
                                <span class="radio">
                                    <input type="radio" name="order[type]" value="go-back">
                                    <span></span>
                                </span>
                            </span>
                            <span class="option-label">
                                <span class="option-head">
                                    <span class="option-title">
                                        Allez et Retours
                                    </span>
                                </span>
                                <span class="option-body">
                                    24/7 support and Lifetime access
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Point d'origine</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
								<button class="btn btn-success" type="button" data-toggle="modal" data-target="#mapModal1"><i class="la la-group icon-lg"></i></button>
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
                        <label>Date</label>
                        <input type="text" class="form-control" id="kt_datepicker_1" readonly="" placeholder="Select date">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Time</label>
                        <input class="form-control" id="kt_timepicker_1" readonly="" placeholder="Select time" type="text">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Select club</label>
                        <input type="hidden" name="order[place]" id="order_place" value="1">
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
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Point de retours</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
								<button class="btn btn-success" type="button" data-toggle="modal" data-target="#mapModal2"><i class="la la-group icon-lg"></i></button>
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
                        <label>Date</label>
                        <input type="text" class="form-control" id="kt_datepicker_2" readonly="" placeholder="Select date">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Time</label>
                        <input class="form-control" id="kt_timepicker_2" readonly="" placeholder="Select time" type="text">
                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Forms Widget 1-->
                    <div class="card card-custom card-shadowless card-stretch gutter-b card-spacer">
                        <!--begin::Nav Tabs-->
                        <ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0" role="tablist">
                            <!--begin::Item-->
                            <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                                <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#tab_forms_widget_1">
                                    <span class="nav-icon py-2 w-auto">
                                        <span class="svg-icon svg-icon-3x"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Home/Library.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"></path>
                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="nav-text font-size-lg py-2 font-weight-bold text-center">
                                        SAAS Application
                                    </span>
                                </a>
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-0 mb-3 mb-lg-0">
                                <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#tab_forms_widget_5">
                                    <span class="nav-icon py-2 w-auto">
                                        <span class="svg-icon svg-icon-3x"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Communication/Group.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">
                                        Customer Support
                                    </span>
                                </a>
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Nav Tabs-->

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
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Résérver</button>
        </div>
    </form>
</div>

<div class="modal fade" id="mapModal1" tabindex="-1" role="dialog" aria-labelledby="mapModal1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Point d'origine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_0" style="width:100%; height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <div id="order_items_0_detail"></div>
                <button type="button" id="order_items_0_button_confirm"  class="btn btn-primary font-weight-bold" data-dismiss="modal" aria-label="Close">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mapModal2" tabindex="-1" role="dialog" aria-labelledby="mapModal2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Point de retours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="map_1" style="width:100%; height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <div id="order_items_1_detail"></div>
                <button type="button" id="order_items_1_button_confirm" class="btn btn-primary font-weight-bold" data-dismiss="modal" aria-label="Close">Confirmer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
var clubs = @json($clubs);
var club = {lat: {{ $clubs[0]->point->lat }}, lng: {{ $clubs[0]->point->lng }}};
var zoom = {{env('MAP_ZOOM', 15)}};
var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.00) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.00) }}};
var go = null;
var back = null;
function initMap() {
    go = new AutocompleteDirectionsHandler("map_0", 'order_items_0_', club);
    back = new AutocompleteDirectionsHandler("map_1", 'order_items_1_', club);
}

/**
 * @constructor
 */
function AutocompleteDirectionsHandler(mapDiv, id, clubPoint) {
  this.map = new google.maps.Map(document.getElementById(mapDiv), {mapTypeControl: false, center: uluru, zoom: zoom});
  this.id = id;
  this.club = clubPoint;
  this.latLng = null;
  this.placeId = null;
  this.response = null;
  this.marker = new google.maps.Marker({draggable: true, position: uluru, map: this.map});;
  this.autocomplete = new google.maps.places.Autocomplete(document.getElementById(this.id + "point_name"));
  this.geocoder = new google.maps.Geocoder;
  this.directionsService = new google.maps.DirectionsService;
  this.setupPlaceChangedListener();
  this.setupMapClickListener();
}

AutocompleteDirectionsHandler.prototype.setClub = function(club) {
    this.club = club;
    this.route();
}

AutocompleteDirectionsHandler.prototype.setupMapClickListener = function(){
  var me = this;
  me.map.addListener('click', function(e) {
    me.latLng = e.latLng;
    me.placeId = null;
    me.route();
    me.addMarker(e.latLng);
  });
};

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function() {
  var me = this;
  me.autocomplete.bindTo('bounds', me.map);
  me.autocomplete.addListener('place_changed', function() {
    var place = this.autocomplete.getPlace();
    console.log(place);
    if (!place.place_id) {
      window.alert('Please select an option from the dropdown list.');
      return;
    }
    me.latLng = null;
    me.placeId = place.place_id;
    me.route();
  });
};
  
AutocompleteDirectionsHandler.prototype.addMarker = function(latLng) {
    var me = this;
    me.marker.setMap(null);
    me.marker = new google.maps.Marker({draggable: true, position: latLng, map: me.map});
    me.map.panTo(latLng);
};
    
AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.club || (!this.placeId && !this.latLng)) {
        return;
    }
    var me = this;

    me.directionsService.route({
        origin: me.club,
        destination: !me.placeId ? me.latLng : {'placeId': me.placeId},
        travelMode: 'DRIVING'
    },function(response, status) {
        console.log(response);
        if (status === 'OK') {
            me.setResponse(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
};

AutocompleteDirectionsHandler.prototype.setResponse = function(response) {
    this.response = response;
    document.getElementById(this.id + 'detail').innerHTML = response.routes[0].legs[0].end_address;
};
    
jQuery(document).ready(function($){
    $("#kt_select2").select2({placeholder:"Select a state"});
    var t;t=KTUtil.isRTL()?{leftArrow:'<i class="la la-angle-right"></i>',rightArrow:'<i class="la la-angle-left"></i>'}:{leftArrow:'<i class="la la-angle-left"></i>',rightArrow:'<i class="la la-angle-right"></i>'};
    $("#kt_datepicker_1").datepicker({rtl:KTUtil.isRTL(),todayHighlight:!0,orientation:"bottom left",templates:t});
    $("#kt_datepicker_2").datepicker({rtl:KTUtil.isRTL(),todayHighlight:!0,orientation:"bottom left",templates:t});
    $("#kt_timepicker_1").timepicker({minuteStep:1,showSeconds:!0,showMeridian:!0});
    $("#kt_timepicker_2").timepicker({minuteStep:1,showSeconds:!0,showMeridian:!0});
    
    $('#order_items_0_button_confirm').click(function(){
        if(go.response){
            var response = go.response;
            document.getElementById('order_items_0_item_direction').value = response.routes[0].overview_polyline;
            var leg = response.routes[0].legs[0];
            document.getElementById('order_items_0_item_distance').value = leg.distance.text;
            document.getElementById('order_items_0_item_distance_value').value = leg.distance.value;
            document.getElementById('order_items_0_item_duration').value = leg.duration.text;
            document.getElementById('order_items_0_item_duration_value').value = leg.duration.value;
            document.getElementById('order_items_0_point_name').value = leg.end_address;
            document.getElementById('order_items_0_point_lat').value = leg.end_location.lat();
            document.getElementById('order_items_0_point_lng').value = leg.end_location.lng();
        }
    });
    
    $('#order_items_1_button_confirm').click(function(){
        if(back.response){
            var response = back.response;
            document.getElementById('order_items_1_item_direction').value = response.routes[0].overview_polyline;
            var leg = response.routes[0].legs[0];
            document.getElementById('order_items_1_item_distance').value = leg.distance.text;
            document.getElementById('order_items_1_item_distance_value').value = leg.distance.value;
            document.getElementById('order_items_1_item_duration').value = leg.duration.text;
            document.getElementById('order_items_1_item_duration_value').value = leg.duration.value;
            document.getElementById('order_items_1_point_name').value = leg.end_address;
            document.getElementById('order_items_1_point_lat').value = leg.end_location.lat();
            document.getElementById('order_items_1_point_lng').value = leg.end_location.lng();
        }
    });
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection
