@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Approved Agency')


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
                        <th>Years In Business</th>
                        <th>View</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($approved_agencies as $key =>  $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->business_name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->business_information->business_number}}</td>
                            <td>{{$item->business_information->organization_type}}</td>
                            <td>{{$item->business_information->years_in_business}}</td>
                            <td><a href="{{route('admin.agency.view.profile', ['id' => Crypt::encrypt($item->id)])}}" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                            <td><a href="#" class="btn btn-sm btn-success btn-rounded width-md waves-effect waves-light">Approved</a></td>
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
