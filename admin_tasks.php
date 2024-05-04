<?php
include("admin_header.php");
include("conn.php");

// Function to execute SQL query and fetch count
function getCount($status) {
    global $conn; // Assuming $conn is your database connection

    // For 'total', do not filter by status
    if ($status === 'total') {
        $sql = "SELECT COUNT(*) AS count FROM intern_applications_info";
    } else {
        // Filter by status
        $sql = "SELECT COUNT(*) AS count FROM intern_applications_info WHERE application_status = '$status'";
    }
    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Query execution failed
        echo "Error: " . mysqli_error($conn);
        return 0; // Return 0 as count
    }

    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Fetch counts
$totalInternships = getCount('total');
$pendingInternships = getCount('pending'); // Corrected from 'approved' to 'pending'
$approvedInternships = getCount('approved');

?>

 <!-- Facts Start -->
 <div class="container-fluid facts py-5 pt-lg-0">
    <div class="container py-5 pt-lg-0">
        <div class="row gx-0">
            <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s">
                <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                    <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                        <i class="fa fa-users text-primary"></i>
                    </div>
                    <div class="ps-4">
                        <h5 class="text-white mb-0">Total Internships</h5>
                        <h1 class="text-white mb-0" data-toggle="counter-up"><?php echo $totalInternships; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 wow zoomIn" data-wow-delay="0.3s">
                <div class="bg-light shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                    <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                       
                    </div>
                    <div class="ps-4">
                        <h5 class="text-primary mb-0">Pending Internships</h5>
                        <h1 class="mb-0" data-toggle="counter-up"><?php echo $pendingInternships; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 wow zoomIn" data-wow-delay="0.6s">
                <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                    <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                    <i class="fa fa-check text-primary"></i>
                    </div>
                    <div class="ps-4">
                        <h5 class="text-white mb-0">Approved Internships</h5>
                        <h1 class="text-white mb-0" data-toggle="counter-up"><?php echo $approvedInternships; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facts Start -->

<?php
include("footer.php");
?>
