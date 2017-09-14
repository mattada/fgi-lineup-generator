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
    minSalary: 49000,
    maxSalary: 50000,
    generating: false,
    lineups: 50,
    totalSpots: 0,
    position: 'QB',
    change_slate_link: window.slate_global === 'DK NFL Main' ? '/lineup-generator-nfl' : '/lineup-generator-nfl/main',
    change_slate_text: window.slate_global === 'DK NFL Main' ? 'DraftKings NFL THU-MON' : 'DraftKings NFL Main',
    current_slate_text: window.slate_global === 'DK NFL Main' ? 'DraftKings NFL Main' : 'DraftKings NFL THU-MON',
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

      var post_data = {
        minSalary: payload.minSalary,
        maxSalary: payload.maxSalary,
        lineups: parseInt(payload.lineups, 10),
        players: players,
      }

      $.ajax({
        method: 'POST',
        url: 'https://apps.fantasygolfinsider.com/reports/lineup_generator',
        dataType: 'JSON',
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
          // data: JSON.stringify({"minSalary": 49000, "maxSalary": 50000, "lineups": 50, "players": [{"name": "Le'Veon Bell", "salary": 9800, "draft_kings_id": "Le'Veon Bell (9359211)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "David Johnson", "salary": 9400, "draft_kings_id": "David Johnson (9359235)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "Antonio Brown", "salary": 8800, "draft_kings_id": "Antonio Brown (9358987)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Julio Jones", "salary": 8500, "draft_kings_id": "Julio Jones (9359003)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Odell Beckham Jr.", "salary": 8300, "draft_kings_id": "Odell Beckham Jr. (9359352)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "LeSean McCoy", "salary": 8200, "draft_kings_id": "LeSean McCoy (9358939)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "A.J. Green", "salary": 8000, "draft_kings_id": "A.J. Green (9359007)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Mike Evans", "salary": 7800, "draft_kings_id": "Mike Evans (9359400)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Devonta Freeman", "salary": 7000, "draft_kings_id": "Devonta Freeman (9359384)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "Melvin Gordon", "salary": 6600, "draft_kings_id": "Melvin Gordon (9358682)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "Jay Ajayi", "salary": 6500, "draft_kings_id": "Jay Ajayi (9359367)", "position": "RB", "weight": "20", "totalSpots": "10.0"}, {"name": "Matthew Stafford", "salary": 6100, "draft_kings_id": "Matthew Stafford (9358878)", "position": "QB", "weight": "30", "totalSpots": "15.0"}, {"name": "Martavis Bryant", "salary": 6000, "draft_kings_id": "Martavis Bryant (9359430)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Carson Palmer", "salary": 6000, "draft_kings_id": "Carson Palmer (9358775)", "position": "QB", "weight": "30", "totalSpots": "15.0"}, {"name": "Michael Crabtree", "salary": 6000, "draft_kings_id": "Michael Crabtree (9358887)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Stefon Diggs", "salary": 6000, "draft_kings_id": "Stefon Diggs (9358532)", "position": "WR", "weight": "30", "totalSpots": "15.0"}, {"name": "Philip Rivers", "salary": 5800, "draft_kings_id": "Philip Rivers (9358678)", "position": "QB", "weight": "30", "totalSpots": "15.0"}, {"name": "Travis Kelce", "salary": 5600, "draft_kings_id": "Travis Kelce (9358502)", "position": "TE", "weight": "20", "totalSpots": "10.0"}, {"name": "Eli Manning", "salary": 5600, "draft_kings_id": "Eli Manning (9358813)", "position": "QB", "weight": "10", "totalSpots": "5.0"}, {"name": "Davante Adams", "salary": 5200, "draft_kings_id": "Davante Adams (9359572)", "position": "WR", "weight": "40", "totalSpots": "20.0"}, {"name": "Jacquizz Rodgers", "salary": 4900, "draft_kings_id": "Jacquizz Rodgers (9359009)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Rex Burkhead", "salary": 4400, "draft_kings_id": "Rex Burkhead (9358574)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Jeremy Hill", "salary": 4400, "draft_kings_id": "Jeremy Hill (9359597)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Ameer Abdullah", "salary": 4300, "draft_kings_id": "Ameer Abdullah (9359363)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Rob Kelley", "salary": 4300, "draft_kings_id": "Rob Kelley (9359444)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Paul Perkins", "salary": 4300, "draft_kings_id": "Paul Perkins (9359679)", "position": "RB", "weight": "30", "totalSpots": "15.0"}, {"name": "Hunter Henry", "salary": 3400, "draft_kings_id": "Hunter Henry (9358722)", "position": "TE", "weight": "10", "totalSpots": "5.0"}, {"name": "Cameron Brate", "salary": 3100, "draft_kings_id": "Cameron Brate (9359239)", "position": "TE", "weight": "30", "totalSpots": "15.0"}, {"name": "Austin Hooper", "salary": 3000, "draft_kings_id": "Austin Hooper (9359924)", "position": "TE", "weight": "30", "totalSpots": "15.0"}, {"name": "Julius Thomas", "salary": 2900, "draft_kings_id": "Julius Thomas (9359233)", "position": "TE", "weight": "30", "totalSpots": "15.0"}, {"name": "Lions ", "salary": 2600, "draft_kings_id": "Lions  (9358744)", "position": "DST", "weight": "50", "totalSpots": "25.0"}, {"name": "Titans ", "salary": 2600, "draft_kings_id": "Titans  (9358746)", "position": "DST", "weight": "50", "totalSpots": "25.0"} ] })
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