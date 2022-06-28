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
                        <th>Posted By</th>
                        <th>Job Status</th>
                        <th>Completiton Date & Time</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @foreach($completed_job as $key =>  $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->caregiver->firstname}} {{$item->caregiver->lastname}}</td>
                            <td>{{$item->jobByAgency->job_title}}</td>
                            <td>{{$item->jobByAgency->care_type}}</td>
                            <td>{{$item->agency->business_name}}</td>
                            <td>
                                @if ($item->jobByAgency->job_status == 0)
                                    <button type="button" class="btn btn-primary btn-rounded width-sm waves-effect waves-light" style="font-size: 10px; font-weight: 600;">NEW POST</button>
                                @elseif($item->jobByAgency->job_status == 1)
                                    <button type="button" class="btn btn-purple btn-rounded width-sm waves-effect waves-light" style="font-size: 10px; font-weight: 600;">ONGOING</button>
                                @elseif($item->jobByAgency->job_status == 2)
                                    <button type="button" class="btn btn-success btn-rounded width-sm waves-effect waves-light" style="font-size: 10px; font-weight: 600;">COMPLETED</button>
                                @elseif($item->jobByAgency->job_status == 3)
                                    <button type="button" class="btn btn-dark btn-rounded width-sm waves-effect waves-light" style="font-size: 10px; font-weight: 600;">EXPIRED</button>
                                @elseif($item->jobByAgency->job_status == 4)
                                     <button type="button" class="btn btn-danger btn-rounded width-sm waves-effect waves-light" style="font-size: 10px; font-weight: 600;">DELETED BY USER</button>
                                @endif
                            </td>
                            <td>{{Carbon\Carbon::parse($item->updated_at)->format('m-d-Y h:i:s')}}</td>
                            {{-- <td>
                                @if (! ($item->caregiver_payment->isEmpty()) )
                                    <a href="javascript:void(0);" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">Payment Success</a>    
                                @else
                                    <a href="{{route('admin.caregiver.make.payment.page', ['id' => Crypt::encrypt($item->job_by_agencies_id)])}}" class="btn btn-primary btn-sm waves-effect waves-light">Make Payment</a>                                        
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Payment Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h6>Job Description</h6>
                        <p style="font-size:14px;">
                            <span style="color:#282727;">Posted By</span> : Dk Industries<br>
                            <span style="color:#282727;">Job Title</span> : Urgent required caregiver<br>
                            <span style="color:#282727;">Care Type</span> : Patient Care<br>
                            <span style="color:#282727;">Amount Per Hour</span> : <span class="mdi mdi-currency-usd text-success"></span>100 <br>
                            <span style="color:#282727;">Amount Paid By Agency to Peaceworc incl. tax</span> : <span class="mdi mdi-currency-usd text-success"></span>300 ( Payment Status : <span class="text-success">SUCCESS</span> )<br>
                            <span style="color:#282727;">Job Completion Status</span> : <span class="text-success">COMPLETED</span> <br>
                            <span style="color:#282727;">Job Completion Time</span> : 04-02-2022 11:04:12
                        </p>
                    </div>
                </div>
                <h6>Payment To,</h6>
                <p style="font-size:14px;">
                    <span style="color:#282727;">Name :</span> Sikhar Dhawan <br>
                    <span style="color:#282727;">Address :</span> Demoruguri, Nagaon, Assam, 782001
                </p>
                <p style="font-size:14px;">
                    <span style="color:#282727;">Bank Name :</span> Canara Bank <br>
                    <span style="color:#282727;">Account Number :</span> 2563210110148 <br>
                    <span style="color:#282727;">Routing Number :</span> 4154125412
                </p>
                <hr>
                <div>
                    <h4 style="float:left;">
                        Total amount to be paid : <span class="mdi mdi-currency-usd text-success"></span>2000
                    </h4>
                    <button class="btn btn-purple waves-effect waves-light" style="float:right;">Pay Now</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> --}}
@endsection


@section('customJs')
@endsection
