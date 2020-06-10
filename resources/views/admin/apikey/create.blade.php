@extends('layouts.admin')

@section('title'){{ __('messages.form.apikey.create') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.apikey.create') }}</h5>
            <!--end::Title-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.apikeys') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.apikey.scopes') }} *</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('scopes') is-invalid @enderror" type="text" name="scopes" placeholder="{{ __('messages.form.apikey.scopes') }}" value="{{ old('scopes', $model->scopes) }}">
                            @error('scopes')
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.apikey.name') }} *</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" type="text" name="name" placeholder="{{ __('messages.form.apikey.name') }}" value="{{ old('name', $model->name) }}">
                            @error('name')
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.apikey.version') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('version') is-invalid @enderror" type="text" name="version" placeholder="{{ __('messages.form.apikey.version') }}" value="{{ old('version', $model->version) }}">
                            @error('version')
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.apikey.user_agent') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('user_agent') is-invalid @enderror" type="text" name="user_agent" placeholder="{{ __('messages.form.apikey.user_agent') }}" value="{{ old('user_agent', $model->user_agent) }}">
                            @error('user_agent')
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
                        <label class="col-form-label col-3 text-lg-right text-left">{{ __('messages.form.apikey.expires') }}</label>
                        <div class="col-9">
                            <input class="form-control form-control-lg form-control-solid @error('expires_at') is-invalid @enderror" type="text" id="expires_at" name="expires_at" placeholder="{{ __('messages.form.apikey.expires_at') }}" value="{{ old('expires_at', $model->expires_at ? $model->expires_at->format('d/m/Y') : now()->addYear(1)->format('d/m/Y') ) }}">
                            @error('expires_at')
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
						<label class="col-form-label text-right col-lg-3 col-sm-12">{{ __('messages.form.apikey.revoke') }}</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="form-check pl-0 checkbox-inline">
								<label class="checkbox checkbox-outline">
									{{ __('messages.form.apikey.revoke-label') }}
									<input type="hidden" name="revoked" value="0">
									<input type="checkbox" name="revoked" {{ old('revoke', $model->revoke) ? 'checked="checked"' : '' }} value="1">
									<span></span>
								</label>
							</div>
							<span class="form-text text-muted">{{ __('messages.form.apikey.revoke-help') }}</span>
							@error('user_agent')
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
jQuery(document).ready(function(){
	var t;t=KTUtil.isRTL()?{leftArrow:'<i class="la la-angle-right"></i>',rightArrow:'<i class="la la-angle-left"></i>'}:{leftArrow:'<i class="la la-angle-left"></i>',rightArrow:'<i class="la la-angle-right"></i>'};
	jQuery("#expires_at").datepicker({rtl:KTUtil.isRTL(),orientation:"bottom right",todayHighlight:!0});
});
</script>
@endsection