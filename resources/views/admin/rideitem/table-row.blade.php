<tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
	<td data-field="{{ __('messages.point') }}" aria-label="" class="datatable-cell">
		<span style="width: 200px;">
			@if($model->point())
				<div class="text-primary mb-0">{{ $model->point()->name }}</div>
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
			@if($model->user)
				<x-user :model="$model->user" />
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