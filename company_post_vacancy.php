<?php
session_start();
include("company_header.php");
include("conn.php");

function generateRandomNumber($length) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$smtp_server = 'smtp.gmail.com';
$smtp_port = 587;
ini_set('SMTP', $smtp_server);
ini_set('smtp_port', $smtp_port);

if (isset($_POST['btnsubmit'])) {
    // Retrieve form data
    $vtype = $_POST['txttype'];
    $ps = $_POST['txtps'];
    $post_date = $_POST['txtpd'];
    $end_date = $_POST['txted'];
    $desc = $_POST['txtdes'];

    // Handle image upload
    if ($_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['profilePic']['name'];
        $target_dir = "vacancy_images/";
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            // Fetching cid from company_info table based on logged-in user's session
            $cid = $_SESSION['cid'];
            
            // Generating vid
            $vid_result = mysqli_query($conn, "SELECT MAX(vid) AS max_vid FROM vacancy_master");
            $vid_row = mysqli_fetch_assoc($vid_result);
            $vid = $vid_row['max_vid'] + 1;

            // Insert data into vacancy_master table
            $query = "INSERT INTO vacancy_master (cid, vid, vimg, vtype, position, post_date, end_date, `desc`) 
                      VALUES ('$cid', '$vid', '$img', '$vtype', '$ps', '$post_date', '$end_date', '$desc')";
            
            if (mysqli_query($conn, $query)) {
                // Send email to company's registered email address
                $company_email_result = mysqli_query($conn, "SELECT email FROM company_info WHERE cid = '$cid'");
                $company_email_row = mysqli_fetch_assoc($company_email_result);
                $company_email = $company_email_row['email'];
                $subject = "New Vacancy Added";
                $message = "A new vacancy has been added. Check your dashboard for more details.";
                smtp_mailer($company_email, $subject, $message);
                
                echo "<script type='text/javascript'>";
                echo "alert('Vacancy Added Successfully');";
                echo "window.location.href='company_post_vacancy.php';";
                echo "</script>";
                exit; // Prevent further execution
            } else {
                echo "<script type='text/javascript'>";
                echo "alert('Failed to add vacancy. Please try again later.');";
                echo "</script>";
            }
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('Failed to move uploaded file.');";
            echo "</script>";
        }
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('File upload error: ".$_FILES['profilePic']['error']."');";
        echo "</script>";
    }
}
?>
<!-- Registration Form Start -->
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Add Vacancy</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profilePic" class="form-label">Vacancy Image</label>
                            <input type="file" class="form-control" id="profilePic" name="profilePic" accept="image/*" onchange="previewImage(event)">
                        </div>
                        <div class="mb-3">
                            <label for="txttype" class="form-label">Vacancy Type</label>
                            <input type="text" name="txttype" class="form-control" placeholder="Enter vacancy type">
                        </div>
                        <div class="mb-3">
                            <label for="txtps" class="form-label">Position</label>
                            <input type="text" name="txtps" class="form-control" placeholder="Enter position">
                        </div>
                        <div class="mb-3">
                            <label for="txtpd" class="form-label">Post Date</label>
                            <input type="date" name="txtpd" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txted" class="form-label">End Date</label>
                            <input type="date" name="txted" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="txtdes" class="form-label">Description</label>
                            <textarea name="txtdes" class="form-control" placeholder="Enter description"></textarea>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" name="btnsubmit" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Registration Form End -->
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
include("footer.php");
?>
