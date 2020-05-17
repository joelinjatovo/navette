@extends('layouts.customer')

@section('style')
@endsection

@section('content')

    @foreach($cart->items as $item)
        @if($item->type == 'back')
            <div class="col-lg-12 col-xxl-12">
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
                </div>
                <!--end: Card-->
                <!--end: List Widget 9-->
            </div>
        @else
            <div class="col-lg-12 col-xxl-12">
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
                </div>
                <!--end: Card-->
                <!--end: List Widget 9-->
            </div>
        @endif
    @endforeach

    <div class="col-lg-12 col-xxl-12">
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="{{ route('shop.checkout') }}" class="btn btn-primary">Valider</a>
            </div>
            <!--end::Footer-->
        </div>
    </div>

@endsection

@section('javascript')
@endsection
