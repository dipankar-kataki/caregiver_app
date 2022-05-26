@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Dashboard')


@section('content')
    

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-primary bg-soft-primary">
                <div class="card-body">
                    <div class="float-right avatar-md rounded-circle mt-3">
                        <i class="mdi mdi-hospital font-30 widget-icon rounded-circle avatar-title text-primary"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Total Caregivers">Caregivers</p>
                        <h2><span data-plugin="counterup">{{$total_caregivers}}</span> <i class="mdi {{$total_caregivers == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-warning bg-soft-warning">
                <div class="card-body">
                    <div class="float-right avatar-md rounded-circle mt-3">
                        <i class="mdi mdi-hospital-building font-30 widget-icon rounded-circle avatar-title text-warning"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Total Agencies">Agencies</p>
                        <h2><span data-plugin="counterup">{{$total_agencies}} </span> <i class="mdi {{$total_agencies == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-danger bg-soft-danger">
                <div class="card-body">
                    <div class="float-right avatar-md rounded-circle mt-3">
                        <i class="mdi mdi-briefcase font-30 widget-icon rounded-circle avatar-title text-danger"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Total Jobs Posted">Jobs Posted</p>
                        <h2><span data-plugin="counterup">{{$total_jobs_posted}} </span> <i class="mdi {{$total_jobs_posted == 0 ? '' : 'mdi-arrow-up'}} text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card widget-box-one border border-success bg-soft-success">
                <div class="card-body">
                    <div class="float-right avatar-md rounded-circle mt-3">
                        <i class="mdi mdi-currency-usd font-30 widget-icon rounded-circle avatar-title text-success"></i>
                    </div>
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-weight-bold text-muted" title="Total Revenue Generated">Total Income</p>
                        <h2><span data-plugin="counterup">{{$total_agency_payments}}</span> <i class="mdi {{$total_agency_payments == 0 ? '' : 'mdi-arrow-up'}}  text-success font-24"></i></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    {{-- <div class="row">
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

    </div> --}}
    <!-- end row -->

    <div class="row">

        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-4">Caregiver Pending For Approval <a title="Go to caregiver pending for approval page" href="{{route('admin.caregiver.request.for.approval')}}" class="mdi mdi-open-in-new" style="float:right;"></a></h4>
                

                <div class="table-responsive">
                    <table id="datatable-caregiver" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Of Birth</th>
                                <th>Phone Number</th>
                                <th>Experience</th>
                                <th>View</th>
                            </tr>
                        </thead>
        
                        <tbody>
                            @foreach($caregiver_pending_for_approval as $key =>  $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->firstname}} {{$item->lastname}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{Carbon\Carbon::parse($item->profile->dob)->format('m-d-Y')}}</td>
                                    <td>{{$item->profile->phone}}</td>
                                    @if ($item->profile->experience == null)
                                        <td>0</td>
                                    @else
                                        <td>{{$item->profile->experience}}</td>
                                    @endif
                                    <td><a href="{{route('admin.caregiver.view.profile', ['id' => Crypt::encrypt($item->id)])}}" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- table-responsive -->
            </div>
            <!-- end card -->
        </div>
         <!-- end col -->

        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-4">Agency Pending For Approval <a title="Go to agency pending for approval page" href="{{route('admin.agency.request.for.approval')}}" class="mdi mdi-open-in-new" style="float:right;"></a></h4>

                <div class="table-responsive">
                    <table id="datatable-agency" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Business Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Organization Type</th>
                                <th>Legal Structure</th>
                                <th>View</th>
                            </tr>
                        </thead>
        
                        <tbody>
                            @foreach($agency_pending_for_approval as $key =>  $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->business_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->business_information->business_number}}</td>
                                    <td>{{$item->business_information->organization_type}}</td>
                                    <td>{{$item->business_information->legal_structure}}</td>
                                    <td><a href="{{route('admin.agency.view.profile', ['id' => Crypt::encrypt($item->id)])}}" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- table-responsive -->
            </div>
            <!-- end card -->
        </div>
         <!-- end col -->

        <div class="col-xl-6 col-md-6 col-12">
            <div class="card-box">
                <h4 class="header-title mb-4">Recently Joined Caregiver <a title="Go to approved caregiver page" href="{{route('admin.caregiver.list.approved')}}" class="mdi mdi-open-in-new" style="float:right;"></a></h4>

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
                            @foreach ($recently_joined_caregiver as $key => $item)
                                <tr>
                                    <th>
                                        <img src="{{asset($item->profile->profile_image)}}" alt="user" class="avatar-sm rounded-circle" />
                                    </th>
                                    <td>
                                        <h5 class="m-0 font-15">{{$item->firstname}} {{$item->lastname}}</h5>
                                        @if ($item->profile->work_type != null)
                                            <p class="m-0 text-muted"><small>Work Type: {{$item->profile->work_type}}</small></p>
                                        @else
                                            <p class="m-0 text-muted"><small>Work Type: Not Provided</small></p>
                                        @endif
                                    </td>
                                    <td>{{$item->profile->phone}}</td>
                                    <td>{{$item->address->city}}</td>
                                    <td>{{$item->created_at->diffForHumans()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- table-responsive -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6 col-md-6 col-12">
            <div class="card-box">
                <h4 class="header-title mb-4">Recently Joined Agency <a title="Go to approved agency page" href="{{route('admin.agency.list.approved')}}" class="mdi mdi-open-in-new" style="float:right;"></a></h4>
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
                            @foreach ($recently_joined_agency as $key =>  $item)
                                <tr>
                                    <th>
                                        @if ($item->business_information->profile_image != null)
                                            <img src="{{asset($item->business_information->profile_image)}}" alt="user" class="avatar-sm rounded-circle" />
                                        @else
                                            <div class="notify-icon bg-success text-center p-2 rounded-circle text-white" style="height: 40px;width: 40px;">
                                                {{substr($item->business_name, 0, 1)}}
                                            </div>
                                        @endif
                                        
                                    </th>
                                    <td>
                                        <h5 class="m-0 font-15">{{$item->business_name}}</h5>
                                        @if ($item->business_information != null)
                                            <p class="m-0 text-muted"><small>Organization: {{$item->business_information->organization_type}}</small></p>
                                        @else
                                            <p class="m-0 text-muted"><small>Organization: Not Provided</small></p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->business_information != null)
                                            {{$item->business_information->business_number}}
                                        @else
                                            NULL
                                        @endif
                                        </td>
                                    <td>
                                        @if ($item->address != null)
                                            {{$item->address->city}}
                                        @else
                                            NULL
                                        @endif
                                    </td>
                                    <td>{{$item->created_at->diffForHumans()}}</td>
                                </tr>
                            @endforeach
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


@section('customJs')
<script>
    $('#datatable-caregiver').DataTable( {
        responsive: true,
        lengthMenu: [
            [5, 15, 25, -1],
            [5, 15, 25, 'All'],
        ],
    } );

    $('#datatable-agency').DataTable( {
        responsive: true,
        lengthMenu: [
            [5, 15, 25, -1],
            [5, 15, 25, 'All'],
        ],
    } );
    </script>
@endsection
