@extends('layouts.admin')

@section('title'){{ __('messages.activities') }} - {{ __('messages.account') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.activities') }}</h5>
            <!--end::Title-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.dashboard') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <button type="submit" form="kt_form" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base"><i class="la la-check"></i> {{ __('messages.button.update') }}</button>
            <!--end::Button-->
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12 col-xxl-12">
		<!--begin::List Widget 9-->
		<div class="card card-custom card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body pt-4">
				<div class="timeline timeline-1">
					@php ($pevious_model = null)
					@foreach ($models as $model)
						@if(is_null($pevious_model) || ($model->created_at->format('m/d/Y') != $pevious_model->created_at->format('m/d/Y')))
							<div>
								<h3>{{ $model->created_at->format('m/d/Y') }}</h3>
							</div>
							@php ($pevious_model = $model)
						@endif
						<div class="timeline-item">
							<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $model->created_at->format('H:i') }}</div>
							@switch($model->type)
								@case('App\\Notifications\\OrderStatus')
									@switch($model->data['newStatus'])
										@case("ping")
											<div class="timeline-badge">
												<i class="flaticon-bag text-primary "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande a été créée") }}
												<a href="#" class="text-primary">#{{ $model->data['order_id'] }}</a>
											</div>
										@break
										@case("on-hold")
											<div class="timeline-badge">
												<i class="flaticon-bag text-warning "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est en cours de paiement") }}
											</div>
										@break
										@case("processing")
											<div class="timeline-badge">
												<i class="flaticon-bag text-primary "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est en cours de traitement") }}
											</div>
										@break
										@case("ok")
											<div class="timeline-badge">
												<i class="flaticon-bag text-warning "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est bien reçue") }}
											</div>
										@break
										@case("active")
											<div class="timeline-badge">
												<i class="flaticon-bag text-danger "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est active") }}
											</div>
										@break
										@case("canceled")
											<div class="timeline-badge">
												<i class="flaticon-bag text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est annulée") }}
											</div>
										@break
										@case("completed")
											<div class="timeline-badge">
												<i class="flaticon-bag text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre commande est términée") }}
											</div>
										@break
									@endswitch
								@break
								@case('App\\Notifications\\ItemStatus')
									@switch($model->data['newStatus'])
										@case("ping")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-primary "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Un élément de votre commande créé") }}
											</div>
										@break
										@case("active")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-primary "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Un élément de votre commande activé") }}
											</div>
										@break
										@case("next")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-warning "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Vous etes le suivant") }}
											</div>
										@break
										@case("arrived")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-danger "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Chauffeur arrivé") }}
											</div>
										@break
										@case("online")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-warning "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Un élément de votre commande en route") }}
											</div>
										@break
										@case("canceled")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Un élément de votre commande annulé") }}	
											</div>
										@break
										@case("completed")
											<div class="timeline-badge">
												<i class="flaticon2-pin text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Un élément de votre commande términé") }}
											</div>
										@break
									@endswitch
								@break
								@case('App\\Notifications\\RideStatus')
									@switch($model->data['newStatus'])
										@case("ping")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-primary "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Une course a été créée") }}
												<a href="#" class="text-primary">#{{ $model->data['ride_id'] }}</a>
											</div>
										@break
										@case("active")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Une course a été activé") }}
											</div>
										@break
										@case("cancelable")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-warning "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Une course peut etre annulée") }}
											</div>
										@break
										@case("canceled")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre course est annulée") }}
											</div>
										@break
										@case("completable")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-danger "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre course peut etre términée") }}
											</div>
										@break
										@case("completed")
											<div class="timeline-badge">
												<i class="flaticon2-zig-zag-line-sign text-success "></i>
											</div>
											<div class="timeline-content {{ $model->read_at ? 'text-muted font-weight-normal' : 'font-weight-bolder text-dark-75' }}">
												{{ trans("Votre course est términée") }}
											</div>
										@break
									@endswitch
								@break
							@endswitch
						</div>
					@endforeach
				</div>
			</div>
			<!--end: Card Body-->
            
            <!--begin::Footer-->
            <div class="card-footer">
                {{ $models->links() }}
            </div>
            <!--end::Footer-->
			
		</div>
		<!--end: Card-->
		<!--end: List Widget 9-->
	</div>
</div>
@endsection