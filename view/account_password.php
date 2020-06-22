<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../model/Login.php";
@require_once "../model/Person.php";
@require_once "../controller/PersonController.php";
@include_once "../controller/bookingController.php";
$username = "";
$name = "";
$email = "";
$phone = "";
$password = "";
$address = "";


// for login=============================================================>
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (strlen($username) == 0 || strlen($password) == 0) {
        @include_once "./errors/blankEntry.php";
    } else {
        $login = new Login($username, $password);
        $result = loginPerson($login);
        if ($result->status == 1) {
            if ($result != null) {
                if (password_verify($password, $result->password)) {
                    $_SESSION['username'] = $result->user_name;
                    $_SESSION['name'] = $result->name;
                    $_SESSION['email'] = $result->email;
                    $_SESSION['phone'] = $result->phone;
                    $_SESSION['password'] = $result->password;
                    $_SESSION['address'] = $result->address;
                    $_SESSION['status'] = $result->status;
                    @include_once "./errors/success.php";
                } else {
                    @include_once "../errors/invalidUser.php";
                }
            }

            if ($result === null) {
                @include_once "./errors/wrong.php";
            }
        } else {
            @include_once "./errors/invalidUser.php";
        }
    }
}


// for register==========================================================>
if (isset($_POST['insertPerson'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    if (strlen($username) == 0 || strlen($name) == 0 || strlen($email) == 0 || strlen($address) == 0 || strlen($phone) == 0 || strlen($password) == 0) {
        @include_once "./errors/blankEntry.php";
    } else {
        $person = new Person($username, $name, $email, $phone, $password, $address);
        $result = insertPerson($person);

        if ($result == 1) {
            @include_once "./errors/success.php";
        }
        if ($result == -1) {
            @include_once "./errors/exist.php";
        }
        if ($result == 0) {
            @include_once "./errors/wrong.php";
        }
    }
}


// for logout============================================================>
if (isset($_POST['logoutPerson'])) {
    session_destroy();
    @include_once "./errors/success.php";
    header('Location: ./account_password.php');
}

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
        } else if (password_verify($currentPassword, $_SESSION['password'])) {
            $result = updatePassword($username, $newPassword);
            if ($result == 1) {
                @include_once "./errors/success.php";
            }
            if ($result == 0) {
                @include_once "./errors/wrong.php";
            }
        }
    }
}

//for check person=========================================================
if (!empty($_SESSION['username'])) {
    if ($_SESSION['status'] != 1) {
        session_destroy();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Event Organizer</title>

    <link rel="shortcut icon" href="images/Favicon.ico">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/datepicker.css" rel="stylesheet" />
    <link href="css/loader.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="css/jquery.selectbox.css" rel="stylesheet" /><!-- select Box css -->
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">
    <link href="css/ratingModal.css" rel="stylesheet">
</head>

<body class="inner-page">
    <div class="page">
        <header id="header">
            <div class="quck-link">
                <div class="container">
                    <div class="mail"><a href="MailTo:eventorganizer@gmail.com"><span class="icon icon-envelope"></span>eventorganizer@gmail.com</a></div>
                    <div class="right-link">
                        <ul>
                            <li><a href="register.php"><span class="icon icon-multi-user"></span>Become a Vendor</a>
                            </li>
                            <li class="sub-links">
                                <a href="javascript:;"><?php echo $_SESSION['name'] ?><span class="icon icon-arrow-down"></span></a>
                                <ul class="sub-nav" style="right:-40px">
                                    <li><a href="account_profile.php">Profile</a></li>
                                    <li><a href="account_booking.php">Booking</a></li>
                                    <?php
                                    if ($_SESSION['name'] == "") {
                                        echo '<li>';
                                        echo '    <a href="javascript:;" data-toggle="modal" data-target="#loginModal">Login</a>';
                                        echo '</li>';
                                    } else {
                                        echo '<li>';
                                        echo '    <a href="javascript:;" data-toggle="modal" data-target="#logoutModal">Logout</a>';
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
                            <a href="index.php" class="navbar-brand"><img src="images/logo.png" alt="" style="max-width: 80px"></a>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon1-barMenu"></span>
                                <span class="icon1-barMenu"></span>
                                <span class="icon1-barMenu"></span>
                            </button>

                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="single-col ">
                                    <a href="index.php">Home </a>
                                </li>
                                <li class="single-col ">
                                    <a href="#">Services <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li>
                                            <a href="#">Single Package <span class="icon icon-arrow-right"></span></a>
                                            <ul>
                                                <li><a href="services/caterers/caterers.php">Caterers</a></li>
                                                <li><a href="services/decoration/decoration.php">Decoration</a></li>
                                                <li><a href="services/makeup/makeup.php">Make-up</a></li>
                                                <li><a href="services/cake/cake.php">Cake</a></li>
                                                <li><a href="services/dj/dj.php">Dj</a></li>
                                                <li><a href="#">Wedding Card</a></li>
                                                <li><a href="#">Mehandi</a></li>
                                                <li><a href="#">Entertainment</a></li>
                                                <li><a href="#">Photographer</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Bundle Package <span class="icon icon-arrow-right"></span></a>
                                            <ul>
                                                <li><a href="services/weeding/weeding.php">Weeding</a></li>
                                                <li><a href="services/birthday/birthday.php">Birthday</a></li>
                                                <li><a href="services/corporate/corporate.php">Corporate</a></li>
                                                <li><a href="services/exhibition/exhibition.php">Exhibition</a></li>
                                                <li><a href="services/conference/conference.php">Conference</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="single-col active">
                                    <a href="">Pages <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li><a href="career.php">Career</a></li>

                                        <li><a href="privacy_policy.php">Privacy Policy</a></li>
                                        <li>
                                            <a href="account_profile.php">My Account <span class="icon icon-arrow-right"></span></a>
                                            <ul>
                                                <li><a href="account_profile.php">Profile</a></li>
                                                <li><a href="account_booking.php">Orders</a></li>
                                                <li><a href="account_password.php">Change Password</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="team.php">Team</a></li>
                                    </ul>
                                </li>
                                <li class="single-col">
                                    <a href="">Booking <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li><a href="booking_step1.php">Booking Step1</a></li>
                                    </ul>
                                </li>
                                <li><a href="aboutUs.php">About Us</a></li>
                                <li><a href="contact.php">Contact us</a></li>
                            </ul>
                            <div class="search-box">
                                <div class="search-icon"><span class="icon icon-search"></span></div>
                                <div class="search-view">
                                    <div class="input-box">
                                        <form>
                                            <input type="text" placeholder="Search here">
                                            <input type="submit" value="">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- login -->
        <div class="modal modal-vcenter fade" id="loginModal" role="dialog">
            <div class="modal-dialog login-popup" role="document">
                <div class="modal-content">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="images/close-icon.png" alt=""></div>
                    <div class="left-img"><img src="images/login-leftImg.png" alt=""></div>
                    <div class="right-info">
                        <h1>Login</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="input-form">
                                <div class="input-box">
                                    <div class="icon icon-user"></div>
                                    <input type="text" placeholder="Username" name="username" required>
                                </div>
                                <div class="input-box">
                                    <div class="icon icon-lock"></div>
                                    <input type="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="submit-slide">
                                    <input type="submit" class="btn" name="login">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- logout -->
        <div class="modal modal-vcenter fade" id="logoutModal" role="dialog">
            <div class="modal-dialog login-popup" role="document">
                <div class="modal-content">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="images/close-icon.png" alt=""></div>
                    <div class="left-img"><img src="images/login-leftImg.png" alt=""></div>
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
        <!-- registration -->
        <div class="modal modal-vcenter fade" id="registrationModal" tabindex="-1" role="dialog">
            <div class="modal-dialog registration-popup" role="document">
                <div class="modal-content" style="margin-top: 99px;">
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="images/close-icon.png" alt=""></div>
                    <h1>New Member Registration</h1>
                    <div class="registration-form">
                        <div class="info">
                            <h2>Why to sign up</h2>
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
                                    <input type="text" placeholder="Username" name="username" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="Name" name="name" required>
                                </div>
                                <div class="input-box">
                                    <input type="email" placeholder="Email ID" name="email">
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="Phone" name="phone" required>
                                </div>
                                <div class="input-box">
                                    <input type="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="input-box">
                                    <input type="text" placeholder="Address" name="address">
                                </div>
                                <div class="submit-slide">
                                    <input type="submit" class="btn" name="insertPerson">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- rating modal -->
        <div id="ratingModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Rating our Package</h4>
                    </div>
                    <div class="modal-body position">
                        <p>Leave your rating.</p>
                        <form action="" method="POST">
                            <div class="rating ">
                                <input name="productRating" value="5" id="e5" type="radio" <?php if ((isset($_POST['productRating'])) && ($_POST['productRating'] == "5")) ?>><label for="e5">★</label>
                                <input name="productRating" value="4" id="e4" type="radio" <?php if ((isset($_POST['productRating'])) && ($_POST['productRating'] == "4")) ?>><label for="e4">★</label>
                                <input name="productRating" value="3" id="e3" type="radio" <?php if ((isset($_POST['productRating'])) && ($_POST['productRating'] == "3")) ?>><label for="e3">★</label>
                                <input name="productRating" value="2" id="e2" type="radio" <?php if ((isset($_POST['productRating'])) && ($_POST['productRating'] == "2")) ?>><label for="e2">★</label>
                                <input name="productRating" value="1" id="e1" type="radio" <?php if ((isset($_POST['productRating'])) && ($_POST['productRating'] == "1")) ?>><label for="e1">★</label>
                            </div>
                            <div>
                                <input type="submit" class="btn" name="insertRating" style="width: 100px;">
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
                    <div class="close-icon" aria-label="Close" data-dismiss="modal"><img src="images/close-icon.png" alt=""></div>
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
                                <div class="input-box">
                                    <input type="text" placeholder="Address" name="address">
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
                            <li><a href="javascript:void(0);" id="profile">Profile</a></li>
                            <li><a href="javascript:void(0);" id="order">Order</a></li>
                            <li class="active"><a href="javascript:void(0);" id="changePassword">Change Password</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content profile-con">
                        <div class="personal-edit">
                            <a href="account_password.php#"><span class="icon icon-pencile"></span>Edit Profile</a>
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
                    <div>
                        <?php
                        $result = getIndividualBooking($_SESSION['username']);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="tab-content order-con ">
                                    <table class="booking-viewTable">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th class="detail">Booking Details</th>
                                            <th>Booking Date</th>
                                            <th>Event Date</th>
                                            <th>Paid Amount</th>
                                            <th>Need to Pay</th>
                                        </tr>
                                        <tr>
                                            <td><span class="small-heading">Transaction ID</span> <?php echo $row['transaction'] ?></td>
                                            <td class="detail">
                                                <span class="small-heading">Booking Details</span>
                                                <div class="detailTd">
                                                    <label><?php echo $row['packagename'] ?></label>
                                                    <p>Addess: <?php echo $row['address'] ?></p>
                                                    <a href="account_profile.php#">Phone : <?php echo $row['phone'] ?></a>
                                                </div>
                                            </td>
                                            <td><span class="small-heading">Booking Date</span><?php echo $row['pendingdate'] ?></td>
                                            <td><span class="small-heading">Event Date</span><?php echo $row['bookingdate'] ?></td>
                                            <?php
                                            if ($row['fullpaid'] == 'yes') {
                                            ?>
                                                <td><span class="small-heading">Paid Amount</span>$ <?php echo $row['totalcost'] ?></td>
                                                <td><span class="small-heading">Need to Pay</span>$ 0</td>
                                            <?php
                                            } else if ($row['halfpaid'] == 'yes') {
                                            ?>
                                                <td><span class="small-heading">Paid Amount</span>$ <?php echo $row['totalcost'] / 2 ?></td>
                                                <td><span class="small-heading">Need to Pay</span>$ <?php echo $row['totalcost'] / 2 ?></td>
                                            <?php
                                            } else if ($row['halfpaid'] == 'no' && $row['fullpaid'] == 'no') {
                                            ?>
                                                <td><span class="small-heading">Paid Amount</span>$ 0</td>
                                                <td><span class="small-heading">Need to Pay</span>$ <?php echo $row['totalcost'] ?></td>
                                            <?php
                                            }

                                            ?>
                                        </tr>
                                    </table>
                                    <div class="booking-status">
                                        <?php
                                        if ($row['fullpaid'] == 'yes') {
                                            if (date("d:m:Y") >= $row['bookingdate']) {
                                        ?>
                                                <button type="button" data-toggle="modal" data-target="#ratingModal" class="cancel btn_rating packageName" id="<?php echo $row['id']; ?>" name="deletePackage" style="border: #f5f5f503; background: #f5f5f503;">
                                                    Rate this Package
                                                </button>
                                                <div class="status">Status :<span> Booked</span></div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($row['half'] == 'yes') {
                                            if (date("d:m:Y") >= $row['bookingdate']) {
                                        ?>
                                                <a href="contact.php" class="cancel">Cancel your Booking</a>
                                                <div class="status">Status :<span> Booked</span></div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($row['halfpaid'] == 'no' && $row['fullpaid'] == 'no') {
                                        ?>
                                            <a href="contact.php" class="cancel">Cancel your Booking</a>
                                            <div class="status">Status :<span> Booked</span></div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <!-- change password -->
                    <div class="tab-content changePassword-con open">
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
                                <p>Increase occupancy, automate the lead management process, grow relationship with
                                    customer.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-sales"></div>
                                </div>
                                <h3>Sales</h3>
                                <p>Built-in process provides an aggregate view of account activity from the past,
                                    present and future.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-booking"></div>
                                </div>
                                <h3>Booking</h3>
                                <p>Manage calendars , share availability, easily view events, type or location.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-operations"></div>
                                </div>
                                <h3>Operations</h3>
                                <p>Create detailed reports, work orders and generate invoices.</p>
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
                                    <li><a href="aboutUs.php">About Us</a></li>
                                    <li><a href="privacy_policy.php">Privacy Policy</a></li>
                                    <li><a href="career.php">Careers</a></li>
                                    <li><a href="blog.php">Blogs</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
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
    <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/jquery.selectbox-0.2.js"></script>
    <script type="text/javascript" src="js/coustem.js"></script>
    <script type="text/javascript" src="js/placeholder.js"></script>
</body>

</html>