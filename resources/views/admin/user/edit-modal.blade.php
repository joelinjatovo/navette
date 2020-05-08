<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body px-0 py-0">
  <div class="card ">
        <div class="card-header card-header-rose card-header-icon">
          <h4 class="card-title">{{ __('messages.user.update') }}</h4>
        </div>
        <div class="card-body ">

          <form id="main-form" class="form-horizontal">
            @csrf
            <div class="form-group bmd-form-group">
              <label for="user-name" class="bmd-label-floating"> {{ __('messages.name') }} *</label>
              <input type="text" name="name" required="true" aria-required="true" aria-invalid="false" id="user-name" class="form-control" value="{{ $model->name }}">
            </div>
            <div class="form-group bmd-form-group">
              <label for="user-phone" class="bmd-label-floating"> {{ __('messages.phone') }} *</label>
              <input type="text" name="phone" required="true" aria-required="true" aria-invalid="false" id="user-phone" class="form-control" value="{{ $model->phone }}">
            </div>
            <div class="form-group bmd-form-group">
              <label for="user-email" class="bmd-label-floating"> {{ __('messages.email') }} *</label>
              <input type="email" name="email" required="true" aria-required="true" aria-invalid="false" id="user-email" class="form-control" value="{{ $model->email }}">
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
              <button type="button" data-id="{{ $model->id }}" id="update-user" class="btn btn-rose btn-sm"><i style="display:none;"  class="fas fa-spin fa-circle-notch"></i>&nbsp;{{ __('messages.button.update') }}<div class="ripple-container"></div></button>
            </div>
                

            </form>
          
          </div>
        </div>
</div>