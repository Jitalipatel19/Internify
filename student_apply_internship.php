<?php
session_start();
include("student_header.php");
include("conn.php");

// Retrieve company name and position from query parameters
if(isset($_GET['company_name']) && isset($_GET['position'])) {
    $company_name = urldecode($_GET['company_name']);
    $position = urldecode($_GET['position']);
} else {
    $company_name = "";
    $position = "";
}

if(isset($_POST['btnsubmit'])) {
    // Retrieve form data
    $inm = $_POST['txtinm'];
    $erno = $_POST['txterno'];
    $email=$_POST['txtemail'];
    $edu = $_POST['txtedu'];
    $cs = $_POST['txtcs'];
    $sy = $_POST['txtsy'];
    $ey = $_POST['txtey'];
    $exp = $_POST['txtexp'];
    $ps = $_POST['txtps'];
    $cnm = $_POST['txtcnm']; // Fetch selected company name
    $pos = $_POST['txtps']; // Fetch selected position

    // Check if file is uploaded
    if(isset($_FILES['txterno'])) {
        $file_name = $_FILES['txterno']['name'];
        $file_tmp = $_FILES['txterno']['tmp_name'];

        // Create the target directory if it doesn't exist
        $target_dir = "Intern_Resume/";
        if(!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move the uploaded file to the target directory
        $target_file = $target_dir . basename($file_name);
        move_uploaded_file($file_tmp, $target_file);
    } else {
        // If file is not uploaded, you may handle this case according to your requirement
        $target_file = NULL;
    }

    // Check if the application already exists
    $res1 = mysqli_query($conn, "SELECT * FROM intern_applications_info WHERE erno='$erno'");
    if(mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Application Already Exists');";
        echo "window.location.href='stud_apply_internship.php';";
        echo "</script>";
    } else {
        //auto no code start..
        $qur1 = mysqli_query($conn, "SELECT MAX(iid) FROM intern_applications_info");
        $mid = 0;
        while($q1 = mysqli_fetch_array($qur1)) {
            $mid = $q1[0];
        }
        $mid++;
        //auto no code end..

        // Insert the application data into the database
        $query = "INSERT INTO intern_applications_info 
        (iid,sid,intern_name, erno,email ,education, current_sem, starting_year,ending_year,experiecnce,resume,position,comp_name) 
        VALUES ('$mid', '{$_SESSION['sid']}','$inm', '$erno', '$email','$edu', '$cs', '$sy','$ey','$exp','$target_file','$ps','$cnm')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'>";
            echo "alert('Internship Application Sent');";
            echo "window.location.href='student_profile.php';";
            echo "</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Apply for Internship/Job</h3>
                </div>
<form method="post" enctype="multipart/form-data">
    <div class="row g-3">
    <?php
            $sql = "select * from student_regis where sid='$_SESSION[sid]'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
            ?>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Intern Name</label>
            <input type="text" name="txtinm" class="form-control" value="<?php echo $row['name']; ?>">
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Enrollment No</label>
            <input type="text" name="txterno" class="form-control" id="txterno" value="<?php echo $row['erno']; ?>">
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Email</label>
            <input type="text" name="txtemail" class="form-control" id="txtemail" value="<?php echo $row['email']; ?>">        
        </div>
        <?php
            }
            ?>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Education</label>
            <input type="text" name="txtedu" class="form-control"value="">
        </div>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Current Sem</label>
            <input type="text" name="txtcs" class="form-control"value="">
        </div>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Starting Year</label>
            <input type="text" name="txtsy" class="form-control" value="">
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Ending Year</label>
            <input type="text" name="txtey" class="form-control"value="">
        </div>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Experience</label>
            <input type="text" name="txtexp" class="form-control" id="txtinm" value="">
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Resume</label>
            <input type="file" name="txterno" class="form-control" id="txterno" placeholder="Enrollment No">
        </div>
        
        <!-- Include the company name and position text boxes with default values -->
        <div class="col-md-6">
            <label for="txtcnm" class="form-label">Company Name</label>
            <input type="text" name="txtcnm" class="form-control" id="txtcnm" value="<?php echo $company_name; ?>" placeholder="Company Name" readonly>
        </div>
        <div class="col-md-6">
            <label for="txtps" class="form-label">Position</label>
            <input type="text" name="txtps" class="form-control" id="txtps" value="<?php echo $position; ?>" placeholder="Position" readonly>
        </div>
        <div class="col-md-6">
        <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Submit</button>
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
