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
                        <th>SL No</th>
                        <th>Job Order Id</th>
                        <th>Agency</th>
                        <th>Amount/hr</th>
                        <th>Amount Paid</th>
                        <th>Posted On</th>
                        <th>Job Status</th>
                        <th>Payment Status</th>
                        <th>View</th>
                        {{-- <th>Visibility</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @foreach ($job_details as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item['order_id']}}</td>
                            <td>{{$item['agency']}}</td>
                            <td>{{$item['amount_per_hour']}}</td>
                            <td>{{$item['amount_paid']}}</td>
                            <td>{{$item['posted_on']}}</td>
                            <td>
                                @if ($item['job_status'] == 0)
                                    <p class="text-primary">NEW POST</p>
                                @elseif($item['job_status'] == 1)
                                    <p style="color: #8829FF;">ONGOING</p>
                                @elseif($item['job_status'] == 2)
                                    <p class="text-success">COMPLETED</p>
                                @elseif($item['job_status'] == 3)
                                    <p class="text-danger">EXPIRED</p>
                                @elseif($item['job_status'] == 4)
                                    <p class="text-danger">DELETED BY USER</p>
                                @endif
                            </td>
                            <td style="text-transform:uppercase;">
                                @if ($item['payment_status'] == 1)
                                    <span class="text-success">Success</span>                                    
                                @else
                                    <span class="text-danger">Failed</span>
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{route('admin.agency.job.details', ['id' => Crypt::encrypt($item['user_id'])])}}"  target="_blank" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Job Details</a> --}}
                                <a href="{{route('admin.agency.job.details', ['id' => Crypt::encrypt($item['job_id']) ])}}"  target="_blank" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Job Details</a>
                            </td>
                            {{-- <td>
                                @if ($item->is_activate == 1)
                                    <label class="switch">
                                        <input type="checkbox" id="disableJob" data-id="{{ $item->id }}" checked>
                                        <span class="slider round text-white"></span>
                                    </label>
                                @else
                                    <label class="switch">
                                        <input type="checkbox" id="disableJob" data-id="{{ $item->id }}" disabled>
                                        <span class="slider round text-white"></span>
                                    </label>
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('customJs')

    <script>
        $(document.body).on('change', '#disableJob', function() {
            let status = $(this).prop('checked') == true ? 1 : 0;
            let job_id = $(this).data('id');
            let formData = {
                "job_id": job_id,
                "active": status,
                "_token" : "{{csrf_token()}}"
            }
            $.ajax({
                url : "{{route('admin.agency.job.disable.job')}}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.status == 1){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                },
                error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        toastr.error('Whoops! Something went wrong. Failed to update status.');
                    }
                }

            });

        });


        $('#closedJob').on('click',function(){
            $(this).prop('checked', false);
            toastr.error('Closed jobs are hidden by default.');
        });
    </script>
@endsection
