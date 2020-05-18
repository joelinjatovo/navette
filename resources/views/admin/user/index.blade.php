@extends('layouts.admin')

@section('title'){{ __('messages.users.list') }}@endsection

@section('subheader')
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
			
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                                    Users                            </h5>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->

            <!--begin::Search Form-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                                            450 Total                                    </span>
                                    <form class="ml-5">
                        <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                            <input type="text" class="form-control" id="kt_subheader_search_form" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span class="svg-icon"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
    </g>
</svg><!--end::Svg Icon--></span>                                    <!--<i class="flaticon2-search-1 icon-sm"></i>-->
                                </span>
                            </div>
                        </div>
                    </form>
                            </div>
            <!--end::Search Form-->

                            <!--begin::Group Actions-->
                <div class="d-flex- align-items-center flex-wrap mr-2 d-none" id="kt_subheader_group_actions">
                    <div class="text-dark-50 font-weight-bold">
                        <span id="kt_subheader_group_selected_rows">23</span> Selected:
                    </div>
                    <div class="d-flex ml-6">
                        <div class="dropdown mr-2" id="kt_subheader_group_actions_status_change">
                            <button type="button" class="btn btn-light-primary font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown">
                                Update Status
                            </button>
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-sm">
                                <ul class="navi navi-hover pt-3 pb-4">
                                    <li class="navi-header font-weight-bolder text-uppercase text-primary font-size-lg pb-0">
                                        Change status to:
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" data-toggle="status-change" data-status="1">
                                            <span class="navi-text"><span class="label label-light-success label-inline font-weight-bold">Approved</span></span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" data-toggle="status-change" data-status="2">
                                            <span class="navi-text"><span class="label label-light-danger label-inline font-weight-bold">Rejected</span></span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" data-toggle="status-change" data-status="3">
                                            <span class="navi-text"><span class="label label-light-warning label-inline font-weight-bold">Pending</span></span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link" data-toggle="status-change" data-status="4">
                                            <span class="navi-text"><span class="label label-light-info label-inline font-weight-bold">On Hold</span></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button class="btn btn-light-success font-weight-bolder btn-sm mr-2" id="kt_subheader_group_actions_fetch" data-toggle="modal" data-target="#kt_datatable_records_fetch_modal">
                            Fetch Selected
                        </button>
                        <button class="btn btn-light-danger font-weight-bolder btn-sm mr-2" id="kt_subheader_group_actions_delete_all">
                            Delete All
                        </button>
                    </div>
                </div>
                <!--end::Group Actions-->
                    </div>
        <!--end::Details-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
                            <!--begin::Button-->
                <a href="/metronic/preview/demo1/.html" class="">
                    
                                    </a>
                <!--end::Button-->
            
                                                <!--begin::Button-->
                    <a href="/metronic/preview/demo1/custom/apps/user/add-user.html" class="btn btn-light-primary font-weight-bold btn-sm px-4 font-size-base ml-2">
                        
                        Add User                    </a>
                    <!--end::Button-->
                            
                            <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                    <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-success svg-icon-2x"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Files/File-plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"></polygon>
        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
        <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"></path>
    </g>
</svg><!--end::Svg Icon--></span>                    </a>
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                        <!--begin::Naviigation-->
<ul class="navi">
    <li class="navi-header font-weight-bold py-5">
        <span class="font-size-lg">Add New:</span>
        <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
    </li>
    <li class="navi-separator mb-3 opacity-70"></li>
    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="flaticon2-shopping-cart-1"></i></span>
            <span class="navi-text">Order</span>
        </a>
    </li>
    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="navi-icon flaticon2-calendar-8"></i></span>
            <span class="navi-text">Members</span>
            <span class="navi-label">
                <span class="label label-light-danger label-rounded font-weight-bold">3</span>
            </span>
        </a>
    </li>
    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="navi-icon flaticon2-telegram-logo"></i></span>
            <span class="navi-text">Project</span>
        </a>
    </li>
    <li class="navi-item">
        <a href="#" class="navi-link">
            <span class="navi-icon"><i class="navi-icon flaticon2-new-email"></i></span>
            <span class="navi-text">Record</span>
            <span class="navi-label">
                <span class="label label-light-success label-rounded font-weight-bold">5</span>
            </span>
        </a>
    </li>
    <li class="navi-separator mt-3 opacity-70"></li>
    <li class="navi-footer pt-5 pb-4">
        <a class="btn btn-light-primary font-weight-bolder btn-sm" href="#">More options</a>
        <a class="btn btn-clean font-weight-bold btn-sm d-none" href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more...">Learn more</a>
    </li>
</ul>
<!--end::Naviigation-->
                    </div>
                </div>
                <!--end::Dropdown-->
                    </div>
        <!--end::Toolbar-->
    </div>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        {{ __('messages.users') }}
                        <span class="d-block text-muted pt-2 font-size-sm">{{ __('Tous les utilisateurs') }}</span>
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
                            <th data-field="{{ __('messages.users') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('messages.users') }}</span></th>
                            <th data-field="{{ __('messages.email') }}" class="datatable-cell datatable-cell-sort"><span style="width: 250px;">{{ __('messages.email') }}</span></th>
                            <th data-field="{{ __('messages.date') }}" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('messages.date') }}</span></th>
                            <th data-field="{{ __('messages.actions') }}" data-autohide-disabled="false" class="datatable-cell datatable-cell-sort"><span style="width: 130px;">{{ __('messages.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="">
                        @foreach ($models as $model)
                        <tr data-row="0" class="datatable-row datatable-row-hover" style="left: 0px;">
                            <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="350">
                                <span style="width: 40px;"><span class="font-weight-bolder">{{ $model->id }}</span></span>
                            </td>
                            <td data-field="{{ __('messages.users') }}" aria-label="Czech Republic" class="datatable-cell">
                                <span style="width: 250px;">    
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-success flex-shrink-0">
                                            @if($model->image)
                                                <img class="" src="{{ asset($model->image->url) }}" alt="photo">
                                            @else
                                                <span class="symbol-label font-size-h4 font-weight-bold">U</span>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ $model->name }}</div>
                                            <a href="#" class="text-muted font-weight-bold text-hover-primary">{{ $model->phone }}</a>
                                        </div>
                                    </div>
                                </span>
                            </td>
                            <td data-field="{{ __('messages.email') }}" aria-label="61957-1072" class="datatable-cell">
                                <span style="width: 250px;">
                                    <div class="font-size-lg mb-0">{{ $model->email }}</div>
                                    <div class="text-muted">{{ $model->isAdmin() ? __('Administrator') : ( $model->isDriver() ? __('Driver') : __('Customer') ) }}</div>
                                </span>
                            </td>
                            <td data-field="{{ __('Date') }}" aria-label="6/29/2017" class="datatable-cell">
                                <span style="width: 130px;">
                                    <div class="font-weight-bolder text-primary mb-0">{{ $model->created_at }}</div>
                                    <div class="text-muted">{{ $model->status }}</div>
                                </span>
                            </td>
                            <td data-field="{{ __('Actions') }}" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative; width: 130px;">	                        
                                    <a href="{{ route('admin.user.show', $model)}}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">
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
                confirmButtonText:"Oui, supprimez le!",
                cancelButtonText:"Annuler"
            }).then(function(e){
                if(e.value){
                    KTApp.blockPage();
                    axios.delete('/admin/user/' + $this.attr('data-id'))
                        .then(res => {
                            KTApp.unblockPage();
                            var type = "danger";
                            if (res.data.status === "success"){
                                $this.closest('tr').remove();
                                type = "success";
                            }
                            $.notify({icon:"add_alert", message:res.data.message}, {type:type});
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
