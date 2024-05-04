<?php
session_start();
include("company_header.php");
include("conn.php");

// Function to send email using PHPMailer
function smtp_mailer($to, $subject, $msg) {
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
    $mail->SMTPOptions = array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if(!$mail->Send()){
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}

// Process form submission
if (isset($_POST['btnsubmit'])) {
    $inm = $_POST['txtinm'];
    $cnm=$_POST['txtcnm'];
    $pt = $_POST['txtpt'];
    $dur = $_POST['txtdur'];
    $tool = $_POST['txtool'];
    $tech = $_POST['txtech'];
    $mnm = $_POST['txtmnm'];
    $sta = $_POST['txtsta'];
  // Check if the intern already has an assigned project
    $res1 = mysqli_query($conn, "SELECT * FROM project_info WHERE intern_name='$inm'");
    if (mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Intern Already Assigned Project');";
        echo "window.location.href='company_assign_project.php';";
        echo "</script>";
    } else {
        // Insert project details into project_info table
        $qur1 = mysqli_query($conn, "SELECT MAX(pi) FROM project_info");
        $mid = 0;
        while ($q1 = mysqli_fetch_array($qur1)) {
            $mid = $q1[0];
        }
        $mid++;
        $query = "INSERT INTO project_info (pi,intern_name,name,prj_title,duration,tool,tech,mnm,sta)
                  VALUES ('$mid','$inm','$cnm','$pt' ,'$dur', '$tool', '$tech', '$mnm','$sta')";
        if (mysqli_query($conn, $query)) {
            // Fetch the email address of the intern
            $res_email = mysqli_query($conn, "SELECT email FROM intern_applications_info WHERE intern_name='$inm'");
            $email_row = mysqli_fetch_assoc($res_email);
            $to = $email_row['email'];
            // Compose email message with project details
            $subject = "Project Assigned: $pt";
            $msg = "Dear Intern,\n\nYou have been assigned the following project:\n\nProject Title: $pt\nDuration: $dur\nTool: $tool\nTechnology: $tech\nCompany: Your Company Name\n\nThank you!";
            // Send email
            $result = smtp_mailer($to, $subject, $msg);
            // Check if email was sent successfully
            if ($result === 'Sent') {
                echo "<script type='text/javascript'>";
                echo "alert('Project Assigned Successfully. Email Sent.');";
                echo "window.location.href='company_assign_project.php';";
                echo "</script>";
            } else {
                echo "<script type='text/javascript'>";
                echo "alert('Project Assigned Successfully. Failed to send email.');";
                echo "window.location.href='company_assign_project.php';";
                echo "</script>";
            }
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('Failed Assign Project.');";
            echo "</script>";
        }
    }
}
$res4 = mysqli_query($conn, "SELECT * FROM intern_applications_info WHERE application_status = 'approved';");
if (mysqli_num_rows($res4) > 0) {
    echo "<h2>Student Info</h2>";
    echo "<table class='table table-bordered'>
            <tr>
                <th>NO</th>
                <th>INTEREN NAME</th>
                <th>POSITION</th>
                <th>EXPERIENCE</th>
                <th>ASSIGN PROJECT</th>
            </tr>";
    while ($r4 = mysqli_fetch_array($res4)) {
        echo "<tr>";
        echo "<td>$r4[0]</td>";
        echo "<td>$r4[2]</td>";
        echo "<td>$r4[11]</td>";
        echo "<td>$r4[9]</td>";
        echo "<td><a href='company_assign_project.php?action=edit&sid=$r4[0]' class='assign-link' data-intern-name='$r4[2]'>ASSIGN</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>No Interns Found</h2>";
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Assign Project</h3>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">Intern Name</label>
                            <input type="text" name="txtinm" id="txtinm" class="form-control">
                        </div>
                        <?php
// Loop through the data and populate the form field
$sql="SELECT name FROM company_info WHERE cid='$_SESSION[cid]'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
?>

                        <div class="col-md-6">
            <label for="" class="form-label">Company Name</label>
            <input type="text" name="txtcnm" class="form-control" value="<?php echo $row['name']; ?>">
        </div>
        <?php
}
?>
                        <div class="col-md-6">
            <label for="" class="form-label">Project Title</label>
            <input type="text" name="txtpt" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Duration</label>
            <input type="text" name="txtdur" class="form-control" >
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Tool</label>
            <input type="text" name="txtool" class="form-control">        
        </div>
        <div class="col-md-6">
            <label for="txterno" class="form-label">Technology</label>
            <input type="text" name="txtech" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Manager Name</label>
            <input type="text" name="txtmnm" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="txtinm" class="form-label">Stipend</label>
            <input type="text" name="txtsta" class="form-control">
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
    // JavaScript to populate the intern name when the "ASSIGN" link is clicked
    document.addEventListener("DOMContentLoaded", function() {
        const assignLinks = document.querySelectorAll('.assign-link');
        assignLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const internName = this.getAttribute('data-intern-name');
                document.getElementById('txtinm').value = internName;
            });
        });
    });
</script>

<?php
include("footer.php");
?>
