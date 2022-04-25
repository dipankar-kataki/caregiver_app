@extends('admin.common.main')

@section('cunstomHeader')
@endsection


@section('title', 'Admin | Agency Newly Jobs')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Agency</th>
                        <th>Job Title</th>
                        <th>Amount/hr</th>
                        <th>Posted On</th>
                        <th>Job Status</th>
                        <th>Payment Status</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($newly_posted as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->user->business_name}}</td>
                            <td title="{{$item->job_title}}">{{Str::of($item->job_title)->limit(15)}}</td>
                            <td>{{$item->amount_per_hour}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                @if ($item->job_status == 0)
                                    <p class="text-success">NEWLY POSTED</p>

                                @elseif($item->job_status == 1)

                                @else
                                    <p class="text-danger">CLOSED</p>
                                @endif
                            </td>
                            <td>NULL</td>
                            <td><a href="{{route('admin.agency.view.profile', ['id' => Crypt::encrypt($item->user_id)])}}"  target="_blank" class="btn btn-sm btn-primary waves-effect width-md waves-light">View Profile</a></td>
                            <td>
                                <button id="publishJob" data-id="{{ $item->id }}" class="btn btn-sm btn-success">Post Job</button>
                            </td>
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

        $('#publishJob').on('click', function(){
            let job_id = $(this).data('id');
            let formData = {
                "job_id": job_id,
                "_token" : "{{csrf_token()}}"
            }

            $.ajax({
                url : "{{route('admin.agency.job.publish')}}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.status == 1){
                        toastr.success(data.message);
                        location.reload(true);
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
    </script>
@endsection
