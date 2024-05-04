<?php
session_start();
include("student_header.php");
include("conn.php");

// Fetch erno, score, and faculty name from score_info and faculty_regis tables
$erno = "";
$score = "";
$given_by = "";
if(isset($_SESSION['sid'])) {
    $student_id = $_SESSION['sid'];
    $res = mysqli_query($conn, "SELECT si.*, fr.name AS given_by FROM score_info si INNER JOIN faculty_regis fr ON si.fid = fr.fid WHERE si.sid = '$student_id'");
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $erno = $row['erno'];
        $score = $row['score'];
        $given_by = $row['given_by'];
    }
}
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-light rounded p-5">
                <div class="section-title section-title-sm position-relative pb-3 mb-4">
                    <h3 class="mb-0">Assigned Score Info</h3>
                </div>
                <form method="post">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="txtgnm">Enrollment no</label>
                            <input type="text" name="txterno" class="form-control" value="<?php echo $erno; ?>" >
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtgnm">Given By</label>
                            <input type="text" name="txtfnm" class="form-control" value="<?php echo $given_by; ?>" >
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="txtgnm">Score</label>
                            <input type="text" name="txtscore" class="form-control" value="<?php echo $score; ?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php                  
include("footer.php");
?>
