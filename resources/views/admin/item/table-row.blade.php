<tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
	<td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
		<span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
	</td>
	<td data-field="{{ __('messages.points') }}" aria-label="" class="datatable-cell">
		<span style="width: 250px;">
			@if($model->point)
			<div class="d-flex align-items-center">
				<div class="ml-4">
					<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ $model->point->name }}</div>
					<div class="text-muted">{{ $model->type }}</div>
				</div>
			</div>
			@endif
		</span>
	</td>
	<td data-field="{{ __('messages.users') }}" aria-label="" class="datatable-cell">
		<span style="width: 250px;">
			@if($model->order)
				<x-user :model="$model->order->user" />
			@else
				<x-user />
			@endif
		</span>
	</td>
	<td data-field="{{ __('messages.dates') }}" aria-label="{{ $model->created_at }}" class="datatable-cell">
		<span style="width: 130px;">
			<div class="text-primary mb-0">{{ $model->created_at->diffForHumans() }}</div>
			<x-status theme="light" :status="$model->status" />
		</span>
	</td>
	<td data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
		<span style="overflow: visible; position: relative; width: 130px;">	                        
			<a href="{{ route('admin.item.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.view.item') }}"
			   title="{{ __('messages.cancel.item') }}" 
			   title="{{ __('messages.button.view') }}">
				<i class="la la-eye"></i>
			</a>
			@if($model->isCancelable())
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 btn-item-action" 
			   data-action="cancel" 
			   data-id="{{ $model->getKey() }}" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.cancel.item') }}"
			   title="{{ __('messages.cancel.item') }}" >
				<i class="la la-close"></i>
			</a>
			@endif
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete" 
			   data-id="{{ $model->getKey() }}" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.delete.item') }}"
			   title="{{ __('messages.delete.item') }}" >
				<i class="la la-trash"></i>
			</a>	                    
		</span>
	</td>
</tr>