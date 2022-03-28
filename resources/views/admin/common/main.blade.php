<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Peaceworc a caregiver website." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon-icon.png')}}">

    <!-- App css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-stylesheet" />
    @yield('cunstomHeader')
</head>

<body>

  <!-- Begin page -->
  <div id="wrapper">
    <!-- Topbar Start -->
      @include('admin.common.navbar')
    <!-- end Topbar --> 

    <!-- ========== Left Sidebar Start ========== -->
      @include('admin.common.sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

      <div class="content-page">
          <div class="content">

              <!-- Start Content-->
              <div class="container-fluid">
                <!-- start page title -->
                  <div class="row">
                      <div class="col-12">
                          <div class="page-title-box">
                              <div class="page-title-right">
                                  <ol class="breadcrumb m-0">
                                      <li class="breadcrumb-item"><a href="javascript: void(0);">Peaceworc</a></li>
                                      <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-transform:capitalize;">{{Request::segment(1)}} </a></li>
                                      <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-transform:capitalize;">{{Request::segment(2)}} </a></li>
                                  </ol>
                              </div>
                              <h4 class="page-title" style="text-transform:capitalize; ">{{Request::segment(2)}}</h4>
                          </div>
                      </div>
                  </div>
                <!-- end page title -->
                 @yield('content')

              </div>
              <!-- end container-fluid -->

          </div>
          <!-- end content -->

          

          <!-- Footer Start -->
          @include('admin.common.footer')
          <!-- end Footer -->

      </div>
    
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

  </div>
  <!-- END wrapper -->


    <!-- Vendor js -->
    <script src="{{asset('admin/assets/js/vendor.min.js')}}"></script>

    <script src="{{asset('admin/assets/libs/morris-js/morris.min.js')}}"></script>
    <script src="{{asset('admin/assets/libs/raphael/raphael.min.js')}}"></script>

    <script src="{{asset('admin/assets/js/pages/dashboard.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('admin/assets/js/app.min.js')}}"></script>

</body>
</html>