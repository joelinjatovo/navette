@extends('layouts.live')

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
				
			<span class="mr-2">{{ __('messages.distance') }}: <span class="text-dark-75 font-weight-bold" id="kt_subheader_distance">{{ $model->distance }} m</span></span>
			<span class="mr-2">{{ __('messages.duration') }}: <span class="text-dark-75 font-weight-bold" id="kt_subheader_duration">{{ gmdate('H:i:s', $model->duration) }}</span></span>
			<x-status theme="light" :status="$model->status" />

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.rides') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
			
			@if($model->cancelable())
			<!--begin::Button-->
			<a href="#" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" data-action="cancel" data-id="{{ $model->getKey() }}"><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->activable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-active" data-action="active" data-id="{{ $model->getKey() }}"><i class="la la-play-circle-o"></i> {{ __('messages.button.active') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->completable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-complete" data-action="complete" data-id="{{ $model->getKey() }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
			<!--end::Button-->
			@endif
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.create') }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-plus"></i> {{ __('messages.ride.create') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.edit', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-edit"></i> {{ __('messages.ride.edit') }}</a>
            <!--end::Button-->
                            
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
					<span class="text-black mt-3 font-weight-bold font-size-sm">{{ $model->created_at->format('Y-m-d') }}</span>
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
									@if($model->activable())
										<li class="navi-item">
											<a href="#" class="navi-link btn-ride-action" data-action="active" data-id="{{ $model->getKey() }}">
												<span class="navi-icon"><i class="la la-play"></i></span>
												<span class="navi-text">{{ __('messages.button.active') }}</span>
											</a>
										</li>
									@endif
								
									@if($model->cancelable())
										<li class="navi-item">
											<a href="#" class="navi-link btn-ride-action" data-action="cancel" data-id="{{ $model->getKey() }}">
												<span class="navi-icon"><i class="la la-close"></i></span>
												<span class="navi-text">{{ __('messages.button.cancel') }}</span>
											</a>
										</li>
									@endif

									@if($model->completable())
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
					
					@foreach($points as $point)
						<!--begin::Item-->
						<div class="timeline-item align-items-start">
							<!--begin::Label-->
							<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $point->pivot->duration }}</div>
							<!--end::Label-->

							<!--begin::Badge-->
							<div class="timeline-badge">
								@switch($point->pivot->status)
									@case('active')
										<i class="fa fa-genderless text-danger icon-xxl"></i>
									@break
									@case('next')
										<i class="fa fa-genderless text-warning icon-xxl"></i>
									@break
									@case('arrived')
										<i class="fa fa-genderless text-info icon-xxl"></i>
									@break
									@case('online')
										<i class="fa fa-genderless text-default icon-xxl"></i>
									@break
									@case('canceled')
										<i class="fa fa-genderless text-default icon-xxl"></i>
									@break
									@case('completed')
										<i class="fa fa-genderless text-default icon-xxl"></i>
									@break
									@default
										<i class="fa fa-genderless text-default icon-xxl"></i>
									@break
								@endswitch
							</div>
							<!--end::Badge-->

							<!--begin::Content-->
							<div class="timeline-content">
								<div class="d-flex">
									<span>
										@switch($point->pivot->status)
											@case('active')
												<span class="font-weight-bolder text-dark-50">{{ $point->name }}</span>
											@break
											@case('next')
												<span class="font-weight-bolder text-dark-75">{{ $point->name }}</span>
											@break
											@case('arrived')
												<span class="font-weight-bolder text-dark-75">{{ $point->name }}</span>
											@break
											@default
												<span class="text-dark-50">{{ $point->name }}</span>
											@break
										@endswitch
										@if($point->pivot->duration)
										- <span class="font-weight-boldest text-primary mr-2">{{ $point->pivot->duration }}</span>
										@endif
										@if($point->pivot->distance)
										- <span class="font-weight-boldest text-success mr-2">{{ $point->pivot->distance }}</span>
										@endif
									</span>

									<!--begin::Section-->
									<div class="d-flex align-items-start mr-2">
										<!--begin::Symbol-->
										<a href="#" class="symbol symbol-35 mr-2">
											<img src="{{ $point->user && $point->user->image ? asset($point->user->image->url) : asset('img/avatar.png') }}" class="h-75 align-self-end" alt="">
										</a>
										<!--end::Symbol-->
									</div>
									<!--end::Section-->
									
									<div class="dropdown dropdown-inline ml-4" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{ __('messages.options') }}">
										<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											<i class="ki ki-bold-more-ver"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-md dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-217px, -340px, 0px);">
											<!--begin::Navigation-->
											<ul class="navi navi-hover py-5">
												@if($point->user)
													@if($point->user->email)
													<li class="navi-item">
														<a href="mailto:{{ $point->user->email }}" class="navi-link">
															<span class="navi-icon"><i class="flaticon2-envelope"></i></span>
															<span class="navi-text">{{ __('messages.button.contact') }}</span>
														</a>
													</li>
													@endif
													@if($point->user->email)
														<li class="navi-item">
															<a href="tel:{{ $point->user->phone }}" class="navi-link">
																<span class="navi-icon"><i class="flaticon2-phone"></i></span>
																<span class="navi-text">{{ __('messages.button.call') }}</span>
															</a>
														</li>
													@endif
												@endif
												@if($point->pivot->cancelable() || $point->pivot->arrivable() || $point->pivot->finishable()):
													<li class="navi-separator"></li>
												@endif
												@if($point->pivot->arrivable())
												<li class="navi-item">
													<a href="#" class="navi-link btn-action" data-ation="arrive" data-id="{{ $point->pivot->id }}">
														<span class="navi-icon"><i class="flaticon-cancel"></i></span>
														<span class="navi-text">{{ __('messages.button.arrive') }}</span>
													</a>
												</li>
												@endif
												@if($point->pivot->cancelable())
												<li class="navi-item">
													<a href="#" class="navi-link btn-action" data-ation="cancel" data-id="{{ $point->pivot->id }}">
														<span class="navi-icon"><i class="flaticon-cancel"></i></span>
														<span class="navi-text">{{ __('messages.button.cancel') }}</span>
													</a>
												</li>
												@endif
												@if($point->pivot->finishable())
												<li class="navi-item">
													<a href="#" class="navi-link btn-ridepoint-action" data-ation="complete" data-id="{{ $point->pivot->id }}">
														<span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
														<span class="navi-text">{{ __('messages.button.complete') }}</span>
													</a>
												</li>
												@endif
											</ul>
											<!--end::Navigation-->
										</div>
									</div>
								</div>
								
								<div class="d-flex">
									@if($point->pivot->type == 'drop')
										<span class="label label-inline label-light-primary mr-2">{{ __('messages.dropoff') }}</span>
									@else
										<span class="label label-inline label-light-success mr-2">{{ __('messages.pickup') }}</span>
									@endif
									<x-status theme="light" :status="$point->pivot->status" />
								</div>
							</div>
							<!--end::Content-->
						</div>
						<!--end::Item-->
					@endforeach

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
    poly = new google.maps.Polyline({
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 3,
        map: map,
    });
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
				axios.put("{{ route('admin.rides') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
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
	$(document).on('click', '.btn-ridepoint-action', function() {
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
				axios.put("{{ route('admin.rides') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
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