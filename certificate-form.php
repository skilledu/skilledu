<?php
// Disable error reporting to avoid PHP errors being shown in the browser
error_reporting(0);  // Disable error reporting
ini_set('display_errors', 0);  // Hide errors
include('auth.php');

// Include SweetAlert2 library from CDN (above your script)
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.all.min.js"></script>';

// Database connection (replace with your actual connection details)
$host = 'localhost'; // Database host
$username = 'root';  // Database username
$password = '';  // Database password
$dbname = 'skilledu_dummy';    // Your database name


$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // Show SweetAlert2 error message and stop execution
    echo '<script>
    window.onload = function() {
        Swal.fire({
            toast: true,
            icon: "error",
            title: "Database Connection Failed",
            position: "top-end", 
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to the form page
        });
    }
</script>
';
    exit(); // Stop further execution after showing the alert
}

// Handle the form data after it's posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent SQL injection
    $certificate_number = mysqli_real_escape_string($conn, $_POST['certificate_number']);
 $check_sql = "SELECT * FROM certifications WHERE certificate_id = '$certificate_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Certificate ID already exists, show error message and stop execution
        echo '<script>
    window.onload = function() {
        Swal.fire({
            toast: true,
            icon: "error",
            title: "Certificate ID Already Exists",
            position: "top-end", // Position of the Toast
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to the form page
        });
    }
</script>';
        exit(); // Stop further execution after showing the alert
    }
    // Handle file upload
    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
        $file_name = $_FILES['certificate']['name'];  // Fixed issue with extra spaces
        $file_tmp = $_FILES['certificate']['tmp_name'];
        $file_size = $_FILES['certificate']['size'];
        $file_error = $_FILES['certificate']['error'];

        // Debugging: Check file upload error
        if ($file_error !== 0) {
            // echo 'File upload error: ' . $file_error;
            exit();
        }

        // Specify the directory to store uploaded files
        $upload_dir = 'uploads/';  // Relative path to the uploads folder
        $upload_path = $upload_dir . basename($file_name);

        // Check if the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Debugging: Print out the temporary and final paths
        // echo 'Temporary File: ' . $file_tmp . '<br>';
        // echo 'Upload Path: ' . $upload_path . '<br>';

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Only store the relative path (e.g., 'uploads/filename.pdf')
            $relative_path = $upload_path;
            // print_r($relative_path);  // Debugging: Check the path

            // Prepare the SQL query to insert the data (certificate_number and file path)
            $sql = "INSERT INTO certifications (pdf, certificate_id, status)
                    VALUES ('$relative_path', '$certificate_number', 1)";

            // Execute the query and check for success
            if ($conn->query($sql) === TRUE) {
                // Success: Show SweetAlert2 success message and redirect
                echo '<script>
    window.onload = function() {
        Swal.fire({
            toast: true,
            icon: "success",
            title: "Certification Created Successfully",
            position: "top-end", // Position of the Toast
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to another page or the same form page
        });
    }
</script>';
                exit(); // Stop further execution after showing the alert
            } else {
                // SQL error: Show SweetAlert2 error message and stop execution
                echo '<script>
    window.onload = function() {
        Swal.fire({
            icon: "error",
            title: "Database Error",
            text: "<?php echo addslashes($conn->error); ?>", // Injecting PHP error message
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to the form page
        });
    }
</script>
';
                exit(); // Stop further execution after showing the alert
            }
        } else {
            // File upload failed: Show SweetAlert2 error message and stop execution
            echo '<script>
    window.onload = function() {
        Swal.fire({
            toast: true,
            icon: "error",
            title: "File Upload Failed",
            text: "There was an issue uploading your file. Please try again.",
            position: "top-end", // Adjust the position if necessary
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to the form page
        });
    }
</script>
';
            exit(); // Stop further execution after showing the alert
        }
    } else {
        // No file uploaded or file error: Show SweetAlert2 error message and stop execution
        echo '<script>
    window.onload = function() {
        Swal.fire({
            toast: true,
            icon: "error",
            title: "No File Uploaded",
            text: "Please upload a certificate file.",
            position: "top-end", // You can adjust the position as needed
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        }).then(function() {
            window.location.href = "certificate-form.php"; // Redirect to the form page
        });
    }
</script>
';
        exit(); // Stop further execution after showing the alert
    }
}

// Close the database connection
$conn->close();
?>


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Skilled.u - Generate Certificate</title>
   <meta name="keywords" content="education, future skills, programming, coding, skill development, HTML, CSS, ReactJS, in Ujjain, full stack development course, website development course, mobile app development">
    <meta name="description" content="Skilled.u - Empowering Future Developers">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon/skilledU_Icon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/flaticon-skillgro.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default-icons.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/spacing.css">
    <link rel="stylesheet" href="assets/css/tg-cursor.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- additional css  -->
    <link rel="stylesheet" href="assets/css/my_css.css">

    <!-- font awesome icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
          .footer__content .list-wrap li a.f_contact {
            color: #ffc224 !important;
        }
        .footer__content .list-wrap li a.f_contact:hover {
            color: #1c1ab8 !important;
        }
    </style>
</head>

<body>
<?php
?>
    <!--Preloader-->
    <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="assets/img/logo/skilledU_Logo.png" alt="Preloader"></div>
            </div>
        </div>
    </div>
    <!--Preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->

    <header>
        <div class="tg-header__top">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tg-header__top-info list-wrap">
                            <li>
                                <img src="assets/img/icons/map_marker.svg" alt="Icon" />
                                <span
                                  ><a href="https://maps.app.goo.gl/TMc6gjPbDTMm1KPX7" target="_blank"
                                    >201 , Navkar Complex ,Teen Batti Chauraha , Ujjain, MP</a
                                  ></span
                                >
                              </li>                            <li><img src="assets/img/icons/envelope.svg" alt="Icon"> <a href="mailto:info@skilledu.in">info@skilledu.in</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tg-header__top-right">
                            <div class="tg-header__phone">
                                <img src="assets/img/icons/phone.svg" alt="Icon">Call us: <a href="tel:+918989099962">+91 89890 99962</a>
                            </div>
                            <ul class="tg-header__top-social list-wrap">
                                <li>Follow Us On :</li>
                                <li><a href="https://www.facebook.com/profile.php?id=61556212776038&mibextid=ZbWKwL"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank" ><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/skilled-u/"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://www.instagram.com/SkilledU24?igsh=M2Y4djB6dXVzb2xx"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-header__area py-1">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="logo">
                                    <a href="index.html"><img src="assets/img/logo/skilledU_Logo.png" alt="Logo"></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__navbar-wrap-my tgmenu__main-menu d-none d-xl-flex ">
                                    <ul class="navigation">
                                        <li class="menu-item"><a href="index.html">Home</a>
                                            <!-- <ul class="sub-menu">
                                                <li class="active"><a href="#">Home One</a></li>
                                                <li><a href="#">Home Two</a></li>
                                            </ul> -->
                                        </li>
                                        <li><a href="all-courses.html">All Courses</a></li>
                                        <li class="menu-item"><a href="contact.html">Contact Us</a>
                                            <!-- <ul class="sub-menu">
                                                <li><a href="#">About Us</a></li>
                                                <li><a href="#">Our Instructors</a></li>
                                                <li><a href="#">Instructor Details</a></li>
                                                <li><a href="#">Our Events</a></li>
                                                <li><a href="#">Event Details</a></li>
                                                <li><a href="#">Student Login</a></li>
                                                <li><a href="#">Student Registration</a></li>
                                                <li><a href="#">404 Page</a></li>
                                                <li><a href="#">contact</a></li>
                                            </ul> -->
                                        </li>
                                        <!-- <li class="menu-item"><a href=" #">Contact Us</a>
                                            <ul class="sub-menu">
                                                <li><a href="#">Shop Page</a></li>
                                                <li><a href="#">Shop Details</a></li>
                                            </ul>
                                        </li> -->
                                        <!-- <li class="menu-item-has-children"><a href="#">Blog</a>
                                            <ul class="sub-menu">
                                                <li><a href="#">Blog Grid</a></li>
                                                <li><a href="#">Blog Details</a></li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </div>
                                <!-- <div class="tgmenu__search d-none d-md-block">
                                    <form action=" #" class="tgmenu__search-form">
                                        <div class="select-grp">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.992 13.25C10.5778 13.25 10.242 13.5858 10.242 14C10.242 14.4142 10.5778 14.75 10.992 14.75V13.25ZM16.992 14.75C17.4062 14.75 17.742 14.4142 17.742 14C17.742 13.5858 17.4062 13.25 16.992 13.25V14.75ZM14.742 11C14.742 10.5858 14.4062 10.25 13.992 10.25C13.5778 10.25 13.242 10.5858 13.242 11H14.742ZM13.242 17C13.242 17.4142 13.5778 17.75 13.992 17.75C14.4062 17.75 14.742 17.4142 14.742 17H13.242ZM1 6.4H1.75H1ZM1 1.6H1.75H1ZM6.4 1V1.75V1ZM7 1.6H6.25H7ZM6.4 7V6.25V7ZM1 16.4H1.75H1ZM1 11.6H1.75H1ZM6.4 11V11.75V11ZM7 11.6H6.25H7ZM6.4 17V17.75V17ZM1.6 17V17.75V17ZM11 6.4H11.75H11ZM11 1.6H11.75H11ZM11.6 1V0.25V1ZM16.4 1V1.75V1ZM17 1.6H17.75H17ZM17 6.4H17.75H17ZM16.4 7V6.25V7ZM10.992 14.75H13.992V13.25H10.992V14.75ZM16.992 13.25H13.992V14.75H16.992V13.25ZM14.742 14V11H13.242V14H14.742ZM13.242 14V17H14.742V14H13.242ZM1.75 6.4V1.6H0.25V6.4H1.75ZM1.75 1.6C1.75 1.63978 1.7342 1.67794 1.70607 1.70607L0.645406 0.645406C0.392232 0.89858 0.25 1.24196 0.25 1.6H1.75ZM1.70607 1.70607C1.67794 1.7342 1.63978 1.75 1.6 1.75V0.25C1.24196 0.25 0.89858 0.392232 0.645406 0.645406L1.70607 1.70607ZM1.6 1.75H6.4V0.25H1.6V1.75ZM6.4 1.75C6.36022 1.75 6.32207 1.7342 6.29393 1.70607L7.35459 0.645406C7.10142 0.392231 6.75804 0.25 6.4 0.25V1.75ZM6.29393 1.70607C6.2658 1.67793 6.25 1.63978 6.25 1.6H7.75C7.75 1.24196 7.60777 0.898581 7.35459 0.645406L6.29393 1.70607ZM6.25 1.6V6.4H7.75V1.6H6.25ZM6.25 6.4C6.25 6.36022 6.2658 6.32207 6.29393 6.29393L7.35459 7.35459C7.60777 7.10142 7.75 6.75804 7.75 6.4H6.25ZM6.29393 6.29393C6.32207 6.2658 6.36022 6.25 6.4 6.25V7.75C6.75804 7.75 7.10142 7.60777 7.35459 7.35459L6.29393 6.29393ZM6.4 6.25H1.6V7.75H6.4V6.25ZM1.6 6.25C1.63978 6.25 1.67793 6.2658 1.70607 6.29393L0.645406 7.35459C0.898581 7.60777 1.24196 7.75 1.6 7.75V6.25ZM1.70607 6.29393C1.7342 6.32207 1.75 6.36022 1.75 6.4H0.25C0.25 6.75804 0.392231 7.10142 0.645406 7.35459L1.70607 6.29393ZM1.75 16.4V11.6H0.25V16.4H1.75ZM1.75 11.6C1.75 11.6398 1.7342 11.6779 1.70607 11.7061L0.645406 10.6454C0.392231 10.8986 0.25 11.242 0.25 11.6H1.75ZM1.70607 11.7061C1.67793 11.7342 1.63978 11.75 1.6 11.75V10.25C1.24196 10.25 0.898581 10.3922 0.645406 10.6454L1.70607 11.7061ZM1.6 11.75H6.4V10.25H1.6V11.75ZM6.4 11.75C6.36022 11.75 6.32207 11.7342 6.29393 11.7061L7.35459 10.6454C7.10142 10.3922 6.75804 10.25 6.4 10.25V11.75ZM6.29393 11.7061C6.2658 11.6779 6.25 11.6398 6.25 11.6H7.75C7.75 11.242 7.60777 10.8986 7.35459 10.6454L6.29393 11.7061ZM6.25 11.6V16.4H7.75V11.6H6.25ZM6.25 16.4C6.25 16.3602 6.2658 16.3221 6.29393 16.2939L7.35459 17.3546C7.60777 17.1014 7.75 16.758 7.75 16.4H6.25ZM6.29393 16.2939C6.32207 16.2658 6.36022 16.25 6.4 16.25V17.75C6.75804 17.75 7.10142 17.6078 7.35459 17.3546L6.29393 16.2939ZM6.4 16.25H1.6V17.75H6.4V16.25ZM1.6 16.25C1.63978 16.25 1.67793 16.2658 1.70607 16.2939L0.645406 17.3546C0.898581 17.6078 1.24196 17.75 1.6 17.75V16.25ZM1.70607 16.2939C1.7342 16.3221 1.75 16.3602 1.75 16.4H0.25C0.25 16.758 0.392231 17.1014 0.645406 17.3546L1.70607 16.2939ZM11.75 6.4V1.6H10.25V6.4H11.75ZM11.75 1.6C11.75 1.63978 11.7342 1.67793 11.7061 1.70607L10.6454 0.645406C10.3922 0.898581 10.25 1.24196 10.25 1.6H11.75ZM11.7061 1.70607C11.6779 1.7342 11.6398 1.75 11.6 1.75V0.25C11.242 0.25 10.8986 0.392231 10.6454 0.645406L11.7061 1.70607ZM11.6 1.75H16.4V0.25H11.6V1.75ZM16.4 1.75C16.3602 1.75 16.3221 1.7342 16.2939 1.70607L17.3546 0.645406C17.1014 0.392231 16.758 0.25 16.4 0.25V1.75ZM16.2939 1.70607C16.2658 1.67793 16.25 1.63978 16.25 1.6H17.75C17.75 1.24196 17.6078 0.898581 17.3546 0.645406L16.2939 1.70607ZM16.25 1.6V6.4H17.75V1.6H16.25ZM16.25 6.4C16.25 6.36022 16.2658 6.32207 16.2939 6.29393L17.3546 7.35459C17.6078 7.10142 17.75 6.75804 17.75 6.4H16.25ZM16.2939 6.29393C16.3221 6.2658 16.3602 6.25 16.4 6.25V7.75C16.758 7.75 17.1014 7.60777 17.3546 7.35459L16.2939 6.29393ZM16.4 6.25H11.6V7.75H16.4V6.25ZM11.6 6.25C11.6398 6.25 11.6779 6.2658 11.7061 6.29393L10.6454 7.35459C10.8986 7.60777 11.242 7.75 11.6 7.75V6.25ZM11.7061 6.29393C11.7342 6.32207 11.75 6.36022 11.75 6.4H10.25C10.25 6.75804 10.3922 7.10142 10.6454 7.35459L11.7061 6.29393Z" fill="currentcolor" />
                                            </svg>
                                            <select class="form-select" id="course-cat" aria-label="Default select example" style="width: 150px">
                                                <option selected disabled>Categories</option>
                                                <option value="1">Business</option>
                                                <option value="2">Data Science</option>
                                                <option value="3">Art & Design</option>
                                                <option value="4">Marketing</option>
                                                <option value="5">Finance</option>
                                            </select>
                                        </div>
                                        <div class="input-grp">
                                            <input type="text" placeholder="Search For Course . . .">
                                            <button type="submit"><i class="flaticon-search"></i></button>
                                        </div>
                                    </form>
                                </div> -->
                                <div class="tgmenu__action">
                                    <ul class="list-wrap">
                                        <!-- <li class="wishlist-icon">
                                            <a href="#" class="cart-count">
                                                <img src="assets/img/icons/heart.svg" class="injectable" alt="img">
                                                <span class="wishlist-count">0</span>
                                            </a>
                                        </li>
                                        <li class="mini-cart-icon">
                                            <a href="#" class="cart-count">
                                                <img src="assets/img/icons/cart.svg" class="injectable" alt="img">
                                                <span class="mini-cart-count">0</span>
                                            </a>
                                        </li> -->
                                        <!-- <li class="header-btn login-btn">
                                            <a href="#">Register</a>
                                        </li>
                                        <li class="header-btn login-btn">
                                            <a href="#">Log in</a>
                                        </li> -->
                                        <li class="header-btn login-btn">
                                            <a href="+918989099962" class="btn"> <i class="fa fa-phone px-2"></i>Call Us</a>
                                        </li>
                                        
                                        <li class="header-btn login-btn">
                                            <a href="https://wa.me/+918989099962?text=I%20want%20to%20code"  class="btn"><i class="fa fa-whatsapp px-2"></i>whatsApp Us</a>
                                        </li>
                                        <li class="header-btn login-btn">
                                            <a href="https://skilledu.in/logout.php"  class="btn"><i class="fa fa-user px-2"></i>Logout</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                                <div class="mobile-nav-toggler"><i class="tg-flaticon-menu-1"></i></div>
                            </nav>
                        </div>
                        <!-- Mobile Menu  -->
                        <div class="tgmobile__menu">
                            <nav class="tgmobile__menu-box">
                                <div class="close-btn"><i class="tg-flaticon-close-1"></i></div>
                                <div class="nav-logo">
                                    <a href="#"><img src="assets/img/logo/skilledU_Logo.png" alt="Logo"></a>
                                </div>
                                <!--<div class="tgmobile__search">-->
                                <!--    <form action=" #">-->
                                <!--        <input type="text" placeholder="Search here...">-->
                                <!--        <button><i class="fas fa-search"></i></button>-->
                                <!--    </form>-->
                                <!--</div>-->
                                <div class="tgmobile__menu-outer">
                                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                                </div>
                          <div class="social-links">
                                     <ul class="list-wrap">
                                        <li><a href="https://www.facebook.com/profile.php?id=61556212776038&mibextid=ZbWKwL"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank" ><i class="fab fa-whatsapp"></i></a></li>
                                        <li><a href="https://www.instagram.com/SkilledU24?igsh=M2Y4djB6dXVzb2xx"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="https://www.linkedin.com/company/skilled-u/"><i class="fab fa-linkedin-in"></i></a></li>
                                        <!--<li><a href="#"><i class="fab fa-youtube"></i></a></li>-->
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="tgmobile__menu-backdrop"></div>
                        <!-- End Mobile Menu -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-area-end -->



    <!-- main-area -->
    <main class="main-area fix">

        <!-- breadcrumb-area -->
        <section class="breadcrumb__area breadcrumb__bg bread_bg" >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                            <h3 class="title">Create Certificate</h3>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="index.html">Home</a>
                                </span>
                                <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                                <span property="itemListElement" typeof="ListItem">Create Certificate</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__shape-wrap">
                <img src="assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">
                <img src="assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300">
                <img src="assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400">
                <img src="assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400">
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- Add Certificate form code here -->

        <section id="certification-form" class="certification-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="section-title text-center mb-60">
                            <h2>Stunning Certificates Instantly!</h2>
                            <p>Design and personalize certificates effortlessly. 
                            Perfect for achievements, events, and special recognitions!</p>
                        </div>
                        <div class="certification-form-wrapper">
                           
        
                            <form action="certificate-form.php" method="POST" id="certification_form" enctype="multipart/form-data">
                                <!-- Certificate Number -->
                                <div class="form-group">
                                    <label for="recipient-name">Certificate Number</label>
                                    <input type="text" id="recipient-name" name="certificate_number" class="form-control" placeholder="Enter Certificate Number">
                                    <small id="certificate-number-error" class="text-danger"></small>
                                </div>
                            
                                <!-- Certificate File -->
                                <div class="form-group">
                                    <label for="certificate-name">Certificate</label>
                                    <input type="file" id="certificate-name" name="certificate" class="form-control" accept=".pdf">
                                    <small id="certificate-error" class="text-danger"></small>
                                </div>
                            
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
        
        
        
        
        
        
        
        
        
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>
    <!-- main-area-end -->



    <!-- footer-area -->
    <footer class="footer__area">
        <div class="footer__top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer__widget">
                            <div class="logo logo_footer">
                                <a href="index.html"><img src="assets/img/logo/Skilledu_Logo_White2.png" alt="img"></a>
                            </div>
                            <div class="footer__content">
                                <p>Skilled.u aims to empower learners nationwide in frontend,
                                     backend development, machine learning, and more.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="footer__widget">
                            <h4 class="footer__widget-title">Quick Links</h4>
                            <div class="footer__link">
                                <ul class="list-wrap">
                                    <li><a href="contact.html">Contact Us</a></li>
                                    <li><a href="index.html#about">About Us</a></li>
                                    <li><a href="index.html#testimonial">Testimonials</a></li>
                                    <li><a href="index.html#faq">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer__widget">
                            <h4 class="footer__widget-title">Get In Touch</h4>
                            <div class="footer__contact-content">
                                <!-- <p>Reach out to us for inquiries, <br> assistance, or collaborations. </p> -->
                                <div class="footer__content">
                                    <ul class="list-wrap">
                                        <li>                         
                                            <a class="f_contact" href="https://maps.app.goo.gl/TMc6gjPbDTMm1KPX7" target="_blank">201 , Navkar Complex ,Teen Batti Chauraha , Ujjain MP 456010</a
                                            >
                                          </li>
                                          <li><a class="f_contact" href="tel:+918989099962">+91 89890 99962</a></li>
                                        <li><a class="f_contact" href="mailto:info@skilledu.in">info@skilledu.in</a></li>
                                    </ul>
                                </div>
                               
                                <ul class="list-wrap footer__social">
                                     <li><a href="https://www.linkedin.com/company/skilled-u/"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li>
                                        <a href="https://www.facebook.com/profile.php?id=61556212776038&mibextid=ZbWKwL" target="_blank">
                                            <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 5.65773V3.60037C5 3.03254 5.448 2.5717 6 2.5717H7V0H5C3.343 0 2 1.38152 2 3.08603V5.65773H0V8.22943H2V16.4589H5V8.22943H7L8 5.65773H5Z" fill="currentcolor"/>
                                                </svg>
                                        </a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="#" target="_blank">-->
                                    <!--        <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                                    <!--            <path d="M16 1.68868C15.405 1.97506 14.771 2.16489 14.11 2.25706C14.79 1.81157 15.309 1.11152 15.553 0.267731C14.919 0.682494 14.219 0.975461 13.473 1.13895C12.871 0.435611 12.013 0 11.077 0C9.261 0 7.799 1.61736 7.799 3.6001C7.799 3.88539 7.821 4.1597 7.875 4.42085C5.148 4.27491 2.735 2.8408 1.114 0.65616C0.831 1.19491 0.665 1.81157 0.665 2.47541C0.665 3.7219 1.25 4.82683 2.122 5.46653C1.595 5.45556 1.078 5.28768 0.64 5.02324C0.64 5.03421 0.64 5.04848 0.64 5.06274C0.64 6.81177 1.777 8.26454 3.268 8.5992C3.001 8.6793 2.71 8.71771 2.408 8.71771C2.198 8.71771 1.986 8.70454 1.787 8.65626C2.212 10.0816 3.418 11.1295 4.852 11.1635C3.736 12.1214 2.319 12.6986 0.785 12.6986C0.516 12.6986 0.258 12.6854 0 12.6492C1.453 13.6773 3.175 14.2643 5.032 14.2643C11.068 14.2643 14.368 8.77806 14.368 4.02254C14.368 3.86344 14.363 3.70983 14.356 3.55731C15.007 3.05037 15.554 2.41726 16 1.68868Z" fill="currentcolor"/>-->
                                    <!--            </svg>-->
                                                
                                    <!--    </a>-->
                                    <!--</li>-->
                                    <li>
                                        <a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank" >
                                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.50187 0H7.49813C3.36281 0 0 3.36375 0 7.5C0 9.14062 0.52875 10.6613 1.42781 11.8959L0.493125 14.6822L3.37594 13.7606C4.56187 14.5463 5.97656 15 7.50187 15C11.6372 15 15 11.6353 15 7.5C15 3.36469 11.6372 0 7.50187 0ZM11.8659 10.5909C11.685 11.1019 10.9669 11.5256 10.3941 11.6494C10.0022 11.7328 9.49031 11.7994 7.76719 11.085C5.56312 10.1719 4.14375 7.93219 4.03312 7.78687C3.92719 7.64156 3.1425 6.60094 3.1425 5.52469C3.1425 4.44844 3.68906 3.92438 3.90938 3.69938C4.09031 3.51469 4.38937 3.43031 4.67625 3.43031C4.76906 3.43031 4.8525 3.435 4.9275 3.43875C5.14781 3.44812 5.25844 3.46125 5.40375 3.80906C5.58469 4.245 6.02531 5.32125 6.07781 5.43188C6.13125 5.5425 6.18469 5.6925 6.10969 5.83781C6.03938 5.98781 5.9775 6.05437 5.86687 6.18187C5.75625 6.30937 5.65125 6.40688 5.54062 6.54375C5.43937 6.66281 5.325 6.79031 5.4525 7.01063C5.58 7.22625 6.02063 7.94531 6.66937 8.52281C7.50656 9.26812 8.18531 9.50625 8.42812 9.6075C8.60906 9.6825 8.82469 9.66469 8.95687 9.52406C9.12469 9.34313 9.33187 9.04313 9.54281 8.74781C9.69281 8.53594 9.88219 8.50969 10.0809 8.58469C10.2834 8.655 11.355 9.18469 11.5753 9.29437C11.7956 9.405 11.9409 9.4575 11.9944 9.55031C12.0469 9.64313 12.0469 10.0791 11.8659 10.5909Z" fill="currentcolor"/>
                                                </svg>
                                                                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/SkilledU24?igsh=M2Y4djB6dXVzb2xx" target="_blank">
                                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.3125 0H4.6875C2.09906 0 0 2.09906 0 4.6875V10.3125C0 12.9009 2.09906 15 4.6875 15H10.3125C12.9009 15 15 12.9009 15 10.3125V4.6875C15 2.09906 12.9009 0 10.3125 0ZM13.5938 10.3125C13.5938 12.1219 12.1219 13.5938 10.3125 13.5938H4.6875C2.87813 13.5938 1.40625 12.1219 1.40625 10.3125V4.6875C1.40625 2.87813 2.87813 1.40625 4.6875 1.40625H10.3125C12.1219 1.40625 13.5938 2.87813 13.5938 4.6875V10.3125Z" fill="currentcolor"/>
                                                <path d="M7.5 3.75C5.42906 3.75 3.75 5.42906 3.75 7.5C3.75 9.57094 5.42906 11.25 7.5 11.25C9.57094 11.25 11.25 9.57094 11.25 7.5C11.25 5.42906 9.57094 3.75 7.5 3.75ZM7.5 9.84375C6.20813 9.84375 5.15625 8.79187 5.15625 7.5C5.15625 6.20719 6.20813 5.15625 7.5 5.15625C8.79187 5.15625 9.84375 6.20719 9.84375 7.5C9.84375 8.79187 8.79187 9.84375 7.5 9.84375Z" fill="currentcolor"/>
                                                <path d="M11.5313 3.96844C11.8072 3.96844 12.031 3.74472 12.031 3.46875C12.031 3.19278 11.8072 2.96906 11.5313 2.96906C11.2553 2.96906 11.0316 3.19278 11.0316 3.46875C11.0316 3.74472 11.2553 3.96844 11.5313 3.96844Z" fill="currentcolor"/>
                                                </svg>
                                        </a>
                                    </li>
                                    <!--<li>-->
                                    <!--    <a href="#" target="_blank">-->
                                    <!--        <svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                                    <!--            <path d="M20.1075 1.58603C19.5379 0.430923 18.9197 0.218454 17.661 0.137656C16.4036 0.040399 13.2418 0 10.5026 0C7.75819 0 4.59506 0.0403991 3.339 0.13616C2.08294 0.218454 1.46344 0.429426 0.888563 1.58603C0.301875 2.73965 0 4.72668 0 8.22494C0 8.22793 0 8.22943 0 8.22943C0 8.23242 0 8.23392 0 8.23392V8.23691C0 11.7202 0.301875 13.7222 0.888563 14.8638C1.46344 16.019 2.08162 16.2284 3.33769 16.3257C4.59506 16.4095 7.75819 16.4589 10.5026 16.4589C13.2418 16.4589 16.4036 16.4095 17.6623 16.3272C18.921 16.2299 19.5392 16.0204 20.1088 14.8653C20.7008 13.7237 21 11.7217 21 8.2384C21 8.2384 21 8.23392 21 8.23092C21 8.23092 21 8.22793 21 8.22643C21 4.72668 20.7008 2.73965 20.1075 1.58603ZM7.875 12.7182V3.74065L14.4375 8.22943L7.875 12.7182Z" fill="currentcolor"/>-->
                                    <!--            </svg>-->
                                    <!--                                                    </a>-->
                                    <!--</li>-->
                                </ul>
                            </div>
                            <!-- <div class="app-download">
                                <a href="#"><img src="assets/img/others/google-play.svg" alt="img"></a>
                                <a href="#"><img src="assets/img/others/apple-store.svg" alt="img"></a>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="footer__widget">
                            <h4 class="footer__widget-title">Our Location</h4>
                            <div class="footer__link">
                                <ul class="list-wrap">
                                    <div class="contact-map contact-map-my2 mt-0">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3667.8126686437645!2d75.78882589999999!3d23.177036299999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xde22d6ed4c1dceb%3A0x386b788349ba3f7b!2sSkilled.u!5e0!3m2!1sen!2sin!4v1733901595669!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="copy-right-text">
                            <p>© 2026 <a href="index.html">Skilled.u</a> All rights reserved.</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="footer__bottom-menu">
                            <ul class="list-wrap">
                                <li><a href="#">Term of Use</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-area-end -->
 <script>
        // Check if the current URL path is '/certificate-form'
        // if (window.location.pathname === '/certificate-form') {
        //     // Redirect to the correct URL
        //     window.location.href = "https://skilledu.in/certificate-form.php";
        // }
    </script>

<script>
document.getElementById('certification_form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the form from submitting immediately

    // Get form elements
    let certificateNumber = document.getElementById('recipient-name').value.trim();
    let certificateFile = document.getElementById('certificate-name').files.length;

    // Clear previous error messages
    document.getElementById('certificate-number-error').innerText = '';
    document.getElementById('certificate-error').innerText = '';

    let isValid = true;

    // Validate Certificate Number
     if (certificateNumber === "") {
        document.getElementById('certificate-number-error').innerText = "Certificate Number is required.";
        isValid = false;
    }
    // Step 2: Validate first two digits are 'SU'
    else if (!certificateNumber.startsWith('SU')) {
        document.getElementById('certificate-number-error').innerText = "Certificate Number must start with 'SU'.";
        isValid = false;
    }
    // Step 3: Check if the part after 'SU' is at least 3 digits long
    else {
        var remainingDigits = certificateNumber.slice(2);  // Remove 'SU' from the start
        
        // Check if the remaining part has at least 3 digits
        if (remainingDigits.length < 3 || isNaN(remainingDigits.slice(0, 3))) {
            document.getElementById('certificate-number-error').innerText = "Certificate Number should have at least 3 digits after 'SU'.";
            isValid = false;
        } else {
            // Step 4: Validate total length (should be exactly 7 characters)
            if (certificateNumber.length <= 7) {
                document.getElementById('certificate-number-error').innerText = "Certificate Number should be grather than 7.";
                isValid = false;
            }
        }
    }
    

    // Validate Certificate File
    if (certificateFile === 0) {
        document.getElementById('certificate-error').innerText = "Certificate file is required.";
        isValid = false;
    }

    // If validation passes, manually submit the form
    if (isValid) {
        var form = document.getElementById('certification_form');
        form.submit();  // This triggers the form submission to "submit_certification.php"
    }
});
</script>


    <!-- JS here -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.odometer.min.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/tween-max.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/jquery.marquee.min.js"></script>
    <script src="assets/js/tg-cursor.min.js"></script>
    <script src="assets/js/vivus.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/svg-inject.min.js"></script>
    <script src="assets/js/jquery.circleType.js"></script>
    <script src="assets/js/jquery.lettering.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.all.min.js"></script>
    <script>
        SVGInject(document.querySelectorAll("img.injectable"));
    </script>
</body>

</html>