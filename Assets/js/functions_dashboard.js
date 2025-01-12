let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');

$.get(base_url + "/dashboard/show_category_data", function(data) {
  var data = JSON.parse(data);
  let categories = data.result;

  var categoryChartOptions = {
      annotations: {
        position: "back",
      },
      dataLabels: {
        enabled: false,
      },
      chart: {
        type: "bar",
        height: 300,
      },
      fill: {
        opacity: 1,
      },
      plotOptions: {},
      series: [
        {
          name: "Total Categorías",
          data: categories.map(category => category.total),
        },
      ],
      colors: "#435ebe",
      xaxis: {
        categories: categories.map(category => category.name_category),
      },
      yaxis: {
        labels: {
          formatter: function(value) {
            return value.toFixed(0);
          }
        },
        forceNiceScale: true,
      },
    }


    let categoryDistributionChartOptions = {
      series: categories.map(category => parseFloat(category.porcentaje)),
      labels: categories.map(category => category.name_category),
      colors: ["#435ebe", "#55c6e8", "#FF4560", "#FEB019", "#00E396"],
      chart: {
        type: "donut",
        width: "100%",
        height: "350px",
      },
      legend: {
        position: "bottom",
      },
      plotOptions: {
        pie: {
          donut: {
            size: "30%",
          },
        },
      },
    }

  var categoryChart = new ApexCharts(
    document.querySelector("#chart-category"),
    categoryChartOptions
  )
  categoryChart.render()

  var categoryDistributionChart = new ApexCharts(
    document.getElementById("chart-category-distribution"),
    categoryDistributionChartOptions
  )
  categoryDistributionChart.render()
});
  

  
  