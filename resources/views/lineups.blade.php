@extends('layouts.navless')

@section('styles')

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="/lineup-assets/animate.css">
  {{-- <link rel="stylesheet" href="/lineup-assets/lineup.css"> --}}

  <style>

    #lineupGenerator_not_supported{
      display:none;
      font-size:18px;
      color:#999;
      text-align:center;
      padding:20px;
    }

    @media (max-width: 720px) {
      #lineupGenerator{
        display:none;
      }

      #lineupGenerator_not_supported {
        display:block;
      }
    }

  </style>

@endsection

@section('content')

  <div id="fgi-app">

    {{--@if(Auth::check() and Auth::User()->can('view-page', 'lineup-generator'))--}}
    @if(true)

      <header>
        <div class="filters">
          <div class="filter " style="margin-top: 10px;">
            <div class="row" style="margin-top: 5px;">
              <div style="padding: 0;" class="col-md-8 col-sm-8 col-xs-8"><span class="pull-right" style="margin-top: 4px;">No. of lineups:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-4 col-sm-4 col-xs-4"><input style="border: 1px solid #ccc; padding: 2px 5px; margin-left: 10px; width: 75px;" id="no-lineups-crit" type="number" min="1" max="150" step="1" v-model='lineups' v-on:change='update()' /></div>
            </div>
            <div class="row" style="margin-top: 5px;">
              <div style="padding: 0;" class="col-md-8 col-sm-8 col-xs-8"><span class="pull-right" style="margin-top: 4px;">Min salary:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-4 col-sm-4 col-xs-4"><input style="border: 1px solid #ccc; padding: 2px 5px; margin-left: 10px; width: 75px;" id="min-sal-crit" type="number" min="25000" max="50000" step="100" v-model='minSalary' v-on:change='update()' /></div>
            </div>
            <div class="row" style="margin-top: 5px;">
              <div style="padding: 0;" class="col-md-8 col-sm-8 col-xs-8"><span class="pull-right" style="margin-top: 4px;">Max salary:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-4 col-sm-4 col-xs-4"><input style="border: 1px solid #ccc; padding: 2px 5px; margin-left: 10px; width: 75px;" id="max-sal-crit" type="number" min="25000" max="50000" step="100" v-model='maxSalary' v-on:change='update()' /></div>
            </div>
          </div>
          <div class="stats " style="margin-top: 10px;">
            <div class="row">
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Roster Spots:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{totalSpots}}</span></div>
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Salary Available:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{totalSalaryAvailable}}</span></div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Players Used:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{totalSpotsUsed}}</span></div>
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Salary Used:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{totalSalaryUsed}}</span></div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Avg Salary Used / Player:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{averageSalary}}</span></div>
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Avg Salary Remain / Player:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2"><span class="initial-hide">@{{averageSalaryRemaining}}</span></div>
            </div>
          </div>
        </div>
        <div class="actions">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 clearfix">
              <div class="pull-left" style="width: 100%;">
                <ul class="nav nav-tabs" role="tablist" id="myTabs">
                  <li role="presentation" class="active"><a href="#players-wrapper" aria-controls="players-wrapper" role="tab" data-toggle="tab">Players</a></li>
                  <li role="presentation"><a href="#lineups-wrapper" arida-controls="lineups-wrapper" role="tab" data-toggle="tab">Lineups</a></li>
                </ul>
              </div>
              <div class="initial-hide">
                <div class="pull-left" v-if="results.length > 0" style="border-radius: 5px; width: 375px; text-align: center; margin-top: -37px; margin-left: 220px; background-color: #00CC33; color: white; padding: 6px; font-weight: bold;">
                  @{{results.length > lineups ? lineups : results.length}} / @{{lineups}} lineups generated
                </div>
              </div>
              <div class="initial-hide pull-right" style="width: 210px; margin-top: -40px;">
                <div v-if='generating'>
                  <button class="fgi-button pull-right disabled" style="cursor: pointer;" disabled>Generating ....</button>
                </div>
                <div v-else>
                  <button class="fgi-button pull-right" style="cursor: pointer;" v-on:click="generate('click')">Generate</button>
                </div>
                <div class="pull-right button-wrapper" v-if='results.length > 0'>
                  @if( (date('N', strtotime( Carbon\Carbon::now() )) > 5) )
                    <a href="/export-lus-wg" download="dk_lineups.csv" class="pull-right fgi-button">Export</a>
                  @else
                    <a href="/export-lus" download="dk_lineups.csv" class="pull-right fgi-button">Export</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="players-wrapper">
          <div class="row" style="margin-top: -8px; margin-bottom: 2px;">
            <div class="col-md-8 col-sm-8 col-xs-8">
              <b>Course Rotations:</b> (First day, second day, third day)
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <small class="pull-right"><a href="#" id="clear-exposure" v-on:click="clear()">[X] Clear Exposure</a></small>
            </div>
          </div>
          <div class="row" style="margin-top: -8px; margin-bottom: 2px;" v-if="players[0].tee_4.length > 0">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <small>
                <span class="label label-success">SC</span> = Stadium, La Quinta, Nicklaus Tournament
              </small>
              <small style="margin-left: 10px;">
                <span class="label label-info">LQ</span> = La Quinta, Nicklaus Tournament, Stadium
              </small>
              <small style="margin-left: 10px;">
                <span class="label label-warning">NT</span> = Nicklaus Tournament, Stadium, La Quinta
              </small>
            </div>
          </div>
          <table class="players">
            <thead>
              <tr>
                <th style="width: 55%;">Player</th>
                <th>Salary</th>
                <th>Target %</th>
                <th>Target Ct</th>
                <th>Rostered Ct</th>
                <th>Rostered %</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="player in players">
                <td class="fgi-player-name" style="width: 55%;"><span v-if="player.tee_4.length > 0" v-html="player.tee_4"></span><span class="initial-hide">@{{player.name}} <span class="pull-right" style="font-size: 95%;">@{{player.tee_1}}<span v-if="player.tee_2.length > 0"> / @{{player.tee_2}}</span><span v-if="player.tee_3.length > 0"> / @{{player.tee_3}}</span></span></span></td>
                <td class="fgi-player-salary"><span class="initial-hide">$@{{player.salary}}</span></td>
                <td class="fgi-player-rank"><span class="initial-hide"><input class="exposure-item" v-on:change='update()' style="font-size: 12px; text-align:center; width:55px; height: 20px; border:1px solid #979797;" min="0" v-model="player.weight" type="number"></span></td>
                <td><span class="initial-hide">@{{player.totalSpots = ((player.weight/100) * lineups).toFixed(1)}}</span></td>
                <td><span class="initial-hide">@{{rosterCounts[player.draft_kings_id]}}</span></td>
                <td><span class="initial-hide">@{{isNaN(((rosterCounts[player.draft_kings_id] / lineups) * 100)) ? 0 : parseInt(((rosterCounts[player.draft_kings_id] / lineups) * 100),10)}}%</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="lineups-wrapper">
          <table class="lineups">
            <thead>
            <tr>
              <th>#</th>
              <th>Roster</th>
              <th>Salary</th>
            </tr>
            </thead>
            <tbody>
              <tr v-for="(index, result) in results">
                <td class="fgi-lineup-text">@{{index+1}}</td>
                <td class="fgi-lineup-text">@{{result.names}}</td>
                <td class="fgi-salary-total">$@{{result.total}}</td>
              </tr>
              <tr>
                <td v-if='results.length < 1' class='a-gentle-nudge' colspan="3">Infeasable to create lineups based on constraints and/or exposure specified. Please correct and check back.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    @else

      @include('partials.register-to-view')

    @endif
  </div>

@endsection

@section('scripts')

  <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="/lineup-assets/vue.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript">
    window.slate_global = "{{$slate}}";
  </script>
  <script src="/lineup-assets/lineups.js?_=0001"></script>
  <script>
    $(function() {
      $("#clear-exposure").on('click', function(e) {
        e.preventDefault();
        $(".exposure-item").val(0).trigger("change");
      });
    });
  </script>

@endsection