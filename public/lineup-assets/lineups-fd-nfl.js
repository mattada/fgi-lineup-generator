/**
 * Global Generator object.
 *
 */
var lineupGenerator = {};


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
    generating: false,
    lineups: 50,
    totalSpots: 0,
    position: 'QB',
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
      var payload = lineupGenerator.sliders.$data;
      this.generating = true;
      that = this;

      var rosterCounts = {}
      var players = []
    	
      payload.players.forEach((player) => {
    		if (parseInt(player.weight, 10) > 0) {
    			var p = {
    				name: player.name,
    				salary: player.salary,
    				draft_kings_id: player.draft_kings_id,
    				position: player.position,
    				weight: player.weight,
    				totalSpots: player.totalSpots
    			}
    			players.push(p)
    			rosterCounts[player.draft_kings_id] = 0
    		}
    	})
    	// payload.players = players
    	// payload.rosterCounts = rosterCounts
      var post_data = {
        minSalary: payload.minSalary,
        maxSalary: payload.maxSalary,
        lineups: parseInt(payload.lineups, 10),
        players: players,
        rosterCounts: rosterCounts,
      }

      debugger

      $.ajax({
        method: 'POST',
        url: '/lineup-generator-fd-nfl/generate',
        dataType: 'json',
        error: function () {
          that.generating = false;
          if (src!=="auto") {
            alert('Warning: Infeasable to create lineups based on constraints and/or exposure specified. Please correct and try again.');
          }
        },
        success: function (response) {
          var inc = 1;
          lineupGenerator.sliders.$data.results = [];
          var n = 0;
          var rosterCounts = {}
          Object.keys(lineupGenerator.sliders.$data.rosterCounts).forEach(function(count) {
            rosterCounts[count] = 0
            Object.keys(response.rosterCounts).forEach(function(rCount) {
              if (count === rCount) rosterCounts[count] = response.rosterCounts[count]
            })
          })
          lineupGenerator.sliders.$data.rosterCounts = rosterCounts;
          response.combos.forEach(function (value, key) {
            setTimeout(function () {
              // value.inc = inc++;
              lineupGenerator.sliders.$data.results.push(value);
            }, n);
            n = n + 55;
          });
          that.generating = false;
        },
        data: {
          data: JSON.stringify(post_data)
        },
      });
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
      if (this.averageSalaryRemaining === Infinity || averageSalaryRemaining > 50000) {
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