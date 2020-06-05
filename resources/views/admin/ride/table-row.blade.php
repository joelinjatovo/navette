<tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
	<td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
		<span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
	</td>
	<td data-field="{{ __('messages.clubs') }}" aria-label="" class="datatable-cell">
		<span style="width: 200px;">
			<x-club :model="$model->club" />
		</span>
	</td>
	<td data-field="{{ __('messages.drivers') }}" aria-label="" class="datatable-cell">
		<span style="width: 250px;">
			<x-user :model="$model->driver" />
		</span>
	</td>
	<td data-field="{{ __('messages.dates') }}" aria-label="{{ $model->created_at }}" class="datatable-cell">
		<span style="width: 130px;">
			<div class="text-primary mb-0">{{ $model->created_at->diffForHumans() }}</div>
			<x-status theme="light" :status="$model->status" />
		</span>
	</td>
	<td data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
		<span style="overflow: visible; position: relative; width: 200px;">
			<a href="{{ route('admin.ride.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.view.ride') }}"
			   title="{{ __('messages.view.ride') }}" >
				<i class="la la-eye"></i>
			</a>
			<a href="{{ route('admin.ride.live', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2"
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.view.map.ride') }}"
			   title="{{ __('messages.view.map.ride') }}" >
				<i class="la la-map"></i>
			</a>
			@if($model->isCancelable())
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action"
			   data-action="cancel"
			   data-id="{{ $model->getKey() }}" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.cancel.ride') }}"
			   title="{{ __('messages.cancel.ride') }}" >
				<i class="la la-close"></i>
			</a>
			@endif
			@if($model->isStartable())
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action" 
			   data-action="start" 
			   data-id="{{ $model->getKey() }}" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.start.ride') }}"
			   title="{{ __('messages.start.ride') }}" >
				<i class="la la-play-circle-o"></i>
			</a>
			@endif
			@if($model->isCompletable())
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary mr-2 btn-ride-action"
			   data-action="complete" 
			   data-id="{{ $model->getKey() }}" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.complete.ride') }}"
			   title="{{ __('messages.complete.ride') }}" >
				<i class="la la-check"></i>
			</a>
			@endif
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete" 
			   data-id="{{ $model->getKey() }}"
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.delete.ride') }}"
			   title="{{ __('messages.delete.ride') }}" >
				<i class="la la-trash"></i>
			</a>	                    
		</span>
	</td>
</tr>