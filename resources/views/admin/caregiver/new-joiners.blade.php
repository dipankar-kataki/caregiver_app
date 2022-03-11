@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Caregiver New-Joiners')


@section('main')
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> List of New Joiners
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        {{-- <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> --}}
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="new_joiners_table" class="table table-bordered mt-2 mb-2" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                        <th>Respond</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($new_joiner as $key =>  $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->firstname}} {{$item->lastname}}</td>
                                            <td>{{$item->email}}</td>
                                            <td><img src="{{asset($item->profile->profile_image)}}" alt="profile pic"></td>
                                            <td><a href="#" style="text-decoration:none;font-weight:bold;">View Profile</a></td>
                                            <td>
                                                <button class="btn btn-md btn-success approve-btn" data-id="{{$item->id}}">Approve</button>&nbsp;
                                                <button class="btn btn-md btn-danger decline-btn" data-id="{{$item->id}}">Decline</button>
                                            </td>
                                        </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('cunstomJS')
    <script>
         $(document).ready( function () {
            $('#new_joiners_table').DataTable({
                "processing": true,
                'searching' : false,
            });
        });

        $('.approve-btn').on('click', function(){
            $.ajax({
                url: "{{route('admin.caregiver.update.status')}}",
                type:"POST",
                data:{
                    '_token' : "{{csrf_token()}}",
                    'user_id' : $(this).data('id'),
                    'status' : 1
                },
                success:function(data){
                    alert('User Approved');
                    window.location.replace("{{route('admin.caregiver.list.approved')}}");
                },error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        console.log(error);
                    }
                }
            });
        });
    </script>
@endsection
