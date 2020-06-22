<?php

function getAllWeeding()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from bundle_package where package_type = 'Weeding'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getWeedingByLowPrice()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from bundle_package where package_type = 'Weeding' ORDER BY Price";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getWeedingByHighPrice()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from bundle_package where package_type = 'Weeding' ORDER BY Price DESC";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
