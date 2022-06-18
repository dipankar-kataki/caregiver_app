@extends('admin.common.main')

@section('cunstomHeader')
    <style>
        fieldset {
            border: 1px solid #d3d3d3;
            border-radius: 5px;
            padding:20px;
        }

        legend {
            padding: 10px;
            border-radius: 10px;
            width: auto;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
@endsection


@section('title', 'Admin | Agency Job Details')


@section('content')
    <div class="row">
        <div class="col-sm-6">
            <fieldset>
                <legend>Job Description</legend>
                <p style="font-size:15px; margin-bottom:0px;">
                    <span style="color:#282727;">Posted By</span> : {{$job_details->user->business_name}}<br>
                    <span style="color:#282727;">Job Title</span> : {{$job_details->job_title}}<br>
                    <span style="color:#282727;">Care Type</span> : {{$job_details->care_type}}<br>
                    <span style="color:#282727;">Patient Age</span> : {{$job_details->patient_age}}<br>
                    <span style="color:#282727;">Amount Per Hour</span> : <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->amount_per_hour}} <br>
                    <span style="color:#282727;">Amount Paid By Agency to Peaceworc incl. tax</span> : <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->payment_status[0]['amount']}} ( Payment Status : 
                        <span class="text-success" style="text-transform: uppercase;">
                            @if ($job_details->payment_status[0]['payment_status'] == 1)
                                <span class="text-success">SUCCESS</span>
                            @else
                            <span class="text-danger">FAILED</span>
                            @endif
                        </span> 
                    )<br>
                    <span style="color:#282727;">Start Date</span> : {{\Carbon\Carbon::parse($job_details->start_date_of_care)->format('m-d-Y')}} &nbsp;-&nbsp; End Date</span> : {{$job_details->end_date_of_care}} <br>
                    <span style="color:#282727;">Start Time</span> : {{$job_details->start_time}} &nbsp;-&nbsp; End Time</span> : {{$job_details->end_time}} <br>
                    <span style="color:#282727;">Description</span> : {{$job_details->job_description}} <br>

                    @if ($job_details->job_status == 0)
                        <span style="color:#282727;">Job Completion Status</span> : <span class="text-success">NEW POST</span> <br>                        
                    @elseif($job_details->job_status == 1)
                        <span style="color:#282727;">Job Completion Status</span> : <span class="text-primary">ONGOING</span> <br>
                    @elseif($job_details->job_status == 2)
                        <span style="color:#282727;">Job Completion Status</span> : <span class="text-danger">CLOSED</span> <br>                                                
                    @endif
                    {{-- <span style="color:#282727;">Job Completion Date & Time</span> : {{Carbon\Carbon::parse($job_details->accepted_job[0]['updated_at'])->format('m-d-Y h:i:s')}} --}}
                </p>
            </fieldset>
        </div>
    </div>
@endsection


@section('customJs')
@endsection
