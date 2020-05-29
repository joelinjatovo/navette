@extends('layouts.customer')

@section('style')
@endsection

@section('content')
    <div class='row'>
    @foreach($cart->items as $item)
        @if($item->type == 'back')
            <div class="col-md-6">
                <!--begin::List Widget 9-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="font-weight-bolder text-dark">Drop Off</span>
                        </h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <div class="timeline timeline-5 mt-3">

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Badge-->
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-success icon-xxl"></i>
                                </div>
                                <!--end::Badge-->

                                <!--begin::Desc-->
                                <div class="timeline-content font-weight-bolder text-dark-75">
                                    {{ $item->point->name }}
                                </div>
                                <!--end::Desc-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Desc-->
                                <div class="timeline-content text-dark-75 ml-10">
                                    {{ $item->distance }}
                                </div>
                                <!--end::Desc-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Badge-->
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-danger icon-xxl"></i>
                                </div>
                                <!--end::Badge-->

                                <!--begin::Content-->
                                <div class="timeline-content text-dark-50">{{ $cart->club->name }}</div>
                                <!--end::Content-->
                            </div>
                            <!--end::Item-->

                        </div>
                        <!--end: Items-->
                    </div>
                    <!--end: Card Body-->
                    <div class="card-footer">
                        <a href="{{ route('shop.checkout') }}" class="btn btn-primary">Valider</a>
                    </div>
                </div>
                <!--end: Card-->
                <!--end: List Widget 9-->
            </div>
            <div class="col-md-6 mb-5">
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Point de récupération (club)</h5>
                      <i class="fas fa-street-view"></i>
                    </div>
                    <small>{{ $cart->club->name }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Destination (point de retour )</h5>
                      <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <small>{{ $item->point->name }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Nombre de place reservé(s)</h5>
                      <i class="fas fa-users"></i>
                    </div>
                    <small>{{ $cart->place }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Date & Heure</h5>
                      <i class="far fa-calendar-alt"></i>
                    </div>
                    <small>{{ date("l j F Y - H:i", strtotime($cart->items[1]->ride_at)) }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Distance</h5>
                      <i class="fas fa-road"></i>
                    </div>
                    <small>{{ $item->distance }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Durée (estimation)</h5>
                      <i class="fas fa-stopwatch"></i>
                    </div>
                    <small>{{ $cart->items[1]->duration }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Total à payer</h5>
                      <i class="fas fa-euro-sign"></i>
                    </div>
                    <p class="font-weight-bolder">{{ $cart->total }}&nbsp;{{ $cart->currency }}</p>
                  </a>
                </div>

            </div>
        @else
            <div class="col-md-6">
                <!--begin::List Widget 9-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="font-weight-bolder text-dark">Pickup</span>
                        </h3>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <div class="timeline timeline-5 mt-3">

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Badge-->
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-danger icon-xxl"></i>
                                </div>
                                <!--end::Badge-->

                                <!--begin::Content-->
                                <div class="timeline-content text-dark-50">{{ $cart->club->name }}</div>
                                <!--end::Content-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Desc-->
                                <div class="timeline-content text-dark-75 ml-10">
                                    {{ $item->distance }}
                                </div>
                                <!--end::Desc-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="timeline-item align-items-start">
                                <!--begin::Label-->
                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"></div>
                                <!--end::Label-->

                                <!--begin::Badge-->
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-success icon-xxl"></i>
                                </div>
                                <!--end::Badge-->

                                <!--begin::Desc-->
                                <div class="timeline-content font-weight-bolder text-dark-75">
                                    {{ $item->point->name }}
                                </div>
                                <!--end::Desc-->
                            </div>
                            <!--end::Item-->

                        </div>
                        <!--end: Items-->
                    </div>
                    <!--end: Card Body-->
                     <div class="card-footer">
                        <a href="{{ route('shop.checkout') }}" class="btn btn-primary">Valider</a>
                    </div>
                </div>
                <!--end: Card-->
                <!--end: List Widget 9-->
            </div>
            <div class="col-md-6 mb-5">
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Point de récupération</h5>
                      <i class="fas fa-street-view"></i>
                    </div>
                    <small>{{ $item->point->name }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Destination (club)</h5>
                      <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <small>{{ $cart->club->name }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Nombre de place reservé(s)</h5>
                      <i class="fas fa-users"></i>
                    </div>
                    <small>{{ $cart->place }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Date & Heure</h5>
                      <i class="far fa-calendar-alt"></i>
                    </div>
                    <small>{{ date("l j F Y - H:i", strtotime($cart->items[0]->ride_at)) }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Distance</h5>
                      <i class="fas fa-road"></i>
                    </div>
                    <small>{{ $item->distance }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Durée (estimation)</h5>
                      <i class="fas fa-stopwatch"></i>
                    </div>
                    <small>{{ $cart->items[0]->duration }}</small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Total à payer</h5>
                      <i class="fas fa-euro-sign"></i>
                    </div>
                    <p class="font-weight-bolder">{{ $cart->total }}&nbsp;{{ $cart->currency }}</p>
                  </a>
                </div>

            </div>
            <hr>
        @endif
    @endforeach
    </div>

@endsection

@section('javascript')
@endsection
