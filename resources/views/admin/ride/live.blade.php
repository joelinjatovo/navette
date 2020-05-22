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
			<a href="#" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-cancel" data-id="{{ $model->getKey() }}"><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->activable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-active" data-id="{{ $model->getKey() }}"><i class="la la-play-circle-o"></i> {{ __('messages.button.active') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->completable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-ride-complete" data-id="{{ $model->getKey() }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
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
					<span class="font-weight-bolder text-dark">Tous les points</span>
					<span class="text-muted mt-3 font-weight-bold font-size-sm">890,344 Sales</span>
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
									<span class="font-size-lg">Choose Label:</span>
									<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
								</li>
								<li class="navi-separator mb-3 opacity-70"></li>
								<li class="navi-item">
									<a href="#" class="navi-link">
										<span class="navi-text">
											<span class="label label-xl label-inline label-light-success">Customer</span>
										</span>
									</a>
								</li>
								<li class="navi-item">
									<a href="#" class="navi-link">
										<span class="navi-text">
											<span class="label label-xl label-inline label-light-danger">Partner</span>
										</span>
									</a>
								</li>
								<li class="navi-item">
									<a href="#" class="navi-link">
										<span class="navi-text">
											<span class="label label-xl label-inline label-light-warning">Suplier</span>
										</span>
									</a>
								</li>
								<li class="navi-item">
									<a href="#" class="navi-link">
										<span class="navi-text">
											<span class="label label-xl label-inline label-light-primary">Member</span>
										</span>
									</a>
								</li>
								<li class="navi-item">
									<a href="#" class="navi-link">
										<span class="navi-text">
											<span class="label label-xl label-inline label-light-dark">Staff</span>
										</span>
									</a>
								</li>
								<li class="navi-separator mt-3 opacity-70"></li>
								<li class="navi-footer py-4">
									<a class="btn btn-clean font-weight-bold btn-sm" href="#">
										<i class="ki ki-plus icon-sm"></i>
										Add new
									</a>
								</li>
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

					<!--begin::Item-->
					<div class="timeline-item align-items-start">
						<!--begin::Label-->
						<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">21:03</div>
						<!--end::Label-->

						<!--begin::Badge-->
						<div class="timeline-badge">
							<i class="fa fa-genderless text-primary icon-xxl"></i>
						</div>
						<!--end::Badge-->

						<!--begin::Desc-->
						<div class="timeline-content font-weight-bolder text-dark-75">
							Début du course <a href="#" class="text-primary">#{{ $model->getKey() }}</a>.
						</div>
						<!--end::Desc-->
					</div>
					<!--end::Item-->
					
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
										- <span class="font-weight-boldest text-primary mr-2">{{ $point->pivot->duration }}</span>
										- <span class="font-weight-boldest text-success mr-2">{{ $point->pivot->distance }}</span>
									</span>

									<!--begin::Section-->
									<div class="d-flex align-items-start">
										<!--begin::Symbol-->
										<a href="#" class="symbol symbol-35 mr-2">
											<img src="{{ $point->user && $point->user->image ? asset($point->user->image->url) : asset('img/avatar.png') }}" class="h-75 align-self-end" alt="">
										</a>
										<!--end::Symbol-->
									</div>
									<!--end::Section-->
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

					<!--begin::Item-->
					<div class="timeline-item align-items-start">
						<!--begin::Label-->
						<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">21:03</div>
						<!--end::Label-->

						<!--begin::Badge-->
						<div class="timeline-badge">
							<i class="fa fa-genderless text-warning icon-xxl"></i>
						</div>
						<!--end::Badge-->

						<!--begin::Desc-->
						<div class="timeline-content font-weight-bolder text-dark-75">
							Fin du course <a href="#" class="text-primary">#{{ $model->getKey() }}</a>.
						</div>
						<!--end::Desc-->
					</div>
					<!--end::Item-->
					
				</div>
				<!--end: Items-->
			</div>
			<!--end: Card Body-->
		</div>
	</div>
	<div class="col-md-8">
		<div id="map" style="width:100%; height: 400px;"></div>
	</div>
</div>
@endsection
