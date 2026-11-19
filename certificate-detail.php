<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF);

// Database Credentials
$host     = 'localhost';                  // Production DB Host
$username = 'skilledu1_skilledu_main';    // Production DB User
$password = 'Skilledu1_skilledu_main';    // Production DB Password
$dbname   = 'skilledu1_skilledu_main';    // Production DB Name

// Initialize variables
$certificate_id = '';
$certificate_data = null;
$error_message = '';
$pdf_missing_message = '';

$conn = @new mysqli($host, $username, $password, $dbname);

if ($conn->connect_errno) {
    error_log("Database Connection Failed: " . $conn->connect_error);
}

// Handle the form data after it's posted
if (($_SERVER['REQUEST_METHOD'] ?? '') == 'POST') {
    if ($conn->connect_errno) {
        $error_message = 'Verification service is temporarily unavailable. Please try again later.';
    } else {
        $certificate_id = strtoupper(trim($_POST['certificate_id'] ?? ''));

        // Fetch data from database using prepared statement
        if (!empty($certificate_id)) {
            $stmt = $conn->prepare("SELECT * FROM certifications WHERE certificate_id = ?");
            if ($stmt) {
                $stmt->bind_param("s", $certificate_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    // Fetch the real record from MySQL database
                    $row = $result->fetch_assoc();
                    $pdf_file_path = __DIR__ . '/' . ($row['pdf'] ?? '');

                    if (!empty($row['pdf']) && file_exists($pdf_file_path)) {
                        // Valid ID + PDF exists on disk
                        $certificate_data = $row;
                        $certificate_data['is_demo'] = false;
                    } else {
                        // Valid ID in DB, but PDF is missing
                        $certificate_data = null;
                        $pdf_missing_message = "Certificate PDF Unavailable: This certificate was verified in our database, but the certificate PDF document is currently unavailable.";
                    }
                } else {
                    // Invalid ID: hide PDF viewer and show Certificate Not Found
                    $certificate_data = null;
                    $error_message = "No certificate found with ID: $certificate_id";
                }
                $stmt->close();
            } else {
                $certificate_data = null;
                $error_message = 'Verification service is temporarily unavailable. Please try again later.';
            }
        } else {
            $certificate_data = null;
            $error_message = "Please enter a certificate ID.";
        }
    }
} else {
    // Default DEMO certificate preview using New-Update-Certificate.png
    // Note: Ritik Sahu's PDF/photo is removed completely
    $certificate_data = [
        'image' => 'assets/img/New-Update-Certificate.png',
        'is_demo' => true
    ];
}

// Close the database connection
if ($conn && !$conn->connect_errno) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Verify Certificate Credentials Online | SkillEdU Registry</title>
  <meta name="description" content="Instant online credential verification for SkillEdU graduates. Validate authentic completion certificates, internship transcripts, and skill assessments.">
  <link rel="canonical" href="https://skilledu.in/certificate-detail.php">
  
  <!-- Open Graph / Social Media Meta -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="SkillEdU Academy">
  <meta property="og:title" content="Verify Certificate Credentials Online | SkillEdU Registry">
  <meta property="og:description" content="Instant online credential verification for SkillEdU graduates. Validate authentic completion certificates, internship transcripts, and skill assessments.">
  <meta property="og:url" content="https://skilledu.in/certificate-detail.php">
  <meta property="og:image" content="https://skilledu.in/assets/img/logo/skilledU_Logo.png">

  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Verify Certificate Credentials Online | SkillEdU Registry">
  <meta name="twitter:description" content="Instant online credential verification for SkillEdU graduates. Validate authentic completion certificates, internship transcripts, and skill assessments.">
  <meta name="twitter:image" content="https://skilledu.in/assets/img/logo/skilledU_Logo.png">
    <meta name="keywords" content="education, future skills, programming, coding, skill development, HTML, CSS, ReactJS, in Ujjain, full stack development course, website development course, mobile app development">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon/skilledU_Icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <!-- Font Awesome 4.7 (consistent header fa fa-phone icon matching index.html & all pages) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon-skillgro.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default-icons.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/spacing.css">
    <link rel="stylesheet" href="assets/css/tg-cursor.css">
  <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/my_css.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Add SweetAlert2 JS before the closing head tag -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.10/dist/sweetalert2.all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

    <style>
    :root {
        --tg-body-font-family: 'Inter', sans-serif;
        --tg-heading-font-family: 'Poppins', sans-serif;
    }

    .tg-header__top,
    .tg-header__top-info,
    .tg-header__top-info li,
    .tg-header__top-info li span,
    .tg-header__top-info li a,
    .tg-header__phone,
    .tg-header__phone a,
    .tg-header__top-social,
    .tg-header__top-social li {
        font-family: 'Inter', sans-serif !important;
        font-weight: 500 !important;
    }

    .tgmenu__navbar-wrap ul.navigation > li > a,
    .tgmenu__main-menu ul li a,
    .mobile-menu .navigation li a {
        font-family: 'Poppins', sans-serif !important;
        font-weight: 700 !important;
    }

    .tg-header__area .header-btn .btn,
    .tgmenu__action .header-btn .btn,
    .header-btn.login-btn a {
        background: var(--tg-theme-secondary, #ffc224) !important;
        color: var(--tg-heading-color, #161439) !important;
    }

    .tg-header__area .header-btn .btn:hover,
    .tgmenu__action .header-btn .btn:hover,
    .header-btn.login-btn a:hover {
        background: var(--tg-theme-primary, #0b66c3) !important;
        color: var(--tg-common-color-white, #ffffff) !important;
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        #sticky-header .col-12 {
            margin-top: 0 !important;
        }

        #sticky-header .tgmenu__nav {
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        #sticky-header .tgmenu__action {
            display: none;
        }
    }

    /* ===================================================
       Skilled.u Certificate Detail - Original Theme Styling
       =================================================== */

    .certification-area {
        padding: 60px 0 80px;
        background: #fbfbfd;
    }

    .certification-form-wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 36px 32px;
        box-shadow: 0 6px 30px rgba(12, 27, 51, 0.06);
        border: 1px solid #eef2f6;
        position: -webkit-sticky;
        position: sticky;
        top: 95px;
        z-index: 10;
    }

    .su-form-box {
        text-align: left;
    }

    .su-verify-title {
        font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);
        font-size: 1.85rem;
        font-weight: 700;
        color: #0c1b33;
        margin-bottom: 6px;
    }

    .su-verify-subtitle {
        font-size: 0.95rem;
        color: var(--tg-body-color);
        margin-bottom: 22px;
        line-height: 1.5;
    }

    .su-form-label {
        font-weight: 600;
        color: #0c1b33;
        font-size: 0.95rem;
        margin-bottom: 8px;
    }

    .su-input-wrapper {
        position: relative;
        width: 100%;
    }

    .su-input-field {
        width: 100%;
        height: 52px;
        padding: 0 20px;
        font-size: 1rem;
        font-weight: 600;
        font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #0c1b33;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        outline: none;
        transition: all 0.25s ease;
    }

    .su-input-field:focus {
        border-color: #0b66c3;
        box-shadow: 0 0 0 3px rgba(11, 102, 195, 0.15);
    }

    .su-btn-search {
        height: 52px;
        padding: 0 28px;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);
        color: #ffffff;
        background: #0b66c3;
        border: none;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        box-shadow: 4px 6px 0px 0px #0c1b33;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .su-btn-search:hover {
        background: #ffc224;
        color: #0c1b33;
        box-shadow: 0 0 0 0 #0c1b33;
        transform: translateY(-2px);
    }

    .su-input-error {
        background: #fff5f5;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 8px;
        margin-top: 10px;
        text-align: left;
        display: none;
    }

    /* Invalid Certificate Error */
    .su-error-alert {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 14px 18px;
        margin-top: 20px;
        text-align: left;
        animation: suFadeIn 0.3s ease-out;
    }

    /* Simplified Success Banner */
    .su-success-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        padding: 18px 22px;
        text-align: center;
        animation: suFadeIn 0.35s ease-out;
    }

    .su-verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #10b981;
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 8px;
    }

    .su-success-title {
        font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);
        font-size: 1.45rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 4px;
    }

    .su-success-desc {
        font-size: 0.92rem;
        color: #047857;
        margin-bottom: 0;
    }

    /* Certificate Viewer Card (Right Column) */
    .certificate-container {
        width: 100%;
        margin: 0 auto;
    }

    .su-viewer-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #eef2f6;
        box-shadow: 0 6px 30px rgba(12, 27, 51, 0.06);
        padding: 20px;
        text-align: center;
    }

    .su-canvas-frame {
        position: relative;
        width: 100%;
        background: #f8fafc;
        border-radius: 14px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 380px;
    }

    #pdfViewer {
        max-width: 540px !important;
        width: 100% !important;
        height: auto !important;
        display: none;
        margin: 0 auto;
        border-radius: 10px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }

    .loader-pdf {
        width: 40px;
        height: 40px;
        border: 3px solid #e2e8f0;
        border-top-color: #0b66c3;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: suSpin 0.9s linear infinite;
    }

    .su-download-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0b66c3;
        color: #ffffff !important;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);
        padding: 12px 30px;
        border-radius: 50px;
        box-shadow: 4px 6px 0px 0px #0c1b33;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .su-download-btn:hover {
        background: #ffc224;
        color: #0c1b33 !important;
        box-shadow: 0 0 0 0 #0c1b33;
        transform: translateY(-2px);
    }

    .footer__content .list-wrap li a.f_contact {
        color: #ffc224 !important;
    }

    .footer__content .list-wrap li a.f_contact:hover {
        color: #1c1ab8 !important;
    }

    @keyframes suSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes suFadeIn {
        0% { opacity: 0; transform: translateY(-8px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991px) {
        .certification-area {
            padding: 40px 0 60px;
        }
        .certification-form-wrapper {
            position: static;
            padding: 26px 20px;
            margin-bottom: 24px;
        }
        .su-verify-title {
            font-size: 1.5rem;
        }
        .su-viewer-card {
            padding: 16px 12px;
        }
    }
    
    /* Fix 7: Full width certificate search button with 10px top margin below 576px using ID specificity without !important */
    @media (max-width: 576px) {
        #search_certificate .su-btn-search,
        .su-btn-search {
            width: 100%;
            margin-top: 10px;
            display: flex;
        }
    }

</style>
  <!-- Schema.org Structured Data -->
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Verify Certificate Credentials Online | SkillEdU Registry",
  "description": "Instant online credential verification for SkillEdU graduates. Validate authentic completion certificates, internship transcripts, and skill assessments.",
  "url": "https://skilledu.in/certificate-detail.php"
}
  </script>
</head>
<body>
    <div id="preloader">
      <div id="loader" class="loader">
        <div class="loader-container">
          <div class="loader-icon">
            <img src="assets/img/logo/skilledU_Logo.png" alt="Preloader" />
          </div>
        </div>
      </div>
    </div>
      <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html" aria-label="Scroll to top of page">
      <i class="tg-flaticon-arrowhead-up"></i>
    </button>
    <!-- Scroll-top-end-->

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
                                <li><a href="https://www.facebook.com/profile.php?id=61556212776038&sfnsn=wa" aria-label="SkillEdU on Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank" ><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/skilled-u/" aria-label="SkillEdU on LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://www.instagram.com/skilled.u_" aria-label="SkillEdU on Instagram"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-header__area py-1" style="height: 81px;">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12" style="margin-top: -13px;">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="logo">
                                    <a href="index.html"><img src="assets/img/logo/skilledU_Logo.png" alt="Logo"></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__navbar-wrap-my tgmenu__main-menu d-none d-xl-flex" style="margin-top: 10px;">
                                    <ul class="navigation">
                                        <li class="menu-item">
                                            <a href="index.html">Home</a>
                                        </li>
                                        <li class="menu-item"><a href="all-courses.html">All Courses</a></li>
                                        <li class="menu-item">
                                            <a href="contact.html">Contact US</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="sms.html">SMS</a>
                                        </li>
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
                                            <a href="tel:+918989099962" class="btn"> <i class="fa fa-phone px-2"></i>Call Us</a>
                                        </li>
                                        
                                        <li class="header-btn login-btn">
                                            <a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank"  class="btn"><i class="fab fa-whatsapp px-2"></i>whatsApp Us</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                                <div class="mobile-nav-toggler" role="button" tabindex="0" aria-label="Toggle navigation menu"><i class="tg-flaticon-menu-1"></i></div>
                            </nav>
                        </div>
                        <!-- Mobile Menu  -->
                        <div class="tgmobile__menu">
                            <nav class="tgmobile__menu-box">
                                <div class="close-btn" role="button" tabindex="0" aria-label="Close navigation menu"><i class="tg-flaticon-close-1"></i></div>
                                <div class="nav-logo"><a href="index.html"><img src="assets/img/logo/skilledU_Logo.png" alt="Logo"></a>
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
                                        <li><a href="https://www.facebook.com/profile.php?id=61556212776038&sfnsn=wa" aria-label="SkillEdU on Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://wa.me/+918989099962?text=I%20want%20to%20code" target="_blank" ><i class="fab fa-whatsapp"></i></a></li>
                                        <li><a href="https://www.instagram.com/SkilledU24?igsh=M2Y4djB6dXVzb2xx" aria-label="SkillEdU on Instagram"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="https://www.linkedin.com/company/skilled-u/" aria-label="SkillEdU on LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
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
    <section class="breadcrumb__area breadcrumb__bg bread_bg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb__content">
                            <h3 class="title">Certificate Details</h3>
                            <nav class="breadcrumb">
                                <span property="itemListElement" typeof="ListItem">
                                    <a href="index.html">Home</a>
                                </span>
                                <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span>
                                <span property="itemListElement" typeof="ListItem">Certificate Details</span>
                             
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="breadcrumb__shape-wrap">
                <img src="assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">
                <img src="assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300" class="aos-init aos-animate">
                <img src="assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400" class="aos-init aos-animate">
                <img src="assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">
                <img src="assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400" class="aos-init aos-animate">
            </div>
        </section>
    <section id="certification-form" class="certification-area">
        <div class="container">
            <?php
            $isDemo = !empty($certificate_data['is_demo']);
            $isVerified = ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error_message) && empty($pdf_missing_message) && !empty($certificate_data['student_name']) && !$isDemo && !empty($certificate_data['pdf']));
            $showViewer = empty($error_message) && empty($pdf_missing_message) && (!empty($certificate_data['pdf']) || !empty($certificate_data['image']));
            ?>

            <div class="row align-items-stretch justify-content-center">
                
                <!-- Left Column: Search & Verification Status -->
                <div class="<?php echo $showViewer ? 'col-lg-5 col-md-6 mb-4 mb-md-0' : 'col-lg-7 col-md-9'; ?>">
                    <div class="certification-form-wrapper">
                        
                        <!-- Simplified Success UI (when verified) -->
                        <?php if ($isVerified): ?>
                        <div class="su-success-banner mb-4" id="verifiedBanner">
                            <span class="su-verified-badge">
                                <i class="fas fa-check-circle me-1"></i> AUTHENTICATED & VALID
                            </span>
                            <h3 class="su-success-title">
                                Congratulations! 🎉
                            </h3>
                            <p class="su-success-desc">
                                This certificate has been successfully verified by Skilled.u.
                            </p>
                        </div>
                        <?php endif; ?>

                        <div class="su-form-box">
                            <h1 class="su-verify-title">Official Student Certificate Verification Registry</h1>
                            <p class="su-verify-subtitle">Enter your Certificate ID to check your certificate status and view your verified credential.</p>

                            <!-- Form to submit certificate_id -->
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? ''); ?>" id="search_certificate">
                                <div class="mb-3 form-group">
                                    <label for="certificate_id" class="form-label su-form-label">Certificate ID</label>
                                    <div class="su-input-wrapper">
                                        <input type="text" class="form-control su-input-field" id="certificate_id" name="certificate_id" placeholder="Enter your Certificate ID" value="<?php echo htmlspecialchars($certificate_id ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" spellcheck="false">
                                    </div>
                                    <div id="certificate_id_error" class="su-input-error"></div>
                                </div>
                                <button type="submit" class="su-btn-search w-100">
                                    <i class="fas fa-search me-1"></i> Check Certificate Status
                                </button>
                            </form>

                            <!-- Invalid Certificate UI (matches SkilledU branding) -->
                            <?php if (!empty($error_message)): ?>
                            <div class="su-error-alert mt-4" id="serverErrorMessage">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 1.2rem;"></i>
                                        <div>
                                            <strong style="color: #991b1b; font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);">Certificate Not Found:</strong>
                                            <div style="color: #7f1d1d; font-size: 0.9rem;"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="retrySearch()" style="border-radius: 50px; font-weight: 600; padding: 4px 14px; font-size: 0.85rem;">
                                        <i class="fas fa-redo-alt me-1"></i> Try Again
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Valid ID but Missing PDF UI -->
                            <?php if (!empty($pdf_missing_message)): ?>
                            <div class="su-error-alert mt-4" id="missingPdfMessage" style="background: #fffbeb; border-color: #fde68a;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 1.25rem;"></i>
                                        <div>
                                            <strong style="color: #92400e; font-family: var(--tg-heading-font-family, 'Poppins', sans-serif);">Certificate PDF Unavailable:</strong>
                                            <div style="color: #78350f; font-size: 0.9rem;"><?php echo htmlspecialchars($pdf_missing_message, ENT_QUOTES, 'UTF-8'); ?></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-warning text-dark" onclick="retrySearch()" style="border-radius: 50px; font-weight: 600; padding: 4px 14px; font-size: 0.85rem;">
                                        <i class="fas fa-redo-alt me-1"></i> Try Again
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Informational feature tags to balance initial state -->
                            <div class="su-trust-features mt-4 pt-3 border-top">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2 text-muted">
                                            <i class="fas fa-shield-alt text-primary"></i>
                                            <small style="font-size: 0.82rem; font-weight: 500;">Official Registry</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2 text-muted">
                                            <i class="fas fa-file-pdf text-danger"></i>
                                            <small style="font-size: 0.82rem; font-weight: 500;">Instant PDF View</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Column: Certificate Preview (Hidden on Invalid ID or Missing PDF) -->
                <?php if ($showViewer): ?>
                <div class="col-lg-7 col-md-6" id="certificateViewerSection">
                    <div class="certificate-container">
                        <div class="su-viewer-card">
                            
                            <!-- Viewer Header -->
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
                                <div style="font-family: var(--tg-heading-font-family, 'Poppins', sans-serif); font-size: 1.05rem; font-weight: 700; color: #0c1b33;">
                                    <i class="fas fa-file-contract <?php echo $isVerified ? 'text-primary' : 'text-muted'; ?> me-1"></i>
                                    <?php echo $isVerified ? 'Verified Certificate Document' : 'Certificate Preview [SAMPLE]'; ?>
                                </div>
                                <div>
                                    <?php if ($isVerified): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-weight: 600; padding: 5px 12px; border-radius: 50px;">
                                            <i class="fas fa-check-circle me-1"></i> Authenticated Copy
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border" style="font-weight: 600; padding: 5px 12px; border-radius: 50px;">
                                            <i class="fas fa-eye me-1"></i> Sample Preview
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="su-canvas-frame">
                                <?php if ($isDemo): ?>
                                    <img id="demoCertificateImg" src="assets/img/New-Update-Certificate.png" onerror="this.onerror=null; this.src='demo-certificate.png';" alt="Demo Certificate" class="img-fluid rounded" style="max-width: 540px; width: 100%; height: auto; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08); display: block; margin: 0 auto;">
                                <?php else: ?>
                                    <!-- Loader: Hidden on initial demo display; shows only while an actual PDF loads -->
                                    <div id="loaderpg" style="display: none; flex-direction: column; align-items: center; justify-content: center; gap: 10px; padding: 40px 0;">
                                        <span class="loader-pdf"></span>
                                        <span style="font-size: 0.88rem; color: var(--tg-body-color); font-weight: 500;">Loading verified certificate...</span>
                                    </div>

                                    <canvas id="pdfViewer"></canvas>

                                    <!-- In-line PDF fallback error (no browser alerts) -->
                                    <div id="pdfErrorNotice" style="display: none; padding: 20px; color: #991b1b; text-align: center;">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-2 text-danger"></i>
                                        <h5>Certificate PDF could not be displayed</h5>
                                        <p class="mb-2" style="font-size: 0.9rem;">You can try downloading the certificate file directly below.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Download PDF Button (Shown ONLY for verified certificates, NEVER for demo) -->
                            <?php if ($isVerified && !empty($certificate_data['pdf'])): ?>
                            <div class="text-center mt-3">
                                <a href="<?php echo htmlspecialchars($certificate_data['pdf'], ENT_QUOTES, 'UTF-8'); ?>" class="su-download-btn" download>
                                    <i class="fas fa-file-download me-1"></i> Download PDF
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Confetti Overlay Canvas -->
    <canvas id="suConfettiCanvas" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 99999; display: none;"></canvas>
    
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
                                                  <li><a href="certificate-detail.php">Verify Certificate</a></li>
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
                                     <li><a href="https://www.linkedin.com/company/skilled-u/" aria-label="SkillEdU on LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
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
                            <p>© 2024 <a href="index.html">Skilled.u</a> All rights reserved.</p>
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
    <script src="assets/js/main.js"></script>
    <script>
      SVGInject(document.querySelectorAll("img.injectable"));
    </script>
<script>
// JavaScript validation function (client-side, no browser alerts)
document.getElementById('search_certificate').onsubmit = function(event) {
    var errBox = document.getElementById("certificate_id_error");
    if (errBox) {
        errBox.innerHTML = '';
        errBox.style.display = 'none';
    }
    
    var certificateInput = document.getElementById("certificate_id");
    var certificateId = (certificateInput ? certificateInput.value : '').trim().toUpperCase();
    if (certificateInput) {
        certificateInput.value = certificateId;
    }

    var isValid = true;
    var errorMessage = '';

    if (certificateId === "") {
        errorMessage = "Please enter your Certificate ID.";
        isValid = false;
    } else if (certificateId.substring(0, 2) !== "SU") {
        errorMessage = "Certificate ID must start with 'SU' (e.g., SU1012024).";
        isValid = false;
    } else if (!/^\d{3}/.test(certificateId.substring(2))) {
        errorMessage = "After 'SU', your batch digits are required (e.g., SU1012024).";
        isValid = false;
    } else if (certificateId.length < 7) {
        errorMessage = "Certificate ID must be at least 7 characters long.";
        isValid = false;
    }

    if (!isValid) {
        if (errBox) {
            errBox.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i> ' + errorMessage;
            errBox.style.display = 'block';
        }
        event.preventDefault();
    }
};

function retrySearch() {
    var input = document.getElementById('certificate_id');
    if (input) {
        input.focus();
        input.select();
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Subtle lightweight pure JS confetti animation
function triggerSubtleConfetti() {
    var canvas = document.getElementById('suConfettiCanvas');
    if (!canvas) return;
    canvas.style.display = 'block';
    var ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    var colors = ['#0b66c3', '#ffc224', '#10b981', '#38bdf8', '#0c1b33'];
    var particles = [];
    for (var i = 0; i < 55; i++) {
        particles.push({
            x: window.innerWidth * (0.35 + Math.random() * 0.3),
            y: window.innerHeight * 0.35,
            vx: (Math.random() - 0.5) * 10,
            vy: (Math.random() - 0.75) * 8,
            size: Math.random() * 6 + 4,
            color: colors[Math.floor(Math.random() * colors.length)],
            rotation: Math.random() * 360,
            rotSpeed: (Math.random() - 0.5) * 6,
            alpha: 1
        });
    }

    var startTime = Date.now();
    function animate() {
        var elapsed = Date.now() - startTime;
        if (elapsed > 1800) {
            canvas.style.display = 'none';
            return;
        }
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(function(p) {
            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.22;
            p.rotation += p.rotSpeed;
            if (elapsed > 1000) {
                p.alpha = Math.max(0, 1 - (elapsed - 1000) / 800);
            }
            ctx.save();
            ctx.globalAlpha = p.alpha;
            ctx.translate(p.x, p.y);
            ctx.rotate((p.rotation * Math.PI) / 180);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
            ctx.restore();
        });
        requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);
}

// PDF.js worker configuration
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

var isDemo = <?php echo (!empty($certificate_data['is_demo'])) ? 'true' : 'false'; ?>;
var isPost = <?php echo ($_SERVER['REQUEST_METHOD'] === 'POST') ? 'true' : 'false'; ?>;
var url = "<?php echo (!empty($certificate_data['pdf']) && empty($certificate_data['is_demo'])) ? htmlspecialchars($certificate_data['pdf'], ENT_QUOTES, 'UTF-8') : ''; ?>";

var loader = document.getElementById('loaderpg');
var canvas = document.getElementById('pdfViewer');
var errorNotice = document.getElementById('pdfErrorNotice');

if (canvas && url) {
    if (loader) {
        loader.style.display = 'flex';
        canvas.style.display = 'none';
    }

    pdfjsLib.getDocument(encodeURI(url)).promise
        .then(function (pdfDoc) {
            return pdfDoc.getPage(1);
        })
        .then(function (page) {
            var context = canvas.getContext('2d');
            var viewport = page.getViewport({ scale: 1.5 });

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            return page.render({
                canvasContext: context,
                viewport: viewport
            }).promise;
        })
        .then(function () {
            if (loader) loader.style.display = 'none';
            canvas.style.display = 'block';
        })
        .catch(function (error) {
            console.error("PDF loading/rendering error:", error);
            if (loader) loader.style.display = 'none';
            canvas.style.display = 'none';
            if (errorNotice) {
                errorNotice.style.display = 'block';
            }
        });
} else {
    if (loader) loader.style.display = 'none';
    if (canvas) canvas.style.display = 'none';
}

<?php if (isset($isVerified) && $isVerified): ?>
document.addEventListener('DOMContentLoaded', function() {
    triggerSubtleConfetti();
    var banner = document.getElementById('verifiedBanner');
    if (banner) {
        banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});
<?php endif; ?>

<?php if (!empty($error_message)): ?>
Swal.fire({
    icon: 'error',
    text: <?php echo json_encode($error_message, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true
});
<?php endif; ?>
</script>

</body>
</html>
