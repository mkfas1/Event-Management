<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@require_once "../model/Login.php";
@require_once "../model/Person.php";
@require_once "../controller/PersonController.php";
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
    header('Location: ./carrer.php');
}

//for check person=========================================================
if(!empty($_SESSION['username'])){
    if($_SESSION['status']!=1){
        session_destroy();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Event Planning</title>

    <link rel="shortcut icon" href="images/Favicon.ico">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/datepicker.css" rel="stylesheet" />
    <link href="css/loader.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">

</head>

<body>
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
        <div class="carrer-banner">
            <img src="images/photos/stair.jpg" alt="">
            <div class="text">
                <h1>Make Your Passion Your <span>PayCheck </span></h1>
            </div>
        </div>
        <section class="carrerInfo-text">
            <div class="container">
                <div class="heading">
                    <div class="icon"><em class="icon icon-heading-icon"></em></div>
                    <div class="text">
                        <h2>Lorem Ipsum is dummy</h2>
                    </div>
                    <div class="info-text">All the information you will need is listed below, just click on the page you
                        want to view and that's it.</div>
                    <div class="stickLine"></div>
                </div>
            </div>
        </section>
        <section class="carrer-view">
            <div class="container">
                <div class="carrer-boxMain">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="carrer-box">
                                <a data-target="#why_work" data-toggle="modal" href="javascript:;">
                                <img src="images/career-img/one.png" alt="xxxxxxxxxxxxx">
                                    <div class="caption">Why Work With Us</div>
                                </a>
                            </div>
                        </div>
                        <div class="modal modal-vcenter fade" id="why_work" tabindex="-1" role="dialog">
                            <div class="modal-dialog jopFullview-popup" role="document">
                                <div class="modal-content text-left">
                                    <div data-dismiss="modal" aria-label="Close" class="close-icon"><img alt="" src="images/close-icon.png"></div>
                                    <h1>Why Work With Us</h1>
                                    <p>Every mind of beauty envisions a future crafted by dream. Unfortunately, most
                                        dreams are forgotten while employees work towards fulfilling their employer’s
                                        goals. But not at eventplanning.com. </p>
                                    <p><strong>Once a team member always a team member:</strong><br>Complete your tenure
                                        of two years as a team member, and feel free to discover new horizons, while
                                        taking on new ventures, and following your own dreams. Once complete, you gain
                                        the lifetime opportunity to re-join eventplanning.com in the future. And no
                                        interview required.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="carrer-box">
                                <a data-target="#meet_team" data-toggle="modal" href="javascript:;">
                                <img src="images/career-img/two.jpg" alt="xxxxxxxxxxxxx">
                                    <div class="caption">Meet The Team</div>
                                </a>
                            </div>
                        </div>
                        <div class="modal modal-vcenter fade" id="meet_team" tabindex="-1" role="dialog">
                            <div class="modal-dialog jopFullview-popup" role="document">
                                <div class="modal-content text-left">
                                    <div data-dismiss="modal" aria-label="Close" class="close-icon"><img alt="" src="images/close-icon.png"></div>
                                    <h1>Meet The Team</h1>
                                    <p>lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="carrer-box">
                                <a data-target="#life_event" data-toggle="modal" href="javascript:;">
                                    <img src="images/career-img/three.jpg" alt="xxxxxxxxxxxxx">
                                    <div class="caption">Life at Event Planning</div>
                                </a>
                            </div>
                        </div>
                        <div class="modal modal-vcenter fade" id="life_event" tabindex="-1" role="dialog">
                            <div class="modal-dialog jopFullview-popup" role="document">
                                <div class="modal-content text-left">
                                    <div data-dismiss="modal" aria-label="Close" class="close-icon"><img alt="" src="images/close-icon.png"></div>
                                    <h1>Life at Event Planning</h1>
                                    <p>At eventplanning.com, we don’t hire employees. Instead, we look for team members
                                        who will join us on our journey to achieve greater heights, while widening
                                        horizons. </p>

                                    <p>Why work hard when you can work smart. More that quantity, eventplanning.com
                                        believes in quality that can only be achieved when you enjoy what you do. You
                                        can enjoy what you do by simply making work fun.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="carrer-box">
                                <a data-target="#employee_testimonials" data-toggle="modal" href="javascript:;">
                                    <img src="images/career-img/four.jpg" alt="xxxxxxxxxxxxx">
                                    <div class="caption">Employee Testimonials</div>
                                </a>
                            </div>
                        </div>
                        <div class="modal modal-vcenter fade" id="employee_testimonials" tabindex="-1" role="dialog">
                            <div class="modal-dialog jopFullview-popup" role="document">
                                <div class="modal-content text-left">
                                    <div data-dismiss="modal" aria-label="Close" class="close-icon"><img alt="" src="images/close-icon.png"></div>
                                    <h1>Employee Testimonials</h1>
                                    <p>lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="current-openning">
            <div class="container">
                <div class="heading">
                    <div class="icon"><em class="icon icon-heading-icon"></em></div>
                    <div class="text">
                        <h2>Current Openings</h2>
                    </div>
                    <div class="info-text">All the information you will need is listed below, just click on the page you
                        want to view and that's it.</div>
                </div>
                <div class="openings-info">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="openings-title">Openings</div>
                            <div class="job-view">
                                <div class="job-viewBox">
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Regional Manager- Data Support</p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Assistant Manager - Research & Analytics
                                            Experience </p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Analytics</p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Regional Manager- Data Support</p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Assistant Manager - Research & Analytics
                                            Experience </p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                    <div class="openings-slide">
                                        <p><label>Job Title : </label> Analytics</p>
                                        <p class="jobLocation"><label>Location:</label> Bangalore</p>
                                        <p class="jobExperience"><label>Experience:</label> 8-14 years</p>
                                        <ul class="skill">
                                            <li>Product</li>
                                            <li>Manager</li>
                                            <li>Data Support</li>
                                        </ul>
                                        <a class="btn" data-target="#jopFullviewModal" data-toggle="modal" href="javascript:;">Know More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal modal-vcenter fade" id="jopFullviewModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog jopFullview-popup" role="document">
                                    <div class="modal-content">
                                        <div data-dismiss="modal" aria-label="Close" class="close-icon"><img alt="" src="images/close-icon.png"></div>
                                        <h1>Regional Manager- Data Support</h1>
                                        <div class="info-slide">
                                            <label>Experience Range: </label>
                                            <p>8-14 years</p>
                                        </div>
                                        <div class="info-slide">
                                            <label>Location: </label>
                                            <p>Bangalore</p>
                                        </div>
                                        <h2>Responsibilities:</h2>
                                        <ul>
                                            <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. </li>
                                            <li>Lorem Ipsum has been the industry's standard dummy text ever since the
                                                1500s, when an unknown printer took a galley of type and scrambled it to
                                                make a type specimen book. </li>
                                            <li>It has survived not only five centuries, but also the leap into
                                                electronic typesetting, </li>
                                            <li>Remaining essentially unchanged. It was popularised in the 1960s with
                                                the release of Letraset sheets containing.</li>
                                            <li>Lorem Ipsum passages, and more recently with desktop publishing software
                                                like Aldus PageMaker including versions of Lorem Ipsum.</li>
                                            <li>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. </li>
                                            <li>Lorem Ipsum has been the industry's standard dummy text ever since the
                                                1500s, when an unknown printer took a galley of type and scrambled it to
                                                make a type specimen book. </li>
                                            <li>It has survived not only five centuries, but also the leap into
                                                electronic typesetting,</li>
                                            <li>Remaining essentially unchanged. It was popularised in the 1960s with
                                                the release of Letraset sheets containing.</li>
                                        </ul>
                                        <div class="apply">
                                            <label>To apply on this job Email your resume</label>
                                            <a href="mailTo:careers@eventplanning.com"><span class="icon icon-envelope"></span>careers@eventplanning.com</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
    <script type="text/javascript" src="js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/placeholder.js"></script>
    <script type="text/javascript" src="js/coustem.js"></script>

</body>

</html>