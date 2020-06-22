<?php
session_start();

$_SESSION['package_name'] = $_POST['productName'];
$_SESSION['vendor_name'] = $_POST['vendorName'];

echo "Rate this Package";
