<?php
session_start();
include("student_header.php");
include("conn.php");

if(isset($_SESSION['sid'])) {
    $student_id = $_SESSION['sid'];

    // Fetch project details based on intern name equal to the name field in student_table
        $query = "SELECT project_info.prj_title, project_info.duration, project_info.tool, project_info.tech, project_info.mnm, project_info.sta 
                FROM project_info 
                JOIN student_regis ON project_info.intern_name = student_regis.name 
                WHERE student_regis.sid = '$student_id'";
              
        
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
        $project_title = $project['prj_title'];
        $duration = $project['duration'];
        $tool = $project['tool'];
        $technology = $project['tech'];
        $manager_name = $project['mnm'];
        $stipend_amount = $project['sta'];
    } else {
        // If no project details found for the student, set default values
        $project_title = "";
        $duration = "";
        $tool = "";
        $technology = "";
        $manager_name = "";
        $stipend_amount = "";
    }
} else {
    // Redirect if the student is not logged in
    header("Location: student_login.php");
    exit;
}
?>
<!-- Tags Start -->
<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">Tasks</h3>
    </div>
    <div class="d-flex flex-wrap m-n1">
        <a href="stud_add_com_details.php" class="btn btn-light m-1">Add Company Details</a>
        <a href="stud_view_guide.php" class="btn btn-light m-1">View Assigned Guide</a>
        <a href="stud_view_score.php" class="btn btn-light m-1">View Score</a>
        <a href="stud_profile.php" class="btn btn-light m-1">Profile</a>
    </div>
</div>
<!-- Tags End -->
<!-- Project Form Start -->
<div class="bg-light rounded p-5">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">Project Details</h3>
    </div>
    <form method="post">
        <div class="row g-3 owl">
            <div class="col-12 col-sm-6">
                <label for="">Project Title</label>
                <input type="text" name="txtpt" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $project_title; ?>">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Duration</label>
                <input type="text" name="txtdur" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $duration; ?>">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Tools</label>
                <input type="text" name="txtools" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $tool; ?>">
            </div>
            <div class="col-12 col-sm-6">
                <label for="">Technologies</label>
                <input type="text" name="txtech" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $technology; ?>">
            </div>
            <div class="col-12 col-6 col-sm-6">
                <label for="">Manager Name</label>
                <input type="text" name="txtmnm" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $manager_name; ?>">
            </div>
            <div class="col-12 col-6 col-sm-6">
                <label for="">Stipend Amount</label>
                <input type="text" name="txtst" class="form-control bg-white border-0" style="height: 45px;" value="<?php echo $stipend_amount; ?>">
            </div>
            <div class="col-12 col-6">
                <button class="btn btn-primary w-100 py-3" name="btnregis" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
<!-- Project Form End -->
<?php
include("footer.php");
?>
