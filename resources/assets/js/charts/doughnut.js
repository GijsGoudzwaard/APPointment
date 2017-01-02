var doughnutChart = new Chart(elem('#doughnut'), {
    type: 'doughnut',
    data: {
        labels: ["data"],
        datasets: [{data: [100]}]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    }
});

$.get('/api/appointmenttypes').done(function(res) {
    setDoughnutData(res);
});

function setDoughnutData(data) {
    doughnutChart.config.data = {
        labels: data.list('name'),
        datasets: [
            {
                data: data.list('amount'),
                backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56",
                    "#4BC0C0"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56",
                    "#4BC0C0"
                ]
            }
        ]
    };
    doughnutChart.update();
}
