@if($model && $model->getKey())
	<div class="d-flex align-items-center">
		<div class="symbol symbol-40 symbol-light-success flex-shrink-0">
			@if($model->image)
				<img class="" src="{{ asset($model->image->url) }}" alt="photo">
			@else
				<span class="symbol-label font-size-h4 font-weight-bold">U</span>
			@endif
		</div>
		<div class="ml-4">
			<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a href="{{ Route::is('admin.*') ? route('admin.car.show', $model) : '#' }}">{{ $model->name }}</a></div>
			<a href="{{ Route::is('admin.*') ? route('admin.car.show', $model) : '#' }}" class="text-muted font-weight-bold text-hover-primary">{{ $model->model ? $model->model->name : '' }}</a>
		</div>
	</div>
@else
	<div class="d-flex align-items-center">
		<div class="symbol symbol-40 symbol-light-success flex-shrink-0">
			<span class="symbol-label font-size-h4 font-weight-bold">U</span>
		</div>
		<div class="ml-4">
			<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ __('messages.unkown') }}</div>
		</div>
	</div>
@endif