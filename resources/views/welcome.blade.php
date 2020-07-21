<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Book Stomp</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                background-image: url("img/bg2.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-color: #f5f5f3;
            }

            .full-height {
                height: 50vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .searchinput{
                width: 500px;
                border-radius: 5px;
                border: 1px solid silver;
                padding: 5px;
                height: 30px;
                line-height: 30px;
                font-size: 1.2em;
                font-weight: normal;
                color: #7f7878;
                text-align: center;
            }
            .searchbutton{
                height: 40px;
                margin-top: 10px;
                border: 1px solid silver;
                border-radius: 5px;
                width:500px;
            }

            .bigsearch {
                margin-top:20px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/genres') }}">Browse Generes</a>
                    <a href="{{ url('/authors') }}">Browse Authors</a>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{url('/profile')}}">Profile</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title">Book Stomp</div>
                <div class="subtitle">
                    A place for indie authors to showcase their work and reach readers
                </div>
                <div class="bigsearch">
                    <form action="/search" method="post">
                        @csrf
                        <label for="search">Search for books, authors or genres</label>
                        <div class="form-group">
                            <input class="searchinput" type="text" class="form-control" id="search" name="search" placeholder="I'm looking for...">
                        </div>
                        <button class="btn searchbutton">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
