//chart.html Configuration 
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

    var ctx = document.getElementById("canvas-basic").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(233,60,136,0.25)');   
    gradient.addColorStop(1, 'rgba(250,250,250,0)');
    
var barChartData5 = {
    labels : [],
    datasets : [
        {
            label: 'Historial de peso en kg',
            borderWidth: 2.5,
            backgroundColor: gradient,
            borderColor: "#e93c88",
            pointRadius: 5,
            pointBorderColor: "#e93c88",
            backgroundGradientFrom: '#fb8c00',
            backgroundGradientTo: '#ffa726',
            pointBackgroundColor: "#fff",
            pointHighlightStroke: "#e93c88",
            data : []
        }
    ]
}

window.onload = function(){
    "use strict";
    var ctx5 = document.getElementById("canvas-basic").getContext("2d");
    var json_url = base_url+"doctor/get_weight?id="+patient_id;
    
    window.myLine = new Chart(ctx5,  {
        type: 'line',
        data: barChartData5,
        fillColor : gradient, // Put the gradient here as a fill color
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: false,
            },
            scales: {
            yAxes: [{
                gridLineColor: 'transparent',
                stacked: true,
                ticks: {
                    display: true,

                },
                gridLines: {
                        lineWidth: 0,
                        zeroLineColor: "rgba(255,255,255,1)",
                        color: "rgba(255,255,255,1)"
                },
            }],
            xAxes: [{
                gridLineColor: 'transparent',
                stacked: true,
                gridLines: {
                    display: true,
                    color: "rgba(0,0,0,0.1)"
            },
                ticks: {
                    display: true,
                },
            }]
        },
        }
    });
    
    
    ajax_chart(myLine, json_url);
    
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.quantity;
            chart.update();
        });
    }

}






