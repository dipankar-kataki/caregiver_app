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
                    <span style="color:#282727;">Name :</span> {{$bank_details->name}} <br>
                    <span style="color:#282727;">Address :</span> {{$bank_details->address}}
                </p>
                <p style="font-size:14px;margin-bottom:0.6rem;">
                    <span style="color:#282727;">Bank Name :</span> {{$bank_details->bank_name}} <br>
                    <span style="color:#282727;">Account Number :</span> <span style="font-weight:bold;font-size:16px;">{{$bank_details->account_number}}</span> <br>
                    <span style="color:#282727;">Routing Number :</span> <span style="font-weight:bold;font-size:16px;">{{$bank_details->routing_number}}</span>
                </p>
            </fieldset>
        </div>
    </div>
    <hr style="border-style: dashed;">
    <div class="row">
        <div class="col-12">
            <h3>Total Amount To Be Paid <span class="mdi mdi-currency-usd text-success"></span>{{$job_details->payment_status[0]['caregiver_charge']}}</h3>
            <button class="btn btn-md btn-primary mark-as-paid-btn" data-user="{{Crypt::encrypt($bank_details->user_id)}}" data-job="{{Crypt::encrypt($job_details->id)}}" data-amount="{{$job_details->payment_status[0]['caregiver_charge']}}">Mark As Paid</button>
        </div>
    </div>
@endsection


@section('customJs')
    <script>
        $('.mark-as-paid-btn').on('click', function(){

            $(this).attr('disabled', true);
            $(this).text('Please wait.....');

            let user_id = $(this).data('user');
            let job_id = $(this).data('job');
            let amount = $(this).data('amount');

            $.ajax({
                url:"{{route('admin.caregiver.update.payment.status')}}",
                type:"POST",
                data:{
                    'user_id' : user_id,
                    'job_id' : job_id,
                    'amount' : amount,
                    '_token' : "{{csrf_token()}}"
                },
                success:function(data){
                    if(data.status == 1){
                        toastr.success(data.message);
                        location.replace("{{route('admin.caregiver.completed.job')}}");
                    }else{
                        toastr.error(data.message);

                        $('.mark-as-paid-btn').attr('disabled', false);
                        $('.mark-as-paid-btn').text('Mark As Paid');
                    }
                },
                error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        toastr.error('Whoops! Something went wrong. Failed to update payment status.')
                    }
                    $('.mark-as-paid-btn').attr('disabled', false);
                    $('.mark-as-paid-btn').text('Mark As Paid');
                }
            });
        });
    </script>
@endsection
