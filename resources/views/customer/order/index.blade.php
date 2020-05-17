@extends('layouts.customer')

@section('title'){{ __('Mes Commandes') }}@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        {{ __('Mes Commandes') }}
                        <span class="d-block text-muted pt-2 font-size-sm">{{ __('Voici la liste de toutes vos commandes') }}</span>
                    </h3>
                </div>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body">
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style=""><table class="datatable-table" style="display: block;">
                    <thead class="datatable-head">
                        <tr class="datatable-row" style="left: 0px;">
                            <th data-field="RecordID" class="datatable-cell-left datatable-cell datatable-cell-sort datatable-cell-sorted" data-sort="asc"><span style="width: 40px;">#</span></th>
                            <th data-field="{{ __('Club') }}" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('Club') }}</span></th>
                            <th data-field="{{ __('Point') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('Point') }}</span></th>
                            <th data-field="{{ __('Chauffeur') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('Chauffeur') }}</span></th>
                            <th data-field="{{ __('Date') }}" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('Date') }}</span></th>
                            <th data-field="Status" class="datatable-cell datatable-cell-sort" style="display: none;"><span style="width: 130px;">Status</span></th>
                            <th data-field="{{ __('Actions') }}" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('Actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="">
                        @foreach ($models as $model)
                        <tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
                            <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
                                <span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
                            </td>
                            <td data-field="{{ __('Club') }}" aria-label="Cassin, Krajcik and Nicolas" class="datatable-cell">
                                <span style="width: 130px;">
                                    <div class="font-weight-bold text-muted">{{ $model->club->name }}</div>
                                </span>
                            </td>
                            <td data-field="{{ __('Point') }}" aria-label="Czech Republic" class="datatable-cell">
                                <span style="width: 250px;">
                                    <div class="font-weight-bolder font-size-lg mb-0">{{ $model->items ? $model->items[0]->point->name : '' }}</div>
                                    <div class="font-weight-bold text-muted">{{ trans_choice('messages.count.places', $model->place, ['value' => $model->place]) }}</div>
                                </span>
                            </td>
                            <td data-field="{{ __('Chauffeur') }}" aria-label="61957-1072" class="datatable-cell">
                                <span style="width: 250px;">
                                    @if($model->car)
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-success flex-shrink-0">
                                            <span class="symbol-label font-size-h4 font-weight-bold">U</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ $model->car->driver->name }}</div>
                                            <a href="#" class="text-muted font-weight-bold text-hover-primary">{{ $model->car->driver->phone     }}</a>
                                        </div>
                                    </div>
                                    @endif
                                </span>
                            </td>
                            <td data-field="{{ __('Date') }}" aria-label="6/29/2017" class="datatable-cell">
                                <span style="width: 130px;">
                                    <div class="font-weight-bolder text-primary mb-0">{{ $model->created_at }}</div>
                                    <div class="text-muted">{{ currency_format($model->total, $model->currency) }} {{ $model->status }}</div>
                                </span>
                            </td>
                            <td data-field="Status" aria-label="4" class="datatable-cell" style="display: none;">
                                <span style="width: 130px;">
                                    <span class="label label-lg font-weight-bold  label-light-success label-inline">Success</span>
                                </span>
                            </td>
                            <td data-field="{{ __('Actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative; width: 130px;">	                        
                                    <a href="{{ route('customer.order.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon btn-delete"  data-id="{{ $model->getKey() }}" title="Delete" >
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                        </span>
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

@section('javascript')
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            swal.fire({
                title:"Vous êtes sûre?",
                text:"Vous ne pourez pas revenir en arrière après!",
                type:"warning",
                showCancelButton:!0,
                confirmButtonText:"Oui, supprimez la!",
                cancelButtonText:"Annuler"
            }).then(function(e){
                if(e.value){
                    KTApp.blockPage();
                    axios.delete('/customer/order/' + $this.attr('data-id'))
                        .then(res => {
                            KTApp.unblockPage();
                            if (res.data.status === "success"){
                                $this.closest('tr').remove();
                            }
                            $.notify({icon:"add_alert", message:res.data.message}, {type:res.data.status});
                        }).catch(err => {
                            KTApp.unblockPage();
                            $.notify({icon:"add_alert", message:"Une erreur s'est produite."}, {type:"danger"});
                        })
                }
            })
        });
    });
</script>
@endsection
