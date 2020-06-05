<div class="col-lg-12 col-xxl-12">
	<!--begin::List Widget 9-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Body-->
		<div class="card-body align-items-center border-0 mt-2 mb-2">
			<div class="d-flex align-items-center justify-content-between flex-grow-1">
				@if($item->order->user)
				<div class="d-flex align-items-center">
					<div class="symbol symbol-50 symbol-light mr-4 pt-0">
						<img src="{{ $item->order->user->image ? asset($item->order->user->image->url) : asset('img/avatar.png') }}" class="h-75 align-self-end" alt="">
					</div>
					<div>
						<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $item->order->user->name }}</a>
						@if($item->pivot->type == 'drop')
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
					@if($item->pivot->type == 'drop')
						<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.dropoff') }}</span>
					@else
						<span class="text-dark-75 font-weight-bolder font-size-h3">{{ __('messages.pickup') }}</span>
					@endif
				</div>
				@endif
				<div class="d-inline-flex align-items-right align-items-center">
					<div class="font-weight-boldest text-danger mr-4">{{ $item->pivot->duration }}</div>
					<div class="font-weight-boldest text-warning mr-4">{{ $item->pivot->distance }}</div>
					<x-status theme="light" :status="$item->pivot->status" />
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
									<a href="{{ route('admin.rideitem.show', $item->pivot) }}" class="navi-link" data-action="cancel" data-id="">
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
			</div>

			@if($item->point)
			<div class="timeline timeline-2 mt-3">
				<div class="timeline-bar"></div>
				<!--begin::Item-->
				<div class="timeline-item">
					<div class="timeline-badge bg-danger"></div>
					<div class="timeline-content text-dark-50">
						{{ $item->point->name }}
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