@extends('admin.common.main')

@section('cunstomHeader')
    <style>
        .profile-documents li{
            list-style-type: numeric;
            margin-left:10px;
        }
    </style>
@endsection


@section('title', 'Admin | Caregiver Profile')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="text-center card-box shadow-none border border-secoundary">
                        <div class="member-card">
                            <div class="avatar-xl member-thumb mb-3 mx-auto d-block">
                                @if ($user_details->profile->profile_image == null)
                                    <img src="{{asset('admin/assets/images/placeholder.jpg')}}" class="rounded-circle img-thumbnail" alt="profile-image" style="height:100px; width:100px;object-fit: cover;object-position: top;">                                    
                                @else
                                    <img src="{{asset($user_details->profile->profile_image)}}" class="rounded-circle img-thumbnail" alt="profile-image" style="height:100px; width:100px;object-fit: cover;object-position: top;">                                    
                                @endif
                                <i class="mdi mdi-star-circle member-star text-success"></i>
                            </div>

                            <div class="">
                                <h5 class="font-18 mb-1">{{$user_details->firstname}} {{$user_details->lastname}}</h5>
                                <p class="text-muted mb-2">caregiver</p>
                            </div>

                            @if ($user_details->is_user_approved == 0)
                                <button  type="button" class="btn btn-sm btn-purple waves-effect width-md waves-light approveUser"  data-id="{{Crypt::encrypt($user_details->id)}}">Approve User</button>                                
                            @else
                                <div class="btn-group-vertical mb-2">
                                    <button type="button" class="btn btn-success btn-sm  btn-sm width-sm waves-effect mt-2 waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        User Approved
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if ($user_details->is_user_approved == 0)
                                            <li><a href="#" class="dropdown-item text-success approveUser"  data-id="{{Crypt::encrypt($user_details->id)}}">Approve user</a></li>
                                        @else
                                            <li><a href="#" class="dropdown-item text-danger suspendUser"  data-id="{{Crypt::encrypt($user_details->id)}}">Suspend user</a></li>  
                                        @endif
                                    </ul>
                                </div>
                            @endif


                            {{-- <p class="sub-header mt-3">
                               {{Str::of($user_details->profile->bio)->limit(150)}}
                            </p> --}}

                            <hr/>

                            <div class="text-left">

                                <p class="text-muted font-13"><strong>Mobile :</strong><span class="ml-2">{{$user_details->profile->phone}}</span></p>

                                <p class="text-muted font-13"><strong>Email :</strong> <span class="ml-2">{{$user_details->email}}</span></p>

                                <p class="text-muted font-13"><strong>Location :</strong> <span class="ml-2">{{$user_details->address->street}}, {{$user_details->address->city}}, {{$user_details->address->state}}, {{$user_details->address->zip_code}}.</span></p>
                            </div>

                            {{-- <ul class="social-links list-inline mt-4">
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Skype"><i class="fab fa-skype"></i></a>
                                </li>
                            </ul> --}}

                        </div>

                    </div>
                    <!-- end card-box -->

                </div>
                <!-- end col -->

                <div class="col-xl-9 col-md-8">
                    <h5 class="header-title">Expertise</h5>

                    <div class="row mt-3">
                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="{{$user_details->profile->total_care_completed != null ? $user_details->profile->total_care_completed : 0 }}" data-max="1000" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Total Care Completed</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="{{$user_details->profile->rating <= 2 ? '#bf172b' : '#17bf44' }}" value="{{$user_details->profile->rating != null ? $user_details->profile->rating : 0 }}" data-max="5" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Total Rating</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="{{$user_details->profile->experience != null ? $user_details->profile->experience : 0 }}" data-skin="tron" data-angleOffset="180" data-max="50" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Total Experience</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="{{$user_details->profile->total_reviews != null ? $user_details->profile->total_reviews : 0 }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Total Reviews</h6>
                            </div>
                        </div>
                        <!-- end col-->

                    </div>
                    <!-- end row -->

                    <hr/>

                    <div class="row pt-2">
                        <div class="col-xl-12">
                            <h5 class="header-title">Basic Details</h5>
                            
                            <div class="pt-2">
                                <h6 class="font-16 mb-1">Bio</h6>
                                @if ($user_details->profile->bio == null)
                                    <p class="mb-0">Not found.</p>
                                @else
                                    <p class="mb-0">{{$user_details->profile->bio}}</p>
                                @endif
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Gender</h6>
                                        <p class="mb-0">{{$user_details->profile->gender}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Work Type</h6>
                                        @if ($user_details->profile->work_type == null)
                                            <p class="mb-0">Not found.</p>
                                        @else
                                            <p class="mb-0">{{$user_details->profile->work_type}}</p>
                                        @endif
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Date of Birth</h6>
                                        <p class="mb-0">{{Carbon\Carbon::parse($user_details->profile->dob)->format('m-d-Y')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">SSN</h6>
                                        <p class="mb-0">{{$user_details->profile->ssn}}</p>
                                    </div>
                                </div>
                            </div>

                            <hr/>
                             
                            <div class="pt-2">
                                <h5 class="font-16 mb-3">Education</h5>
                                @forelse ($education as $item)
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">
                                            <div class=" pt-2">
                                                <h6 class="font-16 mb-1">Institution</h6>
                                                <p class="mb-0">{{$item->institution}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class=" pt-2">
                                                <h6 class="font-16 mb-1">Course</h6>
                                                <p class="mb-0">{{$item->course}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class=" pt-2">
                                                <h6 class="font-16 mb-1">Location</h6>
                                                <p class="mb-0">{{$item->city}}, {{$item->state}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class=" pt-2">
                                                <h6 class="font-16 mb-1">Duration</h6>
                                                <p class="mb-0">{{$item->duration}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class=" pt-2">
                                                <h6 class="font-16 mb-1">Grade</h6>
                                                <p class="mb-0">{{$item->grade_percentage}}</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @empty
                                    <div class="text-center">
                                        <p>No Education To Show</p>
                                    </div>
                                @endforelse
                            </div>

                            <hr/>

                            <div class="pt-2">
                                <h5 class="font-16 mb-3">Uploaded Documents</h5>
                                <div class="row">
                                    @forelse ($documents as $key => $item)
                                        @if (!($documents[$key]['tuberculosis']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Tuberculosis Test</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['tuberculosis'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['covid']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Covid-19 Vaccination Card</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['covid'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['criminal']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Criminal Background Result</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['criminal'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['childAbuse']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Child Abuse Clearance</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['childAbuse'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        @if (!($documents[$key]['w_4_form']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>W-4 Form</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                        @foreach ($documents[$key]['w_4_form'] as  $item2)
                                                            <li>
                                                                <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                            </li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['employment']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Employment Eligibility form (I-9)</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['employment'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['driving']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Driving License</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['driving'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!($documents[$key]['identification']->isEmpty()))
                                            <div class="col-sm-12">
                                                <p>Identification</p>
                                                <div class="card">
                                                    <div class="card-body" style="padding:0.5rem">
                                                        <ul class="profile-documents">
                                                            @foreach ($documents[$key]['identification'] as  $item2)
                                                                <li>
                                                                    <h6>Document: <a href="{{asset($item2->image)}}" target="_blank">Click to view</a></h6>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                    @empty
                                        <div class="text-center">
                                            <h6>No Documents To Show</h6>
                                        </div>
                                    @endforelse
                                    
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end col -->

            </div>
        </div>
    </div>
</div>
@endsection


@section('customJs')
<script>
        $('.approveUser').on('click', function(){
            let id = $(this).data('id');
            $(this).text('Please wait...');
            $(this).attr('disabled', true);
            $.ajax({
                url:"{{route('admin.caregiver.update.status')}}",
                type:"POST",
                data:{
                    '_token' : "{{csrf_token()}}",
                    'id' : id
                },
                success:function(data){
                    if(data.status == 1){
                        toastr.success(data.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 4000);
                    }else{
                        toastr.error(data.message);
                        $('.approveUser').text('Approve User');
                        $('.approveUser').attr('disabled', false);
                    }
                },error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        toastr.error('Whoops! Something went wron. Failed to approve user.');
                        $('.approveUser').text('Approve User');
                        $('.approveUser').attr('disabled', false);
                    }
                }
            });
        });

        $('.suspendUser').on('click', function(){
            let id = $(this).data('id');
            $(this).text('Please wait...');
            $(this).attr('disabled', true);
            $.ajax({
                url:"{{route('admin.caregiver.profile.suspend.user')}}",
                type:"POST",
                data:{
                    '_token' : "{{csrf_token()}}",
                    'id' : id
                },
                success:function(data){
                   
                    if(data.status == 1){
                        toastr.success(data.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 4000);
                    }else{
                        toastr.error(data.message);
                        $('.suspendUser').text('Approve User');
                        $('.suspendUser').attr('disabled', false);
                    }
                },error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        toastr.error('Whoops! Something went wron. Failed to approve user.');
                        $('.suspendUser').text('Approve User');
                        $('.suspendUser').attr('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
