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
    totalSpotsUsed: 0,
    averageSalaryRemaining: 0,
    totalSalaryAvailable: 0,
    totalSalaryUsed:0,
    averageSalary:0,
    playerCountInc: 0
  },
  methods: {
    generate: function (src) {
      var payload = lineupGenerator.sliders.$data;
      this.generating = true;
      that = this;
      $.ajax({
        method: 'POST',
        url: '/lineup-generator/generate',
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
          lineupGenerator.sliders.$data.rosterCounts = response.rosterCounts;
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
          data: JSON.stringify(payload)
        },
      });
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

      var totalSpots = 6 * this.lineups;
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
  var $data =lineupGenerator.sliders.$data;
  if($data.minSalary > $data.maxSalary){
    return true;
  }
  return false;
};

lineupGenerator.start = function () {
  // show buttons and messages
  $.get('/lineup-generator/players/' + window.slate_global, function (response) {
    var modified_players = response.players.map(function(player) {
      var p = player;
      if (p.hasOwnProperty('tee_3') && p.tee_3.length > 0) p.tee_3 = p.tee_3 + "/span>&nbsp;";
      return p;
    });
    lineupGenerator.sliders.config.data.players = modified_players;
    lineupGenerator.sliders.config.data.rosterCounts = response.rosterCounts;
    lineupGenerator.sliders = new Vue(lineupGenerator.sliders.config);
    lineupGenerator.sliders.updateStats();
    $(".initial-hide").removeClass('initial-hide');
  });
};

$(function () {
  lineupGenerator.start();
  // Vue.transition('flyIn', {
  //     enterClass: 'bounceInRight',
  //     leaveClass: 'bounceOutLeft'
  // });
});





