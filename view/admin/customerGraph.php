<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        BODY {
            width: 100%;
        }

        #customer-chart-container {
            width: 40%;
            height: 300px;
        }
    </style>
    <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="../js/Chart.min.js"></script>


</head>

<body>
    <div id="customer-chart-container">
        <canvas id="customerGraphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function() {
            showGraph();
        });

        function showGraph() {
            {
                $.post("../../controller/graph/customerGraphController.php",
                    function(data) {
                        console.log(data);
                        var year = [];
                        var number = [];

                        for (var i in data) {
                            year.push(data[i].r_year);
                            number.push(data[i].id_no);
                        }

                        var chartdata = {
                            labels: year,
                            datasets: [{
                                label: 'Customer Number',
                                backgroundColor: '#f15b22',
                                borderColor: '#f15b52',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: number

                            }]
                        };

                        var graphTarget = $("#customerGraphCanvas");

                        var barGraph = new Chart(graphTarget, {
                            type: 'bar',
                            data: chartdata
                        });
                    });
            }
        }
    </script>

</body>

</html>