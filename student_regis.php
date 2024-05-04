<?php
session_start();
include("header.php");
include("conn.php");

function generateRandomNumber($length) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if (isset($_POST['btnsubmit'])) {
    $nm = $_POST['txtnm'];
    $snm = $_POST['txtsnm'];
    $gen = $_POST['txtgen'];
    $dob = $_POST['txtdob'];
    $clg = $_POST['txtclg'];
    $erno = generateRandomNumber(6);
    $dept = $_POST['txtdept'];
    $email = $_POST['txtemail'];
    $pwd = generateRandomNumber(4);
    $mno = $_POST['txtmno'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } elseif (!preg_match('/^[0-9]{10}+$/', $mno)) {
        echo "<script>alert('Invalid mobile number format');</script>";
    } elseif (calculateAge($dob) < 18) {
        echo "<script>alert('Age must be at least 18 years old');</script>";
    } else{
        // Upload image file
        $img = $_FILES['profilePic']['name'];
        $target_dir = "student_profile/";
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
        move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file);

        $res1 = mysqli_query($conn, "SELECT * FROM student_regis WHERE email='$email'");
        if (mysqli_num_rows($res1) > 0) {
            echo "<script type='text/javascript'>";
            echo "alert('Email Already Exists');";
            echo "window.location.href='login.php';";
            echo "</script>";
        } else {
            $qur1 = mysqli_query($conn, "SELECT MAX(sid) FROM student_regis");
            $mid = 0;
            while ($q1 = mysqli_fetch_array($qur1)) {
                $mid = $q1[0];
            }
            $mid++;

            $query = "INSERT INTO student_regis 
            (sid, profile, name, surname, gender, dob, clg, erno, dept, email, pwd, mno)
             VALUES ('$mid', '$img', '$nm', '$snm', '$gen', '$dob', '$clg', '$erno', '$dept', '$email', '$pwd', '$mno')";

            if (mysqli_query($conn, $query)) {
                // Email content
                $to = $email;
$subject = 'Registration Successful';
$to = $email;
$subject = 'Registration Successful';
$message = '<p style="font-family: Arial, sans-serif; font-size: 16px;">Dear ' . $nm . ',</p>';
$message .= '<p style="font-family: Arial, sans-serif; font-size: 16px;">Your registration is successful.</p>';
$message .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 16px;">';
$message .= '<thead>';
$message .= '<tr>';
$message .= '<th colspan="2" style="border: 1px solid #000; padding: 10px; text-align: center;">Login Credentials</th>';
$message .= '</tr>';
$message .= '</thead>';
$message .= '<tbody>';
$message .= '<tr><td style="border: 1px solid #000; padding: 10px;">Enrollment No:</td><td style="border: 1px solid #000; padding: 10px;">' . $erno . '</td></tr>';
$message .= '<tr><td style="border: 1px solid #000; padding: 10px;">Password:</td><td style="border: 1px solid #000; padding: 10px;">' . $pwd . '</td></tr>';
$message .= '</tbody>';
$message .= '</table>';
$message .= '<p style="font-family: Arial, sans-serif; font-size: 16px;">Thank you.</p>';

// Send email
$mail_sent = smtp_mailer($to, $subject, $message);
                if ($mail_sent) {
                    echo "<script type='text/javascript'>";
                    echo "alert('Student Registered Successfully. Check your email for login details.');";
                    echo "window.location.href='student_regis.php';";
                    echo "</script>";
                } else {
                    echo "<script type='text/javascript'>";
                    echo "alert('Failed to send email. Please try again later.');";
                    echo "</script>";
                }
            }
        }
    }
}
function calculateAge($dob) {
    $dob = new DateTime($dob);
    $now = new DateTime();
    $interval = $now->diff($dob);
    return $interval->y;
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
        return false;
    }else{
        return true;
    }
}
?>

<!-- Registration Form Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Student Registration</h3>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-12 text-center">
                            <!-- Profile Picture Input -->
                            <label for="profilePic" class="form-label">Profile Picture</label>
                            <img id="preview" src="img/profile.png" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover; display: block; margin: 0 auto;">
                            <input type="file" class="form-control mt-2" id="profilePic" name="profilePic" accept="image/*" onchange="previewImage(event)" style="width: 245px; margin: 0 auto;">
                        </div>
                        <div class="col-md-6">
                            <label for="txtnm" class="form-label">Name</label>
                            <input type="text" name="txtnm" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <label for="txtsnm" class="form-label">Surname</label>
                            <input type="text" name="txtsnm" class="form-control" placeholder="Surname">
                        </div>
                        <div class="col-md-6">
                            <label for="txtgen" class="form-label">Gender</label>
                            <input type="text" name="txtgen" class="form-control" placeholder="Gender">
                        </div>
                        <div class="col-md-6">
                            <label for="txtdob" class="form-label">Birthdate</label>
                            <input type="date" name="txtdob" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="txtclg" class="form-label">College Name</label>
                            <input type="text" name="txtclg" class="form-control" placeholder="College Name">
                        </div>
                        <div class="col-md-6">
                            <label for="txtdept" class="form-label">Department</label>
                            <input type="text" name="txtdept" class="form-control" placeholder="Department">
                        </div>
                        <div class="col-md-6">
                            <label for="txtemail" class="form-label">Email</label>
                            <input type="email" name="txtemail" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label for="txtmno" class="form-label">Mobile No</label>
                            <input type="text" name="txtmno" class="form-control" placeholder="Mobile No">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Submit</button>
                        </div>
                        <div class="col-md-6">
                            <a href="student_login.php" class="btn btn-outline-primary w-100 py-3">Already Registered? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Registration Form End -->

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?php
include("footer.php");
?>
