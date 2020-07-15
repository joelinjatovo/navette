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
			<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.club.show', $model) : '#' }}">{{ $model->name }}</a></div>
			<a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.club.show', $model) : '#' }}" class="text-muted font-weight-bold text-hover-primary">{{ $model->point ? $model->point->name : '' }}</a>
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