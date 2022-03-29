@extends('site.common.main')

@section('customHeader')
    <style>
        .main {
            margin-top: 100px;
        }

        .navbar .navbar-collapse .navbar-nav .nav-item .nav-link {
            color: #111;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
        }

        .navbar .navbar-brand img {
            filter: none;
        }

    </style>
@endsection

@section('siteTitle', 'PeaceWorc | Read Blog')

@section('main')
    <!-- Navbar -->
    @include('site.common.navbar')

    <div class="container main" id="blogDetails">
        <h1 class="mb-3">{{$blog_details->title}}</h1>
        <img src="{{$blog_details->image}}"
            width="100%" alt="">

        <div class="details">
            <p class="my-4 fw-bold">Posted : {{$blog_details->created_at->format('M d, Y')}} {{$blog_details->created_at->diffForHumans()}}</p>
            <p>{{$blog_details->content}}</p>
        </div>
    </div>
@endsection

@section('customJs')
@endsection
