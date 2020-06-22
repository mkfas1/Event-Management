<?php
session_start();
$_SESSION['product_name'] = $_POST['productName'];
echo "Delete";
