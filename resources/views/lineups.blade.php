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
          <div class="filter">
            <div>
              <span>Number of lineups: <strong>@{{lineups}}</strong></span>
              <input class="fgi-slider" id="no-lineups-crit" type="range" min="1" max="150" step="1" v-model='lineups' v-on:change='update()' />
            </div>
            <div style="margin-top: 5px;">
              <span>Minimum salary: <strong>$@{{minSalary}}</strong></span>
              <input class="fgi-slider" id="min-sal-crit" type="range" min="25000" max="50000" step="100" v-model='minSalary' v-on:change='update()' />
            </div>
          </div>
          <div class="stats">
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Roster Spots:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{totalSpots}}</div>
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Players Used:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{totalSpotsUsed}}</div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Avg Salary Used / Player:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{averageSalary}}</div>
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Salary Available:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{totalSalaryAvailable}}</div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Total Salary Used:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{totalSalaryUsed}}</div>
              <div class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Avg Salary Remain / Player:</span></div>
              <div class="col-md-2 col-sm-2 col-xs-2">@{{averageSalaryRemaining}}</div>
            </div>
          </div>
        </div>
        <div class="actions">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <span class="messages pull-left">@{{message}}</span>
              <div class="pull-right" style="width: 180px;">
                <button class="fgi-button pull-right" style="cursor: pointer;" v-on:click="generate()">Generate</button>
                <div class="pull-right button-wrapper" v-if='results.length < 1'>
                  <a href="/lineup-generator/export" class="pull-right fgi-button">Export</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="content">
        <table class="players">
          <thead>
            <tr>
              <th>Player</th>
              <th>Salary</th>
              <th>Target %</th>
              <th>Target Ct</th>
              <th>Rostered</th>
              <th>Rostered %</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="player in players">
              <td class="fgi-player-name">@{{ player.name }}</td>
              <td class="fgi-player-salary"><span>$@{{player.salary}}</span></td>
              <td class="fgi-player-rank"><input v-on:change='update()' style="font-size: 12px; text-align:center; width:40px; height: 20px; border:1px solid #979797;" v-model="player.weight"></td>
              <td>@{{ player.totalSpots =  Math.round((player.weight/100) * lineups) }}</td>
              <td>@{{ rosterCounts[player.draft_kings_id] }}</td>
              <td>@{{ ((rosterCounts[player.draft_kings_id] / lineups) * 100).toFixed(2) }}%</td>
            </tr>
          </tbody>
        </table>
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
  {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
  <script type="text/javascript">
    window.slate_global = "{{$slate}}";
  </script>
  <script src="/lineup-assets/lineups.js"></script>
  {{-- <script>
    $(function() {
      $(window).resize(function() {
        $('tbody').height(33 * $("tbody tr").length);
      });
      $(window).resize();
    });
  </script> --}}

@endsection