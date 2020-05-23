<style>
.custom-dashboard-tabs a:not(.unavailable):hover,
.custom-dashboard-tabs a:not(.unavailable):hover{
    background: #1bc5bd!important;
}
.custom-dashboard-tabs li:hover span,
.custom-dashboard-tabs li:focus span,
.custom-dashboard-tabs li:hover i,
.custom-dashboard-tabs li:focus i{
    color: #fff!important;
}
.custom-dashboard-tabs .nav-link.active {
    background: #1bc5bd!important;
    webkit-box-shadow: 0 1rem 2rem 1rem rgba(0,0,0,.1)!important;
    box-shadow: 0 1rem 2rem 1rem rgba(0,0,0,.1)!important;
}
.custom-dashboard-tabs .nav-link.active i{
    color: #fff!important;
}
</style>
<!--begin::Nav Tabs-->
<ul class="dashboard-tabs custom-dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0" role="tablist">
    <!--begin::Item-->   
    @if (count($models) != 0)
        
        @foreach ($models as $car)
        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#tab_forms_widget_1">
                <i class="fas fa-4x fa-car"></i>
                <span class="nav-text font-size-lg py-2 font-weight-bold text-center">
                    {{ $car->name }}
                </span>
            </a>
        </li>
        @endforeach

    @else
        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0" style="background:#ccc;">
            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column unavailable align-items-center" data-toggle="pill" href="#tab_forms_widget_1">
                <i class="fas fa-4x fa-car"></i>
                <span class="nav-text font-size-lg py-2 font-weight-bold text-center">
                    aucune voiture disponible
                </span>
            </a>
        </li>
    @endif
    <!--end::Item-->
</ul>
<!--end::Nav Tabs-->