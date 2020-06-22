<?php
@include_once "../model/booking.php";
@include_once "../model/PendingBook.php";
function insertBookingDetails(Booking $booking)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    } else {
        $query = "INSERT INTO booking ( username,transaction, email, phone, address, bookingdate, vendorname, packagename, totalcost, halfpaid, fullpaid)
        VALUES (
            '" . $booking->getUsername() . "' ,
            '" . $booking->getTransaction() . "' ,
            '" . $booking->getEmail() . "' ,
            '" . $booking->getPhone() . "' ,
            '" . $booking->getAddress() . "' ,
            '" . $booking->getBookingDate() . "' ,
            '" . $booking->getVendorName() . "' ,
            '" . $booking->getPackageName() . "' ,
            '" . $booking->getTotalCost() . "' ,
            '" . $booking->getHalfPaid() . "' ,
            '" . $booking->getFullPaid() . "' 
            )";
        if (mysqli_query($connection, $query)) {
            return 1;
        } else {
            return 0;
        }
    }
    mysqli_close($connection);
}

function updateBooking($vendorName, $packageName)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    $query = "UPDATE single_package, bundle_package
    SET available_status = 'No'
    where vendor_username = '$vendorName' and package_name = '$packageName'
    ";
    if (mysqli_close($connection, $query)) {
        return 1;
    } else {
        return 0;
    }
}
function getAllBooking()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from booking where fullpaid ='no' ";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function halfBooking(PendingBook $pendingbook)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "UPDATE booking SET halfpaid = '" . $pendingbook->getHalfPaid() . "'  where transaction = '" . $pendingbook->getTransaction() . "'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function fullBooking(PendingBook $pendingbook)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "UPDATE booking SET fullpaid = '" . $pendingbook->getFullPaid() . "'  where transaction = '" . $pendingbook->getTransaction() . "'";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}

function cancelBooking(PendingBook $pendingbook)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "DELETE from booking where transaction = '" . $pendingbook->getTransaction() . "'";
    $result = $connection->query($query);
    mysqli_close($connection);
}


function getAllOrderHistory()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from booking where fullpaid ='yes' order by transaction DESC ";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function getIndividualBooking($person)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from booking where username = '$person' ";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function updateBookingForSingle($vendorName, $packageName)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    $query = "UPDATE single_package
    SET available_status = 'No'
    where vendor_username = '$vendorName' and package_name = '$packageName'
    ";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}
function updateBookingForBundle($vendorName, $packageName)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    $query = "UPDATE bundle_package
    SET available_status = 'No'
    where vendor_username = '$vendorName' and package_name = '$packageName'
    ";
    mysqli_query($connection, $query);
    mysqli_close($connection);
}
