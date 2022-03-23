@extends('admin.common.main')

@section('cunstomHeader')
<style>
    .profilePic img{
        height: 150px;
        width: 150px;
        object-fit: cover;
    }

    .form-control:disabled, .form-control[readonly]{
        background: #fff
    }
</style>
@endsection


@section('title', 'Admin | Caregiver Profile')


@section('main')
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> Caregiver Profile
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                    </li>
                </ul>
            </nav>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="profilePic text-center mb-3">
                        <img src="{{ asset('admin/assets/images/faces/face1.jpg') }}" alt="">
                    </div>
                    <div class="details">
                        <form action="#">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="name" name="name"
                                        value="Alexa Brown">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="email" name="email"
                                        value="alexa.brown@gmail.com">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age" class="col-sm-2 col-form-label">Age</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="age" name="age"
                                        value="Alexa Brown">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="address" name="address"
                                        value="Guwahati">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exp" class="col-sm-2 col-form-label">Caregiver Exp.</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="exp" name="exp" value="27 Years">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="careCompleted" class="col-sm-2 col-form-label">Care Completed</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="careCompleted"
                                        name="careCompleted" value="05">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                <div class="col-sm-10">
                                    <textarea type="text" readonly class="form-control" rows="7" id="bio" name="bio"
                                        value="05">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">Documents</h2>
                        <ul>
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

                        <div class="text-center">
                            <a href="#" class="btn btn-primary">Go Back</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('cunstomJS')

@endsection
