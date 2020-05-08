@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">@section('content.title'){{ __('messages.form.car.create') }}@show</h4>
          </div>
        </div>
        <div class="card-body ">
          <form id="main-form" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.image') }}</label>
              <div class="col-md-4 col-sm-4">
                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                      <img src="{{ $model->image ? asset($model->image->url) : '/img/image_placeholder.jpg'}}" alt="...">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                    <div>
                      <span class="btn btn-rose btn-round btn-file">
                        <span class="fileinput-new">{{ __('messages.form.image.select') }}</span>
                        <span class="fileinput-exists">{{ __('messages.button.change') }}</span>
                        <input type="file" name="car[image]">
                      </span>
                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.name') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="car[name]" class="form-control" value="{{ old('car.name', $model->name) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.year') }}</label>
              <div class="col-sm-4">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="car[year]" class="form-control" value="{{ old('car.year', $model->year) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.place') }}</label>
              <div class="col-sm-4">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="car[place]" class="form-control" value="{{ old('car.place', $model->place) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.club') }}</label>
              <div class="col-sm-4">
                <div class="form-group has-success bmd-form-group">
                    <select name="car[club]" class="form-control">
                        @foreach($clubs as $club)
                            <option value="{{ $club->getKey() }}" @if($club->getKey() == old('car.club', $model->club ? $model->club->getKey() : 0)) selected="selected" @endif>{{ $club->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.model') }}</label>
              <div class="col-sm-4">
                <div class="form-group has-success bmd-form-group">
                    <select name="car[model]" class="form-control">
                        @foreach($models as $carmodel)
                            <option value="{{ $carmodel->getKey() }}" @if($carmodel->getKey() == old('car.model', $model->model ? $model->model->getKey() : 0)) selected="selected" @endif>{{ $carmodel->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.form.car.driver') }}</label>
              <div class="col-sm-4">
                <div class="form-group has-success bmd-form-group">
                    <select name="car[driver]" class="form-control">
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->getKey() }}" @if($driver->getKey() == old('car.driver', $model->driver ? $model->driver->getKey() : 0)) selected="selected" @endif>{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
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
