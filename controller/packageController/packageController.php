<?php
@include_once "../../model/SinglePackage.php";
@include_once "../../model/BundlePackage.php";

function getSinglePackage()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from single_package where vendor_username = '" . $_SESSION['username'] . "'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function getBundlePackage()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT * from bundle_package where vendor_username = '" . $_SESSION['username'] . "'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function insertSinglePackage(SinglePackage $singlePackage)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $findSamePackage = "SELECT package_name, vendor_username from single_package where package_name = '" . $singlePackage->getPackageName() . "' AND vendor_username = '" . $singlePackage->getVendorName() . "'";
    $result = mysqli_query($connection, $findSamePackage);
    while ($row = mysqli_fetch_assoc($result)) {
        $vendorName = $row['vendor_username'];
        $packageName = $row['package_name'];
    }
    if ($vendorName == $singlePackage->getVendorName() && $packageName == $singlePackage->getPackageName()) {
        return -1;
    } else {

        $query = "INSERT into single_package (category, package_name,vendor_username,price, transport_cost, available_status,description, image, rating ) 
        VALUES ('" . $singlePackage->getCategory() . "' , 
        '" . $singlePackage->getPackageName() . "',
        '" . $singlePackage->getVendorName() . "',
        '" . $singlePackage->getPrice() . "',
        '" . $singlePackage->getTransportCost() . "',
        '" . $singlePackage->getAvailableStatus() . "',
        '" . $singlePackage->getDescription() . "',
        '" . "../../packageImage/singlePackagePicture/" . $singlePackage->getImage() . "',
        0
        ) ";
        if (mysqli_query($connection, $query)) {
            return 1;
        } else {
            return 0;
        }
    }
    mysqli_close($connection);
}

function updateSinglePackage($packageName, $vendorName, $price, $transportCost, $availableStatus, $description)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE single_package set price = '" . $price . "',transport_cost = '" . $transportCost . "',available_status = '" . $availableStatus . "',description = '" . $description . "'  where  package_name = '" . $packageName . "' AND vendor_username = '" . $vendorName . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}

function insertBundlePackage(BundlePackage $bundlePackage)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $findSamePackage = "SELECT package_name, vendor_username from bundle_package where package_name = '" . $bundlePackage->getPackageName() . "' AND vendor_username = '" . $bundlePackage->getVendorName() . "'";
    $result = mysqli_query($connection, $findSamePackage);
    while ($row = mysqli_fetch_assoc($result)) {
        $vendorName = $row['vendor_username'];
        $packageName = $row['package_name'];
    }
    if ($vendorName == $bundlePackage->getVendorName() && $packageName == $bundlePackage->getPackageName()) {
        return -1;
    } else {
        $query = "INSERT into bundle_package (package_type, package_name, caterers_available_status,decor_florists_available_status,makeup_andHair_available_status, 
        wedding_cards_available_status, mehandi_available_status,cakes_available_status, dj_available_status, photographers_available_status,entertainment_available_status, 
        price, transport_cost, description, available_status, vendor_username, rating) 
        VALUES ('" . $bundlePackage->getPackageType() . "' ,
        '" . $bundlePackage->getPackageName() . "',
        '" . $bundlePackage->getCaterersAvailableStatus() . "',
        '" . $bundlePackage->getDecorFloristsAvailableStatus() . "',
        '" . $bundlePackage->getMakeupAndHairAvailableStatus() . "',
        '" . $bundlePackage->getWeddingCardsAvailableStatus() . "',
        '" . $bundlePackage->getMehandiAvailableStatus() . "',
        '" . $bundlePackage->getCakesAvailableStatus() . "',
        '" . $bundlePackage->getDjAvailableStatus() . "',
        '" . $bundlePackage->getPhotographersAvailableStatus() . "',
        '" . $bundlePackage->getEntertainmentAvailableStatus() . "',
        '" . $bundlePackage->getPrice() . "',
        '" . $bundlePackage->getTransportCost() . "',
        '" . $bundlePackage->getDescription() . "',
        '" . $bundlePackage->getAvailableStatus() . "',
        '" . $bundlePackage->getVendorName() . "',
        0) ";
        if (mysqli_query($connection, $query)) {
            return 1;
        } else {
            return 0;
        }
    }
    mysqli_close($connection);
}

function updateBundlePackage(
    $packageName,
    $vendorName,
    $caterersAvailableStatus,
    $decorFloristsAvailableStatus,
    $makeupAndHairAvailableStatus,
    $weddingCardsAvailableStatus,
    $mehandiAvailableStatus,
    $cakesAvailableStatus,
    $djAvailableStatus,
    $photographersAvailableStatus,
    $entertainmentAvailableStatus,
    $price,
    $transportCost,
    $availableStatus,
    $description
) {
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "UPDATE bundle_package set 
            caterers_available_status= '" . $caterersAvailableStatus . "',
            decor_florists_available_status= '" . $decorFloristsAvailableStatus . "',
            makeup_andHair_available_status= '" . $makeupAndHairAvailableStatus . "', 
            wedding_cards_available_status= '" . $weddingCardsAvailableStatus . "', 
            mehandi_available_status= '" . $mehandiAvailableStatus . "',
            cakes_available_status= '" . $cakesAvailableStatus . "', 
            dj_available_status= '" . $djAvailableStatus . "', 
            photographers_available_status= '" . $photographersAvailableStatus . "',
            entertainment_available_status= '" . $entertainmentAvailableStatus . "',
            price = '" . $price . "',
            transport_cost = '" . $transportCost . "',
            available_status = '" . $availableStatus . "',
            description = '" . $description . "'  
            where  package_name = '" . $packageName . "' AND vendor_username = '" . $vendorName . "'";

    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}

function deletePackage($productName, $vendorName)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "DELETE FROM single_package where package_name = '$productName' AND vendor_username = '$vendorName'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}
function deleteBundlePackage($productName, $vendorName)
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "DELETE FROM bundle_package where package_name = '$productName' AND vendor_username = '$vendorName'";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function getAllSinglePackage()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT id, package_name, vendor_username, available_status from single_package";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function updateSinglePackageStatusYes($id)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE single_package set available_status = 'No' where  id = '" . $id . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}
function updateSinglePackageStatusNo($id)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE single_package set available_status = 'Yes' where  id = '" . $id . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}

function getAllBundlePackage()
{
    $connection = mysqli_connect("localhost", "root", "", "event_organizer");
    if (!$connection) {
        return -1;
    }
    $query = "SELECT id, package_name, vendor_username, available_status from bundle_package";
    $result = $connection->query($query);
    return $result;
    mysqli_close($connection);
}

function updateBundlePackageStatusYes($id)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE bundle_package set available_status = 'No' where  id = '" . $id . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}
function updateBundlePackageStatusNo($id)
{
    $connection = new PDO("mysql:host=localhost; dbname=event_organizer", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE bundle_package set available_status = 'Yes' where  id = '" . $id . "'";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    return $result;
    mysqli_close($connection);
}

