<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../model/Login.php";
@require_once "../model/Person.php";
@require_once "../model/Booking.php";
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
    } else  {
        $login = new Login($username,$password);
        $result = loginPerson($login);
        if ($result->status == 1 ) {
            if ($result != null) {
                if(password_verify($password, $result->password)){
                    $_SESSION['username'] = $result->user_name;
                    $_SESSION['name'] = $result->name;
                    $_SESSION['email'] = $result->email;
                    $_SESSION['phone'] = $result->phone;
                    $_SESSION['password'] = $result->password;
                    $_SESSION['address'] = $result->address;
                    $_SESSION['status'] = $result->status;
                    @include_once "./errors/success.php";
                }
                else {
                    @include_once "../errors/invalidUser.php";
                }
            }

            if ($result === null) {
                @include_once "./errors/wrong.php";
            }
        }
        else{
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
}
// for Table row==========================================================
$count = 0;
if (isset($_POST["bookPackage"])) {
    if (isset($_SESSION["shoppingCart"])) {
        $item_array_id = array_column($_SESSION["shoppingCart"], "itemId");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = $count + 1;
            $_SESSION["shoppingCart"][$count];
        }
    } else {
        $_SESSION["shoppingCart"][$count];
    }
}
//  for remove
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shoppingCart"] as $keys => $values) {
            if ($values["itemId"] == $_GET["id"]) {
                unset($_SESSION["shoppingCart"][$keys]);
                echo '<script>window.location="booking_step1.php"</script>';
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

// for booking============================================
if (isset($_POST["bookingbtn"])) {
    $transaction = strtoupper(uniqid());
    $_SESSION["transaction"] =  $transaction;
    $_SESSION["bookingDate"] = $_POST['bookingDate'];
    foreach ($_SESSION["shoppingCart"] as $keys => $values) {
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        $address = $_SESSION['address'];
        $bookingDate = $_POST['bookingDate'];
        $vendorName = $values["itemVendor"];
        $packageName = $values["itemName"];
        $totalCost = $values["itemPrice"] + $values["itemTransportCost"];
        $halfPaid = "no";
        $fullPaid = "no";
        if (strlen($bookingDate) == 0) {
            @include_once "./errors/blankEntry.php";
        } else {
            $booking = new Booking($username, $transaction, $email, $phone, $address, $bookingDate, $vendorName, $packageName, $totalCost, $halfPaid, $fullPaid);
            $result = insertBookingDetails($booking);

            if ($result == 1) {
                updateBookingForSingle($vendorName, $packageName);
                updateBookingForBundle($vendorName, $packageName);
                header("Location: ./booking_step2.php");
            }
            if ($result == -1) {
                @include_once "./errors/exist.php";
            }
            if ($result == 0) {
                @include_once "./errors/wrong.php";
            }
        }
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
                            <li><a href="register.php"><span class="icon icon-multi-user"></span>Become a Vendor</a>
                            </li>
                            <?php
                            if ($_SESSION['name'] == "") {
                                echo '<li>';
                                echo '    <a href="javascript:;" data-toggle="modal" data-target="#registrationModal">Registration</a>';
                                echo '</li>';
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
                                <li class="single-col">
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
                                <li class="single-col active">
                                    <a href="">Booking <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li><a href="booking_step1.php">Booking Step1</a></li>
                                        <li><a href="booking_step2.php">Booking Step2</a></li>
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
                                    <input type="submit" class="btn" name="logoutPerson">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                        <form method="POST" action="">
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
        <div class="step-nav">
            <div class="container">
                <div class="inner-nav">
                    <ul>
                        <li class="first active"><a href="booking_step1.php#"><span class="number">1</span><span class="text">Cart Summary</span></a></li>
                        <li class="last"><a href="booking_step1.php#"><span class="number">2</span><span class="text">Order Confirm</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="bookin-info">
                    <form action="" method="post">
                        <table class="bookin-table">
                            <tr>
                                <td class="first Theading" style="width:200px"> Your Address</td>
                                <td class="Theading">Package Name</td>
                                <td class="Theading">Vendor Name</td>
                                <td class="Theading">Price</td>
                                <td class="Theading">Transport Cost</td>
                                <td class="Theading ">Total Cost</td>
                                <td class="Theading ">Action</td>
                            </tr>
                            <?php
                            if (!empty($_SESSION["shoppingCart"])) {
                                $total = 0;
                                foreach ($_SESSION["shoppingCart"] as $keys => $values) {
                                    ?>
                                    <tr>
                                        <td class="first" style="width:200px">
                                            <label>Address</label>
                                            <p><?php echo " " . $_SESSION['address'] ?></p>
                                        </td>
                                        <td>
                                            <label>Package Name</label>
                                            <p><?php echo " " . $values["itemName"]; ?></p>
                                        </td>
                                        <td>
                                            <label>Vendor Name</label>
                                            <p><?php echo " " . $values["itemVendor"]; ?></p>
                                        </td>
                                        <td>
                                            <label>Price</label>
                                            <p>$ <?php echo " " . $values["itemPrice"]; ?></p>
                                        </td>
                                        <td>
                                            <label>Transport Cost</label>
                                            <p>$<?php echo " " . $values["itemTransportCost"]; ?></p>
                                        </td>
                                        <td>
                                            <label>Total Cost</label>
                                            <p>$ <?php echo $x = number_format($values["itemPrice"] + $values["itemTransportCost"], 2); ?></p>
                                        </td>
                                        <td class="Theading">
                                            <a href="booking_step1.php?action=delete&id=<?php echo $values["itemId"]; ?>">
                                                <span class="text-danger"><img src="images/close-icon.png" alt="" style="max-width: 80px"></span>
                                            </a>
                                        </td>

                                    </tr>
                                <?php
                                        $total = $total + $values["itemPrice"] + $values["itemTransportCost"];
                                    }
                                    ?>


                            <?php
                            }
                            ?>
                        </table>
                        <?php
                        if (!empty($_SESSION["shoppingCart"])) {
                            echo '<table class="bookinTotal">';
                            echo '<tr>';
                            echo '<td class="subTotal">Subtotal</td>';
                            echo "<td class=amount subTotal style=padding-right: 9%;> $" .  $total . "</td>";
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td>Min. Booking Amount to pay</td>';
                            echo "<td class=amount style=padding-right: 9%;>$  " . $total / 2 . "</td>";
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo "";
                        }
                        ?>

                        <?php
                        if (!empty($_SESSION["shoppingCart"])) {
                            echo '<div class="check-slide">';
                            echo '<a href="privacy_policy.php" style="color: #f15b22;">Terms & Conditions</a>';
                            echo '</div>';
                        }
                        ?>
                        <div class="bookinRow">
                            <div class="input-box">
                                <label>Your Name : </label><?php if (!empty($_SESSION["name"])) echo " " . $_SESSION['name'] ?>
                            </div>
                            <div class="input-box">
                                <label>Email ID : </label><?php if (!empty($_SESSION["name"])) echo " " . $_SESSION['email'] ?>
                            </div>
                            <div class="input-box">
                                <label>Phone : </label><?php if (!empty($_SESSION["name"])) echo " " . $_SESSION['phone'] ?>
                            </div>
                            <div class="input-box">
                                <label>Booking Date : </label> <input type="date" name="bookingDate">
                            </div>
                            <?php
                            if (!empty($_SESSION["shoppingCart"]) && !empty($_SESSION["name"])) {
                                ?>
                                <input type="submit" name="bookingbtn" class="btn" value="Book Now">
                            <?php
                            } else if (empty($_SESSION["name"])) {
                                echo '    <a href="javascript:;" data-toggle="modal" data-target="#registrationModal" style="font-weight: bold;">Registration</a>';
                                echo " or ";
                                echo '    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" style="font-weight: bold;">Login</a>';
                                echo " first ";
                            }
                            ?>
                        </div>
                    </form>
                    <div class="note">
                        <div class="inner-block">
                            <div class="icon icon-info"></div>
                            <label>Important Information</label>
                            <p>Please carry booking ID proof at the venue</p>
                        </div>
                    </div>
                    <div class="bottom-blcok">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="icon icon-assurance"></div>
                                <span>100% Assurance</span>
                                <p>Assurance of ultimate service quality</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="icon icon-trust"></div>
                                <span>Trust</span>
                                <p>Every business depend on trust.We are happy to be bound within your trust</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="icon icon-promise"></div>
                                <span>Our Promise</span>
                                <p>Excellent services to each client.</p>
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
    <script type="text/javascript" src="js/owl.carousel.js"></script>
    <script type="text/javascript" src="js/jquery.selectbox-0.2.js"></script>
    <script type="text/javascript" src="js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/placeholder.js"></script>
    <script type="text/javascript" src="js/coustem.js"></script>

</body>

</html>