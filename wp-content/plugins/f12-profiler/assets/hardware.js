(function ($) {
    /**
     * Transform the Data from default array [0,5,10]
     * to Coordinates [{x:0, y:0}, {x:1,y:5}, {x:2, y:10}]
     * @param data
     */
    function parseDataToCoordinates(data) {
        var ret = [];
        for (var i = 0; i < data.length; i++) {
            ret.push({x: i, y: data[i]});
        }

        return ret;
    }

    $(document).ready(function () {
        /**
         * CPU CHART
         * Loads the JSON string which has been written to ".hardware .cpu .data" and parse
         * them as coordinates which will be displayed within the "#canvas_cpu" canvas.
         */
        var ctx = document.getElementById('canvas_cpu').getContext('2d');

        var data = JSON.parse($(".hardware .cpu .data").html());
        var config = {
            type: 'line',
            data: {
                labels: ['0', '1'],
                datasets: [{
                    label: 'CPU Usage',
                    backgroundColor: '#fffff',
                    borderColor: '#4183c4',
                    data: parseDataToCoordinates(data),
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'CPU Usage'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '% Usage'
                        }
                    }]
                }
            }
        };

        var CPUChart = new Chart(ctx, config);

        /**
         * RAM CHART
         * Loads the JSON string which has been written to ".hardware .ram .data" and parse
         * them as coordinates which will be displayed within the "#canvas_ram" canvas.
         */
        var ctx = document.getElementById('canvas_ram').getContext('2d');

        var data = JSON.parse($(".hardware .ram .data").html());
        var config = {
            type: 'line',
            data: {
                labels: ['0', '1'],
                datasets: [{
                    label: 'RAM Usage',
                    backgroundColor: '#ff000',
                    borderColor: '#4183c4',
                    data: parseDataToCoordinates(data),
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'RAM Usage'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '% Usage'
                        }
                    }]
                }
            }
        };

        var RAMChart = new Chart(ctx, config);


        /**
         * RAM PHP CHART
         * Loads the JSON string which has been written to ".hardware .ram_php .data" and parse
         * them as coordinates which will be displayed within the "#canvas_ram_php" canvas.
         */
        var ctx = document.getElementById('canvas_ram_php').getContext('2d');

        var data = JSON.parse($(".hardware .ram_php .data").html());
        var config = {
            type: 'line',
            data: {
                labels: ['0', '1'],
                datasets: [{
                    label: 'RAM Usage',
                    backgroundColor: '#ff000',
                    borderColor: '#4183c4',
                    data: parseDataToCoordinates(data),
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'RAM (PHP) Usage'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'MB Usage'
                        }
                    }]
                }
            }
        };

        var RAMPHPChart = new Chart(ctx, config);
    });
})(jQuery);