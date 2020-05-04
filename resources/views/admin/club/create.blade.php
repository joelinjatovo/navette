@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">@section('content.title'){{ __('messages.form.club.create') }}@show</h4>
          </div>
        </div>
        <div class="card-body ">
          <form id="main-form" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.club.image') }}</label>
              <div class="col-md-4 col-sm-4">
                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                      <img src="{{ $model->image ? url($model->image->url) : '/img/image_placeholder.jpg'}}" alt="...">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                    <div>
                      <span class="btn btn-rose btn-round btn-file">
                        <span class="fileinput-new">{{ __('messages.form.image.select') }}</span>
                        <span class="fileinput-exists">{{ __('messages.button.change') }}</span>
                        <input type="file" name="club[image]">
                      </span>
                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.club.name') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="club[name]" class="form-control" value="{{ old('club.name', $model->name) }}">
                  <!--<span class="form-control-feedback">
                    <i class="material-icons">done</i>
                  </span>-->
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.club.location') }}</label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group bmd-form-group">
                        <input type="text" class="form-control" placeholder="{{ __('messages.form.placeholder.lat') }}" id="point-lat" name="point[lat]" value="{{ old('point.lat', $model->point ? $model->point->lat : '') }}"/>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group bmd-form-group">
                        <input type="text" class="form-control" placeholder="{{ __('messages.form.placeholder.lng') }}" id="point-lng" name="point[lng]" value="{{ old('point.lng', $model->point ? $model->point->lng : '') }}"/>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group bmd-form-group">
                        <input type="text" class="form-control" placeholder="{{ __('messages.form.placeholder.alt') }}" id="point-alt" name="point[alt]" value="{{ old('point.alt', $model->point ? $model->point->alt : '') }}"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div id="regularMap" class="map" style="position: relative; overflow: hidden;"></div>
                </div>
            </div>
          </form>
        </div>
        <div class="card-footer ">
            <button type="submit" form="main-form" class="btn btn-fill btn-rose">@if($model->id>0){{ __('messages.button.update') }}@else{{ __('messages.button.save') }}@endif<div class="ripple-container"></div></button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('javascript')
  @parent
  <script>
    $(document).ready(function() {
      demo.initSmallGoogleMaps();
    });
  </script>
@endsection
