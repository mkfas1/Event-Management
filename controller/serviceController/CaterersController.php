<?php

function getAllCaterers()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from single_package where category = 'Caterers'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getCaterersByLowPrice()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from single_package ORDER BY Price ASC";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getCaterersByHighPrice()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from single_package ORDER BY Price DESC";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
