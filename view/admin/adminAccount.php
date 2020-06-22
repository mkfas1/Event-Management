<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../../model/Login.php";
@require_once "../../model/Person.php";
@require_once "../../controller/PersonController.php";
$username = "";
$name = "";
$email = "";
$phone = "";
$password = "";
$address = "";



// for update password====================================================>
$currentPassword = "";
$newPassword = "";
$confNewPassword = "";
if (isset($_POST['updatePassword'])) {
    $username = $_SESSION['username'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confNewPassword = $_POST['confNewPassword'];
    if (strlen($currentPassword) == 0 || strlen($newPassword) == 0 || strlen($confNewPassword) == 0) {
        @include_once "./errors/blankEntry.php";
    } else {
        if ($newPassword != $confNewPassword) {
            @include_once "./errors/password.php";
        } else if(password_verify($currentPassword,$_SESSION['password'])) {
            $result = updatePassword($username, $newPassword);
            if ($result == 1) {
                @include_once "../errors/success.php";
            }
            if ($result == 0) {
                @include_once "../errors/wrong.php";
            }
        }
    }
}

// for logout============================================================>
if (isset($_POST['logoutPerson'])) {
    session_destroy();
    @include_once "../errors/success.php";
    header('Location: home.php');
}
//for check person=========================================================
if(!empty($_SESSION['username'])){
    if($_SESSION['status']!=0){
        session_destroy();
        header("Location: ./home.php");
    }
}
if($_SESSION['name']==""){
    header("Location: ./home.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Admin Panel</title>

    <link rel="../shortcut icon" href="../images/Favicon.ico">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/datepicker.css" rel="stylesheet" />
    <link href="../css/loader.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="../css/jquery.selectbox.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">

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
                                <a href="javascript:;"><?php echo $_SESSION['name'] ?><span class="icon icon-arrow-down"></span></a>
                                <ul class="sub-nav" style="right:-40px">
                                    <?php
                                    if ($_SESSION['name'] != "") {
                                        echo '<li>';
                                        echo '    <a href="javascript:;" data-toggle="modal" data-target="#logoutModal">Logout</a>';
                                        echo '</li>';
                                    }
                                    if ($_SESSION['name'] == "") {
                                        echo '<li>';
                                        echo '    <a href="../index.php">Login</a>';
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
                                    <a href="dashboard.php">Dashboard </a>
                                </li>
                                <li class="single-col ">
                                    <a href="vendor.php">Vendor </a>
                                </li>
                                <li class="single-col ">
                                    <a href="customer.php">Customer </a>
                                </li>
                                <li class="single-col">
                                    <a href="">Action <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li>
                                            <a href="pendingBook.php">Pending Book </a>
                                        </li>
                                        <li>
                                            <a href="orderHistory.php">Order History </a>
                                        </li>
                                        <li>
                                            <a href="singlePackageStatus.php">Single Package Status </a>
                                        </li>
                                        <li>
                                            <a href="bundlePackageStatus.php">Bundle Package Status </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="single-col active">
                                    <a href="adminAccount.php">My Account </span></a>
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

        <!-- update profile -->
        <div class="modal modal-vcenter fade" id="updateProfileModal" tabindex="-1" role="dialog">
            <div class="modal-dialog registration-popup" role="document">
                <div class="modal-content" style="margin-top: 99px;">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="../images/close-icon.png" alt=""></div>
                    <h1>Update Your Profile</h1>
                    <div class="registration-form">
                        <div class="info">
                            <h2>Why to update</h2>
                            <ul>
                                <li>Exclusive discounts for all bookings</li>
                                <li>Full access all discounted prices</li>
                                <li>Dedicated wed-ordination for your event</li>
                                <li>Custom event planner for your event</li>
                            </ul>
                        </div>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-filde">
                                <div class="input-box">
                                    <input type="text" placeholder="Name" name="name" required>
                                </div>
                                <div class="input-box">
                                    <input type="email" placeholder="Email ID" name="email">
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="Phone" name="phone" required>
                                </div>
                                <div class=" select-row">
                                    <select name="address" id="country_select" tabindex="1">
                                        <option value="">Address</option>
                                        <option value="Uttora">Uttora</option>
                                        <option value="Banani">Banani</option>
                                        <option value="Guslshan">Gulshan</option>
                                        <option value="Dhanmondi">Dhanmondi</option>
                                        <option value="Motijheel">Motijheel</option>
                                    </select>
                                </div>
                                <div class="submit-slide">
                                    <input type="submit" class="btn" name="updatePerson">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="dashboard-banner">
            <div class="container">
                <h2>My Dashboard</h2>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="my-account">
                    <div class="account-tab">
                        <ul>
                            <li class="active"><a href="javascript:void(0);" id="profile">Profile</a></li>
                            <li><a href="javascript:void(0);" id="changePassword">Change Password</a></li>
                        </ul>
                    </div>
                    <div class="tab-content profile-con open">
                        <div class="personal-edit">
                            <a href="javascript:;" data-toggle="modal" data-target="#updateProfileModal"> <span class="icon icon-pencile"></span>Edit Profile</a>
                        </div>
                        <div class="personal-information">
                            <div class="info-slide">
                                <p><span>Name :</span><?php echo $_SESSION['name'] ?></p>
                            </div>
                            <div class="info-slide">
                                <p><span>Email ID :</span><?php echo $_SESSION['email'] ?></p>
                            </div>
                            <div class="info-slide">
                                <p><span>Mobile Number :</span><?php echo $_SESSION['phone'] ?></p>
                            </div>
                            <div class="info-slide">
                                <p><span>Address :</span><?php echo $_SESSION['address'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- change password -->
                    <div class="tab-content changePassword-con">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="change-password ">
                                <div class="input-box">
                                    <input type="text" placeholder="Current Password" name="currentPassword" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="New Password" name="newPassword" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="Confirm Password" name="confNewPassword" required>
                                </div>
                                <div class="submit-box">
                                    <input type="submit" value="Save" class="btn" name="updatePassword">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="functionality-view">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-lead-management"></div>
                                </div>
                                <h3>Lead Management</h3>
                                <p>Increase occupancy, automate the lead management process, grow your customer
                                    relationships, match sales-ready leads to the appropriate sales people.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-sales"></div>
                                </div>
                                <h3>Sales</h3>
                                <p>Track sales opportunities, manage the sales process and generate proposals. Built-in
                                    process provides an aggregate view of account activity from the past, present and
                                    future.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-booking"></div>
                                </div>
                                <h3>Booking</h3>
                                <p>Manage calendars , share availability, easily view events color-coded by status, type
                                    or location. Book and manage multiple spaces, venues, and sites all from one master
                                    calendar.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-operations"></div>
                                </div>
                                <h3>Operations</h3>
                                <p>Assign resources and review stock alerts. Create detailed reports, work orders, and
                                    generate invoices. Receive alerts on changes as they take place.</p>
                            </div>
                        </div>
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