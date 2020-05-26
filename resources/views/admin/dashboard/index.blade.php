@extends('layouts.admin')

@section('title'){{ __('messages.dashboard') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('messages.dashboard') }}</h5>
            <!--end::Page Title-->
        </div>
        <!--end::Info-->
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label font-weight-bolder text-dark">Commandes recentes</span>
					<span class="text-muted mt-3 font-weight-bold font-size-sm">{{ trans_choice('messages.count.orders', $count['orders'], ['value' => $count['orders']]) }}</span>
				</h3>
			</div>
            <!--begin::Body-->
            <div class="card-body">
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style=""><table class="datatable-table" style="display: block;">
                    <thead class="datatable-head">
                        <tr class="datatable-row" style="left: 0px;">
                            <th data-field="RecordID" class="datatable-cell-left datatable-cell datatable-cell-sort datatable-cell-sorted" data-sort="asc"><span style="width: 40px;">#</span></th>
                            <th data-field="{{ __('messages.clubs') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('messages.clubs') }}</span></th>
                            <th data-field="{{ __('messages.users') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('messages.users') }}</span></th>
                            <th data-field="{{ __('messages.date') }}" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('messages.date') }}</span></th>
                            <th data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 150px;">{{ __('messages.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="">
                        @foreach ($orders as $model)
                        <tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
                            <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
                                <span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
                            </td>
                            <td data-field="{{ __('messages.clubs') }}" aria-label="" class="datatable-cell">
                                <span style="width: 250px;">
									<x-club :model="$model->club" />
                                </span>
                            </td>
                            <td data-field="{{ __('messages.users') }}" aria-label="" class="datatable-cell">
                                <span style="width: 250px;">
									<x-user :model="$model->user" />
                                </span>
                            </td>
                            <td data-field="{{ __('Date') }}" aria-label="{{ $model->created_at }}" class="datatable-cell">
                                <span style="width: 130px;">
                                    <div class="text-primary mb-0">{{ $model->created_at->diffForHumans() }}</div>
									<x-status theme="light" :status="$model->status" />
                                </span>
                            </td>
                            <td data-field="{{ __('Actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative; width: 150px;">
                                    <a href="{{ route('admin.order.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.view.order') }}"
									   title="{{ __('messages.view.order') }}">
                                        <i class="la la-eye"></i>
                                    </a>
									@if($model->cancelable())
									<a href="#" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 btn-order-action" 
									   data-action="cancel"
									   data-id="{{ $model->getKey() }}"
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.cancel.order') }}"
									   title="{{ __('messages.cancel.order') }}">
										<i class="la la-close"></i>
									</a>
									@endif
                                    <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete"  
									   data-id="{{ $model->getKey() }}"
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.delete.order') }}"
									   title="{{ __('messages.delete.order') }}" >
                                        <i class="la la-trash"></i>
                                    </a>	                    
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <!--end: Datatable-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '.btn-order-action', function() {
		var $this = $(this);
		swal.fire({
			title:"{{ __('messages.swal.action.title') }}",
			text:"{{ __('messages.swal.action.content') }}",
			type:"warning",
			showCancelButton:!0,
			confirmButtonText:"{{ __('messages.swal.action.confirm') }}",
			cancelButtonText:"{{ __('messages.swal.action.cancel') }}"
		}).then(function(e){
			if(e.value){
				KTApp.blockPage();
				axios.put("{{ route('admin.orders') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
					.then(res => {
						KTApp.unblockPage();
						var type = "danger";
						if (res.data.status === "success"){
							type = "success";
						}
						$.notify({icon:"add_alert", message:res.data.message}, {type:type});
					}).catch(err => {
						KTApp.unblockPage();
						$.notify({icon:"add_alert", message:"{{ __('messages.swal.error') }}"}, {type:"danger"});
					})
			}
		})
	});
});
</script>
@endsection