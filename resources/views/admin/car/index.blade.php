@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">{{ __('messages.cars.list') }}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>{{ __('messages.cars') }}</th>
                  <th>{{ __('messages.models') }}</th>
                  <th>{{ __('messages.place') }}</th>
                  <th>{{ __('messages.drivers') }}</th>
                  <th>{{ __('messages.clubs') }}</th>
                  <th class="text-right">{{ __('messages.actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($models as $model)
                <tr>
                  <td> <a href="{{ route('admin.car.show',  $model ) }}">{{ $model->name }}</a></td>
                  <td>{{ $model->model ? $model->model->name : '' }}</td>
                  <td>{{ trans_choice('messages.count.places', $model->place, ['value' => $model->place]) }}</td>
                  <td>{{ $model->driver ? $model->driver->name : '' }}</td>
                  <td>{{ $model->club ? $model->club->name : '' }}</td>
                  <td class="td-actions text-right">
                    <a href="{{ route('admin.car.show',  $model ) }}" rel="tooltip" class="btn btn-info btn-link" data-original-title="{{ __('messages.title.show.driver') }}" title="{{ __('messages.title.show.driver') }}">
                      <i class="material-icons">person</i>
                    </a>
                    <a href="{{ route('admin.car.edit', $model ) }}" rel="tooltip" class="btn btn-success btn-link" data-original-title="{{ __('messages.title.edit.car') }}" title="{{ __('messages.title.edit.car') }}">
                      <i class="material-icons">edit</i>
                    </a>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-link btn-delete" data-id="{{ $model->getKey() }}" data-original-title="{{ __('messages.title.remove.car') }}" title="{{ __('messages.title.remove.car') }}">
                      <i class="material-icons">close</i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
            {{ $models->links() }}
        </div>
      </div>
    </div>
</div>
@endsection

@section('javascript')
    @parent
    @include('inc.admin.btn-delete', ['path' => '/admin/car/'])
@endsection
