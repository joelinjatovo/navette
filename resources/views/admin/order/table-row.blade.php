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
	<td data-field="{{ __('messages.dates') }}" aria-label="{{ $model->created_at }}" class="datatable-cell">
		<span style="width: 130px;">
			<div class="text-primary mb-0">{{ $model->created_at->diffForHumans() }}</div>
			<x-status theme="light" :status="$model->status" />
		</span>
	</td>
	<td data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
		<span style="overflow: visible; position: relative; width: 150px;">
			<a href="{{ route('admin.order.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" 
			   data-toggle="tooltip" 
			   data-placement="top" 
			   data-original-title="{{ __('messages.view.order') }}"
			   title="{{ __('messages.view.order') }}">
				<i class="la la-eye"></i>
			</a>
			@if($model->isCancelable())
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