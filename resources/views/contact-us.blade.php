@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">contact us
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">

                                <form action="{{ url('/contact-us') }}" method="post">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name">

                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name">

                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="contactEmail">Email</label>
                                        <input type="email" class="form-control" id="contactEmail" name="email" placeholder="Email">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>

                                        @if ($errors->has('comment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-golf-green">Submit</button>
                                </form>

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