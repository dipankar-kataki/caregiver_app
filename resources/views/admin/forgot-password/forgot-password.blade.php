<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .form-gap {
            padding-top: 70px;
        }
        ::placeholder{
            color:rgb(143, 142, 142) !important;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="{{asset('admin/assets/images/logo-main.png')}}" alt="" style="width:220px;">
          </a>
        </div>
    </nav>
    <div class="row mt-5 forgot-password-div">
        <div class="col-md-4 col-md-offset-4 mx-auto">
            <div class="card card-default">
                <div class="card-body">
                    <div class="text-center">
                        <h6><i class="fa fa-key fa-4x"></i></h6>
                        <h4 class="text-center">Forgot Password?</h4>
                        <p>You can reset your password here.</p>
                        <div class="card-body">
                            <form id="sendResetLinkForm" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="e.g johndoe@xyz.com" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-block btn-primary send-reset-link-btn" style="background: linear-gradient( 327deg, rgba(0, 232, 101, 1) 0%, rgba(0, 105, 224, 1) 100% );">Send Reset Link</button>
                                </div>
                                <div class="form-group">
                                    <a href="/" style="font-size:15px; color:grey;text-decoration:none;">Go Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 verify-otp-div">
        <div class="col-md-4 col-md-offset-4 mx-auto">
            <div class="card card-default">
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="text-center">ENTER OTP</h5>
                        <div class="card-body">
                            <form id="verifyOtpForm" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_1" id="otp_val_1" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_2" id="otp_val_2" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_3" id="otp_val_3" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_4" id="otp_val_4" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_5" id="otp_val_5" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="otp_val_6" id="otp_val_6" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-block btn-primary verify-otp-btn" style="background: linear-gradient( 327deg, rgba(0, 232, 101, 1) 0%, rgba(0, 105, 224, 1) 100% );">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 enter-new-pwd-form">
        <div class="col-md-4 col-md-offset-4 mx-auto">
            <div class="card card-default">
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="text-center">Change Password</h5>
                        <div class="card-body">
                            <form id="newPwdForm" autocomplete="off">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirmPassword" id="confPassword" class="form-control" placeholder="Enter confirm password" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-block btn-primary submit-password-btn" style="background: linear-gradient( 327deg, rgba(0, 232, 101, 1) 0%, rgba(0, 105, 224, 1) 100% );">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>


        $('.verify-otp-div').css('display', 'none');
        $('.enter-new-pwd-form').css('display', 'none');

        
        $('#sendResetLinkForm').on('submit', function(e){
            e.preventDefault();

            $('.send-reset-link-btn').attr('disabled', true);
            $('.send-reset-link-btn').text('Please wait...');
            let formData = new FormData(this);
            sessionStorage.setItem("email", $('#email').val());
            $.ajax({
                url:"{{route('admin.forgot.password.send.reset.link')}}",
                type:"POST",
                contentType:false,
                processData:false,
                data:formData,
                success:function(data){
                   
                    if(data.error != null){
                        swal({
                            title: "Whoops!",
                            text: data.error[0],
                            icon: "error",
                        });
                    }

                    if(data.status == 200){
                        swal({
                            title: "Great!",
                            text: data.message,
                            icon: "success",
                        });
                        
                        $('.verify-otp-div').css('display', 'block');
                        $('.forgot-password-div').css('display', 'none');
                    }else{
                        swal({
                            title: "Whoops!",
                            text: data.message,
                            icon: "error",
                        });
                    }
                   
                    $('.send-reset-link-btn').attr('disabled', false);
                    $('.send-reset-link-btn').text('Send Reset Link');
                    $('#sendResetLinkForm').trigger('reset');
                },
                error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        swal({
                            title: "Error",
                            text: 'Whoops! Something went wrong.',
                            icon: "error",
                        });
                        $('.send-reset-link-btn').attr('disabled', false);
                        $('.send-reset-link-btn').text('Send Reset Link');
                    }
                }
            });

        });

        $('#verifyOtpForm').on('submit', function(e){
            e.preventDefault();

            $('.verify-otp-btn').attr('disabled', true);
            $('.verify-otp-btn').text('Please wait...');
            if( ($('#otp_val_1').val().length == 0) || ($('#otp_val_2').val().length == 0) || ($('#otp_val_3').val().length == 0) || ($('#otp_val_4').val().length == 0) || ($('#otp_val_5').val().length == 0) || ($('#otp_val_6').val().length == 0) ){
                swal({
                    title: "Whoops!",
                    text: 'OTP fields are mandatory',
                    icon: "error",
                });
            }else{
                let formData = new FormData(this); 
                $.ajax({
                    url:"{{route('admin.forgot.password.verify.otp')}}",
                    type:"POST",
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(data){
                        if(data.error != null){
                            swal({
                                title: "Whoops!",
                                text: data.error,
                                icon: "error",
                            });

                            $('.verify-otp-btn').attr('disabled', false);
                            $('.verify-otp-btn').text('Verify OTP');
                        }

                        if(data.status == 200){
                            swal({
                                title: "Great!",
                                text: data.message,
                                icon: "success",
                            });
                            $('.enter-new-pwd-form').css('display', 'block');
                            $('.verify-otp-div ').css('display', 'none');
                        }else{
                            swal({
                                title: "Whoops!",
                                text: data.message,
                                icon: "error",
                            });
                            $('.verify-otp-btn').attr('disabled', false);
                            $('.verify-otp-btn').text('Verify OTP');
                        }
                    },
                    error:function(xhr, status, error){
                        if(xhr.status == 500 || xhr.status == 422){
                            swal({
                                title: "Whoops!",
                                text: 'Something went wrong.',
                                icon: "error",
                            });
                            $('.verify-otp-btn').attr('disabled', false);
                            $('.verify-otp-btn').text('Verify OTP');
                        }
                    }
                });
            }
        });

        $('#newPwdForm').on('submit', function(e){
            e.preventDefault();

            $('.submit-password-btn').attr('disabled', true);
            $('.submit-password-btn').text('Please wait...');

            if($('#password').val() != $('#confPassword').val()){
                swal({
                    title: "Whoops!",
                    text: 'Password not matched.',
                    icon: "error",
                });
                $('.submit-password-btn').attr('disabled', false);
                $('.submit-password-btn').text('Submit');
            }else{
                $.ajax({
                    url:"{{route('admin.forgot.password.change.password')}}",
                    type:"POST",
                    data:{
                        "_token" : "{{csrf_token()}}",
                        "email" : sessionStorage.getItem("email"),
                        "password" : $('#confPassword').val()
                    },
                    success:function(data){

                        if(data.status == 200){
                            swal({
                                title: "Great!",
                                text: data.message,
                                icon: "success",
                            });
                            sessionStorage.removeItem("email")
                            location.reload(true);
                        }else{
                            console.log(data.message)
                            swal({
                                title: "Error!",
                                text: data.message,
                                icon: "error",
                            }); 

                            $('.submit-password-btn').attr('disabled', false);
                            $('.submit-password-btn').text('Submit');
                        }
                        
                    },
                    error:function(xhr, status, error){
                        if(xhr.status == 500 || xhr.status == 422){
                            swal({
                                title: "Error!",
                                text: data.message,
                                icon: "error",
                            }); 

                            $('.submit-password-btn').attr('disabled', false);
                            $('.submit-password-btn').text('Submit');
                        }
                    }
                });
            }
        });



    </script>
</body>
</html>