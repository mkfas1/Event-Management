<?php error_reporting(E_ALL ^ E_NOTICE)?>

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
    header('Location: ./privacy_policy.php');
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

        <section class="page-header">
            <div class="container">
                <h1>Privacy Policy</h1>
            </div>
        </section>
        <section class="otherInfo">
            <div class="container">
                <div class="heading">
                    <div class="icon"><em class="icon icon-heading-icon"></em></div>
                    <div class="text">
                        <h2>Event Planning</h2>
                    </div>
                    <div class="info-text">Our management has developed this Privacy Statement(Policy) to express our firm commitment to aid our users better understand what information we collect about them and what may happen to that information.</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="text-center">This Terms of Use agreement was last updated: <strong>November 09, 2015</strong> This Terms of Use agreement is effective as of: <strong>November 09, 2015</strong></p>

                        <p class="text-center">Healthmart ("Event Planning") values your privacy. In this Privacy Policy ("Policy"), we describe the information that we collect about you when you visit our website, www.eventplanning.com (the "Website") and use the services available on the Website ("Services"), and how we use and disclose that information.</p>

                        <p class="text-center">If you have any questions or comments about the Privacy Policy, please contact us at <a href="mailto:info@eventplanning.com" target="_top">info@eventplanning.com</a> . This Policy is incorporated into and is subject to the eventplanning Terms of Use, which can be accessed at www.eventplanning.com/terms and conditions. Your use of the Website and/or Services and any personal information you provide on the Website remains subject to the terms of the Policy and eventplanning's Terms of Use.</p>
                    </div>

                </div>
            </div>
        </section>
        <section class="content policyPage">
            <div class="container">
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Collection of Your Personal Information</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <ul class="policy-block">
                            <li>
                                <h3>1) COLLECTION OF PERSONAL INFORMATION</h3>
                                <p>“Personal information” is defined to @include information that whether on its own or in combination with other information may be used to readily identify or contact you such as: name, address, email address, phone number etc.</p>
                                <p>We collect personal information from Service Professionals offering their products and services. This information is partially or completely accessible to all visitors using eventplanning’s website or mobile application, either directly or by submitting a request for a service. Service Professionals and customers are required to create an account to be able to access certain portions of our Website, such as to submit questions, participate in polls or surveys, to request a quote, to submit a bid in response to a quote, and request information. - Service Professionals, if and when they create an account with eventplanning, will be required to disclose information including personal contact details, agree to participation in polls or surveys or feedbacks or any other information that can help customer satiate its needs. The type of personal information that we collect from you varies based on your particular interaction with our Website or mobile application.</p>
                                <p><span>Consumers:</span> During the Account registration process, we will collect information such as your name, postal code, telephone email address and other personal information. You also may provide us with your, mailing address, and demographic information (e.g., gender, age, political preference, education, race or ethnic origin, and other information relevant to user surveys and/or offers). We may also collect personal information that you post in your Offer, Profile, Wants, or Feedback, and any comments or discussions you post in any blog, chat room, or other correspondence site on the Website or mobile application, or any comments you provide during dispute resolution with other users of the Website or mobile application.</p>
                                <p><span>Service Professionals:</span> If you are a Service Professional and would like to post any information about yourself, we will require you to register for an Account. During the Account registration process, we will collect your business name, telephone number, address, zip code, travel preferences, a description of your services, a headline for your profile, first and last name, and email address. In addition, you may, but are not required to, provide other content or information about your business, including photographs and videos. We also may collect payment information, such as credit card information, from you.</p>
                                <p>If we deem it necessary, in our sole and absolute discretion, we may also ask for and collect supplemental information from third parties, such as information about your credit from a credit bureau (to the extent permitted by law), or information to verify any identification details you provide during registration.</p>
                            </li>
                            <li>
                                <h3>2) COLLECTION OF PERSONAL INFORMATION FROM SOCIAL NETWORKING SITES</h3>
                                <p>You may log into our Website through your Facebook account. If you do so, you must enter the email address and password that you use for your Facebook account. We will ask that you grant us permission to access and collect your Facebook basic information (this @includes your name, profile picture, gender, networks, user IDs, list of friends, date of birth, email address, and any other information you have set to public on your Facebook account). If you allow us to have access to this information, then we will have access to this information even if you have chosen not to make that information public.</p>
                                <p>We store the information that we receive from Facebook with other information that we collect from you or receive about you.</p>
                                <p>Facebook controls the information it collects from you. For information about how Facebook may use and disclose your information, including any information you make public, please consult Facebook's privacy policy. We have no control over how any third party site uses or discloses the personal information it collects about you.</p>
                            </li>
                            <li>
                                <h3>3) COLLECTION OF AUTOMATIC INFORMATION, USE OF COOKIES AND OTHER TRACKING DEVICES</h3>
                                <p>We and our third party service providers, which @include ad networks, use cookies, web beacons, and other tracking technologies to collect information about your use of our Website and Services, such as your browser type, your ISP or operating system, your domain name, your access time, the URL of the previous website you visited, your page views, your IP address, and the type of device that you use. We also track how frequently you visit our Website and use our Services. We use this information (including the information collected by our third party service providers) for Website analytics (including to determine which portions of our Website are used most frequently, what our users like/do not like), to assist us in determining relevant advertising (both on and off our Website), to evaluate the success of our advertising campaigns, and as otherwise described in this policy. Currently, we do not honour browser requests not to be tracked.</p>
                                <p>We may obtain your device ID, which is sent to eventplanning's servers and used in fraud prevention efforts.</p>
                                <p><span>Cookies</span> We and our third party service providers collect information from you by using cookies. A cookie is a small file stored on user's computer hard drive containing information about the user. The cookie helps us analyze web traffic or informs you about your use of a particular website. Cookies allow web applications to respond to you as an individual, tailoring its operations to your needs, likes and dislikes by gathering and remembering information about your preferences. When you visit the Website, we may send one or more cookies (i.e., a small text file containing a string of alphanumeric characters) to your computer that identifies your browser.</p>
                                <p>Some of these cookies may be connected to third-party companies or websites. The terms of use of such cookies are governed by this Policy and the privacy policy of the relevant third party company or website. For example, Google measures the performance of advertisements by placing cookies on your computer when you click on ads. If you visit the Website when you have such cookies on your computer, we and Google will be able to tell that you saw the ad delivered by Google. The terms of use of these cookies are governed by this Policy and Google's Privacy Policy.</p>
                                <p>Disabling Cookies. You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. If you disable cookies you may be prevented from taking full advantage of the Website because it may not function properly if the ability to accept cookies is disabled.</p>
                                <p>Clear GIFs, pixel tags and other technologies. Clear GIFs are tiny graphics with a unique identifier, similar in function to cookies. In contrast to cookies, which are stored on your computer's hard drive, clear GIFs are embedded invisibly on web pages. We may use clear GIFs (a.k.a. web beacons, web bugs or pixel tags), in connection with our Website to, among other things, track the activities of Website visitors, help us manage content, and compile statistics about Website usage. We and our third party service providers also use clear GIFs in HTML emails to our customers, to help us track email response rates, identify when our emails are viewed, and track whether our emails are forwarded.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>How eventplanning Uses the Information We Collect</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <ul class="policy-block">
                            <li>
                                <h3>1) HOW PERSONAL INFORMATION IS USED</h3>
                                <ul class="customList">
                                    <li>We collect your personal information and aggregate information about the use of our Website and Services to better understand your needs and to provide you with a better Website experience. Specifically, we may use your personal information for any of the following reasons:</li>
                                    <li>To provide our Services to you, including registering you for our Services, verifying your identity and authority to use our Services, and to otherwise enable you to use our Website and our Services;</li>
                                    <li>For customer support and to respond to your inquiries;</li>
                                    <li><span>For internal record-keeping purposes; </span>To process billing and payment, including sharing with third party payment gateways in connection with Website and/or eventplanning's products and Services;</li>
                                    <li>To improve and maintain our Website and our Services (for example, we track information entered through the "Search" function; this helps us determine which areas of our Website users like best and areas that we may want to enhance; we also will use for trouble-shooting purposes, where applicable);</li>
                                    <li>To periodically send promotional emails to the email address you provide regarding new products from eventplanning, special offers from eventplanning or other information about eventplanning that we think you may find interesting;</li>
                                    <li>To contact you via email, telephone, facsimile or mail, or, where requested, by text message, to deliver certain services or information you have requested;</li>
                                    <li>For eventplanning's market research purposes, including, but not limited to, the customization of the Website according to your interests;</li>
                                    <li>We may use your demographic information (i.e., age, postal code, residential and commercial addresses, and other various data) to more effectively facilitate the promotion of goods and services to appropriate target audiences and for other research and analytical purposes;</li>
                                    <li>To resolve disputes, to protect ourselves and other users of our Website and Services, and to enforce our Terms of Use;</li>
                                    <li>We also may compare personal information collected through the Website and Services to verify its accuracy with personal information collected from third parties; and</li>
                                    <li>We may combine aggregate data with the personal information we collect about you.</li>
                                    <li>From time to time, eventplanning may use personal information for new and unanticipated uses not previously disclosed in our Privacy Policy. If our information practices change regarding information previously collected, eventplanning shall make reasonable efforts to provide notice and obtain consent of any such uses as may be required by law.</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Electronic Newsletters, Invitations, Polls and Surveys</h2>
                            <div class="info-text">At our sole discretion, eventplanning may offer any of the following free services on the Website, which you may select to use or receive at your option. Certain of the following services may require you to provide additional personal information as detailed below:</div>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <ul class="policy-block">
                            <li>
                                <h3>1) ELECTRONIC NEWSLETTERS</h3>
                                <p>We may offer a free electronic newsletter to users. We will gather the email addresses of users who sign up for eventplanning for the newsletter mailing list. Users may remove themselves from this mailing list by opting out of receiving newsletters during the registration process, by following the link provided in each newsletter that points users to a subscription management page where the user can unsubscribe from receiving newsletters or by changing their preferences in their Profile Settings page.</p>
                            </li>
                            <li>
                                <h3>2) SEND TO A FRIEND</h3>
                                <p>Our Website users can voluntarily choose to electronically forward a link, page, or document to someone else by clicking "send to a friend." To do so, the user must provide his or her email address, as well as the email address of the recipient. The user's email address is used only in the case of transmission errors and, of course, to let the recipient know who sent the email. The information is not used for any other purpose.</p>
                            </li>
                            <li>
                                <h3>3) POLLING</h3>
                                <p>We may offer interactive polls to users so they can easily share their opinions with other users and see what our audience thinks about important issues, Services, and/or the Website. Opinions or other responses to polls are aggregated and are not identifiable to any particular user. We may use a system to "tag" users after they have voted, so they can vote only once on a particular question. This tag is not correlated with information about individual users.</p>
                            </li>
                            <li>
                                <h3>4) SURVEYS</h3>
                                <p>We may conduct user surveys from time to time to better target our content to our Website users. We will not share individual responses from these surveys with any third party. We will share aggregate data with third party service providers, partners, and other third parties. We also will post aggregate data containing survey responses on our Website; that data may be viewed and downloaded by other users of our Website.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Security</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">We employ procedural and technological security measures, which are reasonably designed to help protect your personal information from unauthorized access or disclosure. eventplanning may use encryption, passwords, and physical security measures to help protect your personal information against unauthorized access and disclosure. No security measures, however, are 100% complete. Therefore, we do not promise and cannot guarantee, and thus you should not expect, that your personal information or private communications will not be collected and used by others. You should take steps to protect against unauthorized access to your password, phone, and computer by, among other things, signing off after using a shared computer, choosing a robust password that nobody else knows or can easily guess, and keeping your log-in and password private. eventplanning is not responsible for the unauthorized use of your information or for any lost, stolen, compromised passwords, or for any activity on your Account via unauthorized password activity.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Disclosure</h2>
                            <div class="info-text">We may share the information that we collect about you, including your personal information, as follows:</div>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <ul class="policy-block">
                            <li>
                                <h3>1) INFORMATION DISCLOSED TO PROTECT US AND OTHERS</h3>
                                <p>We may disclose your information including Personal Information if: (i) eventplanning reasonably believes that disclosure is necessary in order to comply with a legal process (such as a court order, search warrant, etc.) or other legal requirement of any governmental authority, (ii) disclosure would potentially mitigate our liability in an actual or potential lawsuit, (iii) reasonably necessary to enforce this Privacy Policy, our Terms of Use etc. (iv) disclosure is intended to help investigate or prevent unauthorized transactions or other illegal activities, or (v) necessary or appropriate to protect our rights or property, or the rights or property of any person or entity.</p>
                            </li>
                            <li>
                                <h3>2) INFORMATION DISCLOSED TO THIRD PARTY SERVICE PROVIDERS AND BUSINESS PARTNERS</h3>
                                <p>We may contract with various third parties for the provision and maintenance of the Website, Services and our business operations, and eventplanning may need to share your personal information and data generated by cookies and aggregate information (collectively, "information") with these vendors and service agencies. For example, we may provide your information to a credit card processing company to process your payment. The vendors and service agencies will not receive any right to use your personal information beyond what is necessary to perform its obligations to provide the Services to you. If you complete a survey, we also may share your information with the survey provider; if we offer a survey in conjunction with another entity, we also will disclose the results to that entity.</p>
                            </li>
                            <li>
                                <h3>3) DISCLOSURE TO NON-AFFILIATED THIRD PARTIES IN FURTHERANCE OF YOUR REQUEST</h3>
                                <p>Your request for services may be shared with third party websites with whom we have a contractual relationship in order to provide your request with maximum exposure. The post on the third party website will @include the details of your request, including your location, and other contact details. Interested bidders, however, will be able to click on your request on such third party site, and will be directed to our Website where they will have access to your contact details (Partial or complete), as would any other service provider on our Website interested in bidding on your request.</p>
                            </li>
                            <li>
                                <h3>4) DISCLOSURE TO OTHER USERS OF OUR WEBSITE</h3>
                                <p>If you are a Service Professional, the information that you post (other than your payment information) is available to other users of our Website and our Services. Comments that users post to our Website also will be available to other visitors to our Website (see our discussion of User Generated Content below). In addition, we will post the results (in aggregate form) of surveys to our Website. If you are a consumer, name, and location, as well as the details of your request, are available to all visitors to our Website. Bidding professionals also will be permitted to see the consumer's full name, telephone number, email address and the -location</p>
                            </li>
                            <li>
                                <h3>5) INFORMATION DISCLOSED TO LAW ENFORCEMENT OR GOVERNMENT OFFICIALS</h3>
                                <p>We will disclose your information, including, without limitation, your name, city, state, telephone number, email address, user ID history, quoting and listing history, and fraud complaints, to law enforcement or other government officials if we are required to do so by law, regulation or other government authority or otherwise in cooperation with an investigation of a governmental authority.</p>
                            </li>
                            <li>
                                <h3>6) IN THE EVENT OF A CHANGE OF CONTROL OR BANKRUPTCY</h3>
                                <p>In the event that eventplanning undergoes a change in control, including, without limitation, a merger or sale of all or substantially all of eventplanning's assets to which this Website relates or other corporate reorganization in which eventplanning participates, and is thus merged with or acquired by a third party entity (a "Successor"), eventplanning hereby reserves the right to transfer the information we have collected from the users of the Website and/or Services to such Successor.</p>
                                <p>In addition, in the event of eventplanning's bankruptcy, reorganization, receivership, or assignment for the benefit of creditors, or the application or laws or equitable principles affecting creditors' rights generally, eventplanning may not be able to control how your information is transferred, used, or treated and reserves the right to transfer the information we have collected from the users of the Website and/or Services to non-affiliated third parties in such event.</p>
                            </li>
                            <li>
                                <h3>7) INFORMATION DISCLOSED AT YOUR REQUEST</h3>
                                <p>We may share your personal information with other Registered Users to whom you explicitly ask us to send your information or if you explicitly consent to such disclosure upon receipt of a specific Service. For instance, when you contract for a specific Service with another Registered User, eventplanning will send that Registered User a notice that @includes the personal information that you have chosen to allow eventplanning to reveal to users with whom you contract.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Links to External Websites</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">The Website may contain links to other websites or resources over which eventplanning does not have any control. Such links do not constitute an endorsement by eventplanning of those external websites. You acknowledge that eventplanning is providing these links to you only as a convenience, and further agree that eventplanning is not responsible for the content of such external websites. We are not responsible for the protection and privacy of any information which you provide while visiting such external websites and such sites are not governed by this Policy. Your use of any external website is subject to the terms of use and privacy policy located on the linked to external website.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Updating, Deleting and Correcting Your Personal Information</h2>
                            <div class="info-text">You may choose to restrict the collection or use of your personal information in the following ways:</div>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">You can review, correct and delete your personal information by logging into the Website and navigating to your preferences page in "Edit Profile." You must promptly update your personal information if it changes or is inaccurate. Typically, we will not manually alter your personal information because it is very difficult to verify your identity remotely. Nonetheless, upon your request we will close your Account and remove your personal information from view as soon as reasonably possible based on your Account activity and in accordance with applicable law. We do retain information from closed Accounts in order to comply with the law, prevent fraud, collect any fees owed, resolve disputes, troubleshoot problems, assist with any investigations of any Registered User, enforce our Terms of Use, and take any other actions otherwise permitted by law that we deem necessary in our sole and absolute discretion. You should understand, however, that once you publicly post a Request, Offer, Want, Feedback, or any other information onto the Website, you may not be able to change or remove it. Once we have deleted or removed your Account, you agree that eventplanning shall not be responsible for any personal information that was not @included within your deleted and/or removed Account that remains on the Website.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>What Choices Do I Have Regarding Use of My Personal Information?</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">We may send periodic promotional or informational emails to you. You may opt-out of such communications by following the opt-out instructions contained in the email. Please note that it may take up to 10 business days for us to process opt-out requests. If you opt-out of receiving emails about recommendations or other information we think may interest you, we may still send you emails about your Account or any Services you have requested or received from us.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Third-Party Ad Networks</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">We participate in third party ad networks that may display advertisements on other websites based on your visits to our Site as well as other websites. This enables us and these third parties to target advertisements by displaying ads for products and services in which you might be interested. Third party ad network providers, advertisers, sponsors and/or traffic measurement services may use cookies, JavaScript, web beacons (including clear GIFs), Flash LSOs and other technologies to measure the effectiveness of their ads and to personalize advertising content to you. These third party cookies and other technologies are governed by each third party's specific privacy policy, and not by eventplanning’s Policy. We may provide these third-party advertisers with information about your usage of our Site and our services, as well as aggregate or non-personally identifiable information about visitors to our Site and users of our service.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Your Full Name and Use of eventplanning Information</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <ul class="policy-block">
                            <li>
                                <h3>1) YOUR FULL NAME</h3>
                                <p>As a Registered User of the Website you will select a Full Name during the registration process. All of your activities on the Website will be traceable to your Full Name. Certain other people, including other Registered Users with whom you have transacted business via the Website, can see a large part of your activity on the Website. If you book a service with a Registered User, cancel a scheduled service with a Registered User, receive an offer on your posted service from a Registered User, or have posted a service, eventplanning may send a notice to you or the appropriate Registered User that @includes your Full Name. Thus, if you associate your real name with your Full Name, the people to whom you have revealed your name may be able to personally identify your Website activities.</p>
                            </li>
                            <li>
                                <h3>2) USING INFORMATION FROM eventplanning</h3>
                                <p>The Website facilitates your sharing of personal information with others in order to negotiate, provide, and use the Services. If you agree to contract for a service with another Registered User, you may need to reveal your name, email, phone number, or personal address to that individual so that the service may be performed. Please respect the privacy of others. You agree to use the information of other users solely for the following purposes: (a) eventplanning-transaction-related purposes; and (b) using Services offered through the Website.</p>
                            </li>
                            <li>
                                <h3>3) ACCOUNT PROTECTION</h3>
                                <p>Your password is the key to your Account. When creating your password you should use unique numbers, letters, special characters, and combinations thereof. In addition, DO NOT disclose your password to anyone. If you do share your password or your personal information with others, you are solely responsible for all actions taken via your Account. If you lose control of your password, you may lose substantial control over your personal information and be subject to legally binding actions taken on your behalf. Thus, IF YOUR PASSWORD HAS BEEN COMPROMISED FOR ANY REASON, YOU MUST IMMEDIATELY NOTIFY eventplanning TO CHANGE YOUR PASSWORD.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>User Generated Content</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block ">We invite you to post content on our Website, including your comments, feedback, pictures, and any other information that you would like to be available on our Website. If you post content to our Website, all of the information that you post will be available to all visitors to our Website. If you post your own content on our Website or Services, your posting may become public and eventplanning cannot prevent such information from being used in a manner that may violate this Policy, the law, or your personal privacy.</p>
                    </div>
                </div>
                <div class="innerSec">
                    <div class="heading">
                        <div class="icon"><em class="icon icon-heading-icon"></em></div>
                        <div class="text">
                            <h2>Privacy Policy Updates</h2>
                        </div>
                    </div>
                    <div class="policy-list Dicpadding">
                        <p class="policy-block">THIS POLICY IS CURRENT AS OF THE EFFECTIVE DATE SET FORTH ABOVE. eventplanning MAY, IN ITS SOLE AND ABSOLUTE DISCRETION, CHANGE THIS POLICY FROM TIME TO TIME BY UPDATING THIS DOCUMENT. eventplanning WILL POST ITS UPDATED POLICY ON THE WEBSITE ON THIS PAGE. eventplanning ENCOURAGES YOU TO REVIEW THIS POLICY REGULARLY FOR ANY CHANGES. YOUR CONTINUED USE OF THIS WEBSITE AND/OR CONTINUED PROVISION OF PERSONAL INFORMATION TO US WILL BE SUBJECT TO THE TERMS OF THE THEN-CURRENT POLICY.</p>
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
    <script type="text/javascript" src="js/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="js/placeholder.js"></script>
    <script type="text/javascript" src="js/coustem.js"></script>
</body>

</html>