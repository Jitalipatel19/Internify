<?php include("company_header.php"); ?>
<?php include("conn.php"); ?>
<?php session_start(); 

// Function to send email
function smtp_mailer($to, $subject, $msg)
{
    require_once('smtp/PHPMailerAutoload.php');
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
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if (!$mail->Send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }
}

// Function to generate a random string (Google Meet link)
function generateGoogleMeetLink()
{
    // Generate a random string of length 10 for the Google Meet link
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ($i = 0; $i < 10; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return "https://meet.google.com/" . $random_string;
}

// Function to update application status
function updateApplicationStatus($conn, $id, $new_status)
{
    $id = mysqli_real_escape_string($conn, $id);
    $new_status = mysqli_real_escape_string($conn, $new_status);

    $update_query = "UPDATE intern_applications_info SET application_status='$new_status' WHERE iid='$id'";
    if (mysqli_query($conn, $update_query)) {
        return true;
    } else {
        return "Error updating status: " . mysqli_error($conn);
    }
}

// Function to fetch applications for the logged-in company
function fetchCompanyApplications($conn, $company_id)
{
    $company_id = mysqli_real_escape_string($conn, $company_id);

    // Modify the query to fetch applications for the logged-in company using company ID
    $application_query = "SELECT ia.*, ci.email AS company_email 
    FROM intern_applications_info ia 
    INNER JOIN company_info ci ON ia.comp_name = ci.name 
    WHERE ci.cid='$company_id'";
    $application_result = mysqli_query($conn, $application_query);
    if ($application_result && mysqli_num_rows($application_result) > 0) {
        return $application_result;
    } else {
        return false; // Return false if no data found or error occurred
    }
}

$logged_in_cid = $_SESSION['cid']; // Assuming 'cid' is the session variable storing the company ID

// Check if a status change request is made
if (isset($_GET['change_status'], $_GET['id'], $_GET['new_status'])) {
    $id = $_GET['id'];
    $new_status = $_GET['new_status'];
    // Update status in the database
    $update_status_result = updateApplicationStatus($conn, $id, $new_status);
    if ($update_status_result === true) {
        // Fetch application data
        $application_data_result = fetchCompanyApplications($conn, $logged_in_cid);
        if ($application_data_result) {
            while ($application_data = mysqli_fetch_assoc($application_data_result)) {
                $to = $application_data['email'];

                // Send email notification of status change
                $subject = 'Application Status Update';
                $message = "Dear Student,\n\n";
                $message .= "Your internship application for the position of {$application_data['position']} has been {$new_status}.\n";
                if ($new_status == 'approved') {
                    // If application is approved, generate Google Meet link
                    $google_meet_link = generateGoogleMeetLink();
                    $message .= "Here is the Google Meet link for your interview: {$google_meet_link}\n";
                }
                $message .= "\nBest regards,\nInternify";

                $email_result = smtp_mailer($to, $subject, $message);
                if ($email_result !== true) {
                    echo "Error sending email to {$to}: " . $email_result;
                }
            }
            // Redirect back to the current page after updating status and sending email
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error fetching application data";
        }
    } else {
        echo $update_status_result;
    }
}

?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Applications</h2>

    <?php
    // Fetch applications for the logged-in company
    $res4 = fetchCompanyApplications($conn, $logged_in_cid);
    if ($res4 && mysqli_num_rows($res4) > 0) {
        echo "<div class='table-responsive'>
                <table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                        <tr>
                            <th scope='col'>NO</th>
                            <th scope='col'>STUDENT NAME</th>
                            <th scope='col'>POSITION</th>
                            <th scope='col'>EDUCATION</th>
                            <th scope='col'>EXPERIENCE</th> <!-- Corrected -->
                            <th scope='col'>RESUME</th>
                            <th scope='col'>STATUS</th>
                            <th scope='col'>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($r4 = mysqli_fetch_array($res4)) {
            echo "<tr>";
            echo "<td>{$r4[0]}</td>";
            echo "<td>{$r4[2]}</td>";
            echo "<td>{$r4[11]}</td>";
            echo "<td>{$r4[5]}</td>"; // Corrected to display education
            echo "<td>{$r4[9]}</td>"; // Corrected to display experience
            echo "<td><a href='{$r4['resume']}' target='_blank'>View Resume</a></td>"; // Link to view resume
            echo "<td>{$r4[13]}</td>";
            echo "<td>";
            echo "<a href='?change_status=true&id={$r4[0]}&new_status=approved' class='btn btn-success mr-2'>Approve</a>";
            echo "<a href='?change_status=true&id={$r4[0]}&new_status=rejected' class='btn btn-danger'>Reject</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<h2 class='text-center'>No Applications Found</h2>";
    }
    ?>
</div>

<?php include("footer.php"); ?>
