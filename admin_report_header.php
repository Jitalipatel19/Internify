<?php
include("conn.php"); // Include database connection if not already included

// Function to generate PDF, Excel, and Print links
function generateLinks() {
    $links = "
        
        <a href='javascript:window.print()' class='nav-item nav-link'>Print</a> 
    ";
    return $links;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Carousel Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
            <a href="index.html" class="navbar-brand p-0">
                <h1 class="m-0"><i class="fa fa-user-tie me-2"></i>Internify</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.html" class="nav-item nav-link active">Home</a>
                    <?php echo generateLinks(); ?> 
                   
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Reports</a>
                        <div class="dropdown-menu m-0">
                            <a href="admin_view_student_report.php" class="dropdown-item">All Students</a>
                            <a href="admin_view_faculty_report.php" class="dropdown-item">All Faculties</a>
                            <a href="admin_view_internship.php" class="dropdown-item">All Internships</a>
                            <a href="admin_view_company.php" class="dropdown-item">All Companies</a>
                            <a href="admin_view_studentwise_project.php" class="dropdown-item">Studentwise Projects</a>
                            <a href="admin_guidewise_report.php" class="dropdown-item">Guidewise Info</a>
                            <a href="admin_view_facultywise_score.php" class="dropdown-item">Guidewise Score</a>
                            <a href="admin_view_compamywise_vacancies.php" class="dropdown-item">Companywise Vacancies</a>
                        </div>
                    </div>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                </div>
                
            </div>
            
        </nav>
        <div class="container-fluid bg-primary py-5 bg-header" style="margin-bottom: 80px;">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-4 text-white animated zoomIn"></h1>
                    <a href="" class="h5 text-white">Admin</a>
                    <i class="far fa-circle text-white px-2"></i>
                    <a href="" class="h5 text-white">Admin Tasks</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
