<?php
include("admin_header.php");
include("conn.php");
session_start();
$name = '';
$snm = '';
$gen = '';
$mno = '';
$email = '';
$pwd = '';
$dept = '';
$desig = '';
$cnm = '';
$clg = '';
$fid = ''; 

// Update functionality
if(isset($_POST['btnedit'])) {
    $name = $_POST['txtnm'];
    $snm = $_POST['txtsnm'];
    $gen = $_POST['txtgen'];
    $mno = $_POST['txtmno'];
    $email = $_POST['txtemail'];
    $pwd = $_POST['txtpwd'];
    $dept = $_POST['txtdept'];
    $desig = $_POST['txtdesig'];
    $cnm = $_POST['txtcnm'];
    $clg = $_POST['txtclg'];
   
    $fid = $_POST['fid']; 
    
    $query = "UPDATE faculty_regis SET 
    name='$name', surname='$snm', gender='$gen', mno='$mno', email='$email', pwd='$pwd', 
    dept='$dept', desig='$desig', coursenm='$cnm', clg='$clg'
    WHERE fid='$fid'";
    
    if(mysqli_query($conn, $query)) {
        // Send email notification
        $emailSubject = 'Faculty Record Updated';
        $emailMessage = 'Dear User,<br><br>';
        $emailMessage .= 'The faculty record has been updated successfully!<br><br>';
        $emailMessage .= 'Best regards,<br>';
        $emailMessage .= 'Internify';

        smtp_mailer($email, $emailSubject, $emailMessage);

        echo "<script type='text/javascript'>";
        echo "alert('Faculty Record Updated Successfully');";
        echo "window.location.href='admin_manage_faculty.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Failed to Update Faculty Record');";
        echo "</script>";
    }
}

// Delete functionality
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete' && isset($_REQUEST['fid'])) {
    $fid = $_REQUEST['fid'];
    $query = "DELETE FROM faculty_regis WHERE fid='$fid'";
    
    if(mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>";
        echo "alert('Faculty Record Deleted Successfully');";
        echo "window.location.href='admin_manage_faculty.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Failed to Delete Faculty Record');";
        echo "</script>";
    }
}

// Fetch faculty data for editing
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['fid'])) {
    
    $fid = $_REQUEST['fid'];
    $result = mysqli_query($conn, "SELECT * FROM faculty_regis WHERE fid='$fid'");
    $row = mysqli_fetch_array($result);

    $name = $row['name'];
    $snm = $row['surname'];
    $gen = $row['gender'];
    $email = $row['email'];
    $pwd = $row['pwd'];
    $desig = $row['desig'];
    $dept = $row['dept'];
    $mno = $row['mno'];
    $cnm = $row['coursenm'];
    $clg = $row['clg'];
}

?>
<?php
$res4 = mysqli_query($conn,"SELECT * FROM faculty_regis");
if(mysqli_num_rows($res4) > 0) {
    echo "<h2>Faculty Info</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>
            <th>FID</th>
            <th>NAME</th>
            <th>SURNAME</th>
            <th>GENDER</th>
            <th>MNO</th>
            <th>EMAIL</th>
            <th>PWD</th>
            <th>DEPARTMENT</th>
            <th>DESIGNATION</th>
            <th>COURSE NAME</th>
            <th>COLLEGE</th>
            <th>EDIT</th>
            <th>DELETE</th>
        </tr>";
    echo "</thead>";
    echo "<tbody>";
    while($r4 = mysqli_fetch_array($res4)) {
        echo "<tr>";
        echo "<td>$r4[0]</td>";
        echo "<td>$r4[1]</td>";
        echo "<td>$r4[2]</td>";
        echo "<td>$r4[3]</td>";
        echo "<td>$r4[4]</td>";
        echo "<td>$r4[5]</td>";
        echo "<td>$r4[6]</td>";
        echo "<td>$r4[7]</td>";
        echo "<td>$r4[8]</td>";
        echo "<td>$r4[9]</td>";
        echo "<td>$r4[10]</td>";
        echo "<td><a href='admin_manage_faculty.php?action=edit&fid=$r4[0]' class='btn btn-primary'>EDIT</a></td>";
        echo "<td><a href='admin_manage_faculty.php?action=delete&fid=$r4[0]' class='btn btn-danger'>DELETE</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<h2>No Data Found</h2>";
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Edit Faculty Info</h3>
                </div>
                <form method="post" action="admin_manage_faculty.php">
                    <input type="hidden" name="fid" value="<?php echo $fid; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="txtnm" class="form-label">Name</label>
                            <input type="text" name="txtnm" class="form-control" value="<?php echo $name; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="txtsnm" class="form-label">Surname</label>
                            <input type="text" name="txtsnm" class="form-control" value="<?php echo $snm; ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                <label for="">Gender</label>
                <input type="text" name="txtgen" class="form-control bg-white border-0" 
                value="<?php echo $gen; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Mobile no</label>
                <input type="text" name="txtmno" class="form-control bg-white border-0" 
                value="<?php echo $mno; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Email</label>
                <input type="email" name="txtemail" class="form-control bg-white border-0" 
                value="<?php echo $email; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Password</label>
                <input type="text" name="txtpwd" class="form-control bg-white border-0"
                value="<?php echo $pwd; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Department</label>
                <input type="text" name="txtdept" class="form-control bg-white border-0"
                value="<?php echo $dept; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Designation</label>
                <input type="text" name="txtdesig" class="form-control bg-white border-0" 
                value="<?php echo $desig; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Course Name</label>
                <input type="text" name="txtcnm" class="form-control bg-white border-0"
                value="<?php echo $cnm; ?>" style="height: 45px;">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">College Name</label>
                <input type="text" name="txtclg" class="form-control bg-white border-0" 
                value="<?php echo $clg; ?>" style="height: 45px;">
            </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" name="btnedit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
