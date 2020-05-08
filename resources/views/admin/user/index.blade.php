@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">{{ __('messages.users.list') }}</h4>
        </div>
        <div class="card-body">
          @isset($success_delete)
              <div class="alert w-50 alert-success alert-dismissible fade py-3 show" role="alert">
                {{ $success_delete }}
                <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          @endisset
          @isset($error_delete)
              <div class="alert w-50 alert-warning alert-dismissible fade py-3 show" role="alert">
                {{ $error_delete }}
                <button type="button" class="close mt-2 " data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          @endisset
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>{{ __('messages.name') }}</th>
                  <th>{{ __('messages.phone') }}</th>
                  <th>{{ __('messages.date') }}</th>
                  <th class="text-right">{{ __('messages.role') }}</th>
                  <th class="text-right">{{ __('messages.actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($models as $user)
                <tr>
                  <td class="text-center">{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->phone }}</td>
                  <td>{{ $user->created_at }}</td>
                  <td class="text-right">-</td>
                  <td class="td-actions text-right">
                    <button type="button" rel="tooltip" data-toggle="modal" data-target="#modal-edit-user"class="btn btn-success btn-link user-edit" data-original-title="" title="" data-id="{{ $user->id }}">
                      <i class="material-icons">edit</i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-link user-delete" data-id="{{ $user->id }}" data-original-title="" title="">
                      <i class="material-icons">close</i>
                    </button>
                  </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="edit-modal-content">
      <img src="{{ asset('img/loader.gif') }}" style="width: 200px;margin: auto;">  
    </div>
  </div>
</div>
@endsection
