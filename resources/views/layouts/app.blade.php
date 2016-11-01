<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fantasy Golf Insider</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('styles')

</head>
<body id="app-layout">

<div class="background">

    <div class="logo-header">
        <a href="{{ url('/') }}"><img src="/images/fgi_logo.png" width="375" height="100"></a>
        <a href="#store"><img src="/images/StoreBanner01.jpg" width="728" height="90"></a>
    </div>

    <nav class="navbar navbar-inverse navbar-static-top" data-spy="affix" data-offset-top="160" data-offset-bottom="0">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @include('partials.nav-bar')

                <!-- Right Side Of Navbar -->
                <ul id="bladeLRNav" class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a onclick="cointentLogin()">Login</a></li>
                        <li><a onclick="cointentSubscribe()">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->email }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a id="logoutLink" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    {{--<li><a href="#">Shop</a></li>--}}
                </ul>

                <ul id="JSLRNav" class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span id="userEmail"></span> <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a id="logoutLink" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                    {{--<li><a href="#">Shop</a></li>--}}
                </ul>

            </div>
        </div>
    </nav>

    <div id="content">
        @yield('content')
    </div>

    <div class="footer">
        @include('layouts.footer')
    </div>

</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script> --}}
{{-- <script type="text/javascript">stLight.options({publisher: "01e820bc-8fcd-4a02-a8f6-0e138fef13dc", doNotHash: true, doNotCopy: false, hashAddressBar: false});</script> --}}
{{-- <script src="/build/js/stupidtable.min.js"></script> --}}

{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

<script src="//connect.cointent.com/cointent.0.2.js"></script>

<script type="text/javascript">

    var registered = false;
    var loggedin = false;


    cointent.ready(function() {
        console.log('cointent ready');

        if (!loggedin) {
            console.log('not logged in check cointent');

            cointent.checkLogin(457, function() {

                var AuthToken = cointent.getAuthToken();

                if (AuthToken.uid != "") {

                    AuthToken.password = AuthToken.email;

                    login(AuthToken);
                    loggedin = true;

                }
            });
        }
//            console.log('CoinTent client is ready to go!');
//
//            console.log(cointent.getAuthToken());
//
////            cointent.addSubscribeCallback(function(planId) {
////                console.log('You have just subscribed to plan '+planId);
////            });
//
//            cointent.addLinkCallback(function(publisherId) {
//                console.log('link callback');
//                var AuthToken = cointent.getAuthToken();
//                console.log("after cointent get auth");
//                console.log('User completed linking of accounts, link token is: '+AuthToken.linkToken);
//                console.log(AuthToken);
//            });
//
//            cointent.addPasswordSetupCallback(function() {
//                console.log('You have finished setting up your password!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });
//
//            cointent.addUnlockCallback(function(publisher, article) {
//                console.log('You have just unlocked the article #'+article+'!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });
//
//            cointent.addLockCallback(function(publisher, article) {
//                console.log('You have just logged out. Now hiding or removing the article #'+article+'!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });
//
//            cointent.addLoginCallback(function() {
//                console.log('You are logged in!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });

        cointent.addJustLoggedInCallback(function() {
            console.log('cointent justLoggedInCallback');

            if (!loggedin) {
                loggedin = true;
                var AuthToken = cointent.getAuthToken();

                AuthToken.password = AuthToken.email;

                $.ajax({
                    url: "/login",
                    method: "POST",
                    data: AuthToken,
                    dataType: 'json'
                })
                        .success(function(data) {
                            $("#bladeLRNav").hide();
                            $("#userEmail").html(AuthToken.email);
                            $("#JSLRNav").show();
                            $("#adminAccess").show();
                        })
                        .error(function(data) {
//                            cointent.logout();
                            register(AuthToken);
                            cointentSubscribe();
                        });

            }

        });

//            cointent.addLogoutCallback(function() {
//                console.log('You have just logged out!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });

        cointent.addSignupCallback(function() {
            console.log("cointent SignupCallback");

            if (!registered) {
                registered = true;
                loggedin = true;
                var AuthToken = cointent.getAuthToken();

                $.ajax({
                    url: "/register",
                    method: "POST",
                    data: AuthToken,
                    success: function (data) {
                        $("#bladeLRNav").hide();
                        $("#userEmail").html(AuthToken.email);
                        $("#JSLRNav").show();
                    }
                });

            }
        });

        cointent.addSubscribeCallback(function(planId) {
            console.log('cointent SubscribeCallback');

            var AuthToken = cointent.getAuthToken();

            var data = $.extend({}, AuthToken, {planId: planId});

            $.ajax({
                url: '/select-plan',
                method: 'POST',
                data: data
            })
                    .success(function(data) {

                    })
                    .error(function(data) {
                    })

        });

//            cointent.addSpendCallback(function(publisherId, articleId) {
//                console.log('You have just purchased '+articleId);
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });
//
//            cointent.addClickCallback('subscription', function() {
//                console.log('The user just clicked the Subscription Options button!');
//                var AuthToken = cointent.getAuthToken();
//                console.log(AuthToken);
//            });


    });

    $(document).on('click', "#logoutLink", function() {
        cointent.logout();
    });

    function cointentLogin() {
        cointent.login(457);
    }

    function cointentSubscribe() {
        cointent.subscribe(457, 1, [4,5,11,12,13,14], 11);
    }

    function register(AuthToken) {
        $.ajax({
            url: "/register",
            method: "POST",
            data: AuthToken
        })
                .success(function(data) {

                })
                .error(function(data) {


                });
    }

    function login(AuthToken) {

        $.ajax({
            url: "/login",
            method: "POST",
            data: AuthToken
        })
                .success(function(data) {
                    $("#bladeLRNav").hide();
                    $("#userEmail").html(AuthToken.email);
                    $("#JSLRNav").show();

                    if (!data.error && data.plan_id === null) {

                        cointentSubscribe();

                    }
                })
                .error(function(data) {
                });

    }
</script>

@yield('scripts')
</body>
</html>