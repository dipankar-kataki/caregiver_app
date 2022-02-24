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

@section('siteTitle', 'PeaceWorc | Blogs')

@section('main')
    <!-- Navbar -->
    @include('site.common.navbar')

    <div class="container main">
        <div class="row">
            @for ($i = 0; $i < 10; $i++)
                <div class="col-sm-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80"
                            alt="">
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural
                                lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="location.href='{{ route('site.blog', ['id' => Crypt::encrypt(1)]) }}';">View</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection

@section('customJs')
@endsection
