<?php
session_start();
include("student_header.php");
include("conn.php");

// Include PHPMailer library
include('smtp/PHPMailerAutoload.php');

// Fetching profile picture filename from student_regis table
$sql_profile_pic = "SELECT profile FROM student_regis WHERE sid = '$_SESSION[sid]'";
$result_profile_pic = $conn->query($sql_profile_pic);
$profile_pic = "";
if ($result_profile_pic->num_rows > 0) {
    $row_profile_pic = $result_profile_pic->fetch_assoc();
    $profile_pic = $row_profile_pic['profile'];
}

// Fetching NOC application status from noc_info table
$sql_noc = "SELECT status FROM noc_info WHERE erno = (SELECT erno FROM student_regis WHERE sid = '$_SESSION[sid]')";
$result_noc = $conn->query($sql_noc);
$noc_status = "";
if ($result_noc->num_rows > 0) {
    $row_noc = $result_noc->fetch_assoc();
    $noc_status = $row_noc['status'];
}
// Fetching Internship application status from intern_applications_info table
$sql_internship = "SELECT application_status FROM intern_applications_info WHERE erno = (SELECT erno FROM student_regis WHERE sid = '$_SESSION[sid]')";
$result_internship = $conn->query($sql_internship);
$internship_status = "";
if ($result_internship->num_rows > 0) {
    $row_internship = $result_internship->fetch_assoc();
    $internship_status = $row_internship['application_status'];
}

// Process form submission
if(isset($_POST['btnsubmit'])) {
    // Handle profile picture update
    if($_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['profilePic']['name'];
        $target_dir = "student_profile/";
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);

        if(move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            // Update profile picture filename in database
            $update_profile_pic = "UPDATE student_regis SET profile = '$img' WHERE sid = '$_SESSION[sid]'";
            $conn->query($update_profile_pic);
            // Update profile_pic variable to reflect the new profile picture
            $profile_pic = $img;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Handle other profile updates
    $name = $_POST['txtnm'];
    $erno = $_POST['txterno'];
    $email = $_POST['txtemail'];
    $mno = $_POST['txtmno'];
    
    // Update name, enrollment number, email, and mobile number in the student_regis table
    $update_profile_info = "UPDATE student_regis SET name = '$name', erno = '$erno', email = '$email', mno = '$mno' WHERE sid = '$_SESSION[sid]'";
    if ($conn->query($update_profile_info) === TRUE) {
        // Email sending logic
        $subject = "Profile Updated";
        $message = "Your profile has been successfully updated.";
        $result = smtp_mailer($email, $subject, $message); // Send the email
        if ($result === 'Sent') {
            // Display alert and redirect
            echo "<script>alert('Student Profile Updated Successfully.');</script>";
            echo "<script>window.location.href='student_profile.php';</script>";
        } else {
            echo "Error sending email.";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Function to send email
function smtp_mailer($to, $subject, $msg) {
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 
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
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <form method="post" enctype="multipart/form-data"> <!-- enctype for file upload -->
                    <div class="row g-3">
                        <div class="col-12 text-center">
                            <!-- Profile Picture Input -->
                            <label for="profilePic" class="form-label">Profile Picture</label>
                            <img id="preview" src="<?php echo $profile_pic ? 'student_profile/' . $profile_pic : 'img/about.jpg'; ?>" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover; display: block; margin: 0 auto;">
                            <input type="file" class="form-control mt-2" id="profilePic" name="profilePic" accept="image/*" onchange="previewImage(event)" style="width: 245px; margin: 0 auto;">
                        </div>
                        <?php
                        $sql = "select * from student_regis where sid='$_SESSION[sid]'";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-12 col-sm-6">
                            <label for="txterno">Enrollment No</label>
                            <input type="text" name="txterno" class="form-control" value="<?php echo $row['erno']; ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm">Name</label>
                            <input type="text" name="txtnm" class="form-control" value="<?php echo $row['name']; ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtemail">Email</label>
                            <input type="email" name="txtemail" class="form-control" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtmno">Mobile No</label>
                            <input type="text" name="txtmno" class="form-control" value="<?php echo $row['mno']; ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnos">NOC Application Status</label>
                            <input type="text" name="txtnos" class="form-control" value="<?php echo $noc_status; ?>" readonly>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtias">Internship Application Status</label>
                            <input type="text" name="txtias" class="form-control" value="<?php echo $internship_status; ?>" readonly>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Function to preview image
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php
include("footer.php");
?>
