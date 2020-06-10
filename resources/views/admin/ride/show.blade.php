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
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.live', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.view.map.ride') }}"
			   title="{{ __('messages.view.map.ride') }}"><i class="la la-map"></i> {{ __('messages.button.live') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.create') }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.ride.create') }}"
			   title="{{ __('messages.ride.create') }}"><i class="la la-plus"></i> {{ __('messages.ride.create') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.ride.edit', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"
			   data-toggle="tooltip" 
			   data-placement="left" 
			   data-original-title="{{ __('messages.ride.edit') }}"
			   title="{{ __('messages.ride.edit') }}"><i class="la la-edit"></i> {{ __('messages.ride.edit') }}</a>
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
		
    </div>
    <!--end::Aside-->
    
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        @foreach($items as $item)
			@each('admin.ride.item', $items, 'item')
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
	$(document).on('click', '.btn-rideitem-action', function() {
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
				axios.put("{{ route('admin.rideitems') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
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