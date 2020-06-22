<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../../model/Login.php";
@require_once "../../model/Person.php";
@require_once "../../controller/PersonController.php";
@include_once "../../model/SinglePackage.php";
@include_once "../../controller/packageController/packageController.php";
$username = "";
$name = "";
$email = "";
$phone = "";
$password = "";
$address = "";

// for logout============================================================>
if (isset($_POST['logoutPerson'])) {
    session_destroy();
    @include_once "../errors/success.php";
    header("Location: ../register.php");
}

// <======================================================fro single package update================================================>
if (isset($_POST["updateSinglePackage"])) {

    $packageName = $_POST['packageName'];
    $price = $_POST['price'];
    $transportCost = $_POST['transportCost'];
    $availableStatus = $_POST['availableStatus'];
    $description = $_POST['description'];
    $vendorName = $_SESSION['username'];

    if (strlen($vendorName) == 0) {
        @include_once "../errors/loginError.php";
    } else {
        if (strlen((string) $price) == 0 || strlen((string) $transportCost) == 0 || strlen($availableStatus) == 0 || strlen($description) == 0) {
            @include_once "../errors/blankEntry.php";
        } else {
            $update = updateSinglePackage($packageName, $vendorName, $price, $transportCost, $availableStatus, $description);
            if ($update == 1) {
                @include_once "../errors/productAddSuccess.php";
            } else {
                @include_once "../errors/wrong.php";
            }
        }
    }
}


// for Delete=========================================================
if (!isset($_SESSION["product_name"])) {
    $_SESSION["product_name"] = "";
}


if (isset($_POST["deletepackage"])) {

    $productName = $_SESSION["product_name"];
    deletePackage($productName, $_SESSION['username']);
}
if (isset($_POST["deletecancle"])) {
    unset($_SESSION["product_name"]);
    echo '<script>window.location="singlePackagePage.php"</script>';
}

//for check person=========================================================
if (!empty($_SESSION['username'])) {
    if ($_SESSION['status'] != 2) {
        session_destroy();
        header("Location: ../register.php");
    }
}
if($_SESSION['name']==""){
    header("Location: ../register.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Vendor Panel</title>

    <link rel="../shortcut icon" href="../images/Favicon.ico">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/datepicker.css" rel="stylesheet" />
    <link href="../css/loader.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="../css/jquery.selectbox.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        .column1 {
            float: left;
            width: 30%;
            padding: 5px;
            height: auto;
        }

        .column2 {
            float: left;
            width: 70%;
            padding: 5px;
            height: auto;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .customLabel {
            text-align: left;
            font-size: 16px;
            height: 35px;
            color: rgb(142, 139, 139);
            padding-top: 10px;
            font-family: "Normal";
            width: 100%
        }

        .deleteButton {
            line-height: 36px;
            padding: 0 25px;
            margin: 0 20px 0 0;
            font-size: 14px;
            font-weight: 600;
            border: solid 1px #787878;
            box-shadow: 0 1px 0px #aeaeae inset;
            background: #787878;
            display: inline-block;
            vertical-align: middle;
            border-radius: 4px;
            color: whitesmoke;
        }
    </style>
</head>

<body class="inner-page">
    <div class="page">
        <header id="header">
            <div class="quck-link">
                <div class="container">
                    <div class="mail"><a href="MailTo:eventorganizer@gmail.com"><span class="icon icon-envelope"></span>eventorganizer@gmail.com</a></div>
                    <div class="right-link">
                        <ul>
                            <li class="sub-links">
                                <a><span class="icon icon-envelope"></span>Hi </a>
                            </li>
                            <li class="sub-links">
                                <a href="javascript:;"> <?php echo $_SESSION['name'] ?><span class="icon icon-arrow-down"></span></a>
                                <ul class="sub-nav" style="right:-40px">
                                    <?php
                                    if ($_SESSION['name'] != "") {
                                        echo '<li>';
                                        echo '    <a href="javascript:;" data-toggle="modal" data-target="#logoutModal">Logout</a>';
                                        echo '</li>';
                                    }
                                    if ($_SESSION['name'] == "") {
                                        echo '<li>';
                                        echo '    <a href="../register.php">Login</a>';
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <nav id="nav-main">
                <div class="container">
                    <div class="navbar navbar-inverse">
                        <div class="navbar-header">
                            <a href="dashboard.php" class="navbar-brand"><img src="../images/logo.png" alt="" style="max-width: 80px"></a>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon1-barMenu"></span>
                                <span class="icon1-barMenu"></span>
                                <span class="icon1-barMenu"></span>
                            </button>

                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="single-col ">
                                    <a href="dashboard.php">Home </a>
                                </li>
                                <li class="single-col active">
                                    <a href="singlePackagePage.php">Single Package </a>
                                </li>
                                <li class="single-col ">
                                    <a href="bundlePackagePage.php">Bundle package </a>
                                </li>
                                <li class="single-col ">
                                    <a href="#">Add Packages <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li> <a href="singlePackageAddForm.php">Single Package </span></a> </li>
                                        <li> <a href="bundlePackageAddForm.php">Bundle Package </span></a> </li>
                                    </ul>
                                </li>
                                <li class="single-col ">
                                    <a href="vendor_account_profile.php">My Account </span></a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- logout -->
        <div class="modal modal-vcenter fade" id="logoutModal" role="dialog">
            <div class="modal-dialog login-popup" role="document">
                <div class="modal-content">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="../images/close-icon.png" alt=""></div>
                    <div class="left-img"><img src="../images/login-leftImg.png" alt=""></div>
                    <div class="right-info">
                        <h1>Are you sure ? </h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="input-form">
                                <div class="submit-slide">
                                    <input type="submit" class="btn" value="Yes" name="logoutPerson">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="searchFilter-main" style="padding: 0px 0 0 0;">
            <section class="content">
                <div class="container">
                    <div class="venues-view">
                        <div class="row">

                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="right-side" id="changeOrder">
                                    <?php

                                    $result = getSinglePackage();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $rating = $row["rating"] * 20;
                                            ?>
                                            <html>

                                            <head>

                                                <link href="../css/docs.css" rel="stylesheet">
                                            </head>

                                            <body>
                                                <div class="venues-slide first">
                                                    <div class="img">
                                                        <img src="<?php echo substr($row["image"], 3) ?>" style=max-height:260px>
                                                    </div>
                                                    <div class=" text">
                                                        <h3 class="product_name"><?php echo $row["package_name"] ?></h3>
                                                        <div class=reviews><?php echo  $row["rating"] . " " ?><div class=star>
                                                                <div class=fill style="width:<?php echo $rating ?>%"></div>
                                                            </div>reviews</div>
                                                        <div class=" outher-info">
                                                            <div class="info-slide first">
                                                                <label>Price</label>
                                                                <span><?php echo $row["price"] ?></span>
                                                            </div>
                                                            <div class="info-slide">
                                                                <label>Transport cost</label>
                                                                <span><?php echo  $row["transport_cost"] ?><small> (Owners)</small></span>
                                                            </div>
                                                            <div class="info-slide">
                                                                <label>Available</label>
                                                                <span><?php echo  $row["available_status"] ?><small> (status)</small></span>
                                                            </div>
                                                        </div>
                                                        <div class="outher-link">
                                                            <label>Description</label><br>
                                                            <span><?php echo  $row["description"] ?><small> (quantity)</small></span>
                                                        </div>
                                                        <div class="button">
                                                            <a href="javascript:;" class="btn gray">Update <span class="icon icon-arrow-down"></span></a>
                                                            <button type="button" data-toggle="modal" data-target="#delete" class="prodectbtn deleteButton gray btn_delete product_id" id="<?php echo $row["id"]; ?>" name="deletePackage">Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="amenities-view" style="padding-left:18px">
                                                        <h2>Update package : </h2>
                                                        <hr>
                                                        <div class="register-banner">
                                                            <div class="inner-banner">
                                                                <div class="register-form" style="padding: 0px 10% 0px 10%;">
                                                                    <div class="inner-form">
                                                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 100%;" enctype="multipart/form-data">
                                                                            <div class="form-filde" style="border-radius: 10px 10px 10px 10px;padding: 20px 45px 25px 25px;">
                                                                                <input type="hidden" name="packageName" value="<?php echo  $row["package_name"] ?>">
                                                                                <div class="input-slide" style="margin-left: 10px;">
                                                                                    <input type="number" placeholder="Price" name="price">
                                                                                </div>
                                                                                <div class="input-slide" style="margin-left: 10px;">
                                                                                    <input type="number" placeholder="Transport Cost" name="transportCost">
                                                                                </div>
                                                                                <div class="select-row" style="margin-left: 10px;">
                                                                                    <select name="availableStatus" class="customSelectBox">
                                                                                        <option value="">Choose availability</option>
                                                                                        <option value="yes">Yes</option>
                                                                                        <option value="no">No</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="input-slide" style="margin-left: 10px;">
                                                                                    <input type="text" placeholder="How many people ? in one line" name="description">
                                                                                </div>
                                                                                <div class="submit-slide">
                                                                                    <input type="submit" value="Submit" class="btn" name="updateSinglePackage" style="width: 100px;    margin-left: 10px; margin-top: 15px; ">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script type="text/javascript" src="../js/imageUpload.js"></script>
                                            </body>

                                            </html>
                                    <?php
                                        }
                                    } else {
                                        include_once "../errors/spinner.php";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            var addToCartButtons = document.getElementsByClassName('btn_delete');

            for (var i = 0; i < addToCartButtons.length; i++) {
                var buttonAdd = addToCartButtons[i];
                buttonAdd.addEventListener('click', addToCartClicked);
            }

            function addToCartClicked(event) {
                var button = event.target;
                var product = button.parentElement.parentElement;
                var name = product.getElementsByClassName('product_name')[0].innerText;
                console.log(name);
                document.getElementById("productName").innerHTML = name;
                $('#' + button.id).load('deleteSession.php', {
                    productName: name
                });

            }
        </script>

        <!-- delete -->
        <div class="modal modal-vcenter fade" id="delete" role="dialog">
            <div class="modal-dialog login-popup" role="document">
                <div class="modal-content">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="../images/close-icon.png" alt=""></div>
                    <div class="left-img"><img src="../images/login-leftImg.png" alt=""></div>
                    <div class="right-info">
                        <h1>Delete </h1>
                        <h3 id="productName"></h3>
                        <form method="POST" action="">
                            <div class="input-form">
                                <div class="submit-slide">

                                    <input type="submit" class="btn" value="Yes" name="deletepackage">
                                    <input type="submit" class="btn" value="no" name="deletecancle">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-sm6 col-md-4 ">
                            <div class="footer-link">
                                <h5>Company</h5>
                                <ul>
                                    <li><a href="../aboutUs.php">About Us</a></li>
                                    <li><a href="../privacy_policy.php">Privacy Policy</a></li>
                                    <li><a href="../career.php">Careers</a></li>
                                    <li><a href="../blog.php">Blogs</a></li>
                                    <li><a href="../contact.php">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-4">
                            <div class="footer-contact">
                                <h5>Contact us</h5>
                                <div class="contact-slide">
                                    <div class="icon icon-location-1"></div>
                                    <p>Khilkhet, Nikunjo-2, Dhaka, Bangladesh </p>
                                </div>
                                <div class="contact-slide">
                                    <div class="icon icon-phone"></div>
                                    <p>01948510951</p>
                                </div>

                                <div class="contact-slide">
                                    <div class="icon icon-message"></div>
                                    <a href="MailTo:eventorganizer@gmail.com">eventorganizer@gmail.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-8 col-md-4">
                            <div class="contact-form">
                                <h5>Connect with us</h5>
                                <p>Connect with us so that u can get update news and offer. </p>

                                <div class="sosal-midiya">
                                    <ul>
                                        <li><a href="#"><span class="icon icon-facebook"></span></a></li>
                                        <li><a href="#"><span class="icon icon-twitter"></span></a></li>
                                        <li><a href="#"><span class="icon icon-linkedin"></span></a></li>
                                        <li><a href="#"><span class="icon icon-skype"></span></a></li>
                                        <li><a href="#"><span class="icon icon-google-plus"></span></a></li>
                                        <li><a href="#"><span class="icon icon-play"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <p>Copyright &copy; <span></span> - EventOrganizer | All Rights Reserved</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="../js/jquery.selectbox-0.2.js"></script>
    <script type="text/javascript" src="../js/coustem.js"></script>
    <script type="text/javascript" src="../js/placeholder.js"></script>
</body>

</html>