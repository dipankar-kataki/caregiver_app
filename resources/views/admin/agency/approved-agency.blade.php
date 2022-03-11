@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Approved Agency')


@section('main')
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> List of Approved Agencies
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        {{-- <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> --}}
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="approved_agency_table" class="table table-bordered mt-2 mb-2">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Business Name </th>
                                        <th> Email </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($approved_list as $key =>  $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->business_name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td> <a href="#" style="font-weight: bold;">View Profile</a> </td>
                                        </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('cunstomJS')
    <script>
         $(document).ready( function () {
            $('#approved_agency_table').DataTable({
                "processing": true,
                'searching' : false,
            });
        });
    </script>
@endsection
