@extends('admin.common.main')

@section('cunstomHeader')

@endsection


@section('title', 'Admin | Setting')


@section('content')
<div class="col-lg-6 col-md-6 col-sm-12 mt-4">
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
        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" id="updatePasswordBtn">UPDATE</button>
    </form>
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
                $('#updatePasswordBtn').text('UPDATE');
            }else if(($('#newPassword').val().length == 0)){
                toastr.error('New password is required');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('UPDATE');
            }else if($('#newPassword').val().length < 6){
                toastr.error('Password must be at least 6 characters long.');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('UPDATE');
            }else if($('#confirmPassword').val() != $('#newPassword').val()){
                toastr.error('Confirm password not matched');
                $('#updatePasswordBtn').attr('disabled', false);
                $('#updatePasswordBtn').text('UPDATE');
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
                            $('#updatePasswordBtn').text('UPDATE');
                           
                        }

                        if(data.status == 1){
                            toastr.success(data.message);
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('UPDATE');
                            $('#updatePasswordForm')[0].reset();
                        }else{
                            toastr.error(data.message);
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('UPDATE');
                        }
                    },
                    error:function(xhr, status, error){
                        if(xhr.status == 500 || xhr.status == 422){
                            toastr.error('Whoops! Something went wrong.');
                            $('#updatePasswordBtn').attr('disabled', false);
                            $('#updatePasswordBtn').text('UPDATE');
                        }
                    }
                });
            }
        });
    </script>

@endsection
