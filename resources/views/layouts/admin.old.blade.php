
<!--
=========================================================
Material Dashboard PRO - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard-pro
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    Material Dashboard PRO by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
    
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
  <!--  Social tags      -->
  <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 4 dashboard, bootstrap 4, css3 dashboard, bootstrap 4 admin, material dashboard bootstrap 4 dashboard, frontend, responsive bootstrap 4 dashboard, material design, material dashboard bootstrap 4 dashboard">
  <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Material Dashboard PRO by Creative Tim">
  <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@creativetim">
  <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim">
  <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta name="twitter:creator" content="@creativetim">
  <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Open Graph data -->
  <meta property="fb:app_id" content="655968634437471">
  <meta property="og:title" content="Material Dashboard PRO by Creative Tim" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="http://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html" />
  <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg" />
  <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design." />
  <meta property="og:site_name" content="Creative Tim" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <!-- plugins -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('user_panel') }}/css/jpreloader.css">
  <!-- CSS Files -->
  <link href="/css/material-dashboard.min.css?v=2.1.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/css/material-demo.css" rel="stylesheet" />
</head>

<body class="">
  <section id="jSplash">
  <section class="selected">
    <img class="img" src="{{ asset('user_panel') }}/img/preload.jpg" />
    <h3>Bienvenue dans le panel administrateur</h3>
  </section>
</section>
  <!-- Extra details for Live View on GitHub Pages -->
  <div class="wrapper" id="app">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="/img/sidebar-1.jpg">
        @include('inc.admin.sidebar')
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
          @include('inc.admin.navbar')
      </nav>
      <!-- End Navbar -->
      <div class="content">
          <div class="container-fluid">
              @include('inc.alert')
              @yield('content')
          </div>
      </div>
      <footer class="footer">
        @include('inc.admin.footer')
      </footer>
    </div>
  </div>

  @section('javascript')
  <!--   Core JS Files   -->
  <script src="/js/app.js"></script>
  <script src="{{ asset('user_panel') }}/js/jquery-2.2.0.js"></script>
  <script src="/js/core/popper.min.js"></script>
  <script src="/js/core/bootstrap-material-design.min.js"></script>
  <!--<script src="/js/plugins/perfect-scrollbar.jquery.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="/js/plugins/polyfill.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/js/material-dashboard.min.js?v=2.1.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="/js/material-demo.js"></script>
  <script src="{{ asset('user_panel') }}/js/jpreloader.min.js"></script>
  <script src="{{ asset('user_panel') }}/js/loader.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

      md.initVectorMap();

      var demo = document.querySelector('#custom-sidebar');
      var ps = new PerfectScrollbar(demo);

      $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      $(document).on('click', '.user-delete', function(){
        var c = confirm("Voulez-vous vraiment le supprimer");
        if (c == true) {
          $.ajax({
            data: { _id : $(this).attr('data-id'), _token : $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('admin.user.ajax.delete') }}",
            type: "POST",
            success: function (data) {
              if(data == 1){ $(location).attr('href', window.location.href  ); }
            },
            error: function (data) {
              console.log('Error:', data);
            }
        });     
        }
        

      });
      $(document).on('click', '#update-user', function(){
        var c = confirm("Voulez-vous vraiment sauvegarder les modifications");
        if (c == true) {
          $(this).attr('disabled','disabled');
          $(this).find('i').show();
          $.ajax({
            data: { 
                    _id : $(this).attr('data-id'), 
                    name : $('#user-name').val(), 
                    phone : $('#user-phone').val(), 
                    email : $('#user-email').val(), 
                    _token : $('meta[name="csrf-token"]').attr('content') 
                  },
            url: "{{ route('admin.user.ajax.edit') }}",
            type: "POST",
            success: function (data) {
              $('#update-user').removeAttr('disabled');
              $('#update-user').find('i').hide();
              if(data == 1){$(location).attr('href', window.location.href  );}
              else{ console.log(data); }
            },
            error: function (data) {
              $('#update-user').removeAttr('disabled');
              $('#update-user').find('i').hide();
              console.log('Error:', data);
            }
        });     
        }
        

      });
      $(document).on('click', '.user-edit', function(){

          $.ajax({
              data: { _id : $(this).attr('data-id'), _token : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ route('admin.user.modal.edit') }}",
              type: "POST",
              success: function (data) {
                $('#edit-modal-content').html(data);
              },
              error: function (data) {
                console.log('Error:', data);
              }
          });
        

      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
      md.initVectorMap();
    });
  </script>
  @show
</body>
</html>
