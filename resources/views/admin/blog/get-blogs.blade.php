@extends('admin.common.main')

@section('cunstomHeader')
   
@endsection


@section('title', 'Admin | Blog')


@section('content')
    <div class="row">
        <div class="col-12">
            <button class="btn btn-teal waves-effect waves-light mb-3" style="float:right;box-shadow: 0px 5px 10px #bdbbbb;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addBlogModal"><i class="mdi mdi-bookmark-plus-outline"></i>&nbsp; Create Blog</button>
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
                        <p>{{Str::of($item->content)->limit(50)}}</p>
                    </div>
                    <div class="card-footer">
                        <div class="action-buttons">
                            @if ($item->is_activate == 1)
                                <label class="switch">
                                    <input type="checkbox" id="changeBlogStatus" data-id="{{ $item->id }}" checked>
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" id="changeBlogStatus" data-id="{{ $item->id }}">
                                    <span class="slider round"></span>
                                </label>
                            @endif
                            {{-- <a href="{{ route('admin.edit.blog',['id'=>\Crypt::encrypt($item->id)]) }}"
                                class="btn btn-gradient-primary btn-rounded btn-icon anchor_rounded float-right mb-3" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a> --}}
                        </div>
                        <a href="{{ route('site.blog', ['id' => Crypt::encrypt($item->id), 'viewAs' => 'admin']) }}" target="_blank" class="btn btn-success btn-sm waves-effect waves-light">Read More <i class="mdi mdi-arrow-right ml-1"></i></a>
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
                        <p style="font-size:14px;"><span>Note:</span> Fields marked as (<span style="color:red;">*</span>) are mandatory.</p>
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
                                    <label for="title" class="control-label">Add Title <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="title" id="titleBlog" placeholder="e.g Exclusive: Get a First Look at the Fall Collection" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image upload <sup class="text-danger">*</sup></label>
                                    <input type="file" class="filepond" name="blogImage" id="blogImage" data-max-file-size="1MB" data-max-files="1" required>
                                    <span class="text-danger" id="blogImage"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Add Content <sup class="text-danger">*</sup></label>
                                    <textarea name="blogContent" id="blogContent" class="form-control" cols="30" rows="10" placeholder="Write here" required></textarea>
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


@section('customJs')
    <script>

        FilePond.registerPlugin(

            FilePondPluginFileEncode,

            FilePondPluginFileValidateSize,

            FilePondPluginImageExifOrientation,

            FilePondPluginImagePreview,

            FilePondPluginFileValidateType
        );

        // Select the file input and use create() to turn it into a pond
        pond = FilePond.create(
            document.getElementById('blogImage'), {
                allowMultiple: true,
                maxFiles: 1,
                instantUpload: false,
                imagePreviewHeight: 135,
                acceptedFileTypes: ['image/*'],
                labelFileTypeNotAllowed:'Not a valid image.',
                labelIdle: '<div style="width:100%;height:100%;"><p> Drag &amp; Drop your files or <span class="filepond--label-action" tabindex="0">Browse</span><br> Maximum number of image is 1 :</p> </div>',
            }
        );


        $('#blogCloseModalBtn').on('click',function(){
            $('#addBlogModal').modal('hide');
        });

        $('#blogForm').on('submit', function(e){
            e.preventDefault();

            $('#blogSubmitModalBtn').text('Please wait...');
            $('#blogSubmitModalBtn').attr('disabled', true);
            $('#blogCloseModalBtn').attr('disabled', true);

            let formData = new FormData(this);

            pondFiles = pond.getFiles();
            for (var i = 0; i < pondFiles.length; i++) {
                // append the blob file
                formData.append('blogImage', pondFiles[i].file);
            }

            $.ajax({
                url:"{{route('admin.create.blog')}}",
                type:"POST",
                data: formData,
                processData:false,
                contentType:false,
                success:function(data){
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
                        $('#blogSubmitModalBtn').text('Submit');
                        $('#blogSubmitModalBtn').attr('disabled', false);
                        $('#blogCloseModalBtn').attr('disabled', false);
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


        $(document.body).on('change', '#changeBlogStatus', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var blog_id = $(this).data('id');
            // console.log(status);
            var formData = {
                blog_id: blog_id,
                status: status,
                '_token' : "{{csrf_token()}}"
            }
            $.ajax({
                type: "post",
                url: "{{ route('admin.change.blog.active.status') }}",
                data: formData,

                success: function(data) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        location.reload(true);
                    }, 2000);
                }
            });
        });
    </script>
@endsection
