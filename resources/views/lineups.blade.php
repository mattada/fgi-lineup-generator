@extends('layouts.navless')

@section('styles')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/lineup-assets/animate.css">
    <link rel="stylesheet" href="/lineup-assets/lineup.css">

    <style>

        #lineupGenerator_not_supported{
            display:none;
            font-size:18px;
            color:#999;
            text-align:center;
            padding:20px;
        }

        @media (max-width: 1090px) {
            #lineupGenerator{
                display:none;
            }

            #lineupGenerator_not_supported{
                display:block;
            }
        }

    </style>

@endsection

@section('content')

    <div id="lineupGenerator_not_supported">
        The Lineup Generator has been optimized to be used with a computer. Its
        features are not fully compatible with mobile devices. If you are currently on a
        computer and are receiving this message, please increase the width of your
        Browser window or enter full screen mode.
    </div>

    <div class="col-md-12" style="padding:0;" id="lineupGenerator">
        <div class="article-body">

            <div class="article-content">

                <div class="article-left" style="width: 100%">

                    <div class="content-head">The Lineup Generator
                        {{--<a href="{{ url('/') }}" class="content-head-link">Back to Homepage</a>--}}
                    </div>

                    <div class="article-text">

                        {{--@if(Auth::check() and Auth::User()->can('view-page', 'lineup-generator'))--}}
                        @if(true)
                            <div id="fgi-app">
                                <div id="fgi-app-right">
                                    <div id="fgi-filter-bar">
                                        <div id="form-container">
                                            <div class="pull-left" style="padding-right:30px;">
                                                <span># of Lineups</span>
                                                <div class="form-wrap">
                                                    <input v-model='lineups' v-on:change='update()' type="text">
                                                </div>
                                            </div>
                                            <div style="width:72%;padding-right:0;" class="pull-left">
                                                <div>Salary Filter</div>
                                                <div style="width:52%; float: left;" class="form-wrap">
                                                    <label>Ceiling</label>
                                                    <input v-model='maxSalary' v-on:change='update()' type="text">
                                                </div>
                                                <div class="form-wrap make-inline">
                                                    <label>Floor</label>
                                                    <input v-model='minSalary' v-on:change='update()' type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <span class="disclaimer">* Be careful not to restrict the generator too much with the filter settings.</span>
                                        <button class='fgi-button' type="button">Save Settings</button>
                                    </div>
                                    <div id="fgi-combined-stats-wrap">
                                        <div class="combined-stat">
                                            <span class="stat-title">Total Roster Spots:</span>
                                            <span class="stat-value">@{{totalSpots}}</span>
                                        </div>
                                        <div class="combined-stat">
                                            <span class="stat-title">Total Players Used:</span>
                                            <span class="stat-value">@{{totalSpotsUsed }}</span>
                                        </div>
                                        <div class="combined-stat">
                                            <span class="stat-title">Avg Salary Used / Player:</span>
                                            <span class="stat-value">@{{ averageSalary }}</span>
                                        </div>
                                        <div class="combined-stat">
                                            <span class="stat-title">Total Salary Available:</span>
                                            <span class="stat-value">@{{ totalSalaryAvailable }}</span>
                                        </div>
                                        <div class="combined-stat">
                                            <span class="stat-title">Total Salary Used:</span>
                                            <span class="stat-value">@{{ totalSalaryUsed }}</span>
                                        </div>
                                        <div class="combined-stat">
                                            <span class="stat-title">Avg Salary Remaining / Player:</span>
                                            <span class="stat-value">@{{ averageSalaryRemaining }}</span>
                                        </div>
                                    </div>
                                    <div id="fgi-player-list">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player (OVR Rank)</th>
                                                <th>Salary</th>
                                                <th>Target %</th>
                                                <th>Target Ct</th>
                                                <th>Rostered</th>
                                                <th>Rostered %</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="player in players">
                                                <td>@{{ player.id}}</td>
                                                <td class="fgi-player-name">@{{ player.name }}</td>
                                                <td class="fgi-player-salary center"><span>$@{{player.salary}}</span>
                                                </td>
                                                <td class="fgi-player-rank center">
                                                    <input v-on:change='update()' style="font-size: 12px; text-align:center; width:40px; height: 20px; border:1px solid #979797; background: transparent;" v-model="player.weight">
                                                </td>
                                                <td class="center">@{{ player.totalSpots =  Math.round((player.weight/100) * lineups) }}</td>
                                                <td class="center">@{{ rosterCounts[player.draft_kings_id] }}</td>
                                                <td class="center">@{{ ((rosterCounts[player.draft_kings_id] / lineups) * 100).toFixed(2) }}%</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="fgi-app-left">
                                    <div>
                                        <span class="fgi-heading">Your Lineups</span>
                                        <button class="pull-right fgi-button" style="margin-left: 15px; padding-right:30px; cursor: pointer;" v-on:click="update()">Generate</button>
                                        <a href="/lineup-generator/export" class="pull-right fgi-button">Export</a>
                                    </div>
                                    <div id="fgi-lineups">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width:370px;">Roster</th>
                                                <th>Salary</th>
                                                {{--<th>Proj %</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="result in results">
                                                <td>@{{result.inc}}</td>
                                                <td class="fgi-lineup-text"> @{{ result.names }} </td>
                                                <td class="fgi-salary-total"> $@{{ result.total }} </td>
                                                {{--<td>34%</td>--}}
                                            </tr>
                                            <tr>
                                                <td v-if='results.length < 1'class='a-gentle-nudge' colspan="3">Please adjust filter settings to generate lineups.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>


                            </div>

                        @else

                            @include('partials.register-to-view')

                        @endif

                    </div>

                </div>

                <div class="clear"></div>

            </div>

        </div>
    </div>

@endsection

@section('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="/lineup-assets/vue.js"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <script src="/lineup-assets/lineups.js"></script>

@endsection