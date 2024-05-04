<?php
session_start();
include("admin_header.php");
include("conn.php");
$student_name ='';
$enrollment_no ='';
$company_name ='';
$project_title = '';
if(isset($_GET['sid'])) {
    $sid = $_GET['sid'];
    $student_name = $_GET['name'];
    $enrollment_no = $_GET['eno'];
    $company_name = $_GET['cname'];
    $project_title = $_GET['ptitle'];
}

if(isset($_POST['btnsubmit'])) 
{
    $erno = $_POST['txterno'];
    $snm = $_POST['txtsnm'];
    $pt = $_POST['txtpt'];
    $cnm = $_POST['txtcnm'];
    $gnm = $_POST['txtgnm'];
   
    // Check if the company already exists
    $res1 = mysqli_query($conn, "SELECT * FROM assigned_guide_info WHERE erno='$erno'");
    if(mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Already Assigned Guide');";
        echo "window.location.href='admin_assign_guide.php';";
        echo "</script>";
    } else {
        // Get the maximum cid and increment it for the new company
        $qur1 = mysqli_query($conn, "SELECT MAX(aid) FROM assigned_guide_info ");
        $q1 = mysqli_fetch_array($qur1);
        $mid = $q1[0] + 1;
    
        // Insert company details into the database
        $query = "INSERT INTO assigned_guide_info (aid, erno, snm, prj_title, comp_name, gnm) 
                  VALUES ('$mid', '$erno', '$snm', '$pt', '$cnm', '$gnm')";
        if(mysqli_query($conn, $query)) {
            // Send email to student only
            $student_email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM student_regis WHERE erno='$erno'"))['email'];
            $student_msg = "Dear $snm,<br><br>Your project '$pt' has been assigned to $gnm.<br><br>Regards,<br>Admin";
            smtp_mailer($student_email, 'Project Assignment', $student_msg);
            
            echo "<script type='text/javascript'>";
            echo "alert('Assigned Project detail');";
            echo "window.location.href='admin_assign_guide.php';";
            echo "</script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn); // Display error if query fails
        }
    }
}
function smtp_mailer($to, $subject, $msg) {
    include('smtp/PHPMailerAutoload.php');

    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2; // Enable debugging
    $mail->Username = "jitalipatel120@gmail.com";
    $mail->Password = "avqu huju ryes aoph";
    $mail->SetFrom("jitalipatel120@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if(!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}
?>

<!--Faculty Registration Form Start -->
<div class="bg-light rounded p-5">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">Assign Guide</h3>
    </div>
    <form method="post">
        <div class="row g-3 owl">
            <div class="col-12 col-sm-6">
                <label for="">Enrollment No</label>
                <input type="text" name="txterno" class="form-control bg-white border-0" value="<?php echo $enrollment_no; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Student Name</label>
                <input type="text" name="txtsnm" class="form-control bg-white border-0" value="<?php echo $student_name; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Project Title</label>
                <input type="text" name="txtpt" class="form-control bg-white border-0" value="<?php echo $project_title; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Company Name</label>
                <input type="text" name="txtcnm" class="form-control bg-white border-0" value="<?php echo $company_name; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
    <label for="">Guide Name</label>
    <select name="txtgnm" class="form-control bg-white border-0" style="height: 45px;">
        <option value="" disabled selected>Select Guide Name</option>
        <?php 
        $select_guides = "SELECT name FROM `faculty_regis`";
        $qry_guides = mysqli_query($conn, $select_guides);
        while ($guide_assoc = mysqli_fetch_assoc($qry_guides)) {
            ?>
            <option value="<?php echo $guide_assoc['name']?>"><?php echo $guide_assoc['name'];?></option>  
        <?php
        }
        ?>
    </select>
</div>
            <div class="col-12 col-6">
                <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
<!-- Faculty Registration Form End -->

<?php
include("footer.php");
?>