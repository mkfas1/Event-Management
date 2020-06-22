<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../model/Login.php";
@require_once "../model/Person.php";
@require_once "../controller/PersonController.php";

// for logout============================================================>
if (isset($_POST['logoutPerson'])) {
    session_destroy();
    @include_once "./errors/success.php";
    header('Location: ./register.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Vendor Panel</title>

    <link rel="shortcut icon" href="images/Favicon.ico">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/datepicker.css" rel="stylesheet" />
    <link href="css/loader.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="css/jquery.selectbox.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">

</head>


<body class="registerPage">
    <div class="page">
        <header id="headerRegister">
            <div class="container">
                <div class="logo"><a href="index.php"><img src="images/logo.png" alt="logo" style="max-width: 80px;"></a></div>
                <div class="register-pageLogin">
                    <div class="login-title">
                        <label>Vendor Login</label>
                    </div>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="login-box">
                            <div class="input-box">
                                <input type="text" placeholder="User Name" name="username">
                                <div class="icon icon-user"></div>
                            </div>
                            <div class="input-box">
                                <input type="password" placeholder="Password" name="password">
                                <div class="icon icon-lock"></div>
                            </div>
                            <div class="submit-box">
                                <input type="submit" class="btn" value="Login" name="vendorLogin">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </header>

        <?php
        $username = "";
        $name = "";
        $email = "";
        $phone = "";
        $password = "";
        $address = "";
        // for login=============================================================>
        if (isset($_POST['vendorLogin'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (strlen($username) == 0 || strlen($password) == 0) {
                @include_once "./errors/blankEntry.php";
            } else {
                $login = new Login($username,  $password);
                $result = loginPerson($login);

                if ($result->status == 2) {
                    if ($result !== null) {
                        if (password_verify($password, $result->password)) {
                            $_SESSION['username'] = $result->user_name;
                            $_SESSION['name'] = $result->name;
                            $_SESSION['email'] = $result->email;
                            $_SESSION['phone'] = $result->phone;
                            $_SESSION['password'] = $result->password;
                            $_SESSION['address'] = $result->address;
                            $_SESSION['status'] = $result->status;
                            header('Location: ./vendor/dashboard.php');
                        } else {
                            @include_once "../errors/invalidUser.php";
                        }
                    }
                    if ($result === null) {
                        @include_once "./errors/wrong.php";
                    } else {
                        @include_once "./errors/wrong.php";
                    }
                } else {
                    // header('Location: ' . $_SERVER['REQUEST_URI']);
                    @include_once "./errors/invalidUser.php";
                }
            }
        }

        if (isset($_POST['insertVendor'])) {
            $username = $_POST['username'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            if (strlen($username) == 0 || strlen($name) == 0 || strlen($email) == 0 || strlen($address) == 0 || strlen($phone) == 0 || strlen($password) == 0) {
                @include_once "./errors/blankEntry.php";
            } else {
                $person = new Person($username, $name, $email, $phone, $password, $address);
                $result = insertVendor($person);
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
        ?>
        <div class="register-banner">
            <img src="images/banner-img/registration-banneBg.png" alt="" class="register-bannerImg">
            <div class="inner-banner">
                <div class="text">Lorem Ipsum has been the when an unknown printer took a <span> galley of type</span></div>
                <div class="register-form">
                    <div class="inner-form">
                        <h1>Register Now</h1>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-filde">
                                <div class="input-slide">
                                    <input type="text" placeholder="User Name" name="username" min="6" max="255" required>
                                </div>
                                <div class="input-slide">
                                    <input type="text" placeholder="Name" name="name" min="6" max="255" required>
                                </div>
                                <div class="input-slide">
                                    <input type="email" placeholder="Email ID" name="email" min="6" max="255">
                                </div>
                                <div class="select-row">
                                    <select name="address" id="country_select" tabindex="1">
                                        <option value="">Address</option>
                                        <option value="Uttora">Uttora</option>
                                        <option value="Banani">Banani</option>
                                        <option value="Guslshan">Gulshan</option>
                                        <option value="Dhanmondi">Dhanmondi</option>
                                        <option value="Motijheel">Motijheel</option>
                                    </select>
                                </div>
                                <div class="input-slide">
                                    <input type="text" placeholder="Phone Number" name="phone" min="11" max="13" required>
                                </div>
                                <div class="input-slide">
                                    <input type="password" placeholder="Password" name="password" min="6" max="255" required>
                                </div>
                                <div class="submit-slide">
                                    <input type="submit" value="Submit" class="btn" name="insertVendor">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="register-content">
            <div class="benefits">
                <div class="container">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Benefits</h2>
                        </div>
                    </div>
                    <div class="benefits-view">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="box-view">
                                    <div class="iconBox icon1">
                                        <div class="icon icon-conversion-rates"></div>
                                    </div>
                                    <div class="text">Increase your conversion rates</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="box-view">
                                    <div class="iconBox icon2">
                                        <div class="icon icon-customer-base"></div>
                                    </div>
                                    <div class="text">Increase customer base</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="box-view">
                                    <div class="iconBox icon3">
                                        <div class="icon icon-negotiations"></div>
                                    </div>
                                    <div class="text">Low multiple negotiations</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="box-view">
                                    <div class="iconBox icon4">
                                        <div class="icon icon-wider-customer"></div>
                                    </div>
                                    <div class="text">Wider customer reach</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="choose-us">
                <div class="container">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Why Choose Us?</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-lead-management"></div>
                                </div>
                                <h3>Lead Management</h3>
                                <p>Increase occupancy, automate the lead management process, grow your customer relationships, match sales-ready leads to the appropriate sales people.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-sales"></div>
                                </div>
                                <h3>Sales</h3>
                                <p>Track sales opportunities, manage the sales process and generate proposals. Built-in process provides an aggregate view of account activity from the past, present and future.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-booking"></div>
                                </div>
                                <h3>Booking</h3>
                                <p>Manage calendars , share availability, easily view events color-coded by status, type or location. Book and manage multiple spaces, venues, and sites all from one master calendar.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="functionality-box">
                                <div class="iconBox">
                                    <div class="icon icon-operations"></div>
                                </div>
                                <h3>Operations</h3>
                                <p>Assign resources and review stock alerts. Create detailed reports, work orders, and generate invoices. Receive alerts on changes as they take place.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="work-info">
                <div class="container">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>How it works</h2>
                        </div>
                        <div class="info-text">Once you have registered, listing on Event Planning is just a four step process</div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                            <div class="box">
                                <div class="iconBox">
                                    <div class="inner-box">
                                        <div class="icon icon-step-1"></div>
                                    </div>
                                </div>
                                <div class="text"><span>1.</span> List your venues on Event Planning</div>
                            </div>
                            <div class="box">
                                <div class="iconBox">
                                    <div class="inner-box">
                                        <div class="icon icon-step-2"></div>
                                    </div>
                                </div>
                                <div class="text"><span>2.</span> Connect to customers</div>
                            </div>
                            <div class="box">
                                <div class="iconBox">
                                    <div class="inner-box">
                                        <div class="icon icon-step-4"></div>
                                    </div>
                                </div>
                                <div class="text"><span>3.</span> Increase your business</div>
                            </div>
                            <div class="box last">
                                <div class="iconBox">
                                    <div class="inner-box">
                                        <div class="icon icon-step-3"></div>
                                    </div>
                                </div>
                                <div class="text"><span>4.</span> You receive payment from Event Planning</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="price-info">
                <div class="container">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Pricing</h2>
                        </div>
                        <div class="info-text">Enjoy promotional rates for listing on Event Planning for a limited period only</div>
                    </div>
                    <div class="listing-view">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="list">No monthly subscription fee</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="list">Listing of venues absolutely free</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="list">Zero installation charges</div>
                            </div>
                        </div>
                    </div>
                    <div class="register-btn">
                        <a href="register.php#" class="btn">Register Now</a>
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