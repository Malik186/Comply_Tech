<script>
      $(document).ready(function () {
        $("#crancy-table__main").DataTable({
          searching: true, // Enable search functionality
          info: true,
          lengthChange: true, // Enable the ability to change the number of records per page
          pageLength: 5,
          lengthMenu: [
            [5, 14, 25, 50, -1],
            [5, 14, 25, 50, "All"],
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
        format: "DD MMM", // Set the desired format
        toString(date, format) {
          const day = date.getDate();
          const month = date.toLocaleString("default", { month: "short" });
          const formattedDate = `${day} ${month}`;
          return formattedDate;
        },
      });

      // Create another instance of Pikaday for the dateInput field
      const picker2 = new Pikaday({
        field: document.getElementById("dateInput"),
        // ... other options for the dateInput picker
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
    </script>