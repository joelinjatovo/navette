@extends('layouts.admin')

@section('title'){{ __('messages.form.ride.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.ride.view') }}</h5>
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
            <a href="{{ route('admin.rides') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
			
			@if($model->cancelable())
			<!--begin::Button-->
			<a href="#" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" data-action="cancel" data-id="{{ $model->getKey() }}"><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->activable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" data-action="active" data-id="{{ $model->getKey() }}"><i class="la la-play-circle-o"></i> {{ __('messages.button.active') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->completable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-action" data-action="complete" data-id="{{ $model->getKey() }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
			<!--end::Button-->
			@endif
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.live', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-map"></i> {{ __('messages.button.live') }}</a>
            <!--end::Button-->
            
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
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
		@if($model->driver)
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::User-->
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                        <div class="symbol-label" style="background-image:url('{{ $model->driver->image ? asset($model->driver->image->url) : asset('img/avatar.png') }}')"></div>
                    </div>
                    <div>
                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                            {{ $model->driver->name }}
                        </a>
                        <div class="text-muted">
                            {{ $model->driver->role() }}
                        </div>
                        <div class="mt-2">
                            @if($model->driver->phone)
                            <a href="tel:{{ $model->driver->phone }}" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.call') }}</a>
                            @endif
                            @if($model->driver->email)
                            <a href="mailto:{{ $model->driver->email }}" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.contact') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Usedriverr-->

                <!--begin::Contact-->
                <div class="pt-8 pb-6">
                    @if($model->driver->email)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.email') }}:</span>
                            <a href="mailto:{{ $model->user->email }}" class="text-muted text-hover-primary">{{ $model->driver->email }}</a>
                        </div>
                    @endif
                    @if($model->driver->phone)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.phone') }}:</span>
                            <span class="text-muted">{{ $model->driver->phone }}</span>
                        </div>
                    @endif
                </div>
                <!--end::Contact-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
		@endif
		
		@if($model->car)
		<div class="card card-custom gutter-b">
			<!--begin::Body-->
			<div class="card-body py-2">
				<!--begin::Item-->
				<x-car :model="$model->car" />
				<!--end::Item-->
			</div>
			<!--end::Body-->
		</div>
		@endif
		
    </div>
    <!--end::Aside-->
    
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        @foreach($points as $point)
			<div class="col-lg-12 col-xxl-12">
				<!--begin::List Widget 9-->
				<div class="card card-custom card-stretch gutter-b">
					<!--begin::Body-->
					<div class="card-body align-items-center border-0 mt-2 mb-2">
						<div class="d-flex align-items-center justify-content-between flex-grow-1">
							@if($point->user)
							<div class="d-flex align-items-center">
								<div class="symbol symbol-50 symbol-light mr-4 pt-0">
									<img src="{{ $point->user->image ? asset($point->user->image->url) : asset('img/avatar.png') }}" class="h-75 align-self-end" alt="">
								</div>
								<div>
									<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $point->user->name }}</a>
									@if($point->pivot->type == 'drop')
										<span class="text-dark-50 font-weight-bolder d-block">{{ __('messages.dropoff') }}</span>
									@else
										<span class="text-dark-50 font-weight-bolder d-block">{{ __('messages.pickup') }}</span>
									@endif
								</div>
							</div>
							@else
							<div class="d-inline-flex align-items-center mr-2">
								<a href="#" class="btn btn-icon w-auto btn-clean btn-lg pulse pulse-primary mr-2">
									<span class="svg-icon svg-icon-xl svg-icon-primary px-2">
										<!--begin::Svg Icon-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"/>
												<path d="M14,13.381038 L14,3.47213595 L7.99460483,15.4829263 L14,13.381038 Z M4.88230018,17.2353996 L13.2844582,0.431083506 C13.4820496,0.0359007077 13.9625881,-0.12427877 14.3577709,0.0733126292 C14.5125928,0.15072359 14.6381308,0.276261584 14.7155418,0.431083506 L23.1176998,17.2353996 C23.3152912,17.6305824 23.1551117,18.1111209 22.7599289,18.3087123 C22.5664522,18.4054506 22.3420471,18.4197165 22.1378777,18.3482572 L14,15.5 L5.86212227,18.3482572 C5.44509941,18.4942152 4.98871325,18.2744737 4.84275525,17.8574509 C4.77129597,17.6532815 4.78556182,17.4288764 4.88230018,17.2353996 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.000087, 9.191034) rotate(-315.000000) translate(-14.000087, -9.191034) "/>
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
									<span class="pulse-ring"></span>
								</a>
								@if($point->pivot->type == 'drop')
									<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.dropoff') }}</span>
								@else
									<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.pickup') }}</span>
								@endif
							</div>
							@endif
							<div class="d-inline-flex align-items-right align-items-center">
								<div class="font-weight-boldest text-danger mr-4">{{ $point->pivot->duration }}</div>
								<div class="font-weight-boldest text-warning mr-4">{{ $point->pivot->distance }}</div>
								<x-status theme="light" :status="$point->pivot->status" />
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
											<li class="navi-item">
												<a href="{{ route('admin.ridepoint.show', $point->pivot) }}" class="navi-link" data-action="cancel" data-id="">
													<span class="navi-icon"><i class="flaticon-eye"></i></span>
													<span class="navi-text">{{ __('messages.button.view') }}</span>
												</a>
											</li>
											@if($point->pivot->cancelable() || $point->pivot->arrivable() || $point->pivot->dropable() || $point->pivot->pickable()):
												<li class="navi-separator my-3"></li>
											@endif
											@if($point->pivot->arrivable())
											<li class="navi-item">
												<a href="#" class="navi-link btn-ridepoint-action" data-action="arrive" data-id="{{ $point->pivot->id }}">
													<span class="navi-icon"><i class="flaticon-cancel"></i></span>
													<span class="navi-text">{{ __('messages.button.arrive') }}</span>
												</a>
											</li>
											@endif
											@if($point->pivot->cancelable())
											<li class="navi-item">
												<a href="#" class="navi-link btn-ridepoint-action" data-action="cancel" data-id="{{ $point->pivot->id }}">
													<span class="navi-icon"><i class="flaticon-cancel"></i></span>
													<span class="navi-text">{{ __('messages.button.cancel') }}</span>
												</a>
											</li>
											@endif
											@if($point->pivot->dropable() || $point->pivot->pickable())
											<li class="navi-item">
												<a href="#" class="navi-link btn-ridepoint-action" data-action="pick-or-drop" data-id="{{ $point->pivot->id }}">
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
						</div>
						
						@if($point)
						<div class="timeline timeline-2 mt-3">
							<div class="timeline-bar"></div>
							<!--begin::Item-->
							<div class="timeline-item">
								<div class="timeline-badge bg-danger"></div>
								<div class="timeline-content text-dark-50">
									{{ $point->name }}
								</div>
							</div>
							<!--end::Item-->
						</div>
						@endif
					</div>
					<!--end::Body-->
				</div>
				<!--end: Card-->
				<!--end: List Widget 9-->
			</div>
		@endforeach
	</div>
    <!--end::Content-->
</div>
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '.btn-ride-action', function() {
		var $this = $(this);
		swal.fire({
			title:"{{ __('messages.swal.action.title') }}",
			text:"{{ __('messages.swal.action.content') }}",
			type:"warning",
			showCancelButton:!0,
			confirmButtonText:"{{ __('messages.swal.action.confirm') }}",
			cancelButtonText:"{{ __('messages.swal.action.cancel') }}"
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
$(document).ready(function() {
	$(document).on('click', '.btn-ridepoint-action', function() {
		var $this = $(this);
		swal.fire({
			title:"{{ __('messages.swal.action.title') }}",
			text:"{{ __('messages.swal.action.content') }}",
			type:"warning",
			showCancelButton:!0,
			confirmButtonText:"{{ __('messages.swal.action.confirm') }}",
			cancelButtonText:"{{ __('messages.swal.action.cancel') }}"
		}).then(function(e){
			if(e.value){
				KTApp.blockPage();
				axios.put("{{ route('admin.ridepoints') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
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
@endsection