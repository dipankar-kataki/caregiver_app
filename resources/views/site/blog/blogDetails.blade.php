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
        <h1 class="mb-3">This is a wider card with supporting text below as a natural
            lead-in to additional content. This content is a little bit longer.</h1>
        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80"
            width="100%" alt="">

        <div class="details">
            <p class="my-4 fw-bold">Admin | Feb 18, 2022 - 4:13 p.m.</p>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
                electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
                Aldus PageMaker including versions of Lorem Ipsum.</p>

            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking
                at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters,
                as opposed to using 'Content here, content here', making it look like readable English. Many desktop
                publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for
                'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the
                years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>

            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
                literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem
                Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable
                source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes
                of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular
                during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in
                section 1.10.32.</p>
        </div>
    </div>
@endsection

@section('customJs')
@endsection
