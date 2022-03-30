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


@section('title', 'Admin | Agency Profile')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="text-center card-box shadow-none border border-secoundary">
                        <div class="member-card">
                            <div class="avatar-xl member-thumb mb-3 mx-auto d-block">
                                <img src="{{asset('admin/assets/images/agency-image.png')}}" class="rounded-circle img-thumbnail" alt="profile-image">                                    
                                <i class="mdi mdi-star-circle member-star text-success"></i>
                            </div>

                            <div class="">
                                <h5 class="font-18 mb-1">{{$user_details->business_name}}</h5>
                                <p class="text-muted mb-2">Agency</p>
                            </div>

                            @if ($user_details->is_user_approved == 0)
                                <button  type="button" class="btn btn-sm btn-warning waves-effect width-md waves-light approveUser" data-id="{{Crypt::encrypt($user_details->id)}}">Approve User</button>                                
                            @else
                                <button type="button" class="btn btn-success btn-rounded btn-sm width-sm waves-effect mt-2 waves-light">User Approved</button>                                
                            @endif


                            {{-- <p class="sub-header mt-3">
                               {{Str::of($user_details->profile->bio)->limit(150)}}
                            </p> --}}

                            <hr/>

                            <div class="text-left">

                                <p class="text-muted font-13"><strong>Mobile :</strong><span class="ml-2">{{$user_details->business_information->business_number}}</span></p>

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
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="{{$user_details->jobs->count() != null ? $user_details->jobs->count() : 0 }}" data-max="1000" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Jobs Posted</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#17bf44" value="2" data-max="5" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Rating</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="{{$user_details->business_information->years_in_business != null ? $user_details->business_information->years_in_business : 0 }}" data-skin="tron" data-angleOffset="180" data-max="50" data-readOnly=true data-thickness=".1" />
                                <h6 class="text-muted mt-2">Years In Business</h6>
                            </div>
                        </div>
                        <!-- end col-->

                        <div class="col-lg-3 col-sm-6 text-center">
                            <div class="pt-2" dir="ltr">
                                <input data-plugin="knob" data-width="120" data-height="120" data-linecap=round data-fgColor="#2abfcc" value="50" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
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
                                <p class="mb-0">{{$user_details->business_information->bio}}</p>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Legal Structure</h6>
                                        <p class="mb-0">{{$user_details->business_information->legal_structure}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Organization Type</h6>
                                        <p class="mb-0">{{$user_details->business_information->organization_type}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Tax Id</h6>
                                        <p class="mb-0">{{$user_details->business_information->tax_id}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Number of Employee</h6>
                                        <p class="mb-0">{{$user_details->business_information->no_of_employee}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Country Of Business Formation</h6>
                                        <p class="mb-0">{{$user_details->business_information->country_of_business_formation}}</p>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class=" pt-2">
                                        <h6 class="font-16 mb-1">Annual Revenue</h6>
                                        <p class="mb-0">{{$user_details->business_information->annual_business_revenue}}</p>
                                    </div>
                                </div>
                            </div>

                            <hr/>
                             
                            <div class="row pt-2">
                                <div class="col-md-6 col-sm-12">
                                    <div class="pt-2">
                                        <h6 class="font-16 mb-1">Our Beneficiaries</h6>
                                        @if($user_details->business_information->beneficiary != null)
                                            @forelse ($user_details->business_information->beneficiary as $item)
                                                <ul>
                                                    <li>{{$item}}</li>
                                                </ul>
                                            @empty
                                                <div class="text-center">
                                                    <h6>No beneficiaries to show.</h6>
                                                </div>
                                            @endforelse
                                        @else
                                            <p>No beneficiaries to show.</p>
                                        @endif
                                        
                                        {{-- <p class="mb-0">{{$user_details->business_information->beneficiary}}</p> --}}
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="pt-2">
                                        <h6 class="font-16 mb-1">Homecare Services</h6>
                                        @if($user_details->business_information->homecare_service != null)
                                            @forelse ($user_details->business_information->homecare_service as $item)
                                                <ul>
                                                    <li>{{$item}}</li>
                                                </ul>
                                            @empty
                                                <div class="text-center">
                                                    <h6>No beneficiaries to show.</h6>
                                                </div>
                                            @endforelse
                                        @else
                                            <p>No homecare services to show.</p>
                                        @endif
                                        
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
<script>
        $('.approveUser').on('click', function(){
            let id = $(this).data('id');
            $(this).text('Please wait...');
            $(this).attr('disabled', true);
            $.ajax({
                url:"{{route('admin.agency.update.status')}}",
                type:"POST",
                data:{
                    '_token' : "{{csrf_token()}}",
                    'id' : id
                },
                success:function(data){
                    if(data.status == 1){
                        toastr.success(data.message);
                        location.reload(true);
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
    </script>
@endsection