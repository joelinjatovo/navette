@extends('layouts.admin')

@section('title'){{ __('messages.form.item.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.item.view') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::User Name-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">#{{ $model->getKey() }}</span>
				<span class="label label-inline label-light-danger font-weight-bolder ml-4">{{ $model->status() }}</span>
            </div>
            <!--end::User Name-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.items') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
			
			@if($model->cancelable())
			<!--begin::Button-->
			<a href="#" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-item-cancel" data-id="{{ $model->getKey() }}"><i class="la la-close"></i> {{ __('messages.button.cancel') }}</a>
			<!--end::Button-->
			@endif
			
			@if($model->finishable())
			<!--begin::Button-->
			<a href="#" class="btn btn-light-primary font-weight-bold btn-sm px-3 font-size-base mr-2 btn-item-complete" data-id="{{ $model->getKey() }}"><i class="la la-check"></i> {{ __('messages.button.complete') }}</a>
			<!--end::Button-->
			@endif
            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
		@if($model->order && $model->order->user)
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">{{ __('messages.customer') }}</h3>
				</div>
			</div>
            <!--end::Header-->
			
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::User-->
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                        <div class="symbol-label" style="background-image:url('{{ $model->order->user->image ? asset($model->order->user->image->url) : asset('img/avatar.png') }}')"></div>
                    </div>
                    <div>
                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                            {{ $model->order->user->name }}
                        </a>
                        <div class="text-muted">
                            {{ $model->order->user->role() }}
                        </div>
                        <div class="mt-2">
                            @if($model->order->user->phone)
                            <a href="tel:{{ $model->order->user->phone }}" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.call') }}</a>
                            @endif
                            @if($model->order->user->email)
                            <a href="mailto:{{ $model->order->user->email }}" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.contact') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::User-->

                <!--begin::Contact-->
                <div class="pt-8 pb-6">
                    @if($model->order->user->email)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.email') }}:</span>
                            <a href="mailto:{{ $model->order->user->email }}" class="text-muted text-hover-primary">{{ $model->order->user->email }}</a>
                        </div>
                    @endif
                    @if($model->order->user->phone)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.phone') }}:</span>
                            <span class="text-muted">{{ $model->order->user->phone }}</span>
                        </div>
                    @endif
                </div>
                <!--end::Contact-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
		@endif
		
		@if($model->order && $model->order->car)
		<div class="card card-custom gutter-b">
            <!--begin::Header-->
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">{{ __('messages.car') }}</h3>
				</div>
			</div>
            <!--end::Header-->
			
			<!--begin::Body-->
			<div class="card-body py-2">
				<!--begin::Item-->
				<div class="d-flex align-items-center mb-2 mt-2">
					<!--begin::Symbol-->
					<div class="symbol symbol-60 symbol-xxl-75 mr-5 align-self-start align-self-xxl-center">
						<div class="symbol-label" style="background-image:url('{{ $model->order->car->image ? asset($model->order->car->image->url) : asset('img/car.jpg') }}')"></div>
					</div>
					<!--end::Symbol-->

					<!--begin::Text-->
					<div class="d-flex flex-column flex-grow-1 font-weight-bold">
						<a href="{{ route('admin.car.show', $model->order->car) }}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ $model->order->car->name }}</a>
						@if($model->order->car->driver)
						<span class="text-muted">{{ $model->order->car->driver->name }}</span>
						@endif
					</div>
					<!--end::Text-->
				</div>
				<!--end::Item-->
			</div>
			<!--end::Body-->
		</div>
		@endif
		
    </div>
    <!--end::Aside-->
    
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
		
		@if($model->order)
		<div class="col-lg-12 col-xxl-12 mb-8">
			<!--begin:Amount -->
			<div class="card-body d-flex flex-column p-0" style="position: relative;">
				<div class="card-spacer bg-white card-rounded flex-grow-1">
					<!--begin::Row-->
					<div class="row m-0">
						<div class="col px-8 py-6 mr-4 ml-4">
							<div class="font-size-sm text-muted font-weight-bold">{{ __('messages.place') }}</div>
							<div class="font-size-h4 font-weight-bolder">{{ $model->order->place }}</div>
						</div>
						<div class="col px-8 py-6 mr-4 ml-4">
							<div class="font-size-sm text-muted font-weight-bold">{{ __('messages.amount') }}</div>
							<div class="font-size-h4 font-weight-bolder">{{ $model->order->currency }} {{ $model->order->amount }}</div>
						</div>
						<div class="col px-8 py-6 mr-4 ml-4">
							<div class="font-size-sm text-muted font-weight-bold">{{ __('messages.subtotal') }}</div>
							<div class="font-size-h4 font-weight-bolder">{{ $model->order->currency }} {{ $model->order->subtotal }}</div>
						</div>
						<div class="col px-8 py-6 mr-4 ml-4">
							<div class="font-size-sm text-muted font-weight-bold">{{ __('messages.total') }}</div>
							<div class="font-size-h4 font-weight-bolder">{{ $model->order->currency }}  {{ $model->order->total }}</div>
						</div>
					</div>
					<!--end::Row-->
				</div>
			</div>
			<!--end:Amount -->
		</div>
		@endif
		
		<div class="col-lg-12 col-xxl-12">
			<!--begin::List Widget 9-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Body-->
				<div class="card-body align-items-center border-0 mt-2 mb-2">
					<div class="d-flex align-items-center justify-content-between flex-grow-1">
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
							@if($model->type == 'back')
								<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.dropoff') }}</span>
							@else
								<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.pickup') }}</span>
							@endif
						</div>
						<div class="d-inline-flex align-items-right">
							<div class="font-weight-boldest text-danger mr-4">{{ $model->duration }}</div>
							<div class="font-weight-boldest text-warning mr-4">{{ $model->distance }}</div>
							<span class="label label-inline label-light-danger font-weight-bolder">{{ $model->status() }}</span>
						</div>
					</div>
					<div class="timeline timeline-2 mt-3">
						<div class="timeline-bar"></div>
						@if($model->point && $model->type != 'back')
						<!--begin::Item-->
						<div class="timeline-item">
							<div class="timeline-badge bg-danger"></div>
							<div class="timeline-content text-dark-50">
								{{ $model->point->name }}
							</div>
						</div>
						<!--end::Item-->
						@endif
						
						@if($model->order && $model->order->club)
						<!--begin::Item-->
						<div class="timeline-item">
							<div class="timeline-badge bg-success"></div>
							<div class="timeline-content font-weight-bolder text-dark-75">
								{{ $model->order->club->name }}
							</div>
						</div>
						<!--end::Item-->
						@endif
						
						@if($model->point && $model->type == 'back')
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
				</div>
				<!--end::Body-->
			</div>
			<!--end: Card-->
			<!--end: List Widget 9-->
		</div>
	</div>
    <!--end::Content-->
</div>
@endsection
