@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">{{ __('messages.clubs.list') }}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-shopping">
              <thead>
                <tr>
                  <th class="text-center"></th>
                  <th>Product</th>
                  <th class="th-description">Color</th>
                  <th class="th-description">Size</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Amount</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($models as $model)
                <tr>
                  <td>
                    <div class="img-container"><img src="{{ $model->image ? url($model->image->url) : '/img/product1.jpg' }}" alt="..."></div>
                  </td>
                  <td class="td-name">
                    <a href="{{ route('admin.club.show', $model)}}">{{ $model->name }}</a>
                    <br>
                    <small>by Dolce&amp;Gabbana</small>
                  </td>
                  <td>Red</td>
                  <td>M</td>
                  <td class="td-number text-right"><small>€</small>549</td>
                  <td class="td-number"><small>€</small>549</td>
                  <td class="td-actions">
                    <button type="button" rel="tooltip" data-placement="left" title="" class="btn btn-link" data-original-title="Remove item">
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
@endsection
