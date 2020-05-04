@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-rose card-header-text">
          <div class="card-text">
            <h4 class="card-title">{{ __('messages.order.create') }}</h4>
          </div>
        </div>
        <div class="card-body ">
          <form id="main-form" method="post" action="{{ url()->current() }}" class="form-horizontal">
            @csrf
            <div class="row">
              <label class="col-sm-2 col-form-label">{{ __('messages.name') }}</label>
              <div class="col-sm-10">
                <div class="form-group has-success bmd-form-group">
                  <input type="text" name="order[name]" class="form-control" value="{{ old('order.name') }}">
                  <!--<span class="form-control-feedback">
                    <i class="material-icons">done</i>
                  </span>-->
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
