/**
 * Generates simple chart images using phantom.js and chart.js.
 *
 * Usage: `phantomjs chart.js {chart data} {output path}`
 * Example: `phantomjs chart.js "$(cat data.json)" chart.png`
 */

var system        = require('system');
var page          = require('webpage').create();
var canvas        = '<canvas id="myChart" width="400" height="400"></canvas>';
var style         = '<style>body { background-color: #FFF; }</style>'
page.content      = '<html><head><title></title>' + style + '</head><body>' + canvas + '</body</html>';
page.viewportSize = {width: 400, height: 400};

page.onLoadFinished = function () {
    if (page.injectJs('/assets/Chart.bundle.min.js')) {
        var chartData = JSON.parse(system.args[1]);
        var outPath = system.args[2];

        page.evaluate(function (chartData) {
            var ctx = document.getElementById("myChart").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: false,
                    animation: {
                        duration: 1,
                        onComplete: function () {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;
                            ctx.textAlign = "center";
                            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                    ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 15);
                                }),this)
                            }),this);
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            labels: {
                                show: true
                            }
                        }]
                    },
                }
            });
        }, chartData);

        window.setTimeout(function () {
            page.render(outPath);
            phantom.exit();
        }, 200);
    }
};
