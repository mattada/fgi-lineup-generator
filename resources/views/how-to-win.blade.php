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

                                {!! $page->content !!}

                                {{--<p>--}}
                                    {{--Daily fantasy sports are the fastest growing form of fantasy sports and it is easy to see why.  The strategy and excitement that comes along with constructing a roster of golfers and then rooting them on that weekend is unmatched.  There are many websites out there offering daily fantasy golf.  Visit one of them by clicking on one of the links on our home page and enjoy a great bonus with your first deposit.  The information that we provide is invaluable and applicable to every daily fantasy site.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Game Selection-</strong> There are several types of contests available to play.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Head-to-Head-</strong> which will match you up against one other person.  Whoever scores more points of the two of you wins the contest.  Theoretically, you have a 50% chance of winning this type of contest.  However, be aware that there are players out there with a vast knowledge and experience, like us  and thus have a significant edge over a beginner.  With the information we provide you on this website, there is no question you can beat anybody in the world.  But why try?  To use an analogy for those of you that play poker.  If your objective is to make money and you have the option of playing heads up vs. Phil Ivey (one of the best poker players in the world) or your neighbor, Bill, which would you choose?  If you are good, you could occasionally beat Phil Ivey, but probably not the majority of the time and we want you to win the majority of the time.  Generally if you see a player with a whole lot of entries, steer clear of them.  They probably have quite a bit of experience and information.   Our objective is to make money and we want you to have the largest edge possible, which is what we give you by providing you this website.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>50/50-</strong> contest s are our favorite contests to enter.  In these contests, roughly half the field doubles their money. There maybe 10 people or 100 people in a 50/50 contest.  All you have to do is be better than average in these contests to make money and we can definitely get you there. Feel free to enter whatever stakes your bankroll allows, see bankroll management.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Guaranteed or Guaranteed Prize Pools (GPP)-</strong> These contests include any number of entrants and possibly in the hundreds or  thousands. These tournaments usually pay out those entries that finish in the top 10-20% of the field.  They offer larger prizes to the winners, but there are also far less winners.  These contests are far more volatile to your bankroll as money making finishes are harder to come by than head-to-head contests or 50/50s.  When you do however cash in these contests, the winnings can be huge!, sometimes tens or hundreds of thousands of dollars.  We like our members to enter these contests, but it is important to adhere to your bankroll management.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Selecting a Team-</strong> Once you have selected the contest you want to enter, it is time to assemble your team.  Select the best golfers using all of the information on our website within the salary cap constraints.  There are many criteria that our professionals use to select winning lineups every week with the most important criteria  having tabs on our homepage to their own distinct pages.  These include:--}}
                                {{--</p>--}}

                                {{--<ul>--}}
                                    {{--<li>--}}
                                        {{--Who’s Hot. What golfers are playing well over the past 3,6,12 months.  Momentum and form is one of the most important factors that determine who will succeed in an upcoming tournament.--}}
                                    {{--</li>--}}
                                    {{--<li>--}}

                                        {{--Tournament History. Who has an affinity for the course that is being played or who always shows up and plays well at a particular tournament.  We show you tournament history covering the last seven years of every upcoming tournament.--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--Sportsbook Odds. We feature a consensus of 10 different top sportsbooks to bring you the chances they give every golfer in the upcoming tournament.--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--Key Insider Information- Who is battling a nagging injury or who has a family situation that may impact their play.--}}
                                    {{--</li>--}}
                                {{--</ul>--}}

                                {{--<p>--}}
                                    {{--Every week we will highlight those golfers that stand out via these tools within the tournament preview.  We do encourage our members to utilize all of the tools included on the site themselves to pick their winning lineups.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Bankroll Management-</strong> The old saying “Don’t put all your eggs in one basket” applies to playing daily fantasy golf.  Just as you would never invest all of your assets in one company’s stock, you should never use your entire bankroll in one contest or with one lineup.  Anything can happen at any given time out of yours and our control.  Example: One of your golfers that you picked withdraws midway into a tournament or more common just plays horribly out of nowhere and it derails a perfectly constructed lineup.  This does happen occasionally so we need to plan for it.  Our results are based on our systems being better than any other website over the long run.  Specifics- Never spend more than 15% of your bankroll on one tournament or one weekend.  For example: you have built a team based upon all of the information we have provided to you on this website. You have a $2,000 bankroll, you should not bet more than $300 on any tournament or weekend.  Our recommendation would be to enter 50/50 contests with 80% of your bankroll for that weekend and 20% into larger (GPP) tournaments.  This will help  you toward consistent winnings while also giving you a chance at a big, quick score!  So with that $300 (15% of bankroll), $240 would be used to enter various 50/50 contests and $60 into GPPs.  We like to enter the GPP contests with the largest prize pools.--}}
                                {{--</p>--}}

                                {{--<p>--}}
                                    {{--<strong>Overlays-</strong> Free money up for grabs!  Keep an eye out for tournaments (GPP) that have a prize pool larger than the sum of the entry fees from the entrants (Overlay).  For example:  A tournament features a prize pool of $100,000, the cost of each entry is $27, the amount of entrants to reach the break even point would be 3,703 ($100,000 / $27).  If  there are less entrants than that, there is money the site is paying out that an entrant is not representing. “A good thing for the entrants”.  This does happen occasionally and you may ask, “how do I know when these overlays are happening”?  Keep an eye out as it gets closer to the opening tee off time to see just how many entrants have entered a tournament.  As a bonus for being a premium member, when we see large overlays we will post it on the website under breaking news or send you and email letting you know and allowing you to take advantage of it.--}}
                                {{--</p>--}}

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