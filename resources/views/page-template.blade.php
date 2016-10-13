@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">Content Title
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">



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