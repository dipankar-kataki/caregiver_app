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

    <!-- Table datatable css -->
    <link href="{{asset('admin/assets/libs/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/fixedHeader.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/scroller.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/dataTables.colVis.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/libs/datatables/fixedColumns.bootstrap4.min.html')}}" rel="stylesheet" type="text/css" />
    
    <!-- App css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('admin/assets/libs/tooltipster/tooltipster.bundle.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Magnific -->

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
                                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard.home')}}">Peaceworc</a></li>
                                      <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-transform:capitalize;">{{Request::segment(2)}} </a></li>
                                      {{-- <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-transform:capitalize;">{{Request::segment(3)}} </a></li> --}}
                                  </ol>
                              </div>
                              @if (Request::segment(3) != null)
                                <h4 class="page-title" style="text-transform:capitalize; ">{{Request::segment(3)}}</h4>                                  
                              @else
                                <h4 class="page-title" style="text-transform:capitalize; ">{{Request::segment(2)}}</h4>                                  
                              @endif
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

    <!-- KNOB JS -->
    <script src="{{asset('admin/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

     <!-- Datatable plugin js -->
     <script src="{{asset('admin/assets/libs/datatables/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/dataTables.bootstrap4.min.js')}}"></script>
 
     <script src="{{asset('admin/assets/libs/datatables/dataTables.responsive.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/responsive.bootstrap4.min.js')}}"></script>
 
     <script src="{{asset('admin/assets/libs/datatables/dataTables.buttons.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/buttons.bootstrap4.min.js')}}"></script>
 
     <script src="{{asset('admin/assets/libs/datatables/buttons.html5.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/buttons.print.min.js')}}"></script>
 
     <script src="{{asset('admin/assets/libs/datatables/dataTables.keyTable.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/dataTables.fixedHeader.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/dataTables.scroller.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/datatables/dataTables.fixedColumns.min.html')}}"></script>
 
     <script src="{{asset('admin/assets/libs/jszip/jszip.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/pdfmake/pdfmake.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/pdfmake/vfs_fonts.js')}}"></script>
 
     <!-- Datatables init -->
     <script src="{{asset('admin/assets/js/pages/datatables.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('admin/assets/js/app.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script src="{{asset('admin/assets/libs/tooltipster/tooltipster.bundle.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/pages/tooltipster.init.js')}}"></script>

    @yield('customJs')


    <script>
      toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
      }
    </script>
 
   

</body>
</html>