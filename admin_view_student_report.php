<?php
session_start();
include("admin_header.php");
include("conn.php");
$sid = '';
$name = '';
$snm = '';
$gen ='';
$dob = '';
$clg = '';
$erno ='';
$dept = '';
$email ='';
$pwd = '';
$mno = '';
$profile_pic_path = ''; // Initialize profile pic path variable

// Check if form is submitted
if(isset($_POST['btnedit'])) {
    // Sanitize input data and assign to variables
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $name = mysqli_real_escape_string($conn, $_POST['txtnm']);
    $snm = mysqli_real_escape_string($conn, $_POST['txtsnm']);
    $gen = mysqli_real_escape_string($conn, $_POST['txtgen']);
    $dob = mysqli_real_escape_string($conn, $_POST['txtdob']);
    $clg = mysqli_real_escape_string($conn, $_POST['txtclg']);
    $erno = mysqli_real_escape_string($conn, $_POST['txterno']);
    $dept = mysqli_real_escape_string($conn, $_POST['txtdept']);
    $email = mysqli_real_escape_string($conn, $_POST['txtemail']);
    $pwd = mysqli_real_escape_string($conn, $_POST['txtpwd']);
    $mno = mysqli_real_escape_string($conn, $_POST['txtmno']);

    // Profile picture path
    if(isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] == 0) {
        // File upload handling
        $target_dir = "student_profile/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]); // Get the filename of the uploaded file

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            // File uploaded successfully, update profile pic path
            $profile_pic_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Update query with profile pic path and other fields
    $query = "UPDATE student_regis SET 
        name='$name', surname='$snm', gender='$gen', dob='$dob',
        clg='$clg', erno='$erno', dept='$dept', email='$email', pwd='$pwd', mno='$mno'";
    
    // Add profile pic path to the query if it's not empty
    if(!empty($profile_pic_path)) {
        $query .= ", profile='$profile_pic_path'";
    }
    
    $query .= " WHERE sid='$sid'";

    // Execute the query
    if(mysqli_query($conn, $query)) {
        // Send email notification
        $emailSubject = 'Profile Updated';
        $emailMessage = 'Dear User,<br><br>';
        $emailMessage .= 'Your profile has been updated successfully!<br>';
        $emailMessage .= 'Thank you for using our service.<br><br>';
        $emailMessage .= 'Best regards,<br>';
        $emailMessage .= 'Internify';
        if(smtp_mailer($email, $emailSubject, $emailMessage)) {
            echo "<script type='text/javascript'>";
            echo "alert('Student Record Updated Successfully');";
            echo "window.location.href='admin_manage_student.php';";
            echo "</script>";
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('Failed to send email notification');";
            echo "</script>";
        }
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Failed to Update Student Record');";
        echo "</script>";
    }
}

// Delete functionality
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete' && isset($_REQUEST['sid'])) {
    $sid1=$_REQUEST['sid'];
    $query="DELETE FROM student_regis WHERE sid='$sid1'";
    
    if(mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>";
        echo "alert('Student Record Deleted Successfully');";
        echo "window.location.href='admin_manage_student.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Failed to Delete Student Record');";
        echo "</script>";
    }
}

   
// Fetch student data for editing
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['sid'])) {
    
    $sid = $_REQUEST['sid'];
    $result = mysqli_query($conn, "SELECT * FROM student_regis WHERE sid='$sid'");
    $row = mysqli_fetch_array($result);

    // Assign fetched data to variables
    $name = $row['name'];
    $snm = $row['surname'];
    $gen = $row['gender'];
    $dob = $row['dob'];
    $clg = $row['clg'];
    $erno = $row['erno'];
    $dept = $row['dept'];
    $email = $row['email'];
    $pwd = $row['pwd'];
    $mno = $row['mno'];
    $profile_pic_path = $row['profile'];
}
?>
<!-- Display student information table -->
<?php
$res4=mysqli_query($conn,"SELECT * FROM student_regis");
if(mysqli_num_rows($res4)>0) {
    echo "<h2>Student Info</h2>";
    echo "<table class='table table-bordered'>
    <tr>
        <th>SID</th>
        <th>PROFILE</th>
        <th>NAME</th>
        <th>SURNAME</th>
        <th>GENDER</th>
        <th>DOB</th>
        <th>COLLEGE NAME</th>
        <th>ERNO</th>
        <th>DEPT</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
        <th>MNO</th>
        <th>EDIT</th>
        <th>DELETE</th>
    </tr>";
while($r4=mysqli_fetch_array($res4)) {
echo "<tr>";
echo "<td>$r4[0]</td>";
echo "<td><img src='$r4[1]' class='img-thumbnail' style='width: 50px; height: 50px;'></td>"; // Display image instead of path
echo "<td>$r4[2]</td>";
echo "<td>$r4[3]</td>";
echo "<td>$r4[4]</td>";
echo "<td>$r4[5]</td>";
echo "<td>$r4[6]</td>";
echo "<td>$r4[7]</td>";
echo "<td>$r4[8]</td>";
echo "<td>$r4[9]</td>";
echo "<td>$r4[10]</td>";
echo "<td>$r4[11]</td>";
echo "<td><a href='admin_manage_student.php?action=edit&sid=$r4[0]'>EDIT</a></td>";
echo "<td><a href='admin_manage_student.php?action=delete&sid=$r4[0]'>DELETE</a></td>";
echo "</tr>";
}
echo "</table>";

} else {
    echo "<h2>No Data Found</h2>";
}
?>
<!-- Display form for editing student information -->
<div class="container">
    <div class="bg-light rounded p-5 mt-5" style="max-width: 600px; margin: 0 auto;">
        <div class="section-title section-title-sm position-relative pb-3 mb-4">
            <h3 class="mb-0">Edit Student Info</h3>
        </div>
        <form method="post" action="admin_manage_student.php" enctype="multipart/form-data">
        <input type="hidden" name="sid" value="<?php echo $row['sid']; ?>"> <!-- Add this hidden field to store sid -->
        <!-- Your form goes here with pre-filled values -->
        <div class="row g-3 owl">
        <div class="col-12 text-center">
                    <!-- Profile Picture Input -->
                    <label for="profilePic" class="form-label">Profile Picture</label>
                    <img id="preview" src="<?php echo $profile_pic_path; ?>" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover; display: block; margin: 0 auto; border-radius: 50%;">
                    <input type="file" class="form-control mt-2" id="profilePic" name="profilePic" accept="image/*" onchange="previewImage(event)" style="width: 245px; margin: 0 auto;">
                </div>
        <div class="col-12 col-sm-6">
            <label for="">Name</label>
            <input type="text" name="txtnm" class="form-control bg-white border-0" 
             value="<?php echo $name; ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Surname</label>
                <input type="text" name="txtsnm" class="form-control bg-white border-0"
                 value="<?php echo $snm; ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Gender</label>
                <input type="text" name="txtgen" class="form-control bg-white border-0" 
                value="<?php echo $gen; ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">DOB</label>
                <input type="date" name="txtdob" class="form-control bg-white border-0" 
                value="<?php echo $dob ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">College Name</label>
                <input type="text" name="txtclg" class="form-control bg-white border-0"
                 value="<?php echo $clg ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Enrollment no</label>
                <input type="text" name="txterno" class="form-control bg-white border-0" 
                value="<?php echo $erno ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Department</label>
                <input type="text" name="txtdept" class="form-control bg-white border-0"
                 value="<?php echo $dept ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Email</label>
                <input type="text" name="txtemail" class="form-control bg-white border-0" 
                value="<?php echo $email ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Password</label>
                <input type="text" name="txtpwd" class="form-control bg-white border-0" 
                value="<?php echo $pwd ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-sm-6">
            <label for="">Mobile No</label>
                <input type="text" name="txtmno" class="form-control bg-white border-0" 
                value="<?php echo $mno ?>" style="height: 45px;">
        </div>
        <div class="col-12 col-6">
            <button class="btn btn-primary w-100 py-3"  name="btnedit" type="submit">Edit</button>
        </div>
</div>
    </form>
</div>
</div>
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
include("footer.php");
?>
