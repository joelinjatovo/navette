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
        <link href="/css/admin/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/css/admin/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="/css/admin/style.bundle.css" rel="stylesheet" type="text/css"/>
        <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
        
        <!--begin::Layout Themes(used by all pages)-->
        <link href="/css/admin/header/base/light.css" rel="stylesheet" type="text/css"/>
        <link href="/css/admin/header/menu/light.css" rel="stylesheet" type="text/css"/>
        <link href="/css/admin/brand/dark.css" rel="stylesheet" type="text/css"/>
        <link href="/css/admin/aside/dark.css" rel="stylesheet" type="text/css"/>
        <!--end::Layout Themes-->

        <link rel="shortcut icon" href="/favicon.png"/>

    </head>
    <!--end::Head-->
    
    <!--begin::Body-->
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >
    	<!--begin::Main-->
        	
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile align-items-center  header-mobile-fixed " >
            <!--begin::Logo-->
            <a href="/admin">
                <img alt="Logo" src="/img/logo-white.png"/>
            </a>
            <!--end::Logo-->

            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                    <!--begin::Aside Mobile Toggle-->
                    <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                        <span></span>
                    </button>
                    <!--end::Aside Mobile Toggle-->

                    <!--begin::Header Menu Mobile Toggle-->
                    <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                        <span></span>
                    </button>
                    <!--end::Header Menu Mobile Toggle-->

                <!--begin::Topbar Mobile Toggle-->
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg><!--end::Svg Icon-->
                    </span>
                </button>
                <!--end::Topbar Mobile Toggle-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
        
        
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                
                <!--begin::Aside-->
                <div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto"  id="kt_aside">
                    <!--begin::Brand-->
                    <div class="brand flex-column-auto " id="kt_brand">
                        <!--begin::Logo-->
                        <a href="/admin" class="brand-logo">
                            <img alt="Logo" src="/img/logo-white.png" width="32px"/>
                        </a>
                        <!--end::Logo-->
                        
                        <!--begin::Toggle-->
                        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                            <span class="svg-icon svg-icon svg-icon-xl">
                                <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </button>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Brand-->

                    <!--begin::Aside Menu-->
                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

                        <!--begin::Menu Container-->
                        <div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500" 			>
                            <!--begin::Menu Nav-->
                            <ul class="menu-nav ">
                                
                                <li class="menu-item {{ Route::is('admin.dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true" >
                                    <a  href="/admin" class="menu-link ">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Layers.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"/>
                                                    <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.dashboard') }}</span>
                                    </a>
                                </li>
                                
                                <li class="menu-section ">
                                    <h4 class="menu-text">{{ __('Application') }}</h4><i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.user*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Bucket.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "></path>
                                                    <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.users') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.users') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.users') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.users') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                            <li class="menu-item {{ Route::is('admin.user.create') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.user.create') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.user.create') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.club*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Bucket.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "></path>
                                                    <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.clubs') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.clubs') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.clubs') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.clubs') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                            <li class="menu-item {{ Route::is('admin.club.create') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.club.create') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.club.create') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.car*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Bucket.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "></path>
                                                    <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.cars') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.cars') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.cars') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.cars') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                            <li class="menu-item {{ Route::is('admin.car.create') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.car.create') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.car.create') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li class="menu-section ">
                                    <h4 class="menu-text">{{ __('Shop') }}</h4><i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.order*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Bucket.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "></path>
                                                    <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.orders') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.orders') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.orders') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.orders') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                            <li class="menu-item {{ Route::is('admin.order.create') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.order.create') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.order.create') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.ride*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/Design/Bucket.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "></path>
                                                    <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.rides') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.rides') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.rides') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.rides') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                            <li class="menu-item {{ Route::is('admin.ride.create') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.ride.create') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.ride.create') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                                <li class="menu-section ">
                                    <h4 class="menu-text">{{ __('messages.settings') }}</h4><i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ Route::is('admin.ride*') ? 'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="svg-icon menu-icon">
                                            <!--begin::Svg Icon | path:/assets/media/svg/icons/General/Settings-1.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                                    <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-text">{{ __('messages.settings') }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item  menu-item-parent" aria-haspopup="true"><span class="menu-link"><span class="menu-text">{{ __('messages.settings') }}</span></span></li>
                                            <li class="menu-item {{ Route::is('admin.apikeys') ? 'menu-item-active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.apikeys') }}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">{{ __('messages.list') }}</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                
                            </ul>
                            <!--end::Menu Nav-->
                            
                        </div>
                        <!--end::Menu Container-->
                    
                    </div>
                    <!--end::Aside Menu-->
                
                </div>
                <!--end::Aside-->
                
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				    <!--begin::Header-->
                    <div id="kt_header" class="header  header-fixed ">
                        <!--begin::Container-->
                        <div class=" container-fluid  d-flex align-items-stretch justify-content-between">

                            <!--begin::Header Menu Wrapper-->
                            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                <!--begin::Header Menu-->
                                <div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default ">
                                    <!--begin::Header Nav-->
                                    <ul class="menu-nav ">
                                    
                                        <li class="menu-item menu-item-submenu menu-item-rel menu-item-open-dropdown" data-menu-toggle="click" aria-haspopup="true">
                                            <a href="javascript:;" class="menu-link menu-toggle"><span class="menu-text">Apps</span><i class="menu-arrow"></i></a>
                                            
                                            <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                <ul class="menu-subnav">
                                                    <li class="menu-item " aria-haspopup="true">
                                                        <a href="javascript:;" class="menu-link ">
                                                            <span class="svg-icon menu-icon">
                                                                <!--begin::Svg Icon | path:/assets/media/svg/icons/Communication/Safe-chat.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <path d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z" fill="#000000" opacity="0.3"></path>
                                                                        <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                                                    </g>
                                                                </svg><!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-text">Reporting</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                    <!--end::Header Nav-->
                                </div>
                                <!--end::Header Menu-->
                            </div>
                            <!--end::Header Menu Wrapper-->

                            <!--begin::Topbar-->
                            <div class="topbar">

                                <!--begin::Notifications-->
                                <div class="dropdown">
                                    <!--begin::Toggle-->
                                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Code/Compiling.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"></path>
                                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"></path>
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <span class="pulse-ring"></span>
                                        </div>
                                    </div>
                                    <!--end::Toggle-->

                                    <!--begin::Dropdown-->
                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                        <form>
                                            <!--begin::Header-->
                                            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top">
                                                <!--begin::Title-->
                                                <h4 class="d-flex flex-center rounded-top">
                                                    <span>User Notifications</span>
                                                    <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">23 new</span>
                                                </h4>
                                                <!--end::Title-->

                                                <!--begin::Tabs-->
                                                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs">Logs</a>
                                                    </li>
                                                </ul>
                                                <!--end::Tabs-->
                                            </div>
                                            <!--end::Header-->

                                            <!--begin::Content-->
                                            <div class="tab-content">
                                                <!--begin::Tabpane-->
                                                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                                    <!--begin::Nav-->
                                                    <div class="d-flex flex-center text-center text-muted min-h-200px">
                                                        All caught up!
                                                        <br>
                                                        No new notifications.
                                                    </div>
                                                    <!--end::Nav-->
                                                </div>
                                                <!--end::Tabpane-->
                                            </div>
                                            <!--end::Content-->

                                        </form>
                                    </div>
                                    <!--end::Dropdown-->
                                </div>
                                <!--end::Notifications-->

                                @auth
                                <!--begin::User-->
                                <div class="topbar-item">
                                    <div class="btn btn-icon w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        <div class="d-flex flex-column text-right pr-3">
                                            <span class="opacity-50 font-weight-bold font-size-sm d-none d-md-inline">{{ auth()->user()->name }}</span>
                                            <span class="font-weight-bolder font-size-sm d-none d-md-inline">{{ auth()->user()->isAdmin() ? __('Administrator') : ( auth()->user()->isDriver() ? __('Driver') : __('Customer') ) }}</span>
                                        </div>
                                        <span class="symbol symbol-35">
                                            <span class="symbol-label font-size-h5 font-weight-bold bg-white-o-30">S</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::User-->
                                @endauth
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Content-->
                    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->
                        @yield('subheader')
                        <!--end::Subheader-->
                                
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

                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class=" container ">
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
                        <div class=" container-fluid  d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">2020 ©</span>
                                <a href="#" target="_blank" class="text-dark-75 text-hover-primary">L&M</a>
                            </div>
                            <!--end::Copyright-->

                            <!--begin::Nav-->
                            <div class="nav nav-dark">
                                <a href="/" target="_blank" class="nav-link pl-0 pr-5">About</a>
                                <a href="/" target="_blank" class="nav-link pl-0 pr-5">Team</a>
                                <a href="/" target="_blank" class="nav-link pl-0 pr-0">Contact</a>
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
            
        <!--begin::Global Config-->
        <script>
            var KTAppSettings = {"breakpoints": {"sm": 576,"md": 768,"lg": 992,"xl": 1200,"xxl": 1200},"colors": {"theme": {"base": {"white": "#ffffff","primary": "#6993FF","secondary": "#E5EAEE","success": "#1BC5BD","info": "#8950FC","warning": "#FFA800","danger": "#F64E60","light": "#F3F6F9","dark": "#212121"},"light": {"white": "#ffffff","primary": "#E1E9FF","secondary": "#ECF0F3","success": "#C9F7F5","info": "#EEE5FF","warning": "#FFF4DE","danger": "#FFE2E5","light": "#F3F6F9","dark": "#D6D6E0"},"inverse": {"white": "#ffffff","primary": "#ffffff","secondary": "#212121","success": "#ffffff","info": "#ffffff","warning": "#ffffff","danger": "#ffffff","light": "#464E5F","dark": "#ffffff"}},"gray": {"gray-100": "#F3F6F9","gray-200": "#ECF0F3","gray-300": "#E5EAEE","gray-400": "#D6D6E0","gray-500": "#B5B5C3","gray-600": "#80808F","gray-700": "#464E5F","gray-800": "#1B283F","gray-900": "#212121"}},"font-family": "Poppins"};
        </script>
        <!--end::Global Config-->

        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="/js/admin/admin.js"></script>
        <script src="/js/admin/plugins.bundle.js"></script>
        <script src="/js/admin/prismjs.bundle.js"></script>
        <script src="/js/admin/scripts.bundle.js"></script>
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
