@extends('layouts.admin')

@section('title'){{ __('messages.form.ridepoint.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.ridepoint.view') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::User Name-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
				<span class="font-weight-boldest text-danger mr-4">{{ $model->duration }}</span>
				<div class="font-weight-boldest text-warning mr-4">{{ $model->distance }}</div>
				<x-status theme="light" :status="$model->status" />
            </div>
            <!--end::User Name-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.ridepoints') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
			
			@if($model->cancelable())
			<!--begin::Button-->
			<a href="#" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ridepoint-action" 
			   data-action="cancel" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.cancel.ridepoint') }}"
			   title="{{ __('messages.cancel.ridepoint') }}"><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->arrivable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ridepoint-action" 
			   data-action="arrive" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.arrive.ridepoint') }}"
			   title="{{ __('messages.arrive.ridepoint') }}"><i class="la la-play-circle-o"></i> {{ __('messages.button.arrive') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->pickable() || $model->dropable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ridepoint-action" 
			   data-action="pick-or-drop" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.pick-or-drop.ridepoint') }}"
			   title="{{ __('messages.pick-or-drop.ridepoint') }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
			<!--end::Button-->
			@endif
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12 col-xxl-12">
		<!--begin::List Widget 9-->
		<div class="card card-custom gutter-b p-2">
			<!--begin::Body-->
			<div class="card-body align-items-center border-0 m-0">
				<!--begin::Timeline-->
				<div class="timeline timeline-2">
					<div class="timeline-bar"></div>
					@if($model->point)
					<!--begin::Item-->
					<div class="timeline-item">
						<div class="timeline-badge bg-danger"></div>
						<div class="timeline-content text-dark-50">
							{{ $model->point->name }}
						</div>
					</div>
					<!--end::Item-->
					@endif
				</div>
				<!--end::Timeline-->
			</div>
			<!--end::Body-->
			<div id="map" style="width:100%; height: 400px;"></div>
		</div>
		<!--end: Card-->
		<!--end: List Widget 9-->
	</div>
</div>
@endsection

@section('javascript')
<script>
var zoom = {{env('MAP_ZOOM', 15)}};
var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.00) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.00) }}};
var map;
var marker;
var poly;
var geodesicPoly;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {mapTypeControl: false, center: uluru, zoom: zoom});
    marker = new google.maps.Marker({draggable: true, position: uluru, map: map});
    poly = new google.maps.Polyline({
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 3,
        map: map,
    });
	
	var path = google.maps.geometry.encoding.decodePath('{{ $model->ride->direction }}');
	poly.setPath(path);

    geodesicPoly = new google.maps.Polyline({
        strokeColor: '#CC0099',
        strokeOpacity: 1.0,
        strokeWeight: 3,
        geodesic: true,
        map: map
    });
	
	var geodesicPath = google.maps.geometry.encoding.decodePath('{{ $model->direction }}');
	geodesicPoly.setPath(geodesicPath);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=geometry&callback=initMap" async defer></script>
@endsection
