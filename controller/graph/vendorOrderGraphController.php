<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "event_organizer");

$sqlQuery = "SELECT monthname(booking.bookingdate) as b_month, count(booking.id) as id_no from booking 
            where booking.vendorname = '" . $_SESSION['username'] . "' AND (booking.bookingdate>DATE_SUB(NOW(),INTERVAL 1 MONTH) 
            OR booking.bookingdate<DATE_SUB(NOW(),INTERVAL 1 MONTH)) 
            GROUP BY monthname(booking.bookingdate) 
            ORDER BY monthname(booking.bookingdate)";

$result = mysqli_query($conn, $sqlQuery);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
