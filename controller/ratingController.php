<?php
@include_once "../model/Rating.php";
function insertRating(Rating $rating)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $findRating = "SELECT * from rating where package_name = '" . $rating->getPackage_name() . "' and customer_name = '" . $rating->getCustomer_name() . "' ";
    $result = mysqli_query($connection, $findRating);
    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE rating
            SET 
            rating_value =         '" . $rating->getRating() . "'
            WHERE package_name = '" . $rating->getPackage_name() . "' and customer_name = '" . $rating->getCustomer_name() . "'";
        mysqli_query($connection, $query);
    } else {
        $query = "INSERT INTO rating(package_name, vendor_name, customer_name, rating_value) 
            VALUES(
                '" . $rating->getPackage_name() . "',
                '" . $rating->getVendor_name() . "',
                '" . $rating->getCustomer_name() . "',
                '" . $rating->getRating() . "'
                )";
        mysqli_query($connection, $query);
    }
}
