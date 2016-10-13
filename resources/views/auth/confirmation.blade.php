@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="loginForm" class="panel panel-default">
                    <div class="panel-heading">Cointent</div>
                    <div class="panel-body">
                        {{--<div class="cointent-widget"--}}
                             {{--data-publisher-id="457"--}}
                             {{--data-article-id="1"--}}
                             {{--data-article-title="Home"--}}
                             {{--data-show-subscription="11"--}}
                             {{--data-view-type="condensed"--}}
                             {{--data-title="To access the premium content you will need to login or subscribe below!"--}}
{{--                             data-link-email="{{ Auth::User()->email }}"--}}
{{--                             {{Auth::User()->cointent_link ? 'data-link-token='.Auth::User()->cointent_link : '' }}--}}
                        {{--></div>--}}

                        {{--<div class="cointent-link" data-publisher-id="457"></div>--}}
                        <button class="btn btn-golf-green" onclick="pass()">PASSCODE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection