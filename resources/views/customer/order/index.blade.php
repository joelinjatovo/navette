@extends('layouts.customer')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">{{ __('messages.orders.list') }}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-shopping">
              <thead>
                <tr>
                  <th class="text-center"></th>
                  <th>{{ __('messages.products') }}</th>
                  <th class="th-description">{{ __('messages.customers') }}</th>
                  <th class="th-description">{{ __('messages.type') }}</th>
                  <th class="text-right">{{ __('messages.place') }}</th>
                  <th class="text-right">{{ __('messages.amount') }}</th>
                  <th class="text-right">{{ __('messages.total') }}</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($models as $model)
                <tr>
                  <td>
                    <div class="img-container"><img src="{{ $model->car && $model->car->image ? asset($model->car->image->url) : '/img/product1.jpg' }}" alt="..."></div>
                  </td>
                  <td class="td-name">
                      @if($model->car)
                        <a href="{{ route('admin.car.show', $model->car)}}">{{ $model->car->name }}</a>
                      @elseif($model->club)
                        <a href="{{ route('admin.club.show', $model->club)}}">{{ $model->club->name }}</a>
                      @endif
                    <br>
                    @if($model->user)
                    <small>by Dolce&amp;Gabbana</small>
                    @endif
                  </td>
                  <td>Red</td>
                  <td>M</td>
                  <td class="td-number text-right">{{ trans_choice('messages.count.places', $model->place, ['value' => $model->place]) }}</td>
                  <td class="td-number text-right">{{ currency_format($model->amount, $model->currency) }}</td>
                  <td class="td-number">{{ currency_format($model->total, $model->currency) }}</td>
                  <td class="td-actions">
                    <button type="button" rel="tooltip" data-placement="left" title="" class="btn btn-link btn-delete" data-id="{{ $model->getKey() }}" data-original-title="Remove item">
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
    @include('inc.admin.btn-delete', ['path' => '/admin/order/'])
@endsection
