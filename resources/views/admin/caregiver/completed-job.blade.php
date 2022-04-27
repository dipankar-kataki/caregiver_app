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
                        <th>Amount/hr</th>
                        <th>Posted By</th>
                        <th>Status</th>
                        <th>Completiton Date & Time</th>
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
                            <td><button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#full-width-modal">Full width Modal</button></td>
                            {{-- <td><button  type="button" class="btn btn-sm btn-purple waves-effect width-md waves-light approveUser"  data-id="{{Crypt::encrypt($item->id)}}">Approve User</button></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Modal Heading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="font-18">Text in a modal</h5>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                <hr>
                <h5 class="font-18">Overflowing text to show scroll behavior</h5>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection


@section('customJs')
@endsection
