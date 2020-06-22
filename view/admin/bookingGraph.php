<html>

<head>
    <style type="text/css">
        BODY {
            width: 100%;
        }

        #booing-chart-container {
            width: 40%;
            height: 300px;
        }
    </style>
    <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="../js/Chart.min.js"></script>
</head>

<body>
    <div id="booing-chart-container">
        <canvas id="bookingGraphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function() {
            showBookingGraph();
        });

        function showBookingGraph() {

            $.post("../../controller/graph/bookingGraphController.php",
                function(data) {
                    console.log(data);
                    var year = [];
                    var number = [];

                    for (var i in data) {
                        year.push(data[i].m_name);
                        number.push(data[i].id_no);
                    }

                    var chartdata = {
                        labels: year,
                        datasets: [{
                            label: 'Booking Number',
                            backgroundColor: '#f15b22',
                            borderColor: '#f15b52',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: number

                        }]
                    };

                    var graphTarget = $("#bookingGraphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });

        }
    </script>


</body>

</html>