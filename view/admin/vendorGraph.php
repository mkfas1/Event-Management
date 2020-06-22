<html>

<head>
    <style type="text/css">
        BODY {
            width: 100%;
        }

        #vendor-chart-container {
            width: 40%;
            height: 300px;
        }
    </style>
    <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="../js/Chart.min.js"></script>
</head>

<body>
    <div id="vendor-chart-container">
        <canvas id="vendorGraphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function() {
            showVendorGraph();
        });

        function showVendorGraph() {

            $.post("../../controller/graph/vendorGraphController.php",
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
                            label: 'Vendor Number',
                            backgroundColor: '#f15b22',
                            borderColor: '#f15b52',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: number

                        }]
                    };

                    var graphTarget = $("#vendorGraphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });

        }
    </script>


</body>

</html>