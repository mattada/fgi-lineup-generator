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

      <div style="margin: 10px 0;" class="alert alert-info" role="alert">
        <p class="initial-hide">
          You are viewing the <b>@{{current_slate_text}} slate</b>. Change to <a style="text-decoration: underline;" href="@{{change_slate_link}}">@{{change_slate_text}} slate</a>.
          <p>Also consider: <a style="text-decoration: underline;" href="/lineup-generator-fd-nfl">FanDuel NFL THU-MON slate</a> or <a style="text-decoration: underline;" href="/lineup-generator-fd-nfl/main">FanDuel NFL Main slate</a></p>
        </p>
      </div>
      <header>
        <div class="filters">
          <div class="filter " style="margin-top: 10px; margin-bottom: 10px;">
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
            <div class="row" style="margin-top: 5px;">
              <div style="padding: 0;" class="col-md-8 col-sm-8 col-xs-8"><span class="pull-right" style="margin-top: 4px;">Max players<br>from same team:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-4 col-sm-4 col-xs-4"><input type="number" min="1" max="5" value="3" style="padding: 2px 5px; margin-left: 10px; width: 75px;" id="max-players-crit" v-model='maxPlayers' v-on:change='update()' /></div>
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
            <div class="row" style="margin-top: 10px;">
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Require QB Stack with:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2">
                <select id="stack-positions-crit" v-model='stackPositions' v-on:change='update()'>
                  <option value=""></option>
                  <option value="WR,TE">WR or TE</option>
                  <option value="WR">WR only</option>
                  <option value="TE">TE only</option>
                </select>
              </div>
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><label class="pull-right" for="avoid-qbrb-crit" style="font-weight: normal;">Avoid QB/RB on same team:</label></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2">
                <input style="margin-top: -1px;" id="avoid-qbrb-crit" type="checkbox" value="YES" v-model='avoidQbRb' v-on:change='update()' />
              </div>
            </div>
            <div class="row" style="margin-top: 5px;">
              <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><span class="pull-right">Eligible Flex Positions:</span></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2">
                <select id="flex-positions-crit" v-model='flexPositions' v-on:change='update()'>
                  <option value="RB,WR,TE">RB,WR,TE</option>
                  <option value="RB,WR">RB,WR</option>
                  <option value="WR,TE">WR,TE</option>
                  <option value="RB">RB</option>
                  <option value="WR">WR</option>
                </select>
              </div>
              <!-- <div style="padding: 0;" class="col-md-4 col-sm-4 col-xs-4"><label class="pull-right" for="avoid-offdef-crit" style="font-weight: normal;">Avoid Offense vs Defense:</label></div>
              <div style="padding: 0; padding-left: 5px;" class="col-md-2 col-sm-2 col-xs-2">
                <input style="margin-top: -1px;" id="avoid-offdef-crit" type="checkbox" value="YES" v-model='avoidOffDef' v-on:change='update()' />
              </div> -->
            </div>
          </div>
        </div>
        <div class="filters">
          <div class="filter " style="margin-top: 0px; margin-bottom: 15px;">
            <div class="row">
              <div style="padding: 0;" class="col-md-1 col-sm-1 col-xs-1"></div>
              <div style="text-align: center; padding: 0;" class="col-md-10 col-sm-10 col-xs-10">
                <small>Note: When using the stack feature be sure to assign enough exposure to a QB's pass catchers to make the desired number of combinations possible. Additionaly if using the Avoid QB/RB feature you should make sure to have enough exposure to RBs not on the same team as your QBs.</small>
              </div>
              <div style="padding: 0;" class="col-md-1 col-sm-1 col-xs-1"></div>
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
                  <button class="fgi-button pull-right" style="cursor: pointer;" v-on:click="generate('click')" :disabled="generating == 1">Generate</button>
                </div>
                <div class="pull-right button-wrapper" v-if='results.length > 0'>
                  <a href="@{{export_data}}" download="dk_lineups.csv" class="pull-right fgi-button">Export</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="players-wrapper">
          <div class="row" style="margin-top: -8px; margin-bottom: 2px;">
            <div class="col-xs-8">
              <ul class="nav nav-pills" style="font-size: 90%; margin-top: 10px; margin-bottom: 5px;">
                <li v-bind:class="{ active: position === 'QB'}" role="presentation"><a style="cursor: pointer; padding: 5px 10px" v-on:click="setPosition('QB')">QB</a></li>
                <li v-bind:class="{ active: position === 'RB'}" role="presentation"><a style="cursor: pointer; padding: 5px 10px" v-on:click="setPosition('RB')">RB</a></li>
                <li v-bind:class="{ active: position === 'WR'}" role="presentation"><a style="cursor: pointer; padding: 5px 10px" v-on:click="setPosition('WR')">WR</a></li>
                <li v-bind:class="{ active: position === 'TE'}" role="presentation"><a style="cursor: pointer; padding: 5px 10px" v-on:click="setPosition('TE')">TE</a></li>
                <li v-bind:class="{ active: position === 'DST'}" role="presentation"><a style="cursor: pointer; padding: 5px 10px" v-on:click="setPosition('DST')">DST</a></li>
              </ul>
            </div>
            <div class="col-xs-4">
              <small style="margin-top: 15px;" class="pull-right"><a href="#" id="clear-exposure" v-on:click="clear()">[X] Clear Exposure</a></small>
            </div>
          </div>
          <table class="players">
            <thead>
              <tr>
                <th>Player</th>
                <th>Salary</th>
                <th>Target %</th>
                <th>Target Ct</th>
                <th>Rostered Ct</th>
                <th>Rostered %</th>
              </tr>
            </thead>
            <tbody class="initial-hide-td-spans">
              <tr v-for="player in players | filterBy position in 'position'">
                <td class="fgi-player-name"><span>@{{player.name}} (@{{player.position}}-@{{player.team}})</span></td>
                <td class="fgi-player-salary"><span>$@{{player.salary}}</span></td>
                <td class="fgi-player-rank"><span><input class="exposure-item" v-on:change='update()' style="font-size: 12px; text-align:center; width:55px; height: 20px; border:1px solid #979797;" min="0" v-model="player.weight" type="number"></span></td>
                <td><span>@{{player.totalSpots = ((player.weight/100) * lineups).toFixed(1)}}</span></td>
                <td><span>@{{rosterCounts[player.draft_kings_id]}}</span></td>
                <td><span>@{{isNaN(((rosterCounts[player.draft_kings_id] / lineups) * 100)) ? 0 : parseInt(((rosterCounts[player.draft_kings_id] / lineups) * 100),10)}}%</span></td>
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
  <script src="/lineup-assets/lineups-nfl.js"></script>
  <script>
    $(function() {
      $("#clear-exposure").on('click', function(e) {
        e.preventDefault();
        $(".exposure-item").val(0).trigger("change");
      });
    });
  </script>

@endsection