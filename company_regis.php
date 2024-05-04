<?php
include("header.php");
include("conn.php");
session_start();

function generateRandomNumber($length) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if(isset($_POST['btnsubmit'])) 
{
    $name = $_POST['txtnm'];
    $hr = $_POST['txthrnm'];
    $des = $_POST['txtdes'];
    $email = $_POST['txtemail'];
    $pwd = generateRandomNumber(4);
    $loc = $_POST['txtloc'];
    
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    }
    else {
        // Check if the company already exists
        $res1 = mysqli_query($conn, "SELECT * FROM company_info WHERE name='$name'");
        if(mysqli_num_rows($res1) > 0) {
            echo "<script type='text/javascript'>";
            echo "alert('Company Already Exists');";
            echo "window.location.href='blog.html';";
            echo "</script>";
        } else {
            // Get the maximum cid and increment it for the new company
            $qur1 = mysqli_query($conn, "SELECT MAX(cid) FROM company_info");
            $q1 = mysqli_fetch_array($qur1);
            $mid = $q1[0] + 1;
        
            // Insert company details into the database
            $query = "INSERT INTO company_info (cid,name,hrnm,`desc`,email,pwd,location) 
                      VALUES ('$mid','$name','$hr','$des','$email','$pwd','$loc')";
            if(mysqli_query($conn, $query)) {
                // Email content
                $emailSubject = 'Registration Completed';
                $emailMessage = 'Dear Company,<br><br>';
                $emailMessage .= 'Thank you for registering with us!<br>';
                $emailMessage .= 'Your password: ' . $pwd . '<br><br>';
                $emailMessage .= 'Best regards,<br>';
                $emailMessage .= 'Internify';

                // Send email
                smtp_mailer($email, $emailSubject, $emailMessage);

                echo "<script type='text/javascript'>";
                echo "alert('Company Registered Successfull');";
                echo "window.location.href='login.php';";
                echo "</script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn); // Display error if query fails
            }
        }
    }
}
?>
<!-- Registration Form Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Registration</h3>
                </div>
                <form method="post" enctype="multipart/form-data"> <!-- Added enctype="multipart/form-data" for file upload -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="txtnm" class="form-label">Name</label>
                            <input type="text" name="txtnm" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">HR Name</label>
                            <input type="text" name="txthrnm" class="form-control" placeholder="HR Name">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Description</label>
                            <input type="text" name="txtdes" class="form-control" placeholder="Description">
                        </div>
                        <div class="col-md-6">
                            <label for="txtemail" class="form-label">Email</label>
                            <input type="text" name="txtemail" class="form-control" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label for="txtloc" class="form-label">Location</label>
                            <input type="text" name="txtloc" class="form-control" placeholder="Location">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100 py-3" name="btnsubmit" type="submit">Submit</button>
                        </div>
                        <div class="col-md-6">
                            <a href="login.php" class="btn btn-outline-primary w-100 py-3">Already Registered? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Registration Form End -->

<?php
include("footer.php");

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

?>
