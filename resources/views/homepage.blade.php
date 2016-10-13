@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="content-background">

                @include('partials.breaking-news')

                <div class="content-left">

                    <div class="sidebox">
                        <div class='title-block-orange'>Fantansy Focus</div>

                        <a href="{{ url('article', $fantasy->title_slug) }}">
                            <div id='score-card' class="mini-panel" style="background-image: url({{'/images/'.$fantasy->thumbnail}}); background-size: cover; height: 260px">
                                <div class="mini-description">
                                    <span class="text">{{ $fantasy->title }}</span>
                                    <div class="uploaded-at">
                                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                        <span>{{ $fantasy->publish_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="sidebox">
                        <div class='title-block'>Featured Video</div>

                        {{-- TODO: switch to a featured video content section--}}
                        <a href="{{ url('/article', $featured->title_slug) }}">
                            <div id='featured-video' class="mini-panel" style="background-image: url({{ "/images/".$featured->thumbnail }}); background-size: 272px 260px; height: 260px">
                                <div class="mini-description">
                                    <span class="text">{{ $featured->title }}</span>
                                    <div class="uploaded-at">
                                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                        <span>{{ $featured->publish_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <div class="content-middle">

                    <a href="{{ url('/article/'.$preview->title_slug) }}">
                        <div id="headline-panel" class="main-panel">
                            <div class="panel-body" style="background-image: url({{ "/images/".$preview->thumbnail }}); background-size: cover; height: 400px;">
                                <div class="preview-image">
                                    {{--                                <img src="/images/{{ $preview->thumbnail }}">--}}
                                </div>
                            </div>
                            <div class="panel-description">
                                <span>{{ $preview->title }}</span>
                                <div class="uploaded-at">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                    <span>{{ $preview->publish_date }}</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="main-panel">
                        <div class="panel-head">
                            <span class="section-title">Expert Columns</span>
                            <a href="{{ url('columns/expert') }}"><span class="view-all">View All</span></a>
                        </div>
                        <div class="panel-body">

                            @foreach($experts as $expert)
                                <a href="{{ url('/article', $expert->title_slug) }}">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="/images/{{  $expert->thumbnail }}" height="120" width="173">
                                        </div>
                                        <div class="card-description">
                                            <span class="card-title">{{ $expert->title }}</span>
                                            <div class="uploaded-at">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                                <span>{{$expert->publish_date}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>

                    <div class="main-panel">
                        <div class="panel-head">
                            <span class="section-title">Fantasy Golf Strategy Video</span>
                            <a href="{{ url('columns/strategy') }}"><span class="view-all">latest news from</span></a>
                        </div>
                        <div class="panel-body">
                            <a href="{{ url('article', $featuredStrategy->title_slug) }}">
                                <div class="feature">
                                    <div class="feature-image">
                                        <img src="/images/{{ $featuredStrategy->thumbnail }}">
                                    </div>
                                    <div class="feature-description">
                                        <h4>{{ $featuredStrategy->title }}</h4>
                                        <p>{!! $featuredStrategy->preview !!}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="main-panel">
                        <div class="panel-head">
                            <span class="section-title">More Fantasy Golf Strategy Articles</span>
                            <a href="{{ url('columns/strategy') }}"><span class="view-all">View All</span></a>
                        </div>
                        <div class="panel-body">
                            @foreach($strategies as $strategy)
                                <a href="{{ url('/article', $strategy->title_slug) }}">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="/images/{{  $strategy->thumbnail }}">
                                        </div>
                                        <div class="card-description">
                                            <span class="card-title">{{ $strategy->title }}</span>
                                            <div class="uploaded-at">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                                <span>{{$strategy->publish_date}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="content-right">

                    {{--<div class="cointent-widget" data-publisher-id="457" data-article-id="6279" data-article-title="Home" data-branding="messaging" data-show-subscription="4,5,11,12,13,14" data-view-type="condensed buyButtonOff" data-title="To access the premium content you will need to login or subscribe below!"></div>--}}

                    @include('partials.content-right')

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
