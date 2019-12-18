//doughnut
var ctxD = document.getElementById("doughnutChart").getContext('2d');
var myLineChart = new Chart(ctxD, {
    type: 'doughnut',
    data: {
        labels: ["Perfect", "Attention", "Bad"],
        datasets: [{
            data: [600, 150, 50],
            backgroundColor: ["#5cb85c", "#f0ad4e", "#d9534f"],
            hoverBackgroundColor: ["#5cb85d", "#f0ad4f", "#d9534d"]
        }]
    },
    options: {
        responsive: true
    }
});

//polar
var ctxPA = document.getElementById("polarChart").getContext('2d');
var myPolarChart = new Chart(ctxPA, {
    type: 'polarArea',
    data: {
        labels: ["Red", "Green", "Yellow", "Grey", "Dark Grey"],
        datasets: [{
            data: [300, 50, 100, 40, 120],
            backgroundColor: ["rgba(219, 0, 0, 0.1)", "rgba(0, 165, 2, 0.1)", "rgba(255, 195, 15, 0.2)",
                "rgba(55, 59, 66, 0.1)", "rgba(0, 0, 0, 0.3)"
            ],
            hoverBackgroundColor: ["rgba(219, 0, 0, 0.2)", "rgba(0, 165, 2, 0.2)",
                "rgba(255, 195, 15, 0.3)", "rgba(55, 59, 66, 0.1)", "rgba(0, 0, 0, 0.4)"
            ]
        }]
    },
    options: {
        responsive: true
    }
});