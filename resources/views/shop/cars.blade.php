
<!--begin::Nav Tabs-->
<ul class="dashboard-tabs custom-dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0" role="tablist" id="custom-list-cars">
    <!--begin::Item-->   
    @if (count($models) != 0)
        
        @foreach ($models as $car)
        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0" data-id="{{ $car->id }}" data-place={{ $car->place }}>
            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#">
                <i class="fas fa-4x fa-car"></i>
                <span class="nav-text font-size-lg py-2 font-weight-bold text-center">
                    {{ $car->name }}
                </span>
            </a>
        </li>
        @endforeach

    @else
        <li class="nav-item d-flex col flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0 invalid" style="background:#ccc;">
            <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center" data-toggle="pill" href="#">
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