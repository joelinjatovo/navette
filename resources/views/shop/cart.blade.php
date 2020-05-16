@extends('layouts.customer')

@section('style')
@endsection

@section('content')
<div class="col-lg-12 col-xxl-12">
    <!--begin::List Widget 9-->
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header align-items-center border-0 mt-4">
            <h3 class="card-title align-items-start flex-column">
                <span class="font-weight-bolder text-dark">Recent Activities</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">890,344 Sales</span>
            </h3>
            <div class="card-toolbar">
                <div class="dropdown dropdown-inline">
                    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ki ki-bold-more-ver"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <!--begin::Navigation-->
                        <ul class="navi navi-hover">
                            <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                            </li>
                            <li class="navi-separator mb-3 opacity-70"></li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-success">Customer</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-danger">Partner</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-primary">Member</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-dark">Staff</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-separator mt-3 opacity-70"></li>
                            <li class="navi-footer py-4">
                                <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                    <i class="ki ki-plus icon-sm"></i>
                                    Add new
                                </a>
                            </li>
                        </ul>
                        <!--end::Navigation-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body pt-4">
            <div class="timeline timeline-5 mt-3">
                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">08:42</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-success icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Text-->
                    <div class="timeline-content text-dark-50">
                        Outlines of the recent activities that happened last weekend
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">3 hr</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-danger icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Content-->
                    <div class="timeline-content text-dark-50">
                        Outlines of the recent activities that happened last weekend
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">14:37</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-info icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Desc-->
                    <div class="timeline-content font-weight-bolder text-dark-75">
                        Submit initial budget -
                        <a href="#" class="text-primary">USD 700</a>.
                    </div>
                    <!--end::Desc-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">16:50</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-danger icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Text-->
                    <div class="timeline-content text-dark-50">
                        Stakeholder meeting scheduling.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">17:30</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-success icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Text-->
                    <div class="timeline-content text-dark-50">
                        Project scoping &amp; estimations with stakeholders.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">21:03</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-warning icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Desc-->
                    <div class="timeline-content font-weight-bolder text-dark-75">
                        New order placed <a href="#" class="text-primary">#XF-2356</a>.
                    </div>
                    <!--end::Desc-->
                </div>
                <!--end::Item-->

                <!--begin: Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">21:07</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-danger icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Text-->
                    <div class="timeline-content text-dark-50">
                        Company BBQ to celebrate the last quater achievements and goals.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end: Item-->

                <!--begin::Item-->
                <div class="timeline-item align-items-start">
                    <!--begin::Label-->
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">20:30</div>
                    <!--end::Label-->

                    <!--begin::Badge-->
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-info icon-xxl"></i>
                    </div>
                    <!--end::Badge-->

                    <!--begin::Text-->
                    <div class="timeline-content text-dark-50">
                        Marketing campaign planning with customer.
                    </div>
                    <!--end::Text-->
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
@endsection

@section('javascript')
@endsection
