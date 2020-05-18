@extends('layouts.admin')

@section('title'){{ __('messages.user.create') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.user.create') }}</h5>
            <!--end::Title-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('Avatar') }}</label>
                        <div class="col-9">
                            <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url({{ $model->image ? asset($model->image->url) : asset('img/avatar.png') }})">
                                <div class="image-input-wrapper"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="{{ __('Modifier') }}">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="profile_avatar_remove">
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="{{ __('Annuler') }}">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="{{ __('Supprimer') }}">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('Nom complet') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $model->name) }}">
                            @error('name')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('Téléphone') }}</label>
                        <div class="col-9">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                <input type="text" class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror" placeholder="{{ __('Numéro de téléphone') }}" name="phone" value="{{ old('phone', $model->phone) }}">
                            </div>
                            <span class="form-text text-muted">{{ __('Votre numéro sera util pour vous contacter avant la course.') }}</span>
                            @error('phone')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('Adresse email') }}</label>
                        <div class="col-9">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                <input type="text" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" placeholder="{{ __('Adresse email') }}" name="email" value="{{ old('email', $model->email) }}">
                            </div>
                             @error('email')
                                <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Group-->

                    @if(Route::is('admin.user.create'))
                        <!--begin::Group-->
                        <div class="form-group row">
                            <label class="col-form-label col-3 text-lg-right text-left">{{ __('Mot de passe') }}</label>
                            <div class="col-9">
                                <input class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" type="password" name="password" placeholder="{{ __('Mot de passe') }}">
                                @error('password')
                                    <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                                @enderror
                            </div>
                        </div>
                        <!--end::Group-->

                        <!--begin::Group-->
                        <div class="form-group row">
                            <label class="col-form-label col-3 text-lg-right text-left">{{ __('Confimation mot de passe') }}</label>
                            <div class="col-9">
                                <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" placeholder="{{ __('Confirmation mot de passe') }}" value="">
                            </div>
                        </div>
                        <!--end::Group-->
                    @endif
                    
                    <div class="form-group row">
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.role') }}</label>
                        <div class="col-9">
                            <div class="checkbox-inline">
                                @foreach($roles as $role)
                                    <label class="checkbox"><input type="checkbox" name="roles[]" value="{{ $role->getKey() }}" {{ $model->hasRole($role->name) ? 'checked=""' : '' }} > {{ $role->description }}<span></span></label>
                                @endforeach
                            </div>
                        </div>
                    </div>
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
var KTUserEdit={init:function(){new KTImageInput("kt_user_edit_avatar")}};
jQuery(document).ready(function(){KTUserEdit.init()});
</script>
@endsection