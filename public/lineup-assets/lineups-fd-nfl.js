/**
 * Global Generator object.
 *
 */
var lineupGenerator = {};
var csv_headers = 'QB,RB,RB,WR,WR,WR,TE,K,D';


/**
 * Sliders Component
 *
 */
lineupGenerator.sliders = {};
lineupGenerator.initRosterCount = function (id){
  l
};

lineupGenerator.sliders.config = {
  el: '#fgi-app',
  data: {
    results: [],
    minSalary: 59000,
    maxSalary: 60000,
    maxPlayers: 5,
    flexPositions: "RB,WR,TE",
    stackPositions: "",
    avoidQbRb: false,
    generating: 0,
    lineups: 50,
    export_data: "data:text/csvcharset=utf-8," + encodeURIComponent(csv_headers),
    totalSpots: 0,
    position: 'QB',
    change_slate_link: window.slate_global === 'FD NFL Main' ? '/lineup-generator-fd-nfl' : '/lineup-generator-fd-nfl/main',
    change_slate_text: window.slate_global === 'FD NFL Main' ? 'FanDuel NFL THU-MON' : 'FanDuel NFL Main',
    current_slate_text: window.slate_global === 'FD NFL Main' ? 'FanDuel NFL Main' : 'FanDuel NFL THU-MON',
    totalSpotsUsed: 0,
    averageSalaryRemaining: 0,
    totalSalaryAvailable: 0,
    totalSalaryUsed:0,
    averageSalary:0,
    playerCountInc: 0
  },
  methods: {
    filterPos: function(players) {
      var position = this.$data.position
      return players.filter(function(player) {
        return player.position === position
      })
    },
    generate: function (src) {
      var payload = lineupGenerator.sliders.$data
      this.generating = 1
      that = this

      var rosterCounts = {}
      var players = []
      var minSalary = parseInt(payload.minSalary, 10)
      var sumSalary = 0

      var errorMessages = {
        "minSalary": "It appears you have not allocated enough salary to meet the min salary specified. Adjust your exposure with an emphasis of getting the Total Salary Used closer to Total Salary Available and try again.",
        "minRosterSpots": "It appears you have not specified exposure to enough players. Try increasing target % or increasing the number of players in your pool to closer align Total Players Used and Total roster Spots and try again."
      }

      var errorMessagesKey = ""

      payload.players.forEach((player) => {
        if (parseInt(player.weight, 10) > 0) {
          var p = {
            name: player.name,
            team: player.team,
            salary: player.salary,
            draft_kings_id: player.draft_kings_id,
            position: player.position,
            weight: player.weight,
            totalSpots: player.totalSpots
          }
          players.push(p)
          rosterCounts[player.draft_kings_id] = 0
          sumSalary = sumSalary + (player.salary * parseInt(player.totalSpots, 10))
        }
      })

      if ((sumSalary/Math.round(minSalary * this.lineups) * 100) < 95) {
        errorMessagesKey = "minSalary"
      }

      if (errorMessagesKey.length < 1) {

        var post_data = {
          minSalary: minSalary,
          maxSalary: parseInt(payload.maxSalary, 10),
          lineups: parseInt(payload.lineups, 10),
          maxPlayers: parseInt(payload.maxPlayers, 10),
          players: players,
          flexPositions: payload.flexPositions,
          stackPositions: payload.stackPositions,
          avoidQbRb: payload.avoidQbRb === "" ? false : true,
          sport: 'nfl',
          site: 'fd'
        }

        $.ajax({
          method: 'POST',
          url: 'https://apps.fantasygolfinsider.com/reports/lineup_generator',
          dataType: 'JSON',
          error: function () {
            that.generating = 0;
            if (src!=="auto") {
              alert('Warning: Infeasable to create lineups based on constraints and/or exposure specified. Please correct and try again.');
            }
          },
          success: function (response) {
            var inc = 1;
            var csv = [];
            lineupGenerator.sliders.$data.results = [];
            var n = 0;
            var rosterCounts = {}
            Object.keys(lineupGenerator.sliders.$data.rosterCounts).forEach(function(count) {
              rosterCounts[count] = 0
              Object.keys(response.rosterCounts).forEach(function(rCount) {
                if (count === rCount) rosterCounts[count] = response.rosterCounts[count]
              })
            })
            response.combos.forEach(function(c) {
              csv.push(c.ids)
            })
            csv.unshift(csv_headers)
            csv = csv.join('\r\n')
            lineupGenerator.sliders.$data.export_data = "data:text/csvcharset=utf-8," + encodeURIComponent(csv)
            lineupGenerator.sliders.$data.rosterCounts = rosterCounts
            if (response.combos < 1) alert('Warning: Infeasable to create lineups based on constraints and/or exposure specified. Please correct and try again.')
            response.combos.forEach(function (value, key) {
              setTimeout(function () {
                // value.inc = inc++
                lineupGenerator.sliders.$data.results.push(value)
              }, n)
              n = n + 55
            })
            that.generating = 0
          },
          data: {
            data: JSON.stringify(post_data)
          },
        });
      } else {
        alert(errorMessages[errorMessagesKey])
        that.generating = 0;
      }
    },
    setPosition: function (pos) {
      this.position = pos
    },
    clear: function () {
      // lineupGenerator.sliders.$data.results = [];
      this.updateStats();
    },
    update: function () {
      // var payload = lineupGenerator.sliders.$data;
      if(lineupGenerator.validateFail()){
        return alert('Warning: Max salary must be a higher number than the minimum salary.');
      }
      // this.generate("auto");
      this.updateStats();
    },
    updateStats : function () {
      var sumSpots = 0;
      var sumSalary = 0;

      var totalSpots = 9 * this.lineups;
      this.players.forEach( function (value, index){
         if(value.totalSpots){
          sumSpots = sumSpots + parseInt(value.totalSpots,10);
          sumSalary = sumSalary + (value.salary * parseInt(value.totalSpots, 10));
         }
      });

      var totalSpotsUsed = sumSpots;
      var totalSalaryUsed = sumSalary;
      var totalSalaryAvailable = Math.round(this.maxSalary * this.lineups);
      var averageSalary = totalSalaryUsed / totalSpotsUsed;
      var averageSalaryRemaining = 0;
      if( isFinite(totalSalaryAvailable / totalSpotsUsed)){
        averageSalaryRemaining = ( (totalSalaryAvailable - totalSalaryUsed) / (totalSpots - totalSpotsUsed) ).toFixed(2);
      }

      this.totalSpots = numeral(totalSpots).format('0,0');
      this.totalSpotsUsed = numeral(totalSpotsUsed).format('0,0');
      this.totalSalaryAvailable = numeral(totalSalaryAvailable).format('0,0');
      this.totalSalaryUsed = numeral(totalSalaryUsed).format('0,0');
      this.averageSalary = numeral(averageSalary).format('0,0');
      this.averageSalaryRemaining = numeral(averageSalaryRemaining).format('0,0');
      if (this.averageSalaryRemaining === Infinity || averageSalaryRemaining > 60000) {
        this.averageSalaryRemaining = 0;
      }
    }

  }

};

lineupGenerator.validateFail = function () {
  var $data = lineupGenerator.sliders.$data;
  if($data.minSalary > $data.maxSalary){
    return true;
  }
  return false;
};

lineupGenerator.start = function () {
  // show buttons and messages
  $.get('/lineup-generator/players/' + window.slate_global, function (response) {
    lineupGenerator.sliders.config.data.players = response.players;
    lineupGenerator.sliders.config.data.rosterCounts = response.rosterCounts;
    lineupGenerator.sliders = new Vue(lineupGenerator.sliders.config);
    lineupGenerator.sliders.updateStats();
    $(".initial-hide").removeClass('initial-hide');
    $(".initial-hide-td-spans").removeClass('initial-hide-td-spans');
  });
};

$(function () {
  lineupGenerator.start();
  // Vue.transition('flyIn', {
  //     enterClass: 'bounceInRight',
  //     leaveClass: 'bounceOutLeft'
  // });
});