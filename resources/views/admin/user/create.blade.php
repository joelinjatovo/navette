@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{ __('messages.user.create') }}</h4>
          </div>
        </div>
        <div class="card-body ">
          <form id="main-form" method="post" action="{{ url()->current() }}" class="form-horizontal">
            @csrf
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.name') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="user[name]" class="form-control" value="{{ old('user.name') }}">
                  <!--<span class="form-control-feedback">
                    <i class="material-icons">done</i>
                  </span>-->
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.phone') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-danger bmd-form-group">
                  <input type="text" name="user[phone]" class="form-control" value="{{ old('user.phone') }}">
                  <!--<span class="form-control-feedback">
                    <i class="material-icons">clear</i>
                  </span>-->
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.email') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-danger bmd-form-group">
                  <input type="email" name="user[email]" class="form-control" value="{{ old('user.email') }}">
                  <!--<span class="form-control-feedback">
                    <i class="material-icons">clear</i>
                  </span>-->
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 col-form-label label-checkbox">{{ __('messages.roles') }}</label>
              <div class="col-sm-4 col-sm-offset-1 checkbox-radios">
                <div class="form-check disabled">
                  <label class="form-check-label">
                    <input type="hidden" value="0" name="user[roles][customer]">
                    <input class="form-check-input" type="checkbox" value="1" name="user[roles][customer]" disabled="" checked=""> {{ __('messages.customer') }}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="hidden" value="0" name="user[roles][driver]">
                    <input class="form-check-input" type="checkbox" value="1" name="user[roles][driver]"> {{ __('messages.driver') }}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="hidden" value="0" name="user[roles][admin]">
                    <input class="form-check-input" type="checkbox" value="1" name="user[roles][admin]"> {{ __('messages.admin') }}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card-footer ">
            <button type="submit" form="main-form" class="btn btn-fill btn-rose">{{ __('messages.button.save') }}<div class="ripple-container"></div></button>
        </div>
      </div>
    </div>
</div>
@endsection
