@extends('layouts.admin')

@section('title'){{ __('messages.user.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.user.view') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::User Name-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">{{ $model->name }}</span>
            </div>
            <!--end::User Name-->

        </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('admin.users') }}" class="btn btn-default font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.user.create') }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-plus"></i> {{ __('messages.user.create') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.user.edit', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-edit"></i> {{ __('messages.user.edit') }}</a>
            <!--end::Button-->
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<!--begin::Profile-->
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::User-->
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                        <div class="symbol-label" style="background-image:url('{{ $model->image ? asset($model->image->url) : asset('img/avatar.png') }}')"></div>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div>
                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                            {{ $model->name }}
                        </a>
                        <div class="text-muted">
                            {{ $model->role() }}
                        </div>
                        <div class="mt-2">
                            @if($model->phone)
                            <a href="tel:{{ $model->phone }}" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.call') }}</a>
                            @endif
                            @if($model->email)
                            <a href="mailto:{{ $model->email }}" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">{{ __('messages.button.contact') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::User-->

                <!--begin::Contact-->
                <div class="pt-8 pb-6">
                    @if($model->email)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.email') }}:</span>
                            <a href="mailto:{{ $model->email }}" class="text-muted text-hover-primary">{{ $model->email }}</a>
                        </div>
                    @endif
                    @if($model->phone)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold mr-2">{{ __('messages.phone') }}:</span>
                            <span class="text-muted">{{ $model->phone }}</span>
                        </div>
                    @endif
                </div>
                <!--end::Contact-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Aside-->
    
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Row-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">{{ __('messages.orders') }}</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">{{ trans_choice('messages.count.orders', $orders->total(), ['value' => $orders->total()]) }}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-head-custom table-head-bg table-vertical-center table-borderless">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th style="min-width: 250px" class="pl-7"><span class="text-dark-75">{{ __('messages.clubs') }}</span></th>
                                <th style="min-width: 130px">{{ __('messages.price') }}</th>
                                <th style="min-width: 120px">{{ __('messages.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="pl-0 py-8">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                            <div class="symbol-label" style="background-image: url('{{ $order->club && $order->club->image ? asset($order->club->image->url) : asset('img/image_placeholder.jpg') }}')"></div>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.order.show', $order) }}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $order->club ? $order->club->name : '' }}</a>
                                            <span class="text-muted font-weight-bold d-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        {{ $order->currency }} {{ $order->total }}
                                    </span>
                                    <span class="text-muted font-weight-bold">
                                        {{ $order->type }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-lg label-light-primary label-inline">{{ $order->status }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Content-->
</div>
<!--end::Profile-->
@endsection
