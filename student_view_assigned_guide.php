<?php
session_start();
include("student_header.php");
include("conn.php");

// Initialize variables
$guideName = "";
$email = "";
$contactNo = "";

// Check if $_SESSION['sid'] is set
if(isset($_SESSION['sid'])) {
    // Fetch the guide name based on the current student's ID
    $sql = "SELECT g.gnm FROM assigned_guide_info AS g 
            INNER JOIN student_regis AS s ON g.aid = s.sid
            WHERE s.sid= '{$_SESSION['sid']}'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Store the guide name in $guideName variable
        $guideName = $row['gnm'];
        
        // Fetch email and contact number based on guide name
        $sqlFaculty = "SELECT email, mno FROM faculty_regis WHERE name = '$guideName'";
        $resultFaculty = $conn->query($sqlFaculty);
        if ($resultFaculty && $resultFaculty->num_rows > 0) {
            $rowFaculty = $resultFaculty->fetch_assoc();
            // Store email and contact number in variables
            $email = $rowFaculty['email'];
            $contactNo = $rowFaculty['mno'];
        } else {
            echo "No information found for the guide: $guideName.";
        }
    } else {
        echo "No assigned guide found for the current student.";
    }
} else {
    // Handle the case when $_SESSION['sid'] is not set
    echo "Session variable 'sid' is not set.";
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Assigned Guide Info</h3>
                </div>
                
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="txtgnm">Guide Name</label>
                            <input type="text" name="txterno" class="form-control" value="<?php echo $guideName; ?>" >
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtemail">Email</label>
                            <input type="text" name="txtemail" class="form-control" value="<?php echo $email; ?>" >
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtcno">Contact No</label>
                            <input type="text" name="txtcno" class="form-control" value="<?php echo $contactNo; ?>" >
                        </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
