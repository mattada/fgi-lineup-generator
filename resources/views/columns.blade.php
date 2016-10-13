@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">Expert Columns
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">

                                @foreach($columns as $column)

                                    <div class="expert-block">
                                        <div class="column-thumbnail">
                                            <img src="/images/{{$column->thumbnail}}">
                                        </div>

                                        <div class="info-block">
                                            <div class="expert-title">
                                                {{ $column->title }}
                                            </div>
                                            <div class="publish-info">
                                                <span class="publisher">{{ $column->author }}</span>
                                                <span class="publish-time"><span class="glyphicon glyphicon-time"></span> {{ $column->publish_date }}</span>
                                            </div>
                                            <div class="preview">
                                                <p></p>
                                            </div>
                                            <a href="/article/{{$column->title_slug}}" class="btn btn-default read-article">Read Full Article</a>
                                        </div>
                                    </div>

                                @endforeach

                                <div class="pages">
                                    {{ $columns->links() }}
                                </div>

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