@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Caregiver Completed Job')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Caregiver Name</th>
                        <th>Job Title</th>
                        <th>Care Type</th>
                        <th>Job Amount/hr</th>
                        <th>Job Posted By</th>
                        <th>Job Status</th>
                        <th>Job Completiton Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($completed_job as $key =>  $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->caregiver->firstname}} {{$item->caregiver->lastname}}</td>
                            <td>{{$item->jobByAgency->job_title}}</td>
                            <td>{{$item->jobByAgency->care_type}}</td>
                            <td>{{$item->jobByAgency->amount_per_hour}}</td>
                            <td>{{$item->agency->business_name}}</td>
                            <td>
                                @if ($item->jobByAgency->job_status == 2)
                                    <strong class="text-success">COMPLETED</strong>
                                @else
                                    <strong class="text-danger">IN COMPLETE</strong>
                                @endif
                            </td>
                            <td>{{Carbon\Carbon::parse($item->updated_at)->format('m-d-Y h:i:s')}}</td>
                            <td><a href="#" class="btn btn-sm btn-primary waves-effect width-md waves-light" disabled>View Profile</a></td>
                            {{-- <td><button  type="button" class="btn btn-sm btn-purple waves-effect width-md waves-light approveUser"  data-id="{{Crypt::encrypt($item->id)}}">Approve User</button></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('customJs')
@endsection
