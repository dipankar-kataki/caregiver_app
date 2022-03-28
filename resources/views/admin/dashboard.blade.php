@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Dashboard')


@section('content')
    

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-primary bg-soft-primary">
                <div class="card-body">
                    <div class="float-right avatar-lg rounded-circle mt-3">
                        <i class="mdi mdi-hospital font-30 widget-icon rounded-circle avatar-title text-primary"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Statistics">Caregivers</p>
                        <h2><span data-plugin="counterup">{{$total_caregivers}}</span> <i class="mdi {{$total_caregivers == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-warning bg-soft-warning">
                <div class="card-body">
                    <div class="float-right avatar-lg rounded-circle mt-3">
                        <i class="mdi mdi-hospital-building font-30 widget-icon rounded-circle avatar-title text-warning"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">Agencies</p>
                        <h2><span data-plugin="counterup">{{$total_agencies}} </span> <i class="mdi {{$total_agencies == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-danger bg-soft-danger">
                <div class="card-body">
                    <div class="float-right avatar-lg rounded-circle mt-3">
                        <i class="mdi mdi-briefcase font-30 widget-icon rounded-circle avatar-title text-danger"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Statistics">Jobs Posted</p>
                        <h2><span data-plugin="counterup">{{$total_jobs_posted}} </span> <i class="mdi {{$total_jobs_posted == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-success bg-soft-success">
                <div class="card-body">
                    <div class="float-right avatar-lg rounded-circle mt-3">
                        <i class="mdi mdi-currency-usd font-30 widget-icon rounded-circle avatar-title text-success"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="User Today">Revenue Generated</p>
                        <h2><span data-plugin="counterup">895</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card-box">

                <h4 class="header-title mb-4">Daily Sales</h4>

                <div class="widget-chart text-center">
                    <div id="morris-donut-example" class="morris-charts" style="height: 245px;"></div>
                    <ul class="list-inline chart-detail-list mb-0">
                        <li class="list-inline-item">
                            <h6 class="text-danger"><i class="fa fa-circle mr-2"></i>Series A</h6>
                        </li>
                        <li class="list-inline-item">
                            <h6 class="text-success"><i class="fa fa-circle mr-2"></i>Series B</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">

                <h4 class="header-title mb-4">Statistics</h4>
                <div id="morris-bar-example" class="text-center morris-charts" style="height: 280px;"></div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-4">
            <div class="card-box">

                <h4 class="header-title mb-4">Total Revenue</h4>
                <div id="morris-line-example" class="text-center morris-charts" style="height: 280px;"></div>
            </div>
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-4">Recent Users</h4>

                <div class="table-responsive">
                    <table class="table table-hover table-centered m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <img src="assets/images/users/avatar-1.jpg" alt="user" class="avatar-sm rounded-circle" />
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Louis Hansen</h5>
                                    <p class="m-0 text-muted"><small>Web designer</small></p>
                                </td>
                                <td>+12 3456 789</td>
                                <td>USA</td>
                                <td>07/08/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <img src="assets/images/users/avatar-2.jpg" alt="user" class="avatar-sm rounded-circle" />
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Craig Hause</h5>
                                    <p class="m-0 text-muted"><small>Programmer</small></p>
                                </td>
                                <td>+89 345 6789</td>
                                <td>Canada</td>
                                <td>29/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <img src="assets/images/users/avatar-3.jpg" alt="user" class="avatar-sm rounded-circle" />
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Edward Grimes</h5>
                                    <p class="m-0 text-muted"><small>Founder</small></p>
                                </td>
                                <td>+12 29856 256</td>
                                <td>Brazil</td>
                                <td>22/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <img src="assets/images/users/avatar-4.jpg" alt="user" class="avatar-sm rounded-circle" />
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Bret Weaver</h5>
                                    <p class="m-0 text-muted"><small>Web designer</small></p>
                                </td>
                                <td>+00 567 890</td>
                                <td>USA</td>
                                <td>20/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <img src="assets/images/users/avatar-5.jpg" alt="user" class="avatar-sm rounded-circle" />
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Mark</h5>
                                    <p class="m-0 text-muted"><small>Web design</small></p>
                                </td>
                                <td>+91 123 456</td>
                                <td>India</td>
                                <td>07/07/2016</td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <!-- table-responsive -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-4">Recent Users</h4>

                <div class="table-responsive">
                    <table class="table table-hover table-centered m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <span class="avatar-sm-box bg-success">L</span>
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Louis Hansen</h5>
                                    <p class="m-0 text-muted"><small>Web designer</small></p>
                                </td>
                                <td>+12 3456 789</td>
                                <td>USA</td>
                                <td>07/08/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <span class="avatar-sm-box bg-primary">C</span>
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Craig Hause</h5>
                                    <p class="m-0 text-muted"><small>Programmer</small></p>
                                </td>
                                <td>+89 345 6789</td>
                                <td>Canada</td>
                                <td>29/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <span class="avatar-sm-box bg-brown">E</span>
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Edward Grimes</h5>
                                    <p class="m-0 text-muted"><small>Founder</small></p>
                                </td>
                                <td>+12 29856 256</td>
                                <td>Brazil</td>
                                <td>22/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <span class="avatar-sm-box bg-pink">B</span>
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Bret Weaver</h5>
                                    <p class="m-0 text-muted"><small>Web designer</small></p>
                                </td>
                                <td>+00 567 890</td>
                                <td>USA</td>
                                <td>20/07/2016</td>
                            </tr>

                            <tr>
                                <th>
                                    <span class="avatar-sm-box bg-orange">M</span>
                                </th>
                                <td>
                                    <h5 class="m-0 font-15">Mark</h5>
                                    <p class="m-0 text-muted"><small>Web design</small></p>
                                </td>
                                <td>+91 123 456</td>
                                <td>India</td>
                                <td>07/07/2016</td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <!-- table-responsive -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
@endsection


@section('cunstomJS')

@endsection
