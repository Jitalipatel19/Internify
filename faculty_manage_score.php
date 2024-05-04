<?php
include("faculty_header.php");
include("conn.php");
include('smtp/PHPMailerAutoload.php');

// Check if 'erno' parameter is set in the URL
if(isset($_GET['erno'])) {
    $enrollment_number = $_GET['erno'];
} else {
    $enrollment_number = ""; // Set default value if 'erno' parameter is not set
}
// Process form submission
if (isset($_POST['btnsubmit'])) {
    // Retrieve Faculty ID from session
    session_start();
    $fid = $_SESSION['fid'];
    
    $erno = $_POST['txtern'];
    $sc = $_POST['txtsc'];  
    
    // Fetch the student ID (sid) and email based on the enrollment number
    $query_student = "SELECT sid, email FROM student_regis WHERE erno='$erno'";
    $result_student = mysqli_query($conn, $query_student);
    $row_student = mysqli_fetch_assoc($result_student);
    $sid = $row_student['sid'];
    $to_email = $row_student['email'];

    // Check if the score for the enrollment number already exists
    $res1 = mysqli_query($conn, "SELECT * FROM score_info WHERE erno='$erno'");
    if (mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Score for this Enrollment Number already exists.');";
        echo "window.location.href='faculty_manage_score.php';";
        echo "</script>";
    } else {
        // Insert score details into score_info table
        $qur1 = mysqli_query($conn, "SELECT MAX(scid) FROM score_info");
        $mid = 0;
        while ($q1 = mysqli_fetch_array($qur1)) {
            $mid = $q1[0];
        }
        $mid++;
        // Insert score details into score_info table
        $query = "INSERT INTO score_info (scid, fid, sid, erno, score)
                  VALUES ('$mid', '$fid', '$sid', '$erno', '$sc')";
        if (mysqli_query($conn, $query)) {
            // Compose email message with score details
            $subject = "Your Score Information";
            $msg = "Dear Student,\n\nYour score for the enrollment number $erno is: $sc\n\nThank you!";
            // Send email
            $result = smtp_mailer($to_email, $subject, $msg);
            // Display success message
            echo "<script type='text/javascript'>";
            echo "alert('Score Assigned Successfully. Email Sent.');";
            echo "window.location.href='faculty_manage_score.php';";
            echo "</script>";
        } else {
            // Display error message
            echo "<script type='text/javascript'>";
            echo "alert('Failed to Assign Score.');";
            echo "</script>";
        }
    }
}


// Fetch data from the student_regis table for the erno field
$res4 = mysqli_query($conn, "SELECT * FROM student_regis");
if(mysqli_num_rows($res4) > 0) {
    echo "<h3>Score</h3>";
    echo "<table class='table table-bordered'>
            <tr>
                <th>NO</th>
                <th>ENROLLMENT NO</th>
                <th>NAME</th>
                <th>SURNAME</th>
                <th>SCORE</th>
            </tr>";
    $count = 1;
    while($r4 = mysqli_fetch_array($res4)) {
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . $r4['erno'] . "</td>"; // Display enrollment number
        echo "<td>" . $r4['name'] . "</td>";
        echo "<td>" . $r4['surname'] . "</td>";
        echo "<td><a href='javascript:void(0);' class='score-link' data-enrollment='" . $r4['erno'] . "'>SCORE</a></td>";
        echo "</tr>";
        $count++;
    }
    echo "</table>";
} else {
    echo "<h2>No Data Found</h2>";  
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Score</h3>
                </div>
                <form method="post" action="faculty_manage_score.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="txtern" class="form-label">Enrollment No</label>
                            <input type="text" name="txtern" id="txtern" class="form-control" value="<?php echo $enrollment_number; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="txtsc" class="form-label">Score</label>
                            <input type="text" name="txtsc" class="form-control">
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
<script>
    // Add event listener to all score links
    var scoreLinks = document.querySelectorAll('.score-link');
    scoreLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Get the enrollment number from the data-enrollment attribute
            var enrollmentNumber = this.getAttribute('data-enrollment');
            // Set the value of the enrollment number text box
            document.getElementById('txtern').value = enrollmentNumber;
        });
    });
</script>
<?php
include("footer.php");
?>

<?php
function smtp_mailer($to,$subject, $msg){
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
	$mail->Body =$msg;
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
