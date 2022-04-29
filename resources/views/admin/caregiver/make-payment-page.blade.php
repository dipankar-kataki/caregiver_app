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


@section('title', 'Admin | Make Payment To Caregiver')


@section('content')
    <div class="row">
        <div class="col-sm-6">
            <fieldset>
                <legend>Job Description</legend>
                <p style="font-size:15px; margin-bottom:0px;">
                    <span style="color:#282727;">Posted By</span> : {{$job_details->user->business_name}}<br>
                    <span style="color:#282727;">Job Title</span> : {{$job_details->job_title}}<br>
                    <span style="color:#282727;">Care Type</span> : {{$job_details->care_type}}<br>
                    {{-- <span style="color:#282727;">Amount Per Hour</span> : <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->amount_per_hour}} <br> --}}
                    <span style="color:#282727;">Amount Paid By Agency to Peaceworc incl. tax</span> : <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->payment_status[0]['amount']}} ( Payment Status : <span class="text-success" style="text-transform: uppercase;">{{$job_details->payment_status[0]['payment_status']}}</span> )<br>
                    <span style="color:#282727;">Job Completion Status</span> : <span class="text-success">COMPLETED</span> <br>
                    <span style="color:#282727;">Job Completion Date & Time</span> : {{Carbon\Carbon::parse($job_details->accepted_job[0]['updated_at'])->format('m-d-Y h:i:s')}}
                </p>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset>
                <legend>Payment To</legend>
                <p style="font-size:15px;">
                    <span style="color:#282727;">Name :</span> Sikhar Dhawan <br>
                    <span style="color:#282727;">Address :</span> Demoruguri, Nagaon, Assam, 782001
                </p>
                <p style="font-size:14px;margin-bottom:0.6rem;">
                    <span style="color:#282727;">Bank Name :</span> Canara Bank <br>
                    <span style="color:#282727;">Account Number :</span> 2563210110148 <br>
                    <span style="color:#282727;">Routing Number :</span> 4154125412
                </p>
            </fieldset>
        </div>
    </div>
    <hr style="border-style: dashed;">
    <div class="row">
        <div class="col-12">
            <h3>Total Amount To Be Paid <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->payment_status[0]['caregiver_charge']}}</h3>
        </div>
    </div>
@endsection


@section('customJs')
@endsection
