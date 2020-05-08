@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">contacts</i>
          </div>
          <h4 class="card-title">{{ __('messages.user.create') }}</h4>
        </div>
        <div class="card-body ">

          <form id="main-form" method="post" action="{{ route('admin.user.store') }}" class="form-horizontal">
            @csrf
            <div class="form-group bmd-form-group">
              <label for="user-name" class="bmd-label-floating"> {{ __('messages.name') }} *</label>
              <input type="text" name="name" required="true" aria-required="true" aria-invalid="false" id="user-name" class="form-control" value="{{ old('user.name') }}">
            </div>
            <div class="form-group bmd-form-group">
              <label for="user-phone" class="bmd-label-floating"> {{ __('messages.phone') }} *</label>
              <input type="text" name="phone" required="true" aria-required="true" aria-invalid="false" id="user-phone" class="form-control" value="{{ old('user.phone') }}">
            </div>
            <div class="form-group bmd-form-group">
              <label for="user-email" class="bmd-label-floating"> {{ __('messages.email') }} *</label>
              <input type="email" name="email" required="true" aria-required="true" aria-invalid="false" id="user-email" class="form-control" value="{{ old('user.email') }}">
            </div>
            <div class="form-group bmd-form-group">
              <label for="user-password" class="bmd-label-floating"> {{ __('messages.password') }} *</label>
              <input type="password" name="password" required="true" aria-required="true" aria-invalid="false" id="user-password" class="form-control" value="{{ old('user.password') }}">
            </div>
            <div class="form-group bmd-form-group">
              <label class="form-label label-checkbox">{{ __('messages.roles') }}</label>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="3" id="r_customer" name="user_role" checked>
                <label class="custom-control-label" for="r_customer">{{ __('messages.customer') }}</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="2" id="r_driver" name="user_role">
                <label class="custom-control-label" for="r_driver">{{ __('messages.driver') }}</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="1" id="r_admin" name="user_role">
                <label class="custom-control-label" for="r_admin">{{ __('messages.admin') }}</label>
              </div>
            </div>
            <div class="form-group bmd-form-group">
              <button type="submit" class="btn btn-rose">{{ __('messages.button.save') }}<div class="ripple-container"></div></button>
              @isset($success)
                  <div class="alert w-25 alert-success alert-dismissible fade py-3 show" role="alert">
                    {{ $success }}
                    <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
              @endisset
              @isset($error)
                  <div class="alert w-25 alert-warning alert-dismissible fade py-3 show" role="alert">
                    {{ $error }}
                    <button type="button" class="close mt-2 " data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
              @endisset
            </div>
                  
                    

            </form>
          
          </div>
        </div>
    </div>
</div>
@endsection
