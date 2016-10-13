@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article-body">

                    <div class="article-content">

                        <div class="article-left">

                            <div class="content-head">ownership percentage predictions
                                <a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>
                            </div>

                            <div class="article-text">

                                <p>
                                    One of the most important variables that goes into winning large tournaments (GPPs)
                                    in Daily Fantasy Golf is ownership percentage of the golfers you select. In studying
                                    the composition of winning rosters of large GPPS over the past two years, we have identified
                                    one common variable: they all contain at least one player who’s ownership is low
                                    (under between 5-10%) and they ultimately perform well. If you construct a roster of
                                    all players owned by 20%+ of the field, you simply will not win the humongous grand
                                    prizes that are now offered in Fantasy Golf. Your research needs to include assumptions
                                    about the ownership of the players that you build your GPPs with and you need to identify
                                    a few overlooked gems. In our research every week, we put assumptions on what we believe
                                    the ownership will be of every player in the field. This helps us in the overall construction
                                    of our GPP lineups. Please note that these are estimates of what we believe the ownership
                                    will be. We are not always correct, and sometimes can be way off on our estimates, but
                                    we believe our experience and success playing in GPPs helps us to be extremely accurate.
                                    We have included a column for your estimates as well and it will combine with ours.
                                    This is an invaluable tool, necessary for building winning GPP lineups and we recommend
                                    that you use it in your research every week.
                                </p>

                                @if(Auth::check() and Auth::User()->can('view-page', 'ownership-percentage-predictions'))

                                    <button class="btn btn-golf-green reset-button" onclick="resetTable()">Reset Table</button>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th data-sort="string">Player Name<span class="glyphicon glyphicon-sort"></span></th>
                                            <th data-sort="int">Salary<span class="glyphicon glyphicon-sort"></span></th>
                                            <th data-sort="int">Zach's Prediction<span class="glyphicon glyphicon-sort"></span></th>
                                            <th data-sort="int">Jeff's Prediction<span class="glyphicon glyphicon-sort"></span></th>
                                            <th data-sort="int">Compiled Prediction<span class="glyphicon glyphicon-sort"></span></th>
                                            <th>User Prediction</th>
                                            <th>Total Combined Prediction</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @foreach($players as $player)

                                            <tr id="player-{{$player->id}}">
                                                <td>{{ $player->name }}</td>
                                                <td class="money" style="width: 100px;">{{ $player->salary }}</td>
                                                <td class="zach percentage">{{ $player->zach_prediction }}</td>
                                                <td class="jeff percentage">{{ $player->jeff_prediction }}</td>
                                                <td class="percentage">{{ $player->combined_prediction }}</td>
                                                <td>
                                                    <div class="input-group" style="width: 100px;">
                                                        <input class="can-reset form-control" type="number">
                                                        {{--<span class="input-group-addon">%</span>--}}
                                                    </div>
                                                </td>
                                                <td class="combined"></td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>

                                @else

                                    @include('partials.register-to-view')

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

@section('scripts')

    <script>
        var table = $('table');
        table.stupidtable();

        var lastSort;
        table.bind('aftertablesort', function (event, data) {
            // data.column - the index of the column sorted after a click
            // data.direction - the sorting direction (either asc or desc)
            // $(this) - this table object

            console.log("The sorting direction: " + data.direction);
            console.log("The column index: " + data.column);
            console.log(data);
            console.log(event.target);

            var arrows = table.find('thead tr th .glyphicon');
            arrows.removeClass('glyphicon-arrow-up').removeClass('glyphicon-arrow-down');
            arrows.addClass('glyphicon-sort');

            arrows.eq(data.column).removeClass('glyphicon-sort');

            var addClass = null;

            if (data.direction == 'desc') {
                addClass = 'glyphicon-arrow-down';
            } else {
                addClass = 'glyphicon-arrow-up';
            }

            arrows.eq(data.column).addClass(addClass);


//            var clicked = table.find('thead tr th .glyphicon').eq(data.column);
//            lastSort = data.column;
//
//            console.log(clicked);

//            clicked.removeClass('glyphicon-sort');
//            clicked.removeClass('glyphicon-arrow-up');
//            clicked.removeClass('glyphicon-arrow-down');
//
//            var addClass = null;
//
//            if (data.direction == 'desc') {
//                addClass = 'glyphicon-arrow-down';
//            } else {
//                addClass = 'glyphicon-arrow-up';
//            }
//
//            clicked.eq(data.column).addClass(addClass);


        });

        var firstSort = table.find('thead tr th').eq(1);
        firstSort.stupidsort('desc');

        $("input").keyup(function() {
            var user = $(this).val();
            var zach = $(this).parent().parent().siblings(".zach").text();
            var jeff = $(this).parent().parent().siblings(".jeff").text();

            console.log(user, zach, jeff);

            var combined = Math.round((+user + +zach + +jeff) / 3);

            var output = $(this).parent().parent().siblings(".combined");
            console.log(combined);
            output.text(combined);
            output.addClass('percentage');
        });

        function resetTable() {

            $(".can-reset").val("");

            $(".combined").removeClass('percentage').text("");

        }
    </script>

@endsection