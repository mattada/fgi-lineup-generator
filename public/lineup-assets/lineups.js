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
    message: "Be sure to specify enough exposure/players for the amount of teams requested",
    valid: false,
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
    generate: function () {
      var payload = lineupGenerator.sliders.$data;
      $.ajax({
        method: 'POST',
        url: '/lineup-generator/generate',
        dataType: 'json',
        success: function (response) {
          var inc = 1;
          lineupGenerator.sliders.$data.results = [];
          var n = 0;
          lineupGenerator.sliders.$data.rosterCounts = response.rosterCounts;
          response.combos.forEach(function (value, key) {
            setTimeout(function () {
              value.inc = inc++;
              lineupGenerator.sliders.$data.results.push(value);
            }, n);
            n = n + 110;
          });
        },
        data: {
          data: JSON.stringify(payload)
        },
      });
    },
    update: function () {
      // var payload = lineupGenerator.sliders.$data;
      if(lineupGenerator.validateFail()){
        return alert('Warning: Max salary must be a higher number than the minimum salary.');
      }
      // this.generate();
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
      if( isFinite(totalSalaryAvailable / totalSpotsUsed)){
        var averageSalaryRemaining = ( (totalSalaryAvailable - totalSalaryUsed) / (totalSpots - totalSpotsUsed) ).toFixed(2);

      }

      this.totalSpots = numeral(totalSpots).format('0,0');
      this.totalSpotsUsed = numeral(totalSpotsUsed).format('0,0');
      this.totalSalaryAvailable = numeral(totalSalaryAvailable).format('0,0');
      this.totalSalaryUsed = numeral(totalSalaryUsed).format('0,0');
      this.averageSalary = numeral(averageSalary).format('0,0');
      this.averageSalaryRemaining = numeral(averageSalaryRemaining).format('0,0');
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
  $.get('/lineup-generator/players', function (response) {
    lineupGenerator.sliders.config.data.players = response.players;
    lineupGenerator.sliders.config.data.rosterCounts = response.rosterCounts;
    lineupGenerator.sliders = new Vue(lineupGenerator.sliders.config);
    lineupGenerator.sliders.updateStats();
  });
};

$(function () {
  lineupGenerator.start();
  // Vue.transition('flyIn', {
  //     enterClass: 'bounceInRight',
  //     leaveClass: 'bounceOutLeft'
  // });
});





