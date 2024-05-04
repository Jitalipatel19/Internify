<?php
session_start();
include("student_header.php");
include("conn.php");

if(isset($_POST['btnsubmit'])) {
    $sid=$_SESSION['sid'];
    $erno = $_POST['txterno'];
    $nm = $_POST['txtnm'];
    $add = $_POST['txtadd'];
    $res = $_POST['txtres'];

    // Check if file is uploaded
    if(isset($_FILES['txtip'])) {
        $file_name = $_FILES['txtip']['name'];
        $file_tmp = $_FILES['txtip']['tmp_name'];

        // Create the target directory if it doesn't exist
        $target_dir = "NOC_Application/";
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

    // Fetch email from student_regis table
    $sql = "SELECT email FROM student_regis WHERE sid='$_SESSION[sid]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

    $res1 = mysqli_query($conn, "SELECT * FROM noc_info WHERE erno='$erno'");
    if(mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Email Already Exists');";
        echo "window.location.href='login.php';";
        echo "</script>";
    } else {
        //auto no code start..
        $qur1 = mysqli_query($conn, "SELECT MAX(nid) FROM noc_info");
        $mid = 0;
        while($q1 = mysqli_fetch_array($qur1)) {
            $mid = $q1[0];
        }
        $mid++;
        //auto no code end..

        $query = "INSERT INTO noc_info (sid,nid, erno, name, address, reason, id_proof) VALUES ('$sid','$mid', '$erno', '$nm', '$add', '$res', '$target_file')";
        
        if(mysqli_query($conn, $query)) {
            // Email content
            $emailSubject = 'NOC Application Submitted';
            $emailMessage = 'Dear ' . $nm . ',<br><br>';
            $emailMessage .= 'Your NOC application has been successfully submitted!<br>';
            $emailMessage .= 'Thank you for using our services.<br><br>';
            $emailMessage .= 'Best regards,<br>';
            $emailMessage .= 'Internify';

            // Send email
            smtp_mailer($email, $emailSubject, $emailMessage);
            
            echo "<script type='text/javascript'>";
            echo "alert('Application Sent');";
            echo "window.location.href='student_profile.php';";
            echo "</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!-- HTML Form -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="bg-light rounded p-4">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">NOC Application</h3>
                </div>
                <form method="post" enctype="multipart/form-data"> <!-- enctype for file upload -->
                    <?php
                    // Loop through the data and populate the form field
                    $sql="select * from student_regis where sid='$_SESSION[sid]'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="mb-3">
                        <label for="txterno" class="form-label">Enrollment No</label>
                        <input type="text" name="txterno" class="form-control" value="<?php echo $row['erno'];?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="txtnm" class="form-label">Name</label>
                        <input type="text" name="txtnm" class="form-control" value="<?php echo $row['name'];?>" readonly>
                    </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="txtadd" class="form-label">Address</label>
                        <input type="text" name="txtadd" class="form-control" placeholder="Address">
                    </div>
                    <div class="mb-3">
                        <label for="txtres" class="form-label">Reason</label>
                        <input type="text" name="txtres" class="form-control" placeholder="Reason">
                    </div>
                    <div class="mb-3">
                        <label for="txtip" class="form-label">Student ID(Upload PDF or Photo)</label>
                        <input type="file" name="txtip" class="form-control">
                    </div>
                    <button class="btn btn-primary w-100" name="btnsubmit" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
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
include("footer.php"); ?>
