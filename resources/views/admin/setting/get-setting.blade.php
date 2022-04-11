@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Setting')


@section('content')


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
        <div class="card-box">
            <h4 class="header-title">Basic Information</h4>
            <div class="card-body">
                <form id="updateBasicInformation">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Firstname</label>
                        <input type="text" name="firstname" class="form-control" id="firstname"  value="{{Auth::user()->firstname}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Lastname</label>
                        <input type="text" name="lastname" class="form-control" id="lastname" value="{{Auth::user()->lastname}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" id="email"  value="{{Auth::user()->email}}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" id="updateBasicInformationBtn">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
        <div class="card-box">
            <h4 class="header-title">Change Password</h4>
            <div class="card-body">
                <form id="updatePasswordForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Old password</label>
                        <input type="password" name="oldPassword" class="form-control" id="oldPassword"  placeholder="e.g xxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="e.g xxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="e.g xxxxxxxx">
                    </div>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" id="updatePasswordBtn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('customJs')
    <script>
        $('#updatePasswordForm').on('submit', function(e){
            e.preventDefault();
            $('#updatePasswordBtn').attr('disabled', true);
            $('#updatePasswordBtn').text('Please Wait...');
            if($('#oldPassword').val() == 0){
                toastr.error('Old password is required');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('Update');
            }else if(($('#newPassword').val().length == 0)){
                toastr.error('New password is required');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('Update');
            }else if($('#newPassword').val().length < 6){
                toastr.error('Password must be at least 6 characters long.');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('Update');
            }else if($('#confirmPassword').val() != $('#newPassword').val()){
                toastr.error('Confirm password not matched');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('Update');
            }else{
                let formData = new FormData(this);
                $.ajax({
                    url:"{{route('admin.setting.update.password')}}",
                    type:"POST",
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(data){
                        if(data.error != null){
                            $.each(data.error, function(key, val){
                                toastr.error(val[0]);
                            });
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('Update');
                           
                        }

                        if(data.status == 1){
                            toastr.success(data.message);
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('Update');
                            $('#updatePasswordForm')[0].reset();
                        }else{
                            toastr.error(data.message);
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('Update');
                        }
                    },
                    error:function(xhr, status, error){
                        if(xhr.status == 500 || xhr.status == 422){
                            toastr.error('Whoops! Something went wrong.');
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('Update');
                        }
                    }
                });
            }
        });


        $('#updateBasicInformation').on('submit', function(e){
            e.preventDefault();
            $('#updateBasicInformationBtn').attr('disabled', true);
            $('#updateBasicInformationBtn').text('Please Wait...');
            if($('#firstname').val().length < 3){
                toastr.error('Firstname is required. Must be at least 4 characters long ');
                $('#updateBasicInformationBtn').attr('disabled', false);
                $('#updateBasicInformationBtn').text('Update');
            }else if(($('#lastname').val().length < 3)){
                toastr.error('Lastname is required. Must be at least 4 characters long');
                $('#updateBasicInformationBtn').attr('disabled', false);
                $('#updateBasicInformationBtn').text('Update');
            }else if($('#email').val().length == 0){
                toastr.error('Email is required. Must be a valid email.');
                $('#updateBasicInformationBtn').attr('disabled', false);
                $('#updateBasicInformationBtn').text('Update');
            }else{
                let formData = new FormData(this);
                $.ajax({
                    url:"{{route('admin.setting.update.basic.info')}}",
                    type:"POST",
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(data){
                        if(data.error != null){
                            $.each(data.error, function(key, val){
                                toastr.error(val[0]);
                            });
                            $('#updateBasicInformationBtn').attr('disabled', false);
                            $('#updateBasicInformationBtn').text('Update');
                           
                        }

                        if(data.status == 1){
                            toastr.success(data.message);
                            $('#updateBasicInformationBtn').attr('disabled', false);
                            $('#updateBasicInformationBtn').text('Update');
                        }else{
                            toastr.error(data.message);
                            $('#updateBasicInformationBtn').attr('disabled', false);
                            $('#updateBasicInformationBtn').text('Update');
                        }
                    },
                    error:function(xhr, status, error){
                        if(xhr.status == 500 || xhr.status == 422){
                            toastr.error('Whoops! Something went wrong.');
                            $('#updateBasicInformationBtn').attr('disabled', false);
                            $('#updateBasicInformationBtn').text('Update');
                        }
                    }
                });
            }
        });
    </script>

@endsection
