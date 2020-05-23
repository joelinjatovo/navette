@extends('layouts.admin')

@section('title'){{ __('messages.form.club.create') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.club.create') }}</h5>
            <!--end::Title-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.clubs') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
            
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.club.image') }}</label>
                        <div class="col-9">
                            <div class="image-input image-input-empty image-input-outline" id="kt_club_edit_image" style="background-image: url({{ $model->image ? asset($model->image->url) : asset('img/image_placeholder.jpg') }})">
                                <div class="image-input-wrapper"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="{{ __('messages.button.edit') }}">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="profile_avatar_remove">
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="{{ __('messages.button.cancel') }}">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="{{ __('messages.button.delete') }}">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Group-->
                    
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.club.name') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" type="text" name="name" placeholder="{{ __('messages.form.club.name') }}" value="{{ old('name', $model->name) }}">
                            @error('name')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                    
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.point.lat') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('point.lat') is-invalid @enderror" type="text" name="point[lat]" id="point_lat" placeholder="{{ __('messages.form.point.lat') }}" value="{{ old('point.lat', $model->point ? $model->point->lat: '') }}">
                            @error('point.lat')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                    
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.point.lng') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('point.lng') is-invalid @enderror" type="text" name="point[lng]" id="point_lng" placeholder="{{ __('messages.form.point.lng') }}" value="{{ old('point.lng', $model->point ? $model->point->lng: '') }}">
                            @error('point.lng')
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


@section('javascript')
<script type="text/javascript">
var KTClubEdit={init:function(){new KTImageInput("kt_club_edit_image")}};
jQuery(document).ready(function(){KTClubEdit.init()});
</script>
@endsection
