var doughnutChart = new Chart(elem('#doughnut'), {
    type: 'doughnut',
    data: {
        labels: ["data"],
        datasets: [{data: [100]}]
    },
    animation: {
        animateScale: false
    }
});

ajax({
    method: 'GET',
    destination: '/api/appointmenttypes',
    loader: false,
}, function(res) {
    setDoughnutData(JSON.parse(res));
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
                    "#FFCE56"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            }
        ]
    }
    doughnutChart.update();
}