var lineChart = new Chart(elem('#line'), {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
            {
                data: [],
            }
        ]
    },
    options: {
        defaultFontSize: 0,
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                    stepSize: 10,
                    suggestedMax: 100,
                    beginAtZero: true
                }
            }],
        }
    }
});

$.get('/api/appointments').done(function(res) {
    setLineData(res);
});

function setLineData(data) {
    lineChart.config.data = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
            {
                label: 'Afspraken',
                fill: true,
                lineTension: 0.2,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                data: data
            }
        ]
    };

    lineChart.update();
}
