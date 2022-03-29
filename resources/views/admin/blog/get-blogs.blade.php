@extends('admin.common.main')

@section('cunstomHeader')
   
@endsection


@section('title', 'Admin | Blog')


@section('content')
    <div class="row">
        <div class="col-12">
            <button class="btn btn-teal waves-effect waves-light m-2" style="float:right;box-shadow: 0px 5px 10px #bdbbbb;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addBlogModal"><i class="mdi mdi-bookmark-plus-outline"></i>&nbsp; Create Blog</button>
        </div>
    </div>
    <div class="row">
        @forelse ($details as $item)
            <div class="col-md-4 col-sm-12">
                <div class="card blog-post">
                    <div class="post-image">
                        <img src="{{asset($item->image)}}" alt="" class="img-fluid d-block" style="height:275px; width:100%; object-fit:cover;">
                    </div>
                    <div class="card-body">
                        <div class="text-muted"><span>Posted :</span> <span>{{$item->created_at->diffForHumans()}}</span></div>
                        <div class="post-title">
                            <h5><a href="javascript:void(0);">{{Str::of($item->title)->limit(30)}}</a></h5>
                        </div>
                        <p>{{Str::of($item->content)->limit(100)}}</p>
                        <div class="text-right">
                            <a href="javascript:void(0);" class="btn btn-success btn-sm waves-effect waves-light">Read More <i class="mdi mdi-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <h5 class="text-muted">No Blogs To Show</h5>
            </div>
        @endforelse
        
    </div>

    <!-- Add blog Modal -->

    <div id="addBlogModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0">Create Blog.
                        <p style="font-size:14px;"><span style="color:red !important;">Note:</span> All fields are mandatory.</p>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="blogForm" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="control-label">Add Title</label>
                                    <input type="text" class="form-control" name="title" id="titleBlog" placeholder="e.g Exclusive: Get a First Look at the Fall Collection">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add Image</label>
                                    <input type="file" name="blogImage" id="blogImage" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add Content</label>
                                    <textarea name="blogContent" id="blogContent" class="form-control" cols="30" rows="10" placeholder="Write here"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div style="float:right;">
                                    <button type="button" class="btn btn-secondary waves-effect" id="blogCloseModalBtn">Close</button>
                                    <button type="submit" class="btn btn-info waves-effect waves-light" id="blogSubmitModalBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('cunstomJS')
    <script>
        $('#blogForm').on('submit', function(e){
            e.preventDefault();

            $('#blogSubmitModalBtn').text('Please wait...');
            $('#blogSubmitModalBtn').attr('disabled', true);
            $('#blogCloseModalBtn').attr('disabled', true);

            let formData = new FormData(this);
            $.ajax({
                url:"{{route('admin.create.blog')}}",
                type:"POST",
                data: formData,
                processData:false,
                contentType:false,
                success:function(data){
                    console.log(data);

                    if(data.error != null){
                        $.each(data.error, function(key, val){
                            toastr.error(val);
                        });

                        $('#blogSubmitModalBtn').text('Submit');
                        $('#blogSubmitModalBtn').attr('disabled', false);
                        $('#blogCloseModalBtn').attr('disabled', false);
                    }

                    if(data.status == 1){
                        toastr.success(data.message);

                        $('#blogSubmitModalBtn').text('Submit');
                        $('#blogSubmitModalBtn').attr('disabled', false);
                        $('#blogCloseModalBtn').attr('disabled', false);

                        location.reload(true);
                    }else{
                        toastr.error(data.message);
                    }
                },
                error:function(xhr, status, error){
                    if(xhr.status == 500 || xhr.status == 422){
                        toastr.error('Whoops! Something went wrong');
                        
                        $('#blogSubmitModalBtn').text('Submit');
                        $('#blogSubmitModalBtn').attr('disabled', false);
                        $('#blogCloseModalBtn').attr('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
