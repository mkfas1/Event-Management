<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "event_organizer");

$sqlQuery = "SELECT  MONTHNAME(bookingdate) as m_name, count(id) as id_no from booking GROUP BY MONTHNAME(bookingdate)";

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
