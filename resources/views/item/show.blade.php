@extends('layouts.customer')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <!--begin::Body-->
                <div class="card-body pt-4">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ki ki-bold-more-hor"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Navigation-->
                                <ul class="navi navi-hover py-5">
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-drop"></i></span>
                                            <span class="navi-text">New Group</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-list-3"></i></span>
                                            <span class="navi-text">Contacts</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-rocket-1"></i></span>
                                            <span class="navi-text">Groups</span>
                                            <span class="navi-link-badge">
                                                <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                            <span class="navi-text">Calls</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-gear"></i></span>
                                            <span class="navi-text">Settings</span>
                                        </a>
                                    </li>

                                    <li class="navi-separator my-3"></li>

                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-magnifier-tool"></i></span>
                                            <span class="navi-text">Help</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                            <span class="navi-text">Privacy</span>
                                            <span class="navi-link-badge">
                                                <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Navigation-->
                            </div>
                        </div>
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::User-->
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                            <div class="symbol-label" style="background-image:url('/metronic/themes/metronic/theme/html/demo9/dist/assets/media/users/300_13.jpg')"></div>
                            <i class="symbol-badge bg-success"></i>
                        </div>
                        <div>
                            <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                                James Jones
                            </a>
                            <div class="text-muted">
                                Application Developer
                            </div>
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Chat</a>
                                <a href="#" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">Follow</a>
                            </div>
                        </div>
                    </div>
                    <!--end::User-->

                    <!--begin::Contact-->
                    <div class="pt-8 pb-6">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">Email:</span>
                            <a href="#" class="text-muted text-hover-primary">matt@fifestudios.com</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">Phone:</span>
                            <span class="text-muted">44(76)34254578</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="font-weight-bold mr-2">Location:</span>
                            <span class="text-muted">Melbourne</span>
                        </div>
                    </div>
                    <!--end::Contact-->

                    <!--begin::Contact-->
                    <div class="pb-6">
                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                    </div>
                    <!--end::Contact-->

                    <a href="#" class="btn btn-light-success font-weight-bold py-3 px-6 mb-2 text-center btn-block">
                        Profile Overview
                    </a>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
    </div>
    <div class="col-lg-9">
        <div id="map" style="width:100%; height: 400px;"></div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script>
var zoom = {{env('MAP_ZOOM', 15)}};
var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.00) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.00) }}};
var map;
var marker;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {mapTypeControl: false, center: uluru, zoom: zoom});
    marker = new google.maps.Marker({draggable: true, position: uluru, map: map});
}
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}', 
    authEndpoint: '/broadcasting/auth',
    auth: {headers: {'X-CSRF-Token': "{{ csrf_token() }}"}}
});
/**
* Test driver location tracker from public channels
var channel = pusher.subscribe('my-channel');
channel.bind('user.point.created', function(data) {
    // Set driver location
    console.log(JSON.stringify(data));
    var point = data.point;
    if(marker){
        marker.setMap(null);
    }
    marker = new google.maps.Marker({draggable: true, position: {lat:point.lat, lng:point.lng}, map: map});
});
*/

var itemChannel = pusher.subscribe('private-App.Item.{{ $model->getKey() }}');
itemChannel.bind('item.updated', function(data) {
    // Set driver location
    console.log(JSON.stringify(data));
    loadItem();
});

var rideChannel;
var driverMarker;
function loadItem(){
    KTApp.blockPage();
    jQuery.get(window.location.pathname)
        .done(function( data ) {
            KTApp.unblockPage();
            console.log(data);
            
            if(!rideChannel && data.ride){
                // Track driver location
                rideChannel = pusher.subscribe('private-App.Ride.' + data.ride.id);
                rideChannel.bind('user.point.created', function(res) {
                    console.log(res);
                    var point = res.point;
                    if(driverMarker){
                        driverMarker.setMap(null);
                    }
                    driverMarker = new google.maps.Marker({draggable: true, position: {lat:point.lat, lng:point.lng}, map: map});
                });
            }
        })
        .fail(function() {
            KTApp.unblockPage();
            Swal.fire("Erreur", "Une erreur s'est produite.", "error")
        });
}

jQuery(document).ready(function(){
    loadItem();
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection
