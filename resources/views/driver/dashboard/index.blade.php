@extends('layouts.driver')

@section('title'){{ __('messages.rides.list') }}@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom">
			<div class="card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label font-weight-bolder text-dark">Dernières Courses</span>
					<span class="text-muted mt-3 font-weight-bold font-size-sm">{{ trans_choice('messages.count.rides', $count['rides'], ['value' => $count['rides']]) }}</span>
				</h3>
			</div>
            <!--begin::Body-->
            <div class="card-body">
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style=""><table class="datatable-table" style="display: block;">
                    <thead class="datatable-head">
                        <tr class="datatable-row" style="left: 0px;">
                            <th data-field="RecordID" class="datatable-cell-left datatable-cell datatable-cell-sort datatable-cell-sorted" data-sort="asc"><span style="width: 40px;">#</span></th>
                            <th data-field="{{ __('messages.cars') }}" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">{{ __('messages.cars') }}</span></th>
                            <th data-field="{{ __('messages.drivers') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('messages.drivers') }}</span></th>
                            <th data-field="{{ __('messages.date') }}" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('messages.date') }}</span></th>
                            <th data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 200px;">{{ __('messages.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="">
                        @foreach ($rides as $ride)
                        <tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
                            <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
                                <span style="width: 40px;"><span class="font-weight-bolder">{{ $ride->id }}</span></span>
                            </td>
                            <td data-field="{{ __('messages.cars') }}" aria-label="" class="datatable-cell">
                                <span style="width: 200px;">
									<x-car :model="$ride->car" />
                                </span>
                            </td>
                            <td data-field="{{ __('messages.drivers') }}" aria-label="" class="datatable-cell">
                                <span style="width: 250px;">
									<x-user :model="$ride->driver" />
                                </span>
                            </td>
                            <td data-field="{{ __('Date') }}" aria-label="{{ $ride->created_at }}" class="datatable-cell">
                                <span style="width: 130px;">
                                    <div class="text-primary mb-0">{{ $ride->created_at->diffForHumans() }}</div>
									<x-status theme="light" :status="$ride->status" />
                                </span>
                            </td>
                            <td data-field="{{ __('Actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative; width: 200px;">
                                    <a href="{{ route('driver.ride.show', $ride)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.view.ride') }}"
									   title="{{ __('messages.view.ride') }}" >
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="{{ route('driver.ride.live', $ride)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.view.map.ride') }}"
									   title="{{ __('messages.view.map.ride') }}" >
                                        <i class="la la-map"></i>
                                    </a>
									@if($ride->cancelable())
									<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action"
									   data-action="cancel"
									   data-id="{{ $ride->getKey() }}" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.cancel.ride') }}"
									   title="{{ __('messages.cancel.ride') }}" >
										<i class="la la-close"></i>
									</a>
									@endif
									@if($ride->activable())
									<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action" 
									   data-action="active" 
									   data-id="{{ $ride->getKey() }}" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.active.ride') }}"
									   title="{{ __('messages.active.ride') }}" >
										<i class="la la-play-circle-o"></i>
									</a>
									@endif
									@if($ride->completable())
									<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action"
									   data-action="complete" 
									   data-id="{{ $ride->getKey() }}" 
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.complete.ride') }}"
									   title="{{ __('messages.complete.ride') }}" >
										<i class="la la-check"></i>
									</a>
									@endif
                                    <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete" 
									   data-id="{{ $ride->getKey() }}"
									   data-toggle="tooltip" 
									   data-placement="top" 
									   data-original-title="{{ __('messages.delete.ride') }}"
									   title="{{ __('messages.delete.ride') }}" >
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
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '.btn-ride-action', function() {
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
				axios.put("{{ route('driver.rides') }}", {action:$this.attr('data-action'),id: $this.attr('data-id')})
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