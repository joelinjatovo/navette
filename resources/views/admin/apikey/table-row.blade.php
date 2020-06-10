<tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
	<td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
		<span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
	</td>
	<td data-field="{{ __('messages.names') }}" aria-label="" class="datatable-cell">
		<span style="width: 100px;">
			<div class="d-flex flex-column">
				<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">
					{{ $model->name }}
					@if($model->revoked || (now() > $model->expires_at))
						<span class="label label-dot label-lg label-danger"></span>
					@endif
				</a>
				<span class="text-muted font-weight-bold font-size-sm">{{ $model->version }}</span>
			</div>
		</span>
	</td>
	<td data-field="{{ __('messages.user_agents') }}" aria-label="" class="datatable-cell">
		<span style="width: 100px;">{{ $model->user_agent }}</span>
	</td>
	<td data-field="{{ __('messages.expires') }}" aria-label="{{ $model->created_at }}" class="datatable-cell">
		<span style="width: 130px;">{{ $model->expires_at->format('m/d/Y') }}</span>
	</td>
	<td data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
		<span style="overflow: visible; position: relative; width: 130px;">	                        
			<a href="{{ route('admin.apikey.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="{{ __('messages.button.edit') }}">
				<i class="la la-eye"></i>
			</a>                   
			<a href="{{ route('admin.apikey.edit', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="{{ __('messages.button.edit') }}">
				<i class="la la-edit"></i>
			</a>
			<a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete"  data-id="{{ $model->getKey() }}" title="{{ __('messages.button.delete') }}" >
				<i class="la la-trash"></i>
			</a>	                    
		</span>
	</td>
</tr>