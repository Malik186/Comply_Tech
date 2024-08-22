<script>
      $(document).ready(function () {
        $("#crancy-table__main").DataTable({
          searching: true, // Enable search functionality
          info: true,
          lengthChange: true, // Enable the ability to change the number of records per page
          pageLength: 7,
          lengthMenu: [
            [7, 14, 25, 50, -1],
            [7, 14, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="fas fa-angle-right"></i>',
              previous: '<i class="fas fa-angle-left"></i>',
            },
            lengthMenu: "Show result: _MENU_ ", // Customize the "Show entries" text
          },
          dom: 'rt<"crancy-table-bottom"flp><"clear">', // Set the desired layout for the table
        });
      });
    </script>
    <script>
      var picker = new Pikaday({ field: document.getElementById("dateInput") });
      // Create a new instance of Pikaday for the date-input field
      const picker1 = new Pikaday({
        field: document.getElementById("date-input"),
        format: "MMM DD", // Set the desired format
        toString(date, format) {
          const day = date.getDate();
          const month = date.toLocaleString("default", { month: "short" });
          const formattedDate = `${day} ${month}`;
          return formattedDate;
        },
      });

      // Create another instance of Pikaday for the dateInput field
      const picker2 = new Pikaday({
        field: document.getElementById("date-input2"),
        format: "MMM DD", // Set the desired format
        toString(date, format) {
          const day = date.getDate();
          const month = date.toLocaleString("default", { month: "short" });
          const formattedDate = `${day} ${month}`;
          return formattedDate;
        },
      });
    </script>

    <script>
      // Chart Three
      const ctx_myChart_recent_statics = document
        .getElementById("myChart_recent_statics")
        .getContext("2d");
      const gradientBgs = ctx_myChart_recent_statics.createLinearGradient(
        400,
        100,
        100,
        400
      );

      gradientBgs.addColorStop(0, "rgba(10, 130, 253, 0.19)");
      gradientBgs.addColorStop(1, "rgba(10, 130, 253, 0)");

      const myChart_recent_statics = new Chart(ctx_myChart_recent_statics, {
        type: "line",

        data: {
          labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "Sells",
              data: [10, 15, 35, 60, 35, 50, 40, 30, 35, 80, 50, 30],
              backgroundColor: gradientBgs,
              borderColor: "#194BFB",
              borderWidth: 3,
              fill: true,
              tension: 0.4,
              fillColor: "#fff",
              fill: "start",
              pointRadius: 2,
            },
          ],
        },

        options: {
          maintainAspectRatio: false,
          responsive: true,
          scales: {
            x: {
              ticks: {
                color: "#9AA2B1",
              },
              grid: {
                display: false,
                drawBorder: false,
                color: "#E6F3FF",
              },
              suggestedMax: 100,
              suggestedMin: 50,
            },
            y: {
              ticks: {
                color: "#5D6A83",
                callback: function (value, index, values) {
                  return (value / 10) * 10 + "%";
                },
              },
              grid: {
                drawBorder: false,
                color: "#D7DCE7",
                borderDash: [5, 5],
              },
            },
          },
          plugins: {
            tooltip: {
              padding: 10,
              displayColors: true,
              yAlign: "bottom",
              backgroundColor: "#fff",
              titleColor: "#000",
              titleFont: { weight: "normal" },
              bodyColor: "#2F3032",
              cornerRadius: 12,
              boxPadding: 3,
              usePointStyle: true,
              borderWidth: 0,
              font: {
                size: 14,
              },
              caretSize: 9,
              bodySpacing: 100,
            },
            legend: {
              position: "bottom",
              display: false,
            },
            title: {
              display: false,
              text: "Sell History",
            },
          },
        },
      });

      //   target chart
      const centerInfo = {
        id: "centerInfo",
        afterDatasetsDraw(chart, args, pluginOptions) {
          const {
            ctx,
            data,
            chartArea: { top, bottom, left, right, width, height },
          } = chart;
          const { x, y } = chart.getDatasetMeta(0).data[1].tooltipPosition();
          ctx.save();
          ctx.font = " 700 36px sans-serif";
          ctx.textAlign = "center";
          ctx.fillStyle = data.centerDataColor || "#191b23";
          ctx.textBaseline = "middle";
          ctx.fillText(`${data.datasets[0].data[0]}`, width / 2 + 13, height);
          ctx.font = "400 16px sans-serif";
          ctx.fillStyle = data.centerTitleColor || "#191b23";
          ctx.fillText("Total Count", width / 2 + 10, height - 34);
        },
      };

      const revenueTargetCharts = document.querySelectorAll(".revenueTarget");
      revenueTargetCharts.forEach((chart) => {
        const ctx_bids = chart.getContext("2d");
        const data = {
          labels: ["Red", "Orange", "Yellow"],
          centerDataColor: "#191b23",
          centerTitleColor: "#191b23",
          datasets: [
            {
              label: "Dataset 1",
              data: [1.375, 1.375, 1.375],
              backgroundColor: ["#2563EB", "#BFDBFE", "#EAB308"],
              borderWidth: 0,
              hoverBorderWidth: 13,
              borderColor: ["#2563EB", "#BFDBFE", "#EAB308"],
              borderJoinStyle: "miter",
              rotation: 270,
            },
          ],
        };

        const config = {
          type: "doughnut",
          data: data,
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: 10,
            },
            circumference: 180,
            cutout: 55,
            plugins: {
              legend: {
                display: false,
                position: "top",
              },
              title: {
                display: false,
              },
            },
          },
          plugins: [centerInfo],
        };

        const NUMBER_CFG = { count: 5, min: 0, max: 100 };

        const myChart = new Chart(ctx_bids, config);

        // spending over view
        const revenueCharts = document.querySelectorAll(".spending_over_view");
        revenueCharts.forEach((chart) => {
          const ctx_bids = chart.getContext("2d");

          const labels = [
            "",
            "Apr",
            "",
            "May",
            "",
            "Jun",
            "",
            "July",
            "",
            "Aug",
            "",
            "Sep",
          ];
          const data = {
            labels: labels,
            datasets: [
              {
                label: false,
                data: [0, 0, 12, 38, 29, 15, 36, 78, 56, 38, 27, 55, 38],

                pointBackgroundColor: "#fff",
                borderWidth: 3,
                border: 0.1,
                borderColor: "#194BFB",
                tension: 0.4,
              },
            ],
          };
          const config = {
            type: "line",
            data: data,
            options: {
              layout: {},
              elements: {
                point: {
                  radius: 0,
                },
              },
              maintainAspectRatio: false,
              showAllTooltips: true,
              scales: {
                x: {
                  border: {
                    dash: [1, 8],
                    color: "#FFFF",
                  },
                  grid: {
                    drawBorder: false,
                    borderDash: [5, 5],
                    color: "#BED7FE",
                  },
                  min: 1,
                  max: 12.4,
                  ticks: {
                    color: "#64748B",
                  },
                },
                y: {
                  border: {
                    dash: [4, 8],
                  },
                  grid: {
                    drawBorder: false,
                    dash: [4, 8],
                    color: "transparent",
                  },
                  ticks: {
                    display: false,
                    color: "transparent",
                  },
                  min: 0,
                  max: 100,
                  //   stacked: true,
                },
              },
              plugins: {
                legend: {
                  position: "top",
                  display: false,
                },
                annotation: {
                  annotations: {
                    point1: {
                      type: "point",
                      xValue: 8,
                      yValue: 78,
                      backgroundColor: "#ffff",
                      radius: 5,
                    },
                    label1: {
                      type: "label",
                      xValue: 6,
                      yValue: 80,

                      color: [" #5D6A83", "#5D6A83"],
                      borderRadius: 10,
                      padding: 8,
                      backgroundColor: "#FFFF",
                      backgroundShadowColor: "#191B23  17",
                      shadowBlur: 40,
                      shadowOffsetX: 0,
                      shadowOffsetY: 8,
                      content: (ctx) => {
                        const chart = ctx.chart;
                        const dataset = chart.data.datasets[0];
                        return ["", "Net Sell"];
                      },
                      font: {
                        size: 14,
                        weight: 400,
                      },
                    },
                    label2: {
                      type: "label",
                      color: "#2563EB",
                      xValue: 6,
                      yValue: 80,
                      backgroundColor: "transparent",
                      content: (ctx) => {
                        const chart = ctx.chart;
                        const dataset = chart.data.datasets[1];
                        return ["$" + " " + dataset.data[6], ""];
                      },
                      font: [
                        {
                          size: 12,
                          weight: "bold",
                        },
                      ],
                    },
                  },

                  drawTime: "afterDatasetsDraw",
                },

                title: {
                  display: false,
                  text: "Visitor: 2k",
                },
                tooltip: {
                  // Disable the on-canvas tooltip

                  enabled: true,
                },
              },
            },
          };

          const myChart = new Chart(ctx_bids, config);
        });
      });
    </script>