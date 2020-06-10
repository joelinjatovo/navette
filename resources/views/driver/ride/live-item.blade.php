<!--begin::Item-->
<div class="timeline-item align-items-start">
	<!--begin::Label-->
	<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ $item->pivot->duration }}</div>
	<!--end::Label-->

	<!--begin::Badge-->
	<div class="timeline-badge">
		@switch($item->pivot->status)
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
				@switch($item->pivot->status)
					@case('active')
						<span class="font-weight-bolder text-dark-50">{{ $item->point->name }}</span>
					@break
					@case('next')
						<span class="font-weight-bolder text-dark-75">{{ $item->point->name }}</span>
					@break
					@case('arrived')
						<span class="font-weight-bolder text-dark-75">{{ $item->point->name }}</span>
					@break
					@default
						<span class="text-dark-50">{{ $item->point->name }}</span>
					@break
				@endswitch
				@if($item->pivot->duration)
				- <span class="font-weight-boldest text-primary mr-2">{{ $item->pivot->duration }}</span>
				@endif
				@if($item->pivot->distance)
				- <span class="font-weight-boldest text-success mr-2">{{ $item->pivot->distance }}</span>
				@endif
			</span>

			<!--begin::Section-->
			<div class="d-flex align-items-start mr-2">
				<!--begin::Symbol-->
				<a href="#" class="symbol symbol-35 mr-2">
					<img src="{{ $item->order->user && $item->order->user->image ? asset($item->order->user->image->url) : asset('img/avatar.png') }}" class="h-75 align-self-end" alt="">
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
						@if($item->order->user)
							@if($item->order->user->email)
							<li class="navi-item">
								<a href="mailto:{{ $item->order->user->email }}" class="navi-link">
									<span class="navi-icon"><i class="flaticon2-envelope"></i></span>
									<span class="navi-text">{{ __('messages.button.contact') }}</span>
								</a>
							</li>
							@endif
							@if($item->order->user->email)
								<li class="navi-item">
									<a href="tel:{{ $item->order->user->phone }}" class="navi-link">
										<span class="navi-icon"><i class="flaticon2-phone"></i></span>
										<span class="navi-text">{{ __('messages.button.call') }}</span>
									</a>
								</li>
							@endif
						@endif
						<li class="navi-item">
							<a href="{{ route('driver.rideitem.show', $item->pivot) }}" class="navi-link" data-action="cancel" data-id="">
								<span class="navi-icon"><i class="flaticon-eye"></i></span>
								<span class="navi-text">{{ __('messages.button.view') }}</span>
							</a>
						</li>
						@if($item->pivot->isCancelable() || $item->pivot->isArrivable() || $item->pivot->isDropable() || $item->pivot->isPickable()):
							<li class="navi-separator my-3"></li>
						@endif
						@if($item->pivot->isArrivable())
						<li class="navi-item">
							<a href="#" class="navi-link btn-rideitem-action" data-action="arrive" data-id="{{ $item->pivot->id }}">
								<span class="navi-icon"><i class="flaticon-cancel"></i></span>
								<span class="navi-text">{{ __('messages.button.arrive') }}</span>
							</a>
						</li>
						@endif
						@if($item->pivot->isCancelable())
						<li class="navi-item">
							<a href="#" class="navi-link btn-rideitem-action" data-action="cancel" data-id="{{ $item->pivot->id }}">
								<span class="navi-icon"><i class="flaticon-cancel"></i></span>
								<span class="navi-text">{{ __('messages.button.cancel') }}</span>
							</a>
						</li>
						@endif
						@if($item->pivot->isDropable() || $item->pivot->isPickable())
						<li class="navi-item">
							<a href="#" class="navi-link btn-rideitem-action" data-action="pick-or-drop" data-id="{{ $item->pivot->id }}">
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
			@if($item->pivot->type == 'drop')
				<span class="label label-inline label-light-primary mr-2">{{ __('messages.dropoff') }}</span>
			@else
				<span class="label label-inline label-light-success mr-2">{{ __('messages.pickup') }}</span>
			@endif
			<x-status theme="light" :status="$item->pivot->status" />
		</div>
	</div>
	<!--end::Content-->
</div>
<!--end::Item-->