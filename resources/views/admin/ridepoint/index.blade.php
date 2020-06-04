@extends('layouts.admin')

@section('title'){{ __('messages.rideitems.list') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.rideitems.list') }}</h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::Search Form-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">{{ trans_choice('messages.count.total', $models->total(), ['value' => $models->total()]) }}</span>
                <x-search/>
            </div>
            <!--end::Search Form-->
        </div>
        <!--end::Details-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style=""><table class="datatable-table" style="display: block;">
                    <thead class="datatable-head">
                        <tr class="datatable-row" style="left: 0px;">
                            <th data-field="{{ __('messages.point') }}" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">{{ __('messages.points') }}</span></th>
                            <th data-field="{{ __('messages.status') }}" class="datatable-cell datatable-cell-sort"><span style="width: 70px;">{{ __('messages.status') }}</span></th>
                            <th data-field="{{ __('messages.distance') }}" class="datatable-cell datatable-cell-sort"><span style="width: 100px;">{{ __('messages.distance') }}</span></th>
                            <th data-field="{{ __('messages.users') }}" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">{{ __('messages.users') }}</span></th>
                            <th data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('messages.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="">
                        @foreach ($models as $model)
                        <tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
                            <td data-field="{{ __('messages.point') }}" aria-label="" class="datatable-cell">
                                <span style="width: 200px;">
									@if($model->point)
                                    	<div class="text-primary mb-0">{{ $model->point->name }}</div>
									@endif
                                </span>
                            </td>
                            <td data-field="{{ __('messages.status') }}" aria-label="" class="datatable-cell">
                                <span style="width: 70px;">
                                    <div class="text-primary mb-0">{{ $model->type }}</div>
                                    <x-status theme="light" :status="$model->status" />
                                </span>
                            </td>
                            <td data-field="{{ __('messages.distance') }}" aria-label="" class="datatable-cell">
                                <span style="width: 100px;">
                                    <div class="text-primary mb-0">{{ $model->distance }}</div>
                                    <div class="text-primary mb-0">{{ $model->duration }}</div>
                                </span>
                            </td>
                            <td data-field="{{ __('messages.users') }}" aria-label="" class="datatable-cell">
                                <span style="width: 200px;">
									@if($model->point)
										<x-user :model="$model->point->user" />
									@endif
                                </span>
                            </td>
                            <td data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative; width: 130px;">
                                    <a href="{{ route('admin.rideitem.show', $model) }}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.view.rideitem') }}"
									   title="{{ __('messages.view.rideitem') }}" >
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete"  
									   data-id="{{ $model->getKey() }}" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.delete.rideitem') }}"
									   title="{{ __('messages.delete.rideitem') }}" >
                                        <i class="la la-trash"></i>
                                    </a>	                    
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div class="datatable-pager datatable-paging-loaded">
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
            <!--end::Body-->
            
            <!--begin::Footer-->
            <div class="card-footer">
                {{ $models->links() }}
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection