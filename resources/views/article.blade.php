@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class='article-body'>

                    <div class="article-header">
                        <div class="title-left">
                            <h1>{{ $article->title }}</h1>
                            <div class="author-block">
                                <div class="author-picture"></div>
                                <div class="author-info">
                                    <span class="author-name">{{ $article->author }}</span>
                                    <span class="publish-time">{{$article->publish_date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="title-right">

                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="article-content">

                        <div class="article-left">

                            <div class="article-text">

                                @if(!empty($article->subscription_group))

                                    @if( Auth::check() and Auth::User()->can('view', $article))
                                        <p>{!! $article->content !!}</p>
                                    @else
                                        <p>{!! $article->preview !!}</p>

                                        {{--<div class="cointent-widget" data-publisher-id="457" data-article-id="6279" data-article-title="Home" data-branding="messaging" data-show-subscription="4,5,11,12,13,14" data-view-type="condensed buyButtonOff" data-title="To access the premium content you will need to login or subscribe below!"></div>--}}

                                        @include('partials.register-to-view')

                                    @endif

                                @else

                                    <p>{!! $article->content !!}</p>

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