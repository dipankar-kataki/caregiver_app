@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Agency Jobs')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Agency</th>
                        <th>Job Title</th>
                        <th>Amount/hr</th>
                        <th>Posted On</th>
                        <th>Job Status</th>
                        <th>Payment Status</th>
                        <th>View</th>
                        <th>Visibility</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($job_details as $key =>  $item)
                        @foreach ($item->jobs as $key2 => $item2)
                            <tr>
                                <td>{{$item->business_name}}</td>
                                <td>{{$item2->job_title}}</td>
                                <td>{{$item2->amount_per_hour}}</td>
                                <td>{{$item2->created_at}}</td>
                                
                                @if ($item2->is_activate == 1)
                                   <td class="text-success">Newly Posted</td> 
                                @elseif($item2->is_activate == 2)
                                    <td class="text-primary">On Going</td>
                                @else
                                    <td class="text-danger">Closed</td>
                                @endif
                                <td>NULL</td>
                                <td><a href="{{route('admin.agency.view.profile', ['id' => Crypt::encrypt($item->id)])}}"  target="_blank" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                                <td>
                                    <input type="checkbox" id="switch1_{{$item->id}}" checked data-switch="none" />
                                    <label for="switch1" data-on-label="Online" data-off-label="Offline"></label>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('customJs')

@endsection
