@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-text card-header-rose">
          <div class="card-text">
            <h4 class="card-title">Regular Map</h4>
          </div>
        </div>
        <div class="card-body ">
          <h4 class="card-title"></h4>
          <div id="regularMap" class="map" style="position: relative; overflow: hidden;"></div>
        </div>
      </div>
    </div>
</div>
@endsection
