<?php error_reporting(E_ALL ^ E_NOTICE)?>

<?php
session_start();
@require_once "../../model/Login.php";
@require_once "../../model/Person.php";
@require_once "../../model/PendingBook.php";
@include_once "../../controller/PersonController.php";
@include_once "../../controller/bookingController.php";
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
    header('Location: home.php');
}

// include "../register.php";

//for Halfpaid============================================================
if (isset($_GET["action"])) {
    if ($_GET["action"] == "half") {
        $transaction = $_GET["id"];
        $halfPaid = "yes";
        $pendingbook = new PendingBook();
        $pendingbook->setTransaction($transaction);
        $pendingbook->setHalfPaid($halfPaid);
        $result = halfBooking($pendingbook);
        echo '<script>alert("Half Paid")</script>';
        echo '<script>window.location="pendingBook.php"</script>';
    }
}


//for fulpaid============================================================
if (isset($_GET["action"])) {
    if ($_GET["action"] == "full") {
        $transaction = $_GET["id"];
        $fullPaid = "yes";
        $pendingbook = new PendingBook();
        $pendingbook->setTransaction($transaction);
        $pendingbook->setFullPaid($fullPaid);
        $result = fullBooking($pendingbook);
        echo '<script>alert("Full paid")</script>';
        echo '<script>window.location="pendingBook.php"</script>';
    }
}

//for remove============================================================
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        $transaction = $_GET["id"];
        $pendingbook = new PendingBook();
        $pendingbook->setTransaction($transaction);
        $result = cancelBooking($pendingbook);
        echo '<script>alert("Booking cancle")</script>';
        echo '<script>window.location="pendingBook.php"</script>';
    }
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

    <script>
        function searchByName() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("nameInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function searchByTransaction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("transactionInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function searchByDate() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("dateInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
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
                                <a ><span class="icon icon-envelope"></span>Hi </a>
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
                                <li class="single-col active">
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
                                <li class="single-col ">
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

        <div class="searchFilter-main">
            <section class="searchFormTop">
                <div class="container">
                    <div class="searchCenter">
                        <div class="refineCenter">
                            <span class="icon icon-filter"></span>
                            <span>Refine Customer</span>
                        </div>
                        <div class="searchFilter" style="width: 100%;">
                            <div class="input-box" style="width: 33.3%;">
                                <div class="icon icon-grid-view"></div>
                                <input type="text" id="nameInput" onkeyup="searchByName()" placeholder="Search for customer name" title="Type a name">
                            </div>
                            <div class="input-box searchlocation" style="width: 33.3%;">
                                <div class="icon icon-grid-view"></div>
                                <input type="text" id="transactionInput" onkeyup="searchByTransaction()" placeholder="Search for transaction" title="Type a location">
                            </div>
                            <div class="input-box date" style="width: 33.3%;">
                                <div class="icon icon-calander-month"></div>
                                <input type="text" id="dateInput" onkeyup="searchByDate()" placeholder="Search for Date" title="Type a date">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container">
                    <div class="venues-view">
                        <div class="row">

                            <!-- <div class="right-side" id="changeOrder">

                                </div> -->
                            <div class="content">
                                <div class="container">
                                    <div class="bookin-info">
                                        <table class="bookin-table" id="myTable">
                                            <tr>
                                                <td class=" Theading">Transaction</td>
                                                <td class=" Theading">Username</td>
                                                <td class="Theading">Email</td>
                                                <td class="Theading">Phone</td>
                                                <td class="Theading">Address</td>
                                                <td class="Theading">Booking Date</td>
                                                <td class="Theading">Order Date</td>
                                                <td class="Theading">Vendor Name</td>
                                                <td class="Theading">Package Name</td>
                                                <td class="Theading">Total Cost</td>
                                                <td class="Theading last">Action</td>
                                            </tr>
                                            <?php
                                            $result = getAllBooking();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo '    <td >';
                                                    echo         "<p>" .  $row["transaction"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td >';
                                                    echo         "<p>" .  $row["username"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["email"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["phone"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["address"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["bookingdate"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["pendingdate"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["vendorname"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["packagename"] . "</p>";
                                                    echo '    </td>';
                                                    echo '    <td>';
                                                    echo         "<p>" . $row["totalcost"] . "</p>";
                                                    echo '    </td>';
                                                    ?>
                                                    <td class="Theading last">
                                                        <?php
                                                                if ($row["halfpaid"] == "no") {
                                                                    ?>
                                                            <a href="pendingBook.php?action=half&id=<?php echo $row["transaction"]; ?>">
                                                                <span class="text-danger"><img src="../../view/images/half-icon.png" alt="" style="max-width: 80px"> </span>
                                                            </a>
                                                        <?php
                                                                } else {
                                                                    echo "";
                                                                }
                                                                if ($row["fullpaid"] == "no") {
                                                                    ?>
                                                            <a href="pendingBook.php?action=full&id=<?php echo $row["transaction"]; ?>">
                                                                <span class="text-danger"><img src="../../view/images/done-icon.png" alt="" style="max-width: 100px"> </span>
                                                            </a>
                                                        <?php
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>
                                                        <a href="pendingBook.php?action=delete&id=<?php echo $row["transaction"]; ?>">
                                                            <span class="text-danger"><img src="../../view/images/close-icon.png" alt="" style="max-width: 80px"> </span>
                                                        </a>
                                                    </td>
                                            <?php
                                                    echo '</tr> ';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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