<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $system_title }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

</head>
<body id="app-layout">

    <div id="main">
        {{--<div id="upload_hotspot"></div>--}}
        <div id="navigation">

            <!-- Navigation Header -->
            <div class="header">
                <a href="/" class="logo">
                    <img src="/images/fgi_logo.png">
                </a>
                <a href="#" class="collapse">
                    <span class="fa fa-chevron-circle-left"></span>
                </a>
            </div>

            <!-- Navigation Buttons -->
            <ul>
                @foreach($navigation as $nav)

                    <li>
                        <a href="{{ $nav->url }}">
                            <i class="fa {{ $nav->icon }}"></i>
                            <span>{{ $nav->title }}</span>
                        </a>
                    </li>

                @endforeach
            </ul>
        </div>
        <div id="content">

            <!-- Toolbar -->
            <div class="toolbar">
                <a href="#" id="menu_anchor">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

            @yield("header")

            <div class="area">
                @yield("content")
            </div>

        </div>
    </div>

    <!-- JavaScripts -->
    <script src="/components/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="/components/stacktable.js/stacktable.js"></script>
    <script src="/components/dropzone/dist/min/dropzone.min.js"></script>
    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>

    <script src="{{ elixir('js/all.js') }}"></script>

    @yield("scripts")

</body>
</html>
