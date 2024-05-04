<?php
session_start();
include("header.php");
include("conn.php");

if(isset($_POST['btnsubmit'])) {
    $nm=$_POST['txtnm'];
    $snm=$_POST['txtsnm'];
    $gen=$_POST['txtgen'];
    $mno=$_POST['txtmno'];
    $email=$_POST['txtemail'];
    $pwd = generateRandomPassword();
    $dept=$_POST['txtdept'];
    $desig=$_POST['txtdesig'];
    $clg=$_POST['txtclg'];
    $csnm=$_POST['txtcsnm']; // Assuming this is for course name
    
    // Server-side validation
    if(empty($nm) || empty($snm) || empty($gen) || empty($mno) || empty($email) || empty($dept) || empty($desig) || empty($clg) || empty($csnm)) {
        echo "<script>alert('All fields are required');</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } elseif(!preg_match('/^[0-9]{10}+$/', $mno)) {
        echo "<script>alert('Invalid mobile number format');</script>";
    } else {
        $res1=mysqli_query($conn,"select * from faculty_regis where email='$email'");
        if(mysqli_num_rows($res1)>0) {
            echo "<script type='text/javascript'>";
            echo "alert('Email Already Exists');";
            echo "window.location.href='faculty_regis.php';";
            echo "</script>";
        } else {
            //auto no code start..
            $qur1=mysqli_query($conn,"select max(fid) from faculty_regis");
            $mid=0;
            while($q1=mysqli_fetch_array($qur1)) {
                $mid=$q1[0];
            }
            $mid++;
            //auto no code end..
            $query="insert into faculty_regis
            (fid, name, surname, gender, mno,email,pwd, dept,desig,coursenm,clg) 
            values('$mid', '$nm', '$snm', '$gen', '$mno', '$email', '$pwd', '$dept', '$desig', '$csnm','$clg')";
            if(mysqli_query($conn, $query)) {
                // Send email with auto-generated password
                $emailSubject = 'Registration Successful';
                $emailMessage = 'Hello ' . $nm . ',<br><br>';
                $emailMessage .= 'Your registration is successful.<br>';
                $emailMessage .= 'Your password is: ' . $pwd . '<br><br>';
                $emailMessage .= 'Thank you for registering.<br><br>';
                $emailMessage .= 'Best regards,<br>';
                $emailMessage .= 'Internify';

                smtp_mailer($email, $emailSubject, $emailMessage);

                echo "<script type='text/javascript'>";
                echo "alert('Faculty Registered Successfully');";
                echo "window.location.href='login.php';";
                echo "</script>";
            }
        }
    }
}

function generateRandomPassword($length = 4) {
    $characters = '0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

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
    } else {
        return 'Sent';
    }
}
?>

<!-- Faculty Registration Form Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Registration</h3>
                </div>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Name</label>
                            <input type="text" id="txtnm" name="txtnm" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Surname</label>
                            <input type="text" id="txtnm" name="txtsnm" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Gender</label>
                            <input type="text"  name="txtgen" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Mobile No</label>
                            <input type="text"  name="txtmno" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Email</label>
                            <input type="email" name="txtemail" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Department</label>
                            <input type="text"  name="txtdept" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Course Name</label>
                            <input type="text"  name="txtcsnm" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Designation</label>
                            <input type="text"  name="txtdesig" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtnm" class="form-label">Collge Name</label>
                            <input type="text"  name="txtclg" class="form-control" placeholder="Name" style="height: 45px;">
                        </div>
                        
                        <div class="col-12 col-6">
                            <button class="btn btn-primary w-100 py-3"  name="btnsubmit" type="submit">Submit</button>
                        </div>
                        <div class="col-12 col-6">
                            <a href="login.php">Already Registered? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Faculty Registration Form End -->

<?php
include("footer.php");
?>
