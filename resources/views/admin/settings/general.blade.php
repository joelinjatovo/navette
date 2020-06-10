@extends('layouts.admin')

@section('title'){{ __('messages.settings.general') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4 subheader-solid " id="kt_subheader">
    <div class=" container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.settings.general') }}</h5>
            <!--end::Title-->
        </div>
        <!--end::Details-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <button type="submit" form="kt_form" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base"><i class="la la-check"></i>{{ __('messages.button.save') }}</button>
            <!--end::Button-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<form class="form" id="kt_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card card-custom">
        <!--begin::Card body-->
        <div class="card-body px-0">
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-2"></div>
                <div class="col-xl-7 my-2">
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.settings.app_name') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('app_name') is-invalid @enderror" type="text" name="app_name" placeholder="{{ __('messages.form.settings.app_name') }}" value="{{ old('app_name', config('settings.app_name')) }}">
                            @error('app_name')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-2"></div>
                <div class="col-xl-7 my-2">
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.settings.app_slogan') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('app_slogan') is-invalid @enderror" type="text" name="app_slogan" placeholder="{{ __('messages.form.settings.app_slogan') }}" value="{{ old('app_slogan', config('settings.app_slogan')) }}">
                            @error('app_slogan')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--begin::Card body-->
    </div>
</form>
@endsection