// $(document).ready(() => {
//     navigator.geolocation.getCurrentPosition(function(position) {

//         if(position.coords.latitude && position.coords.longitude){
//             data={
//                 'lat':position.coords.latitude ,
//                 'long':position.coords.longitude
//             }
//             $('#lat').val(data.lat)
//             $('#long').val(data.long)
//             // alert(data.lat)


//         };
//         // console.log();
//       });
// });

(function($) {
  'use strict';



  let monthlySaleRecords=$('#monthlySaleRecords').val().split(',')
//   alert(monthlySaleRecords)
  let monthlyIncomeRecords=$('#monthlyIncomeRecords').val().split(',')
//   alert(monthlySaleRecords)


  $(function() {
    charts()
//when initial state of   admin/dashboard  is called


  });
})(jQuery);
function charts(){
    // a function that is called when  admin/dashboard is visited by client
    // inorder to get income and monthly sale records from laravel
    let monthlySaleRecords=$('#monthlySaleRecords').val().split(',')

      let monthlyIncomeRecords=$('#monthlyIncomeRecords').val().split(',')
    if ($("#sales-chart").length) {
        var SalesChartCanvas = $("#sales-chart").get(0).getContext("2d");
        var SalesChart = new Chart(SalesChartCanvas, {
          type: 'bar',
          data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May","June",'Jul','Aug','Sept','Oct','Nov','Dec'],
            datasets: [{
                label: 'Monthly Sales',
                data: monthlySaleRecords,
                backgroundColor: '#98BDFF'
              },
              {
                label: 'Monthly Income',
                data: monthlyIncomeRecords,
                backgroundColor: '#4B49AC'
              }
            ]
          },
          options: {
            cornerRadius: 5,
            responsive: true,
            maintainAspectRatio: true,
            layout: {
              padding: {
                left: 0,
                right: 0,
                top: 20,
                bottom: 0
              }
            },
            scales: {
              yAxes: [{
                display: true,
                gridLines: {
                  display: true,
                  drawBorder: false,
                  color: "#F2F2F2"
                },
                ticks: {
                  display: true,
                  min: 0,
                  max: 10000,
                  callback: function(value, index, values) {
                    return  value + '₵' ;
                  },
                  autoSkip: true,
                  maxTicksLimit: 10,
                  fontColor:"#6C7383"
                }
              }],
              xAxes: [{
                stacked: false,
                ticks: {
                  beginAtZero: true,
                  fontColor: "#6C7383"
                },
                gridLines: {
                  color: "rgba(0, 0, 0, 0)",
                  display: false
                },
                barPercentage: 1
              }]
            },
            legend: {
              display: false
            },
            elements: {
              point: {
                radius: 0
              }
            }
          },
        });
        document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
      }
      if ($("#sales-pie-chart").length) {
    var SalesChartPieCanvas = $("#sales-pie-chart").get(0).getContext("2d");
    var SalesChart = new Chart(SalesChartPieCanvas, {
      type: 'pie',

      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May","June",'Jul','Aug','Sept','Oct','Nov','Dec'],
        datasets: [{
            label: 'Monthly Sales',
            data: monthlySaleRecords,
            backgroundColor: '#98BDFF'
          },
          {
            label: 'Monthly Income',
            data: monthlyIncomeRecords,
            backgroundColor: '#4B49AC'
          }
        ]
      },
      options: {
        cornerRadius: 5,
        responsive: true,
        maintainAspectRatio: true,
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 20,
            bottom: 0
          }
        },
        scales: {

        },
        legend: {
          display: false
        },
        elements: {
          point: {
            radius: 0
          }
        }
      },
    });
    // document.getElementById('sales-pie-legend').innerHTML = SalesChart.generateLegend();
  }
}
window.onload = function() {
    window.addEventListener('refreshCharts', () => {
        // state change on  admin/dashboard  and as a result,chart needs to be recreated
     charts()

})
}
