<?php
session_start();

if (isset($_SESSION["shoppingCart"])) {
  $item_array_id = array_column($_SESSION["shoppingCart"], "itemId");
  if (!in_array($_POST['productId'], $item_array_id)) {
    $count = count($_SESSION["shoppingCart"]) + 1;
    $item_array = array(
      'itemId' => $_POST['productId'],
      'itemName' => $_POST['productName'],
      'itemPrice' =>  $_POST['productPrice'],
      'itemTransportCost' => $_POST['transportCost'],
      'itemVendor' =>  $_POST['vendor']
    );
    $_SESSION["shoppingCart"][$count] = $item_array;
  } else {
    echo '<script>alert("Already added")</script>';
  }
} else {
  $item_array = array(
    'itemId' => $_POST['productId'],
    'itemName' => $_POST['productName'],
    'itemPrice' =>  $_POST['productPrice'],
    'itemTransportCost' => $_POST['transportCost'],
    'itemVendor' =>  $_POST['vendor']
  );
  $_SESSION["shoppingCart"][0] = $item_array;
}

echo "Book Now";