<!DOCTYPE html>
<html lang="en" >
    <!--begin::Head-->
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Layout options builder"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <!--end::Fonts-->
        
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <!--begin::Page Custom Styles(used by this page)-->
        @yield('style')
        <!--end::Page Custom Styles-->
        
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="/css/main/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/css/main/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/css/main/style.bundle.css" rel="stylesheet" type="text/css"/>
        <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
        <!--end::Layout Themes-->

        <link rel="shortcut icon" href="/favicon.png"/>

    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body" class="header-fixed header-mobile-fixed page-loading"  >
    	<!--begin::Main-->
        
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile bg-primary  header-mobile-fixed " >
            <!--begin::Logo-->
            <a href="/">
                <img alt="Logo" src="/img/logo-letter-9.png" class="max-h-30px"/>
            </a>
            <!--end::Logo-->

            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                        <span></span>
                </button>
                <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
	
        <div class="d-flex flex-column flex-root" id="app">
		    <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header flex-column header-fixed " >
                        <!--begin::Top-->
                        <div class="header-top">
                            <!--begin::Container-->
                            <div class=" container-fluid ">
                                <!--begin::Left-->
                                <div class="d-none d-lg-flex align-items-center mr-3">
                                    <!--begin::Logo-->
                                    <a href="/" class="mr-20">
                                        <img alt="Logo" src="/img/logo-white.png" class="max-h-35px"/>
                                    </a>
                                    <!--end::Logo-->

                                    <!--begin::Desktop Search-->
                                    <div class="quick-search quick-search-inline ml-4 w-300px" id="kt_quick_search_inline">
                                        <!--begin::Form-->
                                        <form method="get" class="quick-search-form">
                                            <div class="input-group rounded bg-light">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="svg-icon svg-icon-lg">
                                                            <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                                                </g>
                                                            </svg><!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control h-45px" placeholder="{{ __('Recherche...') }}"/>

                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="quick-search-close ki ki-close icon-sm"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Form-->

                                        <!--begin::Search Toggle-->
                                        <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,1px"></div>
                                        <!--end::Search Toggle-->

                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg dropdown-menu-anim-up">
                                            <div class="quick-search-wrapper scroll" data-scroll="true" data-height="350" data-mobile-height="200">
                                            </div>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                    <!--end::Desktop Search-->
                                </div>
                                <!--end::Left-->

                                <!--begin::Topbar-->
                                <div class="topbar">

                                    <!--begin::Notifications-->
                                    <div class="dropdown">
                                        <!--begin::Toggle-->
                                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                            <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1 pulse pulse-white">
                                                <span class="svg-icon svg-icon-xl">
                                                    <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Code/Compiling.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="pulse-ring"></span>
                                            </div>
                                        </div>
                                        <!--end::Toggle-->
                                        
                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                            <form>
                                                <!--begin::Header-->
                                                <div class="d-flex flex-column pt-12 bg-dark-o-5 rounded-top">
                                                    <!--begin::Title-->
                                                    <h4 class="d-flex flex-center">
                                                        <span class="text-dark">User Notifications</span>
                                                        <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">23 new</span>
                                                    </h4>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Header-->

                                                <!--begin::Content-->
                                                <div class="p-8" id="topbar_notifications_notifications" role="tabpanel">
                                                    <!--begin::Scroll-->
                                                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
                                                        <!--begin::Item-->
                                                        <div class="d-flex align-items-center mb-6">
                                                            <!--begin::Symbol-->
                                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                                <span class="symbol-label">
                                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                                        <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Home/Library.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"/>
                                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"/>
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <!--end::Symbol-->

                                                            <!--begin::Text-->
                                                            <div class="d-flex flex-column font-weight-bold">
                                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Cool App</a>
                                                                <span class="text-muted">Marketing campaign planning</span>
                                                            </div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                    <!--end::Scroll-->
                                                </div>
                                                <!--end::Content-->
                                            </form>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                    <!--end::Notifications-->

                                    @if(Session::has('cart'))
                                    <!--begin::Cart-->
                                    <div class="dropdown">
                                        <!--begin::Toggle-->
                                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                                            <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1">
                                                <span class="svg-icon svg-icon-xl">
                                                    <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo2/dist/assets/media/svg/icons/Shopping/Cart3.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                            <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000"></path>
                                                        </g>
                                                    </svg><!--end::Svg Icon-->
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::Toggle-->

                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-xl dropdown-menu-anim-up" style="">
                                            <form>
                                                <!--begin::Header-->
                                                <div class="d-flex align-items-center py-10 px-8 rounded-top">
                                                    <span class="btn btn-md btn-icon mr-4">
                                                        <i class="flaticon2-shopping-cart-1 text-success"></i>
                                                    </span>
                                                    <h4 class="m-0 flex-grow-1 mr-3">{{ __('Mon Panier') }}</h4>
                                                    <button type="button" class="btn btn-success btn-sm">
                                                        @if(Session::get('cart')->type == 'go')
                                                            {{ __('Aller Simple') }}
                                                        @elseif(Session::get('cart')->type == 'back')
                                                            {{ __('Retours Simple') }}
                                                        @elseif(Session::get('cart')->type == 'go-back')
                                                            {{ __('Aller et Retours') }}
                                                        @endif
                                                    </button>
                                                </div>
                                                <!--end::Header-->

                                                <!--begin::Scroll-->
                                                <div class="scroll scroll-push ps" data-scroll="true" data-height="250" data-mobile-height="200" style="height: 250px; overflow: hidden;">

                                                    @foreach(Session::get('cart')->items as $item)
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-solid"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center justify-content-between p-8">
                                                        <div class="d-flex flex-column mr-2">
                                                            <a href="#" class="font-weight-bold text-dark-75 font-size-lg text-hover-primary">
                                                                @if($item->type == 'back')
                                                                    {{ __('Drop Off') }}
                                                                @else
                                                                    {{ __('Pick Up') }}
                                                                @endif
                                                            </a>
                                                            <span class="text-muted">
                                                                {{ $item->point->name }}
                                                            </span>
                                                        </div>
                                                        <a href="#" class="symbol symbol-70 flex-shrink-0">
                                                            <img src="{{ Session::get('cart')->image ? asset(Session::get('cart')->image->url) : asset('/img/image_placeholder.jpg') }}" title="" alt="">
                                                        </a>
                                                    </div>
                                                    <!--end::Item-->
                                                    @endforeach
                                               
                                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 5px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                                    <!--end::Scroll-->

                                                    <!--begin::Summary-->
                                                    <div class="p-8">
                                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                                        <span class="font-weight-bold text-muted font-size-sm mr-2">{{ __('Total') }}</span>
                                                        <span class="font-weight-bolder text-dark-50 text-right">{{ Session::get('cart')->currency }} {{ Session::get('cart')->total }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-7">
                                                        <span class="font-weight-bold text-muted font-size-sm mr-2">{{ __('Sous total') }}</span>
                                                        <span class="font-weight-bolder text-primary text-right">{{ Session::get('cart')->currency }} {{ Session::get('cart')->subtotal }}</span>
                                                    </div>
                                                    <div class="text-right">
                                                        <a href="{{ route('shop.checkout') }}" class="btn btn-primary text-weight-bold">{{ __('Payer maintenant') }}</a>
                                                    </div>
                                                </div>
                                                <!--end::Summary-->
                                            </form>
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>
                                    <!--end::Cart-->
                                    @endif
                                    
                                    @auth
                                    <!--begin::User-->
                                    <div class="topbar-item">
                                        <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                            <div class="d-flex flex-column text-right pr-3">
                                                <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline">{{ auth()->user()->name }}</span>
                                                <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline">{{ auth()->user()->isAdmin() ? __('Administrator') : ( auth()->user()->isDriver() ? __('Driver') : __('Customer') ) }}</span>
                                            </div>
                                            <span class="symbol symbol-35">
                                                <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">S</span>
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::User-->
                                    @endauth
                                    <div class="topbar-item">
										<a href="{{ route('login') }}" class="btn btn-success btn-sm- font-weight-bold btn-pill mr-3"><i class="la la-sign-in-alt"></i> {{ __('messages.login') }}</a>
										<a href="{{ route('register') }}" class="btn btn-info font-weight-bold btn-pill mr-3"><i class="la la-user-plus"></i> {{ __('messages.register') }}</a>
										<a href="{{ route('login.provider', ['provider' => 'facebook'])}}" class="btn btn-icon btn-circle btn-facebook mr-2"><i class="socicon-facebook"></i></a>
									</div>
                                </div>
                                <!--end::Topbar-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Top-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container-fluid">
                                
                                <!--begin::Alert-->
                                @if(Session::has('error'))
                                    <div class="alert alert-custom alert-danger fade show mb-5" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">{{ Session::get('error') }}</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(Session::has('success'))
                                    <div class="alert alert-custom alert-success fade show mb-5" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">{{ Session::get('success') }}</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <!--end::Alert-->

                                @yield('content')
                            
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->

                    <!--begin::Footer-->
                    <div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">
                        <!--begin::Container-->
                        <div class=" container  d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">2020 &copy;</span>
                                <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Création de L&M - Tous droits réservés</a>
                            </div>
                            <!--end::Copyright-->

                            <!--begin::Nav-->
                            <div class="nav nav-dark order-1 order-md-2">
                                <a href="/" target="_blank" class="nav-link pr-3 pl-0">{{ __('Qui nous sommes?') }}</a>
                                <a href="/" target="_blank" class="nav-link px-3">{{ __('Equipe') }}</a>
                                <a href="/" target="_blank" class="nav-link pl-3 pr-0">{{ __('Contact') }}</a>
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
		  <!--end::Page-->
	    </div>
        <!--end::Main-->
        
        @auth
        <!-- begin::User Panel-->
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">
                    Profil
                </h3>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->

            <!--begin::Content-->
            <div class="offcanvas-content pr-5 mr-n5">
                <!--begin::Header-->
                <div class="d-flex align-items-center mt-5">
                    <div class="symbol symbol-100 mr-5">
                        <div class="symbol-label" style="background-image:url('{{ auth()->user()->image ? asset(auth()->user()->image->url) : asset('/img/faces/avatar.jpg') }}')"></div>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                            {{ auth()->user()->name }}
                        </a>
                        <div class="text-muted mt-1">
                            {{ auth()->user()->isAdmin() ? __('Administrator') : ( auth()->user()->isDriver() ? __('Driver') : __('Customer') ) }}
                        </div>
                        <div class="navi mt-2">
                            @if(auth()->user()->email)
                            <a href="#" class="navi-item">
                                <span class="navi-link p-0 pb-2">
                                    <span class="navi-icon mr-1">
                                        <span class="svg-icon svg-icon-lg svg-icon-primary">
                                            <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Communication/Mail-notification.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"/>
                                                    <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
                                                </g>
                                            </svg><!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text text-muted text-hover-primary">{{ auth()->user()->email }}</span>
                                </span>
                            </a>
                            @endif

                            <a href="{{ route('logout') }}" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                        </div>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Separator-->
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <!--end::Separator-->

                <!--begin::Nav-->
                <div class="navi navi-spacer-x-0 p-0">
                    <!--begin::Item-->
                    <a href="{{ route('account.profile') }}" class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    <span class="svg-icon svg-icon-md svg-icon-success"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/General/Notification2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000"/>
                                                <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Mon Profil
                                </div>
                                <div class="text-muted">
                                    Voir les détails de mon compte
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--end:Item-->

					@if(auth()->user()->isCustomer())
                    <!--begin::Item-->
                    <a href="{{ route('customer.orders') }}"  class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                   <span class="svg-icon svg-icon-md svg-icon-warning"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Shopping/Chart-bar1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/>
                                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Mes Commandes
                                </div>
                                <div class="text-muted">
                                    Voir la liste de toutes mes commandes
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--end:Item-->
					@endif

					@if(auth()->user()->isDriver())
                    <!--begin::Item-->
                    <a href="{{ route('driver.rides') }}"  class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                   <span class="svg-icon svg-icon-md svg-icon-warning"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Shopping/Chart-bar1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/>
                                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Mes Courses
                                </div>
                                <div class="text-muted">
                                    Voir la liste de toutes mes courses
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--end:Item-->
					@endif

                    <!--begin::Item-->
                    <a href="#"  class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    <span class="svg-icon svg-icon-md svg-icon-danger"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Files/Selected-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M4.85714286,1 L11.7364114,1 C12.0910962,1 12.4343066,1.12568431 12.7051108,1.35473959 L17.4686994,5.3839416 C17.8056532,5.66894833 18,6.08787823 18,6.52920201 L18,19.0833333 C18,20.8738751 17.9795521,21 16.1428571,21 L4.85714286,21 C3.02044787,21 3,20.8738751 3,19.0833333 L3,2.91666667 C3,1.12612489 3.02044787,1 4.85714286,1 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M6.85714286,3 L14.7364114,3 C15.0910962,3 15.4343066,3.12568431 15.7051108,3.35473959 L20.4686994,7.3839416 C20.8056532,7.66894833 21,8.08787823 21,8.52920201 L21,21.0833333 C21,22.8738751 20.9795521,23 19.1428571,23 L6.85714286,23 C5.02044787,23 5,22.8738751 5,21.0833333 L5,4.91666667 C5,3.12612489 5.02044787,3 6.85714286,3 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">
                                    Mes Activités
                                </div>
                                <div class="text-muted">
                                    Logs and notifications
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--end:Item-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Content-->
        </div>
        <!-- end::User Panel-->
        @endauth
        	
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop">
            <span class="svg-icon">
                <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo9/dist/assets/media/svg/icons/Navigation/Up-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
                        <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </div>
        <!--end::Scrolltop-->
            
        <script>
            var KTAppSettings = {"breakpoints": {"sm": 576,"md": 768,"lg": 992,"xl": 1200,"xxl": 1200},"colors": {"theme": {"base": {"white": "#ffffff","primary": "#0BB783","secondary": "#E5EAEE","success": "#1BC5BD","info": "#8950FC","warning": "#FFA800","danger": "#F64E60","light": "#F3F6F9","dark": "#212121"},"light": {"white": "#ffffff","primary": "#D7F9EF","secondary": "#ECF0F3","success": "#C9F7F5","info": "#EEE5FF","warning": "#FFF4DE","danger": "#FFE2E5","light": "#F3F6F9","dark": "#D6D6E0"},"inverse": {"white": "#ffffff","primary": "#ffffff","secondary": "#212121","success": "#ffffff","info": "#ffffff","warning": "#ffffff","danger": "#ffffff","light": "#464E5F","dark": "#ffffff"}},"gray": {"gray-100": "#F3F6F9","gray-200": "#ECF0F3","gray-300": "#E5EAEE","gray-400": "#D6D6E0","gray-500": "#B5B5C3","gray-600": "#80808F","gray-700": "#464E5F","gray-800": "#1B283F","gray-900": "#212121"}},"font-family": "Poppins"};
        </script>
        <!--end::Global Config-->

        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="/js/main/customer.js"></script>
        <script src="/js/main/plugins.bundle.js"></script>
        <script src="/js/main/prismjs.bundle.js"></script>
        <script src="/js/main/scripts.bundle.js"></script>
        <!--end::Global Theme Bundle-->

        <!--begin::Page Scripts(used by this page)-->
        <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
        @yield('javascript')
        <!--end::Page Scripts-->
    </body>
    <!--end::Body-->
</html>
