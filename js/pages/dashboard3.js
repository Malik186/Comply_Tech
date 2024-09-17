//[Dashboard Javascript]

//Project:	Comply Tech
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

    'use strict';
      
      
      var options = {
          series: [
              {
              name: "Current year",
              data: [0, 40, 110, 70, 100, 60, 130, 55, 140, 125]
              },
              {
              name: "Last year",
              data: [0, 30, 150, 40, 90, 80, 70, 45, 110, 105]
              },
                  ],
          chart: {
              foreColor:"#bac0c7",
            height: 310,
            type: 'line',
            zoom: {
              enabled: false
            }
          },
          colors:['#7367F0', '#EA5455'],
          dataLabels: {
            enabled: false,
          },
          stroke: {
                show: true,
              curve: 'smooth',
              lineCap: 'butt',
              colors: undefined,
              width: 4,
              dashArray: 0, 
          },
           legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'center',
           },
          markers: {
              size: 6,
              colors: ['#7367F0', '#EA5455'],
              strokeColors: '#ffffff',
              strokeWidth: 2,
              strokeOpacity: 1,
              strokeDashArray: 0,
              fillOpacity: 1,
              discrete: [],
              shape: "circle",
              radius: 5,
              offsetX: 0,
              offsetY: 0,
              onClick: undefined,
              onDblClick: undefined,
              hover: {
                size: undefined,
                sizeOffset: 3
              }
          },	
          grid: {
              borderColor: '#f7f7f7', 
            row: {
              colors: ['transparent'], // takes an array which will be repeated on columns
              opacity: 0
            },			
            yaxis: {
              lines: {
                show: true,
              },
            },
          },
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            labels: {
              show: true,        
            },
            axisBorder: {
              show: true
            },
            axisTicks: {
              show: true
            },
            tooltip: {
              enabled: true,        
            },
          },
          yaxis: {
            labels: {
              show: true,
              formatter: function (val) {
                return val + "K";
              }
            }
          
          },
        };
        var chart = new ApexCharts(document.querySelector("#charts_widget_2_chart"), options);
        chart.render();
      
      
      
      var options = {
            series: [{
            name: 'Earning',
            data: [76, 85, 101, 98, 87, 105, 91]
          }],
            chart: {
            type: 'bar',
            foreColor:"#bac0c7",
            height: 150,
                toolbar: {
                  show: false,
                }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '20%',
            },
          },
          dataLabels: {
            enabled: false,
          },
          grid: {
              show: false,			
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
          },
          colors: ['#7367F0'],
          xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
              
          },
          yaxis: {
            
          },
           legend: {
                show: false,
           },
          fill: {
            opacity: 1
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "$ " + val + " thousands"
              }
            },
              marker: {
                show: false,
            },
          }
          };
  
          var chart = new ApexCharts(document.querySelector("#recent_trend"), options);
          chart.render();
      
       
      
      
      
      
  
      
  }); // End of use strict