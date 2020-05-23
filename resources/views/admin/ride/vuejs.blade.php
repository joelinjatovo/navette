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
	</div>
	<div class="col-md-8">
	</div>
</div>
@endsection

@section('javascript')
<script src="/js/admin/ride.js"></script>
@endsection