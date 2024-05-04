<?php
include("faculty_header.php");
include("conn.php");
$student_name = '';
// Check if a status change request is made
if(isset($_GET['change_status']) && isset($_GET['id']) && isset($_GET['new_status'])) {
    $id = $_GET['id'];
    $new_status = $_GET['new_status'];

    // Update status in the database
    $update_query = "UPDATE noc_info SET status='$new_status' WHERE nid='$id'";
    mysqli_query($conn, $update_query);

    // Fetch student email from student_regis table based on sid
    $student_email_query = "SELECT s.email, s.name FROM noc_info n INNER JOIN student_regis s ON n.sid = s.sid WHERE n.nid = '$id'";
    $student_email_result = mysqli_query($conn, $student_email_query);
    if(mysqli_num_rows($student_email_result) > 0) {
        $student_email_row = mysqli_fetch_assoc($student_email_result);
            $student_email = $student_email_row['email'];
            $student_name = $student_email_row['name']; 


        // Send email notification to the student
        $emailSubject = 'NOC Application Status Update';
        $emailMessage = 'Dear ' . $student_name . ',<br><br>';
        $emailMessage .= 'Your NOC application status has been updated to ' . $new_status . '.<br>';
        $emailMessage .= 'Thank you for your patience.<br><br>';
        $emailMessage .= 'Best regards,<br>';
        $emailMessage .= 'Internify';

        // Send email
        smtp_mailer($student_email, $emailSubject, $emailMessage);
    }
}

?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">NOC Application List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">ENROLLMENT NO</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">ADDRESS</th>
                                    <th scope="col">REASON</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $res4 = mysqli_query($conn, "SELECT * FROM noc_info");
                                if (mysqli_num_rows($res4) > 0) {
                                    while ($r4 = mysqli_fetch_array($res4)) {
                                        echo "<tr>";
                                        echo "<td>{$r4['nid']}</td>";
                                        echo "<td>{$r4['erno']}</td>";
                                        echo "<td>{$r4['name']}</td>";
                                        echo "<td>{$r4['address']}</td>";
                                        echo "<td>{$r4['reason']}</td>";
                                        echo "<td><a href='{$r4['id_proof']}' target='_blank'>View ID</a></td>";
                                        echo "<td>{$r4['status']}</td>";
                                        echo "<td>";
                                        // Add buttons or links to change status
                                        echo "<a href='?change_status=true&id={$r4['nid']}&new_status=approved' class='btn btn-success btn-sm'>Approve</a>";
                                        echo "<a href='?change_status=true&id={$r4['nid']}&new_status=rejected' class='btn btn-danger btn-sm'>Reject</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No Data Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
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
