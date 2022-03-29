@extends('admin.common.main')

@section('cunstomHeader')
    <style>
        .profile-documents{
            display:flex;
        }
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
                                <img src="{{asset($user_details->profile->profile_image)}}" class="rounded-circle img-thumbnail" alt="profile-image">
                                <i class="mdi mdi-star-circle member-star text-success"></i>
                            </div>

                            <div class="">
                                <h5 class="font-18 mb-1">{{$user_details->firstname}} {{$user_details->lastname}}</h5>
                                <p class="text-muted mb-2">caregiver</p>
                            </div>

                            @if ($user_details->is_user_approved == 0)
                                <button type="button" class="btn btn-warning btn-sm width-sm waves-effect mt-2 waves-light">Approve User</button>                                
                            @else
                                <button type="button" class="btn btn-success btn-rounded btn-sm width-sm waves-effect mt-2 waves-light">User Approved</button>                                
                            @endif


                            {{-- <p class="sub-header mt-3">
                               {{Str::of($user_details->profile->bio)->limit(150)}}
                            </p> --}}

                            <hr/>

                            <div class="text-left">

                                <p class="text-muted font-13"><strong>Mobile :</strong><span class="ml-2">{{$user_details->profile->phone}}</span></p>

                                <p class="text-muted font-13"><strong>Email :</strong> <span class="ml-2">{{$user_details->email}}</span></p>

                                <p class="text-muted font-13"><strong>Location :</strong> <span class="ml-2">{{$user_details->address->street}}, {{$user_details->address->city}}, {{$user_details->address->state}}.</span></p>
                            </div>

                            <ul class="social-links list-inline mt-4">
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Skype"><i class="fab fa-skype"></i></a>
                                </li>
                            </ul>

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
                                <p class="mb-0">{{$user_details->profile->bio}}</p>
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
                                        <p class="mb-0">{{$user_details->profile->work_type}}</p>
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
                                                <p class="mb-0">{{$item->city}}, {{$item->state}}</p>
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
                                    <div class="col-sm-12">
                                        <p>Covid</p>
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="profile-documents">
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                    <li>
                                                        <p>Image: <a href="#">Click to view</a></p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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


@section('cunstomJS')

@endsection
