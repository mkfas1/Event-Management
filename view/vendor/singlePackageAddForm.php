<?php error_reporting(E_ALL ^ E_NOTICE) ?>

<?php
session_start();
@include_once "../../model/Login.php";
@include_once "../../model/Person.php";
@include_once "../../model/SinglePackage.php";
@include_once "../../controller/PersonController.php";
@include_once "../../controller/packageController/packageController.php";

// for logout============================================================>
if (isset($_POST['logoutPerson'])) {
    session_destroy();
    header("Location: ../register.php");
}
//for check person=========================================================
if(!empty($_SESSION['username'])){
    if($_SESSION['status']!=2){
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
    <link href="../css/imageUpload.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/formStyle.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/datepicker.css" rel="stylesheet" />
    <link href="../css/loader.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="../css/jquery.selectbox.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Domine:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,700i%7CRoboto:400,500" rel="stylesheet">

</head>

<body class="registerPage">
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
                                <li class="single-col ">
                                    <a href="singlePackagePage.php">Single Package </a>
                                </li>
                                <li class="single-col ">
                                    <a href="bundlePackagePage.php">Bundle package </a>
                                </li>
                                <li class="single-col active">
                                    <a href="#">Add Packages <span class="icon icon-arrow-down"></span></a>
                                    <ul>
                                        <li> <a href="singlePackageAddForm.php">Single Package </span></a> </li>
                                        <li> <a href="bundlePackageAddForm.php">Bundle Package </span></a> </li>
                                    </ul>
                                </li>
                                <li class="single-col ">
                                    <a href="vendor_account_profile.php">My Account </a>
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

        <div class="dashboard-banner">
            <div class="container">
                <h2>Add your Single Package </h2>
            </div>
        </div>

        <?php
        // <======================================================fro single package add================================================>
        if (isset($_POST["insertSinglePackage"])) {

            $category = $_POST['category'];
            $packageName = $_POST['packageName'];
            $vendorName = $_SESSION['username'];
            $price = $_POST['price'];
            $transportCost = $_POST['transportCost'];
            $availableStatus = $_POST['availableStatus'];
            $description = $_POST['description'];
            $rating = "";

            if (strlen($vendorName) == 0) {
                @include_once "../errors/loginError.php";
            } else {
                if (strlen($category) == 0 || strlen($packageName) == 0  || strlen((string) $price) == 0 || strlen((string) $transportCost) == 0 || strlen($availableStatus) == 0 || strlen($description) == 0) {
                    @include_once "../errors/blankEntry.php";
                } else {

                    $targetDir = "../packageImage/singlePackagePicture/";
                    $fileName =  basename($_FILES["imageUpload"]["name"]);
                    $fileName =  $fileName;
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    $allowTypes = array("jpg", "png", "jpeg", "gif");
                    if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFilePath)) {
                            $singlePackage = new SinglePackage($category, $packageName, $vendorName, $price, $transportCost, $availableStatus, $description, $fileName, $rating);
                            $insert = insertSinglePackage($singlePackage);
                            if ($insert == -1) {
                                @include_once "../errors/alreadyAddedPackage.php";
                            } else {
                                if ($insert == 1) {
                                    @include_once "../errors/productAddSuccess.php";
                                } else {
                                    @include_once "../errors/fileUploadError.php";
                                }
                            }
                        } else {
                            @include_once "../errors/fileUploadError.php";
                        }
                    } else {
                        @include_once "../errors/fileUploadError.php";
                    }
                }
            }
        }

        ?>
        <!-- add form -->
        <div class="register-banner">
            <div class="inner-banner">
                <div class="register-form" style="padding: 0px 10% 0px 10%;">
                    <div class="inner-form">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 100%;" enctype="multipart/form-data">
                            <div class="form-filde" style="border-radius: 10px 10px 10px 10px;padding: 20px 45px 25px 25px;">
                                <div class="select-row">
                                    <select name="category" id="country_select" tabindex="1">
                                        <option value="">Select Category</option>
                                        <option value="Caterers">Caterers</option>
                                        <option value="Decor&Flower">Decor & Flower</option>
                                        <option value="Makeup&Hair">Make-up & Hair</option>
                                        <option value="WeedingCard">Weeding Card</option>
                                        <option value="Mehedi">Mehedi</option>
                                        <option value="Cake">Cake</option>
                                        <option value="Dj">DJ</option>
                                        <option value="Photographer">Photographers</option>
                                        <option value="Entertainment">Entertainment</option>
                                    </select>
                                </div>
                                <div class="input-slide">
                                    <input type="text" placeholder="Package Name" name="packageName">
                                </div>
                                <div class="input-slide">
                                    <input type="number" placeholder="Price" name="price" min="0" oninput="this.value = Math.abs(this.value)">
                                </div>
                                <div class="input-slide">
                                    <input type="number" placeholder="Transport Cost" name="transportCost">
                                </div>
                                <div class="select-row">
                                    <select name="availableStatus" id="month_select" tabindex="1">
                                        <option value="">Choose availability</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="input-slide">
                                    <input type="text" placeholder="How many people ? in one line" name="description">
                                </div>
                                <div class="file-upload">
                                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*" name="imageUpload" />
                                        <div class="drag-text">
                                            <h3>Drag and drop a file or select add Image</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <br /> <span class="image-title"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-slide">
                                    <input type="submit" value="Submit" class="btn" name="insertSinglePackage" style="width: 100px;    margin-left: 10px; margin-top: 15px; ">
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
    <script type="text/javascript" src="../js/imageUpload.js"></script>
</body>

</html>