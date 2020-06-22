<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "event_organizer");

$sqlQuery = "SELECT year(registration_date) as r_year, count(id) as id_no from person 
            where  status=2 AND (registration_date>DATE_SUB(NOW(),INTERVAL 1 YEAR) 
            OR registration_date<DATE_SUB(NOW(),INTERVAL 1 YEAR)) 
            GROUP BY YEAR(registration_date) 
            ORDER BY year(registration_date)";

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
