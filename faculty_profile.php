<?php
include("conn.php");
session_start();
include("faculty_header.php");

// Check if the form is submitted
if(isset($_POST['btnupdate'])) {
    // Retrieve form data
    $name = $_POST['txtname'];
    $surname = $_POST['txtsnm'];
    $mno = $_POST['txtmno']; 
    $gender = $_POST['txtgen'];
    $email = $_POST['txtemail']; 
    $password = $_POST['txtpwd']; 
    $designation = $_POST['txtdesig']; 
    $department = $_POST['txtdept']; 
    $course_name = $_POST['txtcoursenm']; 
    $college_name = $_POST['txtclg']; 

    // Update query
    $sql = "UPDATE faculty_regis 
    SET name='$name', surname='$surname', mno='$mno', gender='$gender', email='$email', pwd='$password', desig='$designation', dept='$department', coursenm='$course_name', clg='$college_name' WHERE fid='$_SESSION[fid]'";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Email content
        $emailSubject = 'Faculty Profile Updated';
        $emailMessage = 'Dear Faculty,<br><br>';
        $emailMessage .= 'Your profile has been updated successfully!<br>';
        $emailMessage .= 'Thank you for keeping your information up-to-date.<br><br>';
        $emailMessage .= 'Best regards,<br>';
        $emailMessage .= 'Internify';

        // Send email
        smtp_mailer($email, $emailSubject, $emailMessage);

        echo "<script>alert('Faculty Profile Update Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<?php
// Loop through the data and populate the form field
$sql="SELECT * FROM faculty_regis WHERE fid='$_SESSION[fid]'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
?>
 <!-- Registration Form Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-4">
            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="txtname" class="form-control" value="<?php echo $row['name']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" name="txtsnm" class="form-control" value="<?php echo $row['surname']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="mno" class="form-label">Mobile No</label>
                            <input type="text" name="txtmno" class="form-control" value="<?php echo $row['mno']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="gen" class="form-label">Gender</label>
                            <input type="text" name="txtgen" class="form-control" value="<?php echo $row['gender']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="txtemail" class="form-control" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="pwd" class="form-label">Password</label>
                            <input type="text" name="txtpwd" class="form-control" value="<?php echo $row['pwd']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="desig" class="form-label">Designation</label>
                            <input type="text" name="txtdesig" class="form-control" value="<?php echo $row['desig']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="dept" class="form-label">Department</label>
                            <input type="text" name="txtdept" class="form-control" value="<?php echo $row['dept']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="coursenm" class="form-label">Course Name</label>
                            <input type="text" name="txtcoursenm" class="form-control" value="<?php echo $row['coursenm']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="clg" class="form-label">College Name</label>
                            <input type="text" name="txtclg" class="form-control" value="<?php echo $row['clg']; ?>">
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary w-100" name="btnupdate" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <?php
}
// Function to send email
function smtp_mailer($to, $subject, $msg){
    include('smtp/PHPMailerAutoload.php');
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
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if(!$mail->Send()){
        echo $mail->ErrorInfo;
    }else{
        return 'Sent';
    }
}

include("footer.php");
?>
