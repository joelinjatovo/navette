@extends('layouts.admin')

@section('title'){{ __('messages.club.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.club.view') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::User Name-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">{{ $model->name }}</span>
            </div>
            <!--end::User Name-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.clubs') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.club.create') }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-plus"></i> {{ __('messages.club.create') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.club.edit', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-edit"></i> {{ __('messages.club.edit') }}</a>
            <!--end::Button-->
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection
