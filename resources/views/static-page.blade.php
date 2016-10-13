@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">{{ $page->title }}
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">

                                @if(!empty($page->subscription_group))

                                    @if( Auth::check() and Auth::User()->can('view', $page))
                                        <p>{!! $page->content !!}</p>
                                    @else
                                        <p>{!! $page->preview !!}</p>

                                        {{--<div class="cointent-widget" data-publisher-id="457" data-article-id="6279" data-article-title="Home" data-branding="messaging" data-show-subscription="4,5,11,12,13,14" data-view-type="condensed buyButtonOff" data-title="To access the premium content you will need to login or subscribe below!"></div>--}}

                                        @include('partials.register-to-view')

                                    @endif

                                @else

                                    <p>{!! $page->content !!}</p>

                                @endif

                            </div>

                        </div>

                        <div class="article-right">
                            @include('partials.content-right')
                        </div>

                        <div class="clear"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection