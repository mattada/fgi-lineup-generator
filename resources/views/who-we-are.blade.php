@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">who we are
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">

                                <p>
                                    We are a fantasy golf website and we are fantasy golf experts. We are not a fantasy football website that dabbles in golf in the football off-season. This is the only thing we do and we excel at it. Fantasy Golf Insider assembled a team of highly experienced and highly successful fantasy golf players in season long, high stakes. and Daily Fantasy Golf. In the past 12 months alone our professionals have won over $102,000 playing daily fantasy golf. We analyze numerous variables prior to every tournament to formulate our picks. We have compiled this information along with our proprietary ranking system to bring you the information that is critical to you making money playing fantasy golf.
                                    No other website brings to you the quality of data, in depth information, or the critical tips as to how to become successful playing fantasy golf. Some websites and fantasy golf forums will give out a few of their “picks” for free. The problem is that most of the time they are not using all the technical tools and really putting in the time and research that we do. Our website provides content that no other does throughout the fantasy golf industry.
                                </p>

                                <p>
                                    We also offer invaluable insight and insider information that is critical to you making money playing fantasy golf. Here are a couple of examples of information that we had and used to profit from. In July 2013, for the RBC Canadian Open, we knew that Hunter Mahan was expecting the birth of his first child. Even though we thought he would play well, we knew that if his wife went into labor, he would withdraw from the tournament. We did not want to take that risk, so we stayed away from picking Mahan in all of our contests that weekend. What happened? Mahan was leading the RBC Canadian Open after 36 holes, his wife went into labor, and he withdrew from the tournament. Everybody who picked him that weekend lost their money to us. A similar situation arose during the 2014 PGA Tour Championship event, when Billy Horschel and his wife were expecting a child. This time however we knew that Horschel planned to keep playing the tournament even if his wife went into labor. So we rode his red hot streak and he went on to win the tournament and we benefited.
                                </p>

                                <p>
                                    Last minute withdrawals happen all the time in golf. Wouldn’t it be nice to know when somebody withdraws from a tournament so that you do not pick them? We will post any last minute withdrawals under the breaking news on our website or send out emails to all of our premium members whenever we hear of a withdrawal, and we are always watching and connecting with inside sources.
                                </p>

                                <p>
                                    We are members of the Fantasy Sports Trade Association (FSTA) and take our role in the industry seriously and are dedicated to providing our readers and members the best news, information, statistics, and advice anywhere.
                                </p>

                                <p>
                                    Look for us on The Pat Mayo Hour on Fantasysportsnetwork.com, podcasts, appearances on The Scout Fantasy Radio Show  with Dr. Roto and Tommy G on the Fantasy Sports network on Sirius/XM every Wednesday night, and in various industry publications.
                                </p>

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