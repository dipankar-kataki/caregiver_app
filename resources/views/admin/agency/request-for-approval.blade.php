@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Request For Approval')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Business Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Organization Type</th>
                        <th>Legal Structure</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($request_for_approval as $key =>  $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->business_name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->business_information->business_number}}</td>
                            <td>{{$item->business_information->organization_type}}</td>
                            <td>{{$item->business_information->legal_structure}}</td>
                            <td><a href="#" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                            <td><a href="#" class="btn btn-sm btn-warning waves-effect width-md waves-light">Approve User</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('cunstomJS')

@endsection
