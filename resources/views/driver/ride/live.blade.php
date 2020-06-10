@extends('layouts.map')

@section('title'){{ __('messages.form.ride.live') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.ride.live') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::User Name-->
            <div class="d-flex align-items-center mr-5" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">#{{ $model->getKey() }}</span>
            </div>
            <!--end::User Name-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->
				
			<span class="font-weight-boldest text-danger mr-2">{{ $model->duration }} m</span>
			<div class="font-weight-boldest text-warning mr-2">{{ gmdate('H:i:s', $model->duration) }}</div>
			<x-status theme="light" :status="$model->status" />

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('driver.rides') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
			
			@if($model->isCancelable())
			<!--begin::Button-->
			<a href="#" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" 
			   data-action="cancel" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.cancel.ride') }}"
			   title="{{ __('messages.cancel.ride') }}" ><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->isStartable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action"
			   data-action="start" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.active.ride') }}"
			   title="{{ __('messages.active.ride') }}"><i class="la la-play-circle-o"></i> {{ __('messages.button.active') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->isCompletable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" 
			   data-action="complete" data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.complete.ride') }}"
			   title="{{ __('messages.complete.ride') }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
			<!--end::Button-->
			@endif
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-4">
        <div class="card card-custom card-stretch gutter-b">
			<!--begin::Header-->
			<div class="card-header align-items-center border-0 mt-4">
				<h3 class="card-title align-items-start flex-column">
					<span class="font-weight-bolder text-dark">Tous les points du course  <a href="#" class="text-primary">#{{ $model->getKey() }}</a></span>
					
        			<div class="d-flex align-items-center flex-wrap mt-3">
						<span class=" font-weight-bolder text-black font-size-sm mr-2">{{ $model->created_at->format('Y-m-d') }}</span>
						<span class="font-weight-bolder text-danger font-size-sm mr-2">{{ $model->duration }} m</span>
						<span class="font-weight-bolder text-warning font-size-sm mr-2">{{ gmdate('H:i:s', $model->duration) }}</span>
					</div>
				</h3>
				<div class="card-toolbar">
					<div class="dropdown dropdown-inline">
						<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ki ki-bold-more-ver"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
							<!--begin::Navigation-->
							<ul class="navi navi-hover">
								<li class="navi-header font-weight-bold py-4">
									<span class="font-size-lg">{{ __('messages.options') }}:</span>
								</li>
								<li class="navi-separator mb-3 opacity-70"></li>
								@if($model->isStartable())
									<li class="navi-item">
										<a href="#" class="navi-link btn-ride-action" data-action="start" data-id="{{ $model->getKey() }}">
											<span class="navi-icon"><i class="la la-play"></i></span>
											<span class="navi-text">{{ __('messages.button.active') }}</span>
										</a>
									</li>
								@endif

								@if($model->isCancelable())
									<li class="navi-item">
										<a href="#" class="navi-link btn-ride-action" data-action="cancel" data-id="{{ $model->getKey() }}">
											<span class="navi-icon"><i class="la la-close"></i></span>
											<span class="navi-text">{{ __('messages.button.cancel') }}</span>
										</a>
									</li>
								@endif

								@if($model->isCompletable())
									<li class="navi-item">
										<a href="#" class="navi-link btn-ride-action" data-action="complete" data-id="{{ $model->getKey() }}">
											<span class="navi-icon"><i class="la la-check"></i></span>
											<span class="navi-text">{{ __('messages.button.active') }}</span>
										</a>
									</li>
								@endif
							</ul>
							<!--end::Navigation-->
						</div>
					</div>
				</div>
			</div>
			<!--end::Header-->

			<!--begin::Body-->
			<div class="card-body pt-4">
				<div class="timeline timeline-5 mt-3">

					@if($model->started_at)
					<!--begin::Item-->
					<div class="timeline-item align-items-start">
						<!--begin::Label-->
						<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $model->started_at->format('H:i') }}</div>
						<!--end::Label-->

						<!--begin::Badge-->
						<div class="timeline-badge">
							<i class="fa fa-genderless text-primary icon-xxl"></i>
						</div>
						<!--end::Badge-->

						<!--begin::Desc-->
						<div class="timeline-content font-weight-bolder text-dark-75">
							Début du course.
						</div>
						<!--end::Desc-->
					</div>
					<!--end::Item-->
					@endif
					
					@each('driver.ride.live-item', $items, 'item')

					@if($model->completed_at)
						<!--begin::Item-->
						<div class="timeline-item align-items-start">
							<!--begin::Label-->
							<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $model->completed_at->format('H:i') }}</div>
							<!--end::Label-->

							<!--begin::Badge-->
							<div class="timeline-badge">
								<i class="fa fa-genderless text-warning icon-xxl"></i>
							</div>
							<!--end::Badge-->

							<!--begin::Desc-->
							<div class="timeline-content font-weight-bolder text-dark-75">
								Fin du course.
							</div>
							<!--end::Desc-->
						</div>
						<!--end::Item-->
					@elseif($model->canceled_at)
						<!--begin::Item-->
						<div class="timeline-item align-items-start">
							<!--begin::Label-->
							<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $model->canceled_at->format('H:i') }}</div>
							<!--end::Label-->

							<!--begin::Badge-->
							<div class="timeline-badge">
								<i class="fa fa-genderless text-danger icon-xxl"></i>
							</div>
							<!--end::Badge-->

							<!--begin::Desc-->
							<div class="timeline-content font-weight-bolder text-dark-75">
								Annulation du course.
							</div>
							<!--end::Desc-->
						</div>
						<!--end::Item-->
					@endif
					
				</div>
				<!--end: Items-->
			</div>
			<!--end: Card Body-->
		</div>
	</div>
	<div class="col-md-8">
		<div id="map" style="width:100%; height: 500px;"></div>
	</div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
var zoom = {{env('MAP_ZOOM', 15)}};
var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.00) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.00) }}};
var map;
var marker;
var poly;
var geodesicPoly;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {mapTypeControl: false, center: uluru, zoom: zoom});
    marker = new google.maps.Marker({draggable: true, position: uluru, map: map});
    poly = new google.maps.Polyline({strokeColor: '#FF0000',strokeOpacity: 1.0,strokeWeight: 3,map: map});
}
$(document).ready(function() {
	$(document).on('click', '.btn-ride-action', function() {
		var $this = $(this);
		swal.fire({
			title:"{{ __('messages.swal.delete.title') }}",
			text:"{{ __('messages.swal.delete.content') }}",
			type:"warning",
			showCancelButton:!0,
			confirmButtonText:"{{ __('messages.swal.delete.confirm') }}",
			cancelButtonText:"{{ __('messages.swal.delete.cancel') }}"
		}).then(function(e){
			if(e.value){
				KTApp.blockPage();
				axios.put("{{ route('driver.rides') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
					.then(res => {
						KTApp.unblockPage();
						var type = "danger";
						if (res.data.status === "success"){
							type = "success";
						}
						$.notify({icon:"add_alert", message:res.data.message}, {type:type});
					}).catch(err => {
						KTApp.unblockPage();
						$.notify({icon:"add_alert", message:"{{ __('messages.swal.error') }}"}, {type:"danger"});
					})
			}
		})
	});
	$(document).on('click', '.btn-rideitem-action', function() {
		var $this = $(this);
		swal.fire({
			title:"{{ __('messages.swal.delete.title') }}",
			text:"{{ __('messages.swal.delete.content') }}",
			type:"warning",
			showCancelButton:!0,
			confirmButtonText:"{{ __('messages.swal.delete.confirm') }}",
			cancelButtonText:"{{ __('messages.swal.delete.cancel') }}"
		}).then(function(e){
			if(e.value){
				KTApp.blockPage();
				axios.put("{{ route('driver.rides') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
					.then(res => {
						KTApp.unblockPage();
						var type = "danger";
						if (res.data.status === "success"){
							type = "success";
						}
						$.notify({icon:"add_alert", message:res.data.message}, {type:type});
					}).catch(err => {
						KTApp.unblockPage();
						$.notify({icon:"add_alert", message:"{{ __('messages.swal.error') }}"}, {type:"danger"});
					})
			}
		})
	});
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=geometry&callback=initMap" async defer></script>
@endsection