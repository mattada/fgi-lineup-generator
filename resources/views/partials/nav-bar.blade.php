<ul class="nav navbar-nav">
    <li>
        <a href="{{ url('/') }}">Home</a>
    </li>
    <li>
        <a id="pgaToolsDropdown" href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PGA Tools <span class="caret"></span></a>
        <ul id="pgaToolsMenu" class="dropdown-menu">
            <li><a href="{{ url('/lineup-generator') }}">Lineup Generator</a></li>
            <li><a href="{{ url('/ownership-percentage-predictions') }}">Ownership Percentage Predictions</a></li>

            @foreach($pgaTools as $item)
                <li><a href="{{ url('p/' . $item->title_slug) }}">{{ $item->title }}</a></li>
            @endforeach

            {{--<li><a href="{{ url('/p/fantasy-golf-players-cut-percent') }}">Cut %</a></li>--}}
            {{--<li><a href="{{ url('/p/whos-hot-in-fantasy-golf') }}">Who's Hot</a></li>--}}
            {{--<li><a href="{{ url('/p/fantasy-golf-tournament-history') }}">Tournament History</a></li>--}}
            {{--<li><a href="{{ url('/p/sportsbook-odds-vs-daily-pricing') }}">Odds Vs Daily Pricing</a></li>--}}
            {{--<li><a href="{{ url('/p/metric') }}">FGI Model</a></li>--}}
            {{--<li><a href="{{ url('/p/pga-dfs-model') }}">PGA DFS Model</a></li>--}}
        </ul>
    </li>
    <li>
        <a id="pgaToolsDropdown" href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">EURO Tools <span class="caret"></span></a>
        <ul id="pgaToolsMenu" class="dropdown-menu">

            @foreach($euroTools as $item)
                <li><a href="{{ url('p/' . $item->title_slug) }}">{{ $item->title }}</a></li>
            @endforeach

            {{--<li><a href="{{ url('/p/fantasy-golf-players-cut-percent') }}">Cut %</a></li>--}}
            {{--<li><a href="{{ url('/p/whos-hot-in-fantasy-golf') }}">Who's Hot</a></li>--}}
            {{--<li><a href="{{ url('/p/euro-tournament-history') }}">EURO Tournament History</a></li>--}}
            {{--<li><a href="{{ url('/p/euro-odds-vs-daily-pricing') }}">EURO Odds Vs Daily Pricing</a></li>--}}
            {{--<li><a href="{{ url('/p/euro-fgi-model')}}">EURO PGA DFS Model</a></li>--}}
        </ul>
    </li>
    <li>
        <a href="{{ url('columns/expert') }}">Expert Columns</a>
    </li>
    <li>
        <a id="pgaToolsDropdown" href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">General <span class="caret"></span></a>
        <ul id="pgaToolsMenu" class="dropdown-menu">

            @foreach($generalMenu as $item)
                <li><a href="{{ url('p/' . $item->title_slug) }}">{{ $item->title }}</a></li>
            @endforeach

            <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>

            {{--<li><a href="{{ url('/p/who-we-are') }}">Who We Are</a></li>--}}
            {{--<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>--}}
            {{--<li><a href="{{ url('/p/testimonials') }}">Testimonials</a></li>--}}
            {{--<li><a href="{{ url('/p/schedule') }}">Schedule</a></li>--}}
            {{--<li><a href="{{ url('/p/how-to-win-playing-daily-fantasy-golf') }}">How To Win Playing Daily</a></li>--}}
        </ul>
    </li>
    <li>
        <a href="http://shop.fantasygolfinsider.com" target="_blank">Shop</a>
    </li>
</ul>