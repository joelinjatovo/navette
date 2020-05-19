@extends('layouts.admin')

@section('title'){{ __('messages.form.car.view') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.form.car.view') }}</h5>
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
            <a href="{{ route('admin.cars') }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-2"><i class="la la-arrow-left"></i> {{ __('messages.button.back') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.car.create') }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-plus"></i> {{ __('messages.car.create') }}</a>
            <!--end::Button-->
            
            <!--begin::Button-->
            <a href="{{ route('admin.car.edit', $model) }}" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2"><i class="la la-edit"></i> {{ __('messages.car.edit') }}</a>
            <!--end::Button-->
                            
        </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <!--begin::Details-->
                <div class="d-flex mb-9">
                    <!--begin: Pic-->
                    <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                        <div class="symbol symbol-50 symbol-lg-120">
                            <img src="{{ $model->image ? asset($model->image->url) : asset('img/image_placeholder.jpg') }}" alt="image">
                        </div>
                        <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                            <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                        </div>
                    </div>
                    <!--end::Pic-->

                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between flex-wrap mt-1">
                            <div class="d-flex mr-3">
                                <a href="#" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $model->name }}</a>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
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
                                <th style="min-width: 250px" class="pl-7"><span class="text-dark-75">{{ __('messages.users') }}</span></th>
                                <th style="min-width: 130px">{{ __('messages.price') }}</th>
                                <th style="min-width: 120px">{{ __('messages.status') }}</th>
                                <th style="min-width: 120px">{{ __('messages.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="pl-0 py-8">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                            <div class="symbol-label" style="background-image: url('{{ $order->user && $order->user->image ? asset($order->user->image->url) : asset('img/avatar.png') }}')"></div>
                                        </div>
                                        <div>
                                            <a href="{{ $order->user ? route('admin.user.show', $order->user) : '#' }}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $order->user ? $order->user->name : '' }}</a>
                                            <span class="text-muted font-weight-bold d-block">{{ $order->user ? $order->user->role() : '' }}</span>
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
                                <td>
                                    <span class="label label-lg label-light-primary label-inline">{{ $order->created_at->diffForHumans() }}</span>
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
</div>
@endsection
